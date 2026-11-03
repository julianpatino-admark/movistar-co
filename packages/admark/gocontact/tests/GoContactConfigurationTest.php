<?php

namespace Admark\GoContact\Tests;

use Admark\GoContact\GoContact;
use Illuminate\Support\Env;
use PHPUnit\Framework\TestCase;

class GoContactConfigurationTest extends TestCase
{
    private array $originalEnvironment = [];

    protected function setUp(): void
    {
        parent::setUp();
        Env::enablePutenv();
    }

    protected function tearDown(): void
    {
        foreach ($this->originalEnvironment as $key => $original) {
            if ($original['getenv'] !== false) {
                putenv($key . '=' . $original['getenv']);
            } else {
                putenv($key);
            }

            if ($original['env_exists']) {
                $_ENV[$key] = $original['env'];
            } else {
                unset($_ENV[$key]);
            }

            if ($original['server_exists']) {
                $_SERVER[$key] = $original['server'];
            } else {
                unset($_SERVER[$key]);
            }
        }

        Env::enablePutenv();
        parent::tearDown();
    }

    public function test_gocontact_connection_values_are_loaded_from_environment(): void
    {
        $environment = [
            'GOCONTACT_BASE_URL' => 'https://env-test.gocontact.com',
            'GOCONTACT_USERNAME' => 'test-user@example.com',
            'GOCONTACT_PASSWORD' => 'unit-test-only-password',
            'GOCONTACT_DATABASE_ID' => 'test-database',
        ];

        foreach ($environment as $key => $value) {
            $this->rememberEnvironmentValue($key);
            putenv($key . '=' . $value);
            $_ENV[$key] = $value;
            $_SERVER[$key] = $value;
        }

        $config = require dirname(__DIR__, 4) . '/config/gocontact.php';
        $packageDefaults = require __DIR__ . '/../config/gocontact.php';

        $this->assertSame($environment['GOCONTACT_BASE_URL'], $config['base_url']);
        $this->assertSame($environment['GOCONTACT_USERNAME'], $config['username']);
        $this->assertSame($environment['GOCONTACT_PASSWORD'], $config['password']);
        $this->assertSame($environment['GOCONTACT_DATABASE_ID'], $config['database_id']);
        $this->assertSame('/poll', $config['base_path']);
        $this->assertSame('/auth/token', $config['token_path']);
        $this->assertSame('/api/databases/{database}/contacts', $config['contacts_path']);
        $this->assertSame($packageDefaults['contacts_path'], $config['contacts_path']);
        $this->assertSame($packageDefaults['token_cache_prefix'], $config['token_cache_prefix']);
    }

    public function test_tracking_uses_the_gocontact_service(): void
    {
        $tracking = require dirname(__DIR__, 4) . '/config/tracking.php';

        $this->assertSame(GoContact::class, $tracking['api']);
    }

    private function rememberEnvironmentValue(string $key): void
    {
        $this->originalEnvironment[$key] = [
            'getenv' => getenv($key),
            'env_exists' => array_key_exists($key, $_ENV),
            'env' => $_ENV[$key] ?? null,
            'server_exists' => array_key_exists($key, $_SERVER),
            'server' => $_SERVER[$key] ?? null,
        ];
    }
}
