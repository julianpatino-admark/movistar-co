<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\Http\Controllers\ApiInsercionController;

/**
 * @covers \App\Http\Controllers\ApiInsercionController
 */
class ApiInsercionControllerTest extends TestCase
{
    use WithoutMiddleware;
    private string $rutaApi = '/api/local/idlead-cobalt';

    /**
     * Datos base correctos para pasar la validación
     */
    public function datosValidos(): array
    {
        return [
            'Microsite' => 'ofertastienda.co',
            'Cliente' => 'MOVISTARCO',
            'Telefono' => 3001234567,
            'Tsource' => 1234,
            'Tipo' => 'in'
        ];
    }

    /**
     * Escenario 1: Fallo de validación (Falta el teléfono)
     */
    public function test_falla_si_faltan_datos_obligatorios()
    {
        $datosIncompletos = [
            'Microsite' => 'ofertastienda.co',
            // Falta Cliente, Telefono, etc.
        ];

        $response = $this->json('POST', $this->rutaApi, $datosIncompletos);

        $response->assertStatus(422)
                ->assertJsonFragment([
                    'status' => 'error_validacion',
                ]);
    }

    /**
     * Escenario 2: Éxito total (La API externa responde con número >= 0)
     */
    public function test_insercion_exitosa()
    {
        // 1. Falsificamos la respuesta de la API de Digitalion
        Http::fake([
            '*' => Http::response(123456, 200) 
        ]);

        // 2. Ejecutamos nuestra ruta con datos válidos
        $response = $this->json('POST', $this->rutaApi, $this->datosValidos());

        // 3. Verificamos que nuestro controlador responda bien
        $response->assertStatus(200)
                ->assertJson([
                    'status' => 'success',
                    'message' => 123456
                ]);
    }

    /**
     * Escenario 3: Error lógico (La API responde bien pero con número negativo)
     */
    public function test_api_externa_devuelve_error_logico_negativo()
    {
        Http::fake([
            '*' => Http::response(-1, 200)
        ]);

        $response = $this->json('POST', $this->rutaApi, $this->datosValidos());

        $response->assertStatus(400)
                ->assertJsonFragment([
                    'status' => 'error',
                ]);
    }

    /**
     * Escenario 4: Error de la API externa (Ej. un error 500 del servidor de ellos)
     */
    public function test_api_externa_devuelve_error_http()
    {
        Http::fake([
            '*' => Http::response('Server Error', 500)
        ]);

        $response = $this->json('POST', $this->rutaApi, $this->datosValidos());

        $response->assertStatus(500)
                ->assertJsonFragment([
                    'status' => 'error',
                    'message' => 'La API externa no respondió correctamente'
                ]);
    }


    /**
     * Escenario 5: Excepción crítica (Ej. Se cae el servidor, timeout)
     */
    public function test_captura_excepcion_critica_de_conexion()
    {
        // Forzamos a que Http lance una excepción en lugar de responder
        Http::fake(function () {
            throw new \Exception('Conexión rechazada');
        });

        $response = $this->json('POST', $this->rutaApi, $this->datosValidos());

        $response->assertStatus(503)
                ->assertJsonFragment([
                    'status' => 'error_critico',
                ]);
    }
}
