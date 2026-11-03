<?php

namespace Admark\GoContact\Tests;

use Admark\GoContact\GoContact;
use Admark\GoContact\GoContactException;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Config\Repository as Config;
use PHPUnit\Framework\TestCase;
use Psr\Log\AbstractLogger;
use Psr\Log\NullLogger;

class GoContactTest extends TestCase
{
    private HttpFactory $http;
    private CacheRepository $cache;
    private ConfigRepository $config;
    private GoContact $client;

    protected function setUp(): void
    {
        parent::setUp();

        $this->http = new HttpFactory();
        $this->cache = new CacheRepository(new ArrayStore());
        $this->config = new Config([
            'gocontact' => [
                'base_url' => 'https://example.gocontact.com',
                'username' => 'api@example.gocontact.com',
                'password' => 'test-password',
                'database_id' => '42',
                'base_path' => '/poll',
                'token_path' => '/auth/token',
                'contacts_path' => '/api/databases/{database}/contacts',
                'connect_timeout' => 10,
                'timeout' => 30,
            ],
        ]);
        $this->client = new GoContact($this->http, $this->cache, $this->config, new NullLogger());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function test_it_authenticates_and_posts_the_lead_payload(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response([
                'token' => 'test-token',
                'expire_timestamp' => time() + 3600,
            ]),
            '*/poll/api/databases/42/contacts' => HttpFactory::response(['id' => 'lead-123']),
        ]);

        $payload = [
            'contact' => 'Test Person',
            'first_phone' => '3000000000',
            'direct_to_hopper' => true,
        ];

        $result = $this->client->insert($payload, 'tracking-123');

        $this->assertTrue($result['status']);
        $this->assertSame('tracking-123', $result['leadId']);
        $this->assertSame(['id' => 'lead-123'], $result['response']);
        $this->assertCount(2, $this->http->recorded());
        $this->assertSame($payload, $this->http->recorded()[1][0]->data());
        $this->assertSame('Bearer test-token', $this->http->recorded()[1][0]->header('Authorization')[0]);
        $this->assertStringContainsString('Basic ', $this->http->recorded()[0][0]->header('Authorization')[0]);
    }

    public function test_it_reuses_a_cached_token(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response([
                'token' => 'cached-token',
                'expire_timestamp' => time() + 3600,
            ]),
            '*/poll/api/databases/42/contacts' => HttpFactory::response(['created' => true]),
        ]);

        $this->client->insert(['contact' => 'First']);
        $this->client->insert(['contact' => 'Second']);

        $this->assertCount(3, $this->http->recorded());
    }

    public function test_it_maps_the_tracking_phone_field_to_first_phone(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response(['token' => 'test-token']),
            '*/poll/api/databases/42/contacts' => HttpFactory::response(['id' => 'lead-123']),
        ]);

        $this->client->insert([
            'phone' => '3000000000',
            'name' => 'Test Person',
        ]);

        $payload = $this->http->recorded()[1][0]->data();
        $this->assertSame('3000000000', $payload['first_phone']);
        $this->assertArrayNotHasKey('phone', $payload);
    }

    public function test_it_throws_on_http_failure_without_exposing_response_content(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response(['token' => 'test-token']),
            '*/poll/api/databases/42/contacts' => HttpFactory::response(['message' => 'private lead info'], 422),
        ]);

        try {
            $this->client->insert(['contact' => 'Sensitive Name']);
            $this->fail('Expected a GoContactException');
        } catch (GoContactException $exception) {
            $this->assertSame(422, $exception->httpStatus());
            $this->assertStringNotContainsString('private lead info', $exception->getMessage());
            $this->assertStringNotContainsString('Sensitive Name', $exception->getMessage());
        }
    }

    public function test_it_logs_which_stage_failed_without_logging_credentials(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response(['message' => 'Unauthorized'], 401),
        ]);

        $logger = new class extends AbstractLogger {
            public array $records = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->records[] = compact('level', 'message', 'context');
            }
        };
        $client = new GoContact($this->http, $this->cache, $this->config, $logger);

        try {
            $client->insert(['contact' => 'Example']);
            $this->fail('Expected a GoContactException');
        } catch (GoContactException $exception) {
            $this->assertSame(401, $exception->httpStatus());
        }

        $this->assertSame('token_authentication', $logger->records[0]['context']['stage']);
        $this->assertArrayNotHasKey('username', $logger->records[0]['context']);
        $this->assertArrayNotHasKey('password', $logger->records[0]['context']);
    }

    public function test_it_logs_sanitized_error_details_and_request_id(): void
    {
        $this->http->fake([
            '*/poll/auth/token' => HttpFactory::response([
                'token' => 'test-token',
                'expire_timestamp' => time() + 3600,
            ]),
            '*/poll/api/databases/42/contacts' => HttpFactory::response([
                'message' => 'Validation failed for test@example.com',
                'errors' => [
                    'email' => ['The email format is invalid'],
                    'first_phone' => ['The phone number is invalid'],
                ],
                'email' => 'test@example.com',
                'contact' => [
                    'email' => 'test@example.com',
                    'first_phone' => '3000000000',
                ],
            ], 400, ['X-Request-Id' => 'request-123']),
        ]);

        $logger = new class extends AbstractLogger {
            public array $records = [];

            public function log($level, string|\Stringable $message, array $context = []): void
            {
                $this->records[] = compact('level', 'message', 'context');
            }
        };
        $client = new GoContact($this->http, $this->cache, $this->config, $logger);

        try {
            $client->insert([
                'contact' => 'Example Person',
                'email' => 'test@example.com',
                'first_phone' => '3000000000',
            ]);
            $this->fail('Expected a GoContactException');
        } catch (GoContactException $exception) {
            $this->assertSame(400, $exception->httpStatus());
        }

        $context = $logger->records[0]['context'];
        $this->assertSame('lead_submission', $context['stage']);
        $this->assertSame('request-123', $context['diagnostics']['request_id']);
        $this->assertStringContainsString('The email format is invalid', $context['diagnostics']['response_body']);
        $this->assertStringContainsString('The phone number is invalid', $context['diagnostics']['response_body']);
        $this->assertStringContainsString('Validation failed for [REDACTED]', $context['diagnostics']['response_body']);
        $this->assertStringContainsString('"email":"[REDACTED]"', $context['diagnostics']['response_body']);
        $this->assertStringNotContainsString('test@example.com', $context['diagnostics']['response_body']);
        $this->assertStringNotContainsString('3000000000', $context['diagnostics']['response_body']);
        $this->assertStringNotContainsString('Example Person', $context['diagnostics']['response_body']);
    }

    public function test_it_requires_https(): void
    {
        $this->config->set('gocontact.base_url', 'http://example.gocontact.com');

        $this->expectException(GoContactException::class);
        $this->expectExceptionMessage('must use HTTPS');

        $this->client->insert(['contact' => 'Example']);
    }
}
