<?php

namespace Tests\Feature;

use Admark\GoContact\DatabaseRouter;
use Admark\GoContact\GoContact;
use Admark\GoContact\GoContactException;
use Admark\Tracking\Http\Models\Form;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Factory;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class GoContactRoutingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        config([
            'anubis.generate_id' => false,
            'gocontact.base_url' => 'https://gocontact.test',
            'gocontact.username' => 'test-user',
            'gocontact.password' => 'test-password',
            'gocontact.database_id' => '44',
            'gocontact.routing.alternate_database_id' => '56',
            'gocontact.routing.alternate_percentage' => 20,
        ]);
        Http::preventStrayRequests();
        Http::fake([
            '*/auth/token' => Http::response(['token' => 'test-token']),
            '*/databases/*/contacts' => Http::response(['id' => 'provider-lead']),
        ]);
        $this->app->instance(Factory::class, Http::getFacadeRoot());
        $this->app->forgetInstance(GoContact::class);
    }

    #[DataProvider('percentages')]
    public function test_complete_blocks_match_the_configured_percentage(int $percentage): void
    {
        config(['gocontact.routing.alternate_percentage' => $percentage]);

        // Recreate the router each time to exercise persisted state across requests.
        for ($i = 0; $i < 100; $i++) {
            app(DatabaseRouter::class)->databaseFor((string) $this->form()->id);
        }

        $this->assertDatabaseCount('gocontact_routing_assignments', 100);
        $this->assertSame($percentage, DB::table('gocontact_routing_assignments')->where('database_id', '56')->count());
        $this->assertSame(100 - $percentage, DB::table('gocontact_routing_assignments')->where('database_id', '44')->count());
        $this->assertSame(0, (int) DB::table('gocontact_routing_counters')->value('remainder'));
    }

    public static function percentages(): array
    {
        return array_map(fn ($value) => [$value], [0, 1, 20, 33, 40, 50, 99, 100]);
    }

    public function test_twenty_percent_is_spread_across_each_ten_assignments(): void
    {
        $destinations = [];
        for ($i = 0; $i < 10; $i++) {
            $destinations[] = app(DatabaseRouter::class)->databaseFor((string) $this->form()->id);
        }
        $this->assertSame(['44', '44', '44', '44', '56', '44', '44', '44', '44', '56'], $destinations);
    }

    public function test_retries_keep_their_destination_and_do_not_advance_the_counter(): void
    {
        $form = $this->form();
        $router = app(DatabaseRouter::class);
        $this->assertSame('44', $router->databaseFor((string) $form->id));
        $before = DB::table('gocontact_routing_counters')->first();

        config(['gocontact.routing.alternate_percentage' => 100, 'gocontact.database_id' => '99']);
        $this->assertSame('44', app(DatabaseRouter::class)->databaseFor((string) $form->id));
        $this->assertEquals($before, DB::table('gocontact_routing_counters')->first());
        $this->assertSame('56', $router->databaseFor((string) $this->form()->id));
        $this->assertDatabaseCount('gocontact_routing_assignments', 2);
    }

    public function test_policy_changes_start_a_new_proportion_without_reassigning_old_leads(): void
    {
        config(['gocontact.routing.alternate_percentage' => 99]);
        $old = $this->form();
        $this->assertSame('44', app(DatabaseRouter::class)->databaseFor((string) $old->id));

        config(['gocontact.routing.alternate_percentage' => 20]);
        for ($i = 0; $i < 10; $i++) {
            app(DatabaseRouter::class)->databaseFor((string) $this->form()->id);
        }
        $this->assertSame(2, DB::table('gocontact_routing_assignments')->where('database_id', '56')->count());
        $this->assertDatabaseHas('gocontact_routing_assignments', ['form_id' => $old->id, 'database_id' => '44', 'alternate_percentage' => 99]);
    }

    #[DataProvider('invalidPercentages')]
    public function test_invalid_settings_do_not_send_or_consume_an_assignment($percentage): void
    {
        config(['gocontact.routing.alternate_percentage' => $percentage]);
        try {
            app(GoContact::class)->insert($this->form()->toArray());
            $this->fail('Invalid percentage must reject routing');
        } catch (GoContactException $exception) {
            $this->assertStringContainsString('integer from 0 to 100', $exception->getMessage());
        }

        Http::assertNothingSent();
        $this->assertDatabaseCount('gocontact_routing_assignments', 0);
        $this->assertDatabaseHas('gocontact_routing_counters', ['id' => 'default', 'remainder' => 0, 'policy_key' => null]);
        $this->assertDatabaseHas('gocontact_submissions', ['stage' => 'database_routing', 'successful' => false, 'database_id' => null]);
    }

    public static function invalidPercentages(): array
    {
        return [[-1], [101], ['not-a-number'], ['20.5'], [true], [null]];
    }

    public function test_missing_counter_does_not_fall_back_to_another_destination(): void
    {
        DB::table('gocontact_routing_counters')->delete();
        try {
            app(GoContact::class)->insert($this->form()->toArray());
            $this->fail('Missing counter must reject routing');
        } catch (GoContactException $exception) {
            $this->assertStringContainsString('run migrations', $exception->getMessage());
        }
        Http::assertNothingSent();
        $this->assertDatabaseCount('gocontact_routing_assignments', 0);
    }

    public function test_failed_submission_retries_from_the_queue_using_its_saved_destination(): void
    {
        config(['gocontact.routing.alternate_percentage' => 100]);
        Http::swap(new Factory());
        Http::preventStrayRequests();
        Http::fake([
            '*/auth/token' => Http::response(['token' => 'test-token']),
            '*/databases/56/contacts' => Http::sequence()->push(['message' => 'Unavailable'], 503)->push(['id' => 'provider-lead']),
        ]);

        $this->withHeader('Referer', url('/movil'))->postJson('/api/form/send', $this->requestData())->assertOk();
        $form = Form::firstOrFail();
        $this->assertSame(1, (int) $form->queued);
        $this->assertDatabaseHas('gocontact_submissions', ['form_id' => $form->id, 'database_id' => '56', 'successful' => false]);

        config(['gocontact.routing.alternate_percentage' => 0]);
        $form->update(['created_at' => now()->subMinutes(21), 'queued_time' => 1200]);
        $this->artisan('queue:insert')->assertSuccessful();
        $this->assertDatabaseHas('forms', ['id' => $form->id, 'queued' => 0]);
        $this->assertDatabaseCount('gocontact_routing_assignments', 1);
        $this->assertDatabaseHas('gocontact_submissions', ['form_id' => $form->id, 'database_id' => '56', 'successful' => true]);
        $contacts = Http::recorded(fn (Request $request) => str_contains($request->url(), '/contacts'));
        $this->assertCount(2, $contacts);
        foreach ($contacts as [$request]) {
            $this->assertSame('https://gocontact.test/poll/api/databases/56/contacts', $request->url());
            $this->assertArrayNotHasKey('form_id', $request->data());
            $this->assertArrayNotHasKey('id', $request->data());
        }
    }

    public function test_new_queued_leads_and_immediate_leads_share_the_counter(): void
    {
        config(['gocontact.routing.alternate_percentage' => 50]);
        $queuedId = $this->withHeader('Referer', url('/'))->postJson('/api/form/queue', $this->requestData())->assertOk()->json('form_id');
        $this->assertDatabaseCount('gocontact_routing_assignments', 0);
        $this->postJson('/api/form/send', $this->requestData('3001234568'))->assertOk();
        $immediate = Form::where('phone', '3001234568')->firstOrFail();
        $this->assertDatabaseHas('gocontact_routing_assignments', ['form_id' => $immediate->id, 'database_id' => '44']);

        Form::whereKey($queuedId)->update(['created_at' => now()->subMinutes(21), 'queued_time' => 1200]);
        $this->artisan('queue:insert')->assertSuccessful();
        $this->assertDatabaseHas('gocontact_routing_assignments', ['form_id' => $queuedId, 'database_id' => '56']);
        $this->assertDatabaseHas('forms', ['id' => $queuedId, 'queued' => 0]);
    }

    public function test_webhook_uses_the_internal_form_id_instead_of_the_external_campaign_id(): void
    {
        config(['gocontact.routing.alternate_percentage' => 100, 'tracking.webhook_password' => 'test-webhook-key']);
        $this->postJson('/api/webhook/post', [
            'google_key' => 'test-webhook-key',
            'form_id' => 'external-campaign-123',
            'adgroup_id' => '121408083769',
            'user_column_data' => [['column_id' => 'PHONE_NUMBER', 'string_value' => '+573001234567']],
        ])->assertOk();

        $form = Form::firstOrFail();
        $this->assertSame('external-campaign-123', $form->form_url);
        $this->assertDatabaseHas('gocontact_routing_assignments', ['form_id' => $form->id, 'database_id' => '56']);
        $this->assertDatabaseHas('gocontact_submissions', ['form_id' => $form->id, 'database_id' => '56', 'successful' => true]);
        Http::assertSent(fn (Request $request) => str_contains($request->url(), '/databases/56/contacts') && $request['batch_id'] === 'batch63');
    }

    public function test_failed_webhook_keeps_its_assignment_and_queues_the_form(): void
    {
        config(['gocontact.routing.alternate_percentage' => 100, 'tracking.webhook_password' => 'test-webhook-key']);
        Http::swap(new Factory());
        Http::preventStrayRequests();
        Http::fake([
            '*/auth/token' => Http::response(['token' => 'test-token']),
            '*/databases/56/contacts' => Http::response(['message' => 'Unavailable'], 503),
        ]);
        $this->withoutExceptionHandling();
        try {
            $this->postJson('/api/webhook/post', [
                'google_key' => 'test-webhook-key', 'form_id' => 'external-campaign-123',
                'adgroup_id' => '121408083769',
                'user_column_data' => [['column_id' => 'PHONE_NUMBER', 'string_value' => '+573001234567']],
            ]);
            $this->fail('GoContact failure must be reported to the webhook caller');
        } catch (GoContactException $exception) {
            $this->assertSame(503, $exception->httpStatus());
        }
        $form = Form::firstOrFail();
        $this->assertSame(1, (int) $form->queued);
        $this->assertDatabaseHas('gocontact_routing_assignments', ['form_id' => $form->id, 'database_id' => '56']);
        $this->assertDatabaseHas('gocontact_submissions', ['form_id' => $form->id, 'database_id' => '56', 'successful' => false]);
    }

    public function test_monitor_exposes_assignments_and_filters_attempts_by_database(): void
    {
        config([
            'gocontact.routing.alternate_percentage' => 50,
            'gocontact.monitor.username' => 'monitor',
            'gocontact.monitor.password' => 'test-password',
        ]);
        app(GoContact::class)->insert($this->form()->toArray());
        app(GoContact::class)->insert($this->form()->toArray());

        $this->withHeaders(['Authorization' => 'Basic '.base64_encode('monitor:test-password')])
            ->get('/monitor/gocontact?database_id=56')
            ->assertOk()->assertSee('BD de destino')->assertViewHas('assignments', fn ($items) => $items->count() === 2)
            ->assertViewHas('attempts', fn ($items) => $items->total() === 1 && $items->first()->database_id === '56')
            ->assertViewHas('totals', fn ($items) => (int) $items->get('56')->successful === 1);
    }

    private function form(): Form
    {
        return Form::create([
            'phone' => '3001234567', 'legal' => 'on', 'legal_version' => 'test',
            'tsource' => '0', 'provider' => 'telemark-interno', 'id_version' => 'index',
            'batch_id' => 'test', 'priority' => 500, 'path' => '/api/form/send',
        ]);
    }

    private function requestData(string $phone = '3001234567'): array
    {
        return ['phone' => $phone, 'id_version' => 'index', 'legal' => 'on', 'tsource' => 0];
    }
}
