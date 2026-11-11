<?php

namespace Tests\Feature;

use Admark\GoContact\GoContact;
use Admark\Tracking\Http\Services\TsourceService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TrackingSourceConfigurationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sources_resolve_with_an_empty_catalog_table(): void
    {
        $this->assertDatabaseCount('tsources', 0);
        $this->assertSame('config', config('tracking.driver'));
        $sources = app(TsourceService::class);

        foreach (['0', 'unconfigured-source'] as $source) {
            $this->assertSame('0', (string) $sources->getTrackingSource($source));
            $this->assertSame('telemark-interno', $sources->getProviderName($source));
            $this->assertSame(500, $sources->getPriority($source));
            $this->assertSame('MOVISTARCO_KDMA_C2CLN_Q12', $sources->getWebhookBatchId($source));
        }

        $this->assertSame('provider63', $sources->getProviderName('63'));
        $this->assertSame(63, $sources->getPriority('63'));
    }

    public function test_form_sends_default_source_routing_to_gocontact(): void
    {
        config([
            'anubis.generate_id' => false,
            'gocontact.base_url' => 'https://gocontact.test',
            'gocontact.username' => 'test-user',
            'gocontact.password' => 'test-password',
            'gocontact.database_id' => 'test-db',
        ]);

        Http::preventStrayRequests();
        Http::fake([
            'https://gocontact.test/poll/auth/token' => Http::response(['token' => 'test-token']),
            'https://gocontact.test/poll/api/databases/test-db/contacts' => Http::response(['id' => 'test-lead']),
        ]);

        $this->app->instance(Factory::class, Http::getFacadeRoot());
        $this->app->forgetInstance(GoContact::class);

        $this->withHeader('Referer', url('/'))
            ->postJson('/api/form/send', [
                'phone' => '3001234567',
                'id_version' => 'index',
                'legal' => 'on',
                'tsource' => 0,
            ])
            ->assertOk()
            ->assertJson(['status' => true, 'provider' => 'telemark-interno', 'priority' => 500]);

        Http::assertSent(fn (Request $request) =>
            $request->url() === 'https://gocontact.test/poll/api/databases/test-db/contacts'
            && $request['provider'] === 'telemark-interno'
            && $request['priority'] === 500
            && $request['batch_id'] === 'MOVISTARCO_KDMA_C2CLN_Q12'
        );

        $this->assertDatabaseCount('tsources', 0);
    }
}
