<?php

namespace Tests\Feature;

use Admark\GoContact\GoContact;
use Admark\Tracking\Http\Models\Form;
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
            $this->assertSame('MOVISTARCO_KDMA_C2CLN_Q12', $sources->getBatchId($source));
        }

        $this->assertSame('provider63', $sources->getProviderName('63'));
        $this->assertSame(63, $sources->getPriority('63'));
    }

    public function test_form_sends_default_source_routing_to_gocontact(): void
    {
        $this->fakeGoContact();

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
            && !isset($request['form_data'])
        );

        $this->assertDatabaseCount('tsources', 0);
    }

    public function test_webhook_uses_the_batch_of_the_matched_campaign(): void
    {
        $this->fakeGoContact();
        config(['tracking.webhook_password' => 'test-webhook-key']);

        $this->postJson('/api/webhook/post', [
            'google_key' => 'test-webhook-key',
            'form_id' => 'test-form',
            'adgroup_id' => '121408083769',
            'user_column_data' => [
                ['column_id' => 'PHONE_NUMBER', 'string_value' => '+573001234567'],
            ],
        ])->assertOk();

        Http::assertSent(fn (Request $request) =>
            $request->url() === 'https://gocontact.test/poll/api/databases/test-db/contacts'
            && $request['provider'] === 'provider63'
            && $request['priority'] === 63
            && $request['batch_id'] === 'batch63'
        );
    }

    public function test_queue_respects_the_saved_delay_and_sends_each_due_lead_once(): void
    {
        $this->fakeGoContact();

        $form = [
            'phone' => '3001234567',
            'id_version' => 'index',
            'legal' => 'on',
            'tsource' => 0,
        ];
        $due = $this->withHeader('Referer', url('/'))
            ->postJson('/api/form/queue', $form)
            ->assertOk()
            ->json('form_id');
        $recent = $this->postJson('/api/form/queue', array_replace($form, ['phone' => '3001234568']))
            ->assertOk()
            ->json('form_id');

        Form::whereKey($due)->update(['created_at' => now()->subMinutes(21), 'queued_time' => 1200]);
        Form::whereKey($recent)->update(['queued_time' => 1200]);

        $this->artisan('queue:insert')->assertSuccessful();

        Http::assertSentCount(2);
        Http::assertSent(fn (Request $request) =>
            $request->url() === 'https://gocontact.test/poll/api/databases/test-db/contacts'
            && $request['first_phone'] === '3001234567'
        );

        $this->assertDatabaseHas('forms', ['id' => $due, 'queued' => 0]);
        $this->assertDatabaseHas('forms', ['id' => $recent, 'queued' => 1]);
    }

    private function fakeGoContact(): void
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
    }
}
