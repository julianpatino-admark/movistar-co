<?php

namespace Tests\Feature;

use Admark\GoContact\DatabaseRouter;
use Admark\Tracking\Http\Models\Form;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GoContactRoutingConcurrencyTest extends TestCase
{
    use DatabaseMigrations;

    public function test_parallel_workers_assign_each_form_once_and_keep_the_proportion(): void
    {
        if (DB::connection()->getDriverName() !== 'mysql' || !function_exists('pcntl_fork')) {
            $this->markTestSkipped('Requires an isolated MySQL test database and pcntl.');
        }

        config([
            'gocontact.database_id' => '44',
            'gocontact.routing.alternate_database_id' => '56',
            'gocontact.routing.alternate_percentage' => 40,
        ]);
        $ids = [];
        for ($i = 0; $i < 100; $i++) {
            $ids[] = Form::create([
                'phone' => '3001234567', 'legal' => 'on', 'legal_version' => 'test',
                'tsource' => '0', 'provider' => 'test', 'id_version' => 'index',
                'batch_id' => 'test', 'priority' => 500, 'path' => '/test',
            ])->id;
        }

        // Never share an inherited PDO socket between parent and children.
        DB::purge();
        $directory = sys_get_temp_dir().'/movistar-routing-workers-'.bin2hex(random_bytes(8));
        mkdir($directory, 0700);
        $startAt = microtime(true) + 0.3;
        $workers = [];

        try {
            foreach (array_chunk($ids, 10) as $worker => $chunk) {
                $pid = pcntl_fork();
                if ($pid === -1) {
                    throw new \RuntimeException('Unable to start routing test worker');
                }
                if ($pid === 0) {
                    try {
                        usleep((int) max(0, ($startAt - microtime(true)) * 1000000));
                        $router = app(DatabaseRouter::class);
                        // All workers race to assign the same form as well as their own set.
                        $router->databaseFor((string) $ids[0]);
                        foreach ($chunk as $id) {
                            $router->databaseFor((string) $id);
                            $router->databaseFor((string) $id);
                        }
                        DB::disconnect();
                        exit(0);
                    } catch (\Throwable $exception) {
                        file_put_contents($directory.'/'.$worker, $exception->getMessage());
                        exit(1);
                    }
                }
                $workers[] = $pid;
            }

            $failures = [];
            foreach ($workers as $pid) {
                pcntl_waitpid($pid, $status);
                if (!pcntl_wifexited($status) || pcntl_wexitstatus($status) !== 0) {
                    $failures[] = $pid;
                }
            }
            $errors = array_map('file_get_contents', glob($directory.'/*'));
            $this->assertSame([], $failures, implode("\n", $errors));
            $this->assertDatabaseCount('gocontact_routing_assignments', 100);
            $this->assertSame(40, DB::table('gocontact_routing_assignments')->where('database_id', '56')->count());
            $this->assertSame(60, DB::table('gocontact_routing_assignments')->where('database_id', '44')->count());
            $this->assertSame(0, (int) DB::table('gocontact_routing_counters')->value('remainder'));
        } finally {
            foreach (glob($directory.'/*') as $file) {
                unlink($file);
            }
            rmdir($directory);
        }
    }
}
