<?php

// Browser fixtures for an isolated SQLite database in /tmp. Never call GoContact.
require dirname(__DIR__, 2).'/vendor/autoload.php';
$app = require dirname(__DIR__, 2).'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if (!$app->environment('testing') || config('database.default') !== 'sqlite'
    || !str_starts_with(config('database.connections.sqlite.database'), '/tmp/movistar-monitor-')) {
    throw new RuntimeException('Monitor fixtures require APP_ENV=testing and an isolated /tmp/movistar-monitor-*.sqlite database.');
}

$user = App\Models\User::firstOrNew(['email' => 'operator@example.com']);
$user->forceFill(['name' => 'Operador de prueba', 'password' => 'BrowserMonitor2026!', 'monitor_access' => true])->save();
Illuminate\Support\Facades\DB::table('cache')->delete();
Illuminate\Support\Facades\DB::table('gocontact_submissions')->delete();
Illuminate\Support\Facades\DB::table('gocontact_routing_assignments')->delete();
for ($i = 0; $i < 56; $i++) {
    $form = Admark\Tracking\Http\Models\Form::create([
        'phone' => '3000000000', 'legal' => 'on', 'legal_version' => 'test', 'tsource' => '0',
        'provider' => 'test', 'id_version' => 'index', 'batch_id' => 'test', 'priority' => 500,
        'path' => '/test', 'lead_id' => 'TRACK-'.(12000+$i),
    ]);
    $database = $i % 5 < 3 ? '44' : '56';
    Illuminate\Support\Facades\DB::table('gocontact_routing_assignments')->insert([
        'form_id' => $form->id, 'database_id' => $database, 'alternate_percentage' => 40, 'created_at' => now(),
    ]);
    Illuminate\Support\Facades\DB::table('gocontact_submissions')->insert([
        'form_id' => $form->id, 'database_id' => $database, 'gocontact_id' => 'GC-'.(23000+$i),
        'successful' => $i % 4 !== 0, 'stage' => 'lead_submission', 'http_status' => $i % 4 !== 0 ? 201 : 503,
        'duration_ms' => 180+$i*7, 'error' => $i % 4 === 0 ? 'GoContact returned an unsuccessful HTTP status' : null,
        'diagnostics' => json_encode(['request_id' => 'request-example-'.$i]),
        'created_at' => now()->subMinutes($i*3), 'updated_at' => now(),
    ]);
}
echo "Isolated monitor browser fixtures ready.\n";
