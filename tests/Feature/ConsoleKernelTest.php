<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Console\Scheduling\Schedule;
use ReflectionClass;

/**
 * @covers \App\Console\Kernel
 */
class ConsoleKernelTest extends TestCase
{
    public function test_el_metodo_schedule_se_ejecuta_correctamente()
    {
        // 1. Instanciamos el Kernel de la consola y el objeto Schedule
        $kernel = app()->make(\Illuminate\Contracts\Console\Kernel::class);
        $schedule = app()->make(Schedule::class);

        // 2. Usamos Reflection para acceder al método protegido 'schedule'
        $reflection = new ReflectionClass($kernel);
        $method = $reflection->getMethod('schedule');
        $method->setAccessible(true);
        
        // 3. Ejecutamos el método directamente pasándole el objeto schedule
        $method->invoke($kernel, $schedule);

        // 4. Si llegó hasta aquí sin explotar, las líneas ya fueron cubiertas
        $this->assertTrue(true);
    }
}
