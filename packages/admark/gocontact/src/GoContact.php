<?php

namespace Admark\GoContact;

use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Psr\Log\LoggerInterface;

class GoContact
{
    public function __construct(
        private HttpFactory $http,
        private CacheRepository $cache,
        private ConfigRepository $config,
        private LoggerInterface $logger,
        private ?EventDispatcher $events = null
    ) {
    }

    /**
     * Send a lead payload to the configured GoContact database.
     *
     * The optional lead ID is returned to callers for compatibility with
     * tracking packages; it is not sent as an undocumented API field.
     */
    public function insert(array $data, string|int|null $leadId = null): array
    {
        return $this->executeFlowState($data, null, $leadId);
    }

    public function executeFlowState(
        array $data,
        string|int|null $databaseId = null,
        string|int|null $leadId = null
    ): array {
        $databaseId ??= $this->config->get('gocontact.database_id');
        $startedAt = microtime(true);
        $formIdValue = $data['form_id'] ?? $data['id'] ?? null;
        $formId = is_scalar($formIdValue) ? (string) $formIdValue : null;
        $stage = 'configuration';

        try {
            $this->validateConfiguration($databaseId);
            $contactsPath = str_replace(
                '{database}',
                rawurlencode((string) $databaseId),
                (string) $this->config->get('gocontact.contacts_path')
            );
            $payload = $this->mapPayload($data);
            unset($payload['form_id'], $payload['id'], $payload['form_data']);

            $stage = 'token_authentication';
            $token = $this->getToken();
            $stage = 'lead_submission';
            $response = $this->request(
                'POST',
                $contactsPath,
                ['Authorization' => 'Bearer ' . $token],
                $payload
            );
        } catch (GoContactException $exception) {
            $this->logger->error('GoContact lead submission failed', [
                'event' => 'gocontact.lead.failed',
                'stage' => $stage,
                'form_id' => $formId,
                'database_id' => (string) $databaseId,
                'http_status' => $exception->httpStatus(),
                'diagnostics' => $exception->diagnostics(),
                'duration_ms' => (int) ((microtime(true) - $startedAt) * 1000),
            ]);

            $this->dispatchAttempt($formId, null, false, $stage, $exception->httpStatus(), $exception->getMessage(), $exception->diagnostics(), (int) ((microtime(true) - $startedAt) * 1000));

            throw $exception;
        }

        $this->logger->info('GoContact lead submitted', [
            'event' => 'gocontact.lead.submitted',
            'database_id' => (string) $databaseId,
            'http_status' => $response['http_status'],
            'diagnostics' => $response['diagnostics'],
            'duration_ms' => (int) ((microtime(true) - $startedAt) * 1000),
        ]);

        $providerLeadId = Arr::get($response['body'], 'id')
            ?? Arr::get($response['body'], 'contact.id')
            ?? Arr::get($response['body'], 'contact_id');
        $providerLeadId = is_scalar($providerLeadId) ? (string) $providerLeadId : null;
        $this->dispatchAttempt($formId, $providerLeadId, true, 'lead_submission', $response['http_status'], null, $response['diagnostics'], (int) ((microtime(true) - $startedAt) * 1000));

        return [
            'status' => true,
            'detail' => 'GoContact lead submitted',
            'message' => 'Lead submitted successfully',
            'leadId' => $leadId,
            'priority' => $data['priority'] ?? null,
            'response' => $response['body'],
            'gocontact_id' => $providerLeadId,
            'http_status' => $response['http_status'],
        ];
    }

    private function dispatchAttempt(?string $formId, ?string $providerLeadId, bool $successful, string $stage, ?int $httpStatus, ?string $error, array $diagnostics, int $durationMs): void
    {
        if ($this->events === null) {
            return;
        }

        $this->events->dispatch(new GoContactSubmissionAttempted(
            $formId,
            $providerLeadId,
            $successful,
            $stage,
            $httpStatus,
            $error,
            $diagnostics,
            $durationMs
        ));
    }

    private function mapPayload(array $data): array
    {
        if (empty($data['first_phone']) && !empty($data['phone'])) {
            $data['first_phone'] = $data['phone'];
        }

        unset($data['phone']);

        return $data;
    }

    private function getToken(): string
    {
        $username = (string) $this->config->get('gocontact.username');
        $password = (string) $this->config->get('gocontact.password');
        $cacheKey = $this->tokenCacheKey($username, $password);

        $cachedToken = $this->cache->get($cacheKey);
        if (is_string($cachedToken) && $cachedToken !== '') {
            return $cachedToken;
        }

        $response = $this->request(
            'POST',
            (string) $this->config->get('gocontact.token_path'),
            [],
            null,
            [$username, $password]
        );

        $token = Arr::get($response['body'], 'token');
        if (!is_string($token) || $token === '') {
            throw new GoContactException(
                'GoContact authentication response did not contain a token',
                $response['http_status'],
                null,
                $response['diagnostics']
            );
        }

        $expiresAt = Arr::get($response['body'], 'expire_timestamp');
        $ttl = is_numeric($expiresAt)
            ? max(1, (int) $expiresAt - time() - 60)
            : 23 * 60 * 60;

        $this->cache->put($cacheKey, $token, $ttl);

        return $token;
    }

    private function request(
        string $method,
        string $endpoint,
        array $headers = [],
        ?array $data = null,
        ?array $basicAuth = null
    ): array {
        $url = $this->url($endpoint);
        $request = $this->http
            ->acceptJson()
            ->asJson()
            ->connectTimeout((int) $this->config->get('gocontact.connect_timeout', 10))
            ->timeout((int) $this->config->get('gocontact.timeout', 30))
            ->withOptions(['verify' => true, 'allow_redirects' => false])
            ->withHeaders($headers);

        if ($basicAuth !== null) {
            $request = $request->withBasicAuth($basicAuth[0], $basicAuth[1]);
        }

        try {
            $response = $request->send($method, $url, $data === null ? [] : ['json' => $data]);
        } catch (ConnectionException $exception) {
            throw new GoContactException('Unable to reach GoContact', null, $exception);
        }

        $diagnostics = $this->responseDiagnostics($response, $data, $basicAuth, $headers, !$response->successful());

        if (!$response->successful()) {
            throw new GoContactException(
                'GoContact returned an unsuccessful HTTP status',
                $response->status(),
                null,
                $diagnostics
            );
        }

        $body = $response->json();
        if (!is_array($body)) {
            $diagnostics = $this->responseDiagnostics($response, $data, $basicAuth, $headers, true);
            throw new GoContactException(
                'GoContact returned an invalid JSON response',
                $response->status(),
                null,
                $diagnostics
            );
        }

        return [
            'body' => $body,
            'http_status' => $response->status(),
            'diagnostics' => $diagnostics,
        ];
    }

    private function responseDiagnostics(
        Response $response,
        ?array $data,
        ?array $basicAuth,
        array $requestHeaders,
        bool $includeBody
    ): array {
        $requestId = $response->header('X-Request-Id')
            ?? $response->header('X-Correlation-Id')
            ?? $response->header('Traceparent');
        if (is_string($requestId)) {
            $requestId = preg_replace('/[^A-Za-z0-9._:-]/', '', substr($requestId, 0, 128));
        }

        $diagnostics = [
            'content_type' => $response->header('Content-Type'),
            'request_id' => is_string($requestId) ? substr($requestId, 0, 128) : null,
        ];

        if ($includeBody) {
            $body = $response->json();
            if (!is_array($body)) {
                $body = $response->body();
            }

            $secrets = array_merge(
                $this->scalarValues($data ?? []),
                $basicAuth ?? [],
                array_values($requestHeaders)
            );
            $sanitizedBody = $this->sanitizeDiagnosticValue($body, $secrets);
            $encodedBody = is_string($sanitizedBody)
                ? $sanitizedBody
                : json_encode($sanitizedBody, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $diagnostics['response_body'] = is_string($encodedBody)
                ? substr($encodedBody, 0, 4096)
                : '[unavailable]';
            $diagnostics['response_body_truncated'] = is_string($encodedBody) && strlen($encodedBody) > 4096;
        }

        return array_filter($diagnostics, static fn ($value) => $value !== null);
    }

    private function sanitizeDiagnosticValue($value, array $secrets, string $key = '', bool $insideErrors = false)
    {
        $insideErrors = $insideErrors || strtolower($key) === 'errors';
        if (is_array($value)) {
            $sanitized = [];
            foreach ($value as $childKey => $childValue) {
                $childKey = (string) $childKey;
                if (!$insideErrors && preg_match(
                    '/(?:password|token|secret|authorization|email|phone|mobile|contact|name|surname|address|document|identification|ip|cookie)/i',
                    $childKey
                )) {
                    $sanitized[$childKey] = '[REDACTED]';
                    continue;
                }
                if ($insideErrors && preg_match(
                    '/(?:password|token|secret|authorization|email|phone|mobile|contact|name|surname|address|document|identification|ip|cookie)/i',
                    $childKey
                ) && !$this->containsOnlyStrings($childValue)) {
                    $sanitized[$childKey] = '[REDACTED]';
                    continue;
                }

                $sanitized[$childKey] = $this->sanitizeDiagnosticValue(
                    $childValue,
                    $secrets,
                    $childKey,
                    $insideErrors
                );
            }

            return $sanitized;
        }

        if (!is_string($value)) {
            return $value;
        }

        usort($secrets, static fn ($left, $right) => strlen((string) $right) <=> strlen((string) $left));
        foreach ($secrets as $secret) {
            $secret = (string) $secret;
            if ($secret === '') {
                continue;
            }
            if (strlen($secret) >= 4) {
                $value = str_replace($secret, '[REDACTED]', $value);
            } else {
                $value = preg_replace(
                    '/(?<![A-Za-z0-9])' . preg_quote($secret, '/') . '(?![A-Za-z0-9])/',
                    '[REDACTED]',
                    $value
                ) ?? $value;
            }
        }

        return $value;
    }

    private function containsOnlyStrings($value): bool
    {
        if (is_string($value)) {
            return true;
        }
        if (!is_array($value) || $value === []) {
            return false;
        }

        foreach ($value as $childValue) {
            if (!$this->containsOnlyStrings($childValue)) {
                return false;
            }
        }

        return true;
    }

    private function scalarValues(array $values): array
    {
        $scalars = [];
        array_walk_recursive($values, static function ($value) use (&$scalars): void {
            if (is_string($value) || is_int($value) || is_float($value)) {
                $scalars[] = (string) $value;
            }
        });

        return $scalars;
    }

    private function url(string $endpoint): string
    {
        $baseUrl = rtrim((string) $this->config->get('gocontact.base_url'), '/');
        $basePath = trim((string) $this->config->get('gocontact.base_path', '/poll'), '/');
        $endpoint = ltrim($endpoint, '/');
        $url = $baseUrl . '/' . ($basePath !== '' ? $basePath . '/' : '') . $endpoint;

        if (parse_url($baseUrl, PHP_URL_SCHEME) !== 'https') {
            throw new GoContactException('GoContact base URL must use HTTPS');
        }

        return $url;
    }

    private function tokenCacheKey(string $username, string $password): string
    {
        $identity = implode('|', [
            (string) $this->config->get('gocontact.base_url'),
            $username,
            hash('sha256', $password),
        ]);

        return (string) $this->config->get('gocontact.token_cache_prefix', 'admark.gocontact.token')
            . '.' . hash('sha256', $identity);
    }

    private function validateConfiguration(string|int|null $databaseId): void
    {
        foreach (['base_url', 'username', 'password'] as $key) {
            if (!is_string($this->config->get('gocontact.' . $key)) || $this->config->get('gocontact.' . $key) === '') {
                throw new GoContactException('GoContact configuration is missing: ' . $key);
            }
        }

        if ($databaseId === null || (string) $databaseId === '') {
            throw new GoContactException('GoContact configuration is missing: database_id');
        }
    }
}
