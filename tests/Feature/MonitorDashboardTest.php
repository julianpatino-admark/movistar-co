<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MonitorDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create(['monitor_access' => true]));
    }

    public function test_filters_summary_and_pagination_use_the_same_selection(): void
    {
        $this->attempt(['gocontact_id' => 'provider-123', 'successful' => true, 'database_id' => '44', 'duration_ms' => 100]);
        $this->attempt(['gocontact_id' => 'provider-456', 'successful' => false, 'database_id' => '56', 'duration_ms' => 300]);
        $this->get('/monitor/gocontact')->assertOk()
            ->assertViewHas('summary', fn ($summary) => (int) $summary->total === 2 && (int) $summary->successful === 1 && (int) $summary->failed === 1 && (float) $summary->duration === 200.0);
        $this->get('/monitor/gocontact?status=failed&database_id=56')->assertOk()
            ->assertViewHas('attempts', fn ($attempts) => $attempts->total() === 1 && $attempts->first()->gocontact_id === 'provider-456')
            ->assertViewHas('summary', fn ($summary) => (int) $summary->total === 1 && (int) $summary->failed === 1);
        $this->get('/monitor/gocontact?q=provider-123')->assertOk()->assertViewHas('attempts', fn ($attempts) => $attempts->total() === 1);
    }

    public function test_date_boundaries_are_inclusive_and_an_end_date_can_be_used_alone(): void
    {
        $this->attempt(['created_at' => '2026-11-20 00:00:00']);
        $this->attempt(['created_at' => '2026-11-20 23:59:59']);
        $this->attempt(['created_at' => '2026-11-21 00:00:00']);
        $this->get('/monitor/gocontact?from=2026-11-20&to=2026-11-20')->assertOk()->assertViewHas('attempts', fn ($items) => $items->total() === 2);
        $this->get('/monitor/gocontact?to=2026-11-20')->assertOk()->assertViewHas('attempts', fn ($items) => $items->total() === 2);
        $this->from('/monitor/gocontact')->get('/monitor/gocontact?from=2026-11-21&to=2026-11-20')->assertSessionHasErrors('to');
    }

    public function test_empty_results_invalid_filters_and_error_content_are_handled_safely(): void
    {
        $this->get('/monitor/gocontact')->assertOk()->assertSee('Todo listo para el primer envío');
        $this->get('/monitor/gocontact?database_id=56')->assertOk()->assertSee('No encontramos resultados');
        $this->from('/monitor/gocontact')->get('/monitor/gocontact?database_id[]=44')->assertSessionHasErrors('database_id');
        $this->attempt(['successful' => false, 'error' => '<script>alert("test")</script>']);
        $this->get('/monitor/gocontact')->assertOk()->assertSee('&lt;script&gt;', false)->assertDontSee('<script>alert("test")</script>', false);
    }

    public function test_pagination_keeps_filters_and_does_not_reset_the_summary(): void
    {
        for ($i = 0; $i < 51; $i++) {
            $this->attempt(['successful' => false, 'database_id' => '56']);
        }
        $this->get('/monitor/gocontact?database_id=56&status=failed&page=2')->assertOk()
            ->assertViewHas('attempts', fn ($items) => $items->total() === 51 && $items->count() === 1)
            ->assertViewHas('summary', fn ($summary) => (int) $summary->total === 51)
            ->assertSee('database_id=56', false)->assertSee('status=failed', false);
    }

    private function attempt(array $values = []): void
    {
        DB::table('gocontact_submissions')->insert(array_replace([
            'form_id' => null, 'gocontact_id' => 'provider-id', 'successful' => true,
            'database_id' => '44', 'stage' => 'lead_submission', 'http_status' => 200,
            'duration_ms' => 100, 'created_at' => now(), 'updated_at' => now(),
        ], $values));
    }
}
