<?php

namespace Tests\Feature\Console\Commands;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Admark\Cobalt\CobaltService;
use Admark\Tracking\Http\Repositories\TsourceRepository;
use Admark\Tracking\Http\Models\Tsource;

/**
 * @covers \App\Console\Commands\CobaltupdateTsources
 */
class CobaltupdateTsourcesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mockeamos el repositorio para que no intente hacer nada raro
        $this->mock(TsourceRepository::class);

        // Asignamos una configuración de prueba para que config('cobalt.default.microsite') no devuelva null
        config(['cobalt.default.microsite' => 'microsite_prueba']);
    }

    /**
     * Escenario 1: Base de datos vacía (Entra en los 'if')
     */
    public function test_crea_nuevos_tsources_cuando_no_existen()
    {
        // 1. Falsificamos el servicio Cobalt para que no haga llamadas reales a la API
        $this->mock(CobaltService::class, function ($mock) {
            // Simulamos que la API devuelve 2 Tsources
            $mock->shouldReceive('getTsources')->once()->andReturn([
                '1234' => ['phone' => '3001112233'],
                '5678' => ['phone' => null] // Este simula el caso donde el teléfono es null y se convierte en '0'
            ]);

            // Simulamos que nos devuelve el Tsource por defecto
            $mock->shouldReceive('getDefaultTsource')
                 ->with('0', 'microsite_prueba', '', '')
                 ->once()
                 ->andReturn('1234');
        });

        // 2. Ejecutamos el comando y verificamos la salida de la consola
        $this->artisan('cobalt:update')
             ->expectsOutput('NEW TSOURCE: 1234')
             ->expectsOutput('NEW TSOURCE: 5678')
             ->expectsOutput('NEW TSOURCE: 0')
             ->assertExitCode(0);

        // 3. Verificamos que se guardaron correctamente en la base de datos
        $this->assertDatabaseHas((new Tsource)->getTable(), [
            'tsource' => '1234',
            'phone' => '3001112233'
        ]);

        $this->assertDatabaseHas((new Tsource)->getTable(), [
            'tsource' => '5678',
            'phone' => '0' // Verificamos que el operador ternario transformó el null a '0'
        ]);

        $this->assertDatabaseHas((new Tsource)->getTable(), [
            'tsource' => '0',
            'phone' => '3001112233', // Heredó el teléfono del Tsource 1234
            'priority' => 500,
            'provider' => 'telemark-interno',
        ]);
    }

    /**
     * Escenario 2: Registros ya existen (Entra en los 'else')
     */
    public function test_actualiza_tsources_existentes()
    {
        // 1. Pre-poblamos la base de datos con información antigua
        $tsourceAntiguo = new Tsource(['tsource' => '1234', 'phone' => '9999999999']);
        $tsourceAntiguo->save();

        $tsourceCero = new Tsource(['tsource' => '0', 'phone' => '9999999999']);
        $tsourceCero->save();

        // 2. Falsificamos el servicio Cobalt
        $this->mock(CobaltService::class, function ($mock) {
            // Cobalt ahora trae un teléfono nuevo
            $mock->shouldReceive('getTsources')->once()->andReturn([
                '1234' => ['phone' => '3001112233'] 
            ]);

            $mock->shouldReceive('getDefaultTsource')->once()->andReturn('1234');
        });

        // 3. Ejecutamos el comando esperando los mensajes de "EXISTENT"
        $this->artisan('cobalt:update')
             ->expectsOutput('EXISTENT TSOURCE: 1234')
             ->expectsOutput('EXISTENT TSOURCE: 0')
             ->assertExitCode(0);

        // 4. Verificamos que se haya actualizado la información
        $actualizado1234 = Tsource::where('tsource', '1234')->first();
        $this->assertEquals('3001112233', $actualizado1234->phone); // El teléfono debió cambiar

        $actualizadoCero = Tsource::where('tsource', '0')->first();
        $this->assertEquals(500, $actualizadoCero->priority); // Se asignó prioridad 500
        $this->assertEquals('telemark-interno', $actualizadoCero->provider); // Cambió el provider
    }
}
