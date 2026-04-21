<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class ApiInsercionController extends Controller
{
    public function obtenerDatosApi(Request $request): JsonResponse
    {

        try{
            $datosValidados = $request->validate([
                'Microsite' => 'required|string|max:100',
                'Cliente' => 'required|string|max:45',
                'Telefono' => 'required|integer',
                'Tsource' => 'required|integer',
                'Tipo' => 'string',

            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error_validacion',
                'message' => 'Los datos proporcionados no son válidos',
                'errores' => $e->errors(),
                'http_code' => 422
            ], 422);
        }

        $urlApiExterna = config('services.digitalion.url');

        try {
            $response = Http::get($urlApiExterna, $datosValidados);

            if($response->successful()){
                $data = $response->json();

                if ($data >= 0){
                    return response()->json([
                        'status' => 'success',
                        'message' => $data,
                        'http_code' => 200
                    ], 200);
                }

                return response()->json([
                    'status' => 'error',
                    'message' => 'Se envió la data sin embargo contiene errores -1:duplicado, -6:dataerror, -100:phonenotpermited',
                    'http_code' => $data
                ], 400);

                
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'La API externa no respondió correctamente',
                    'http_code' => $response->status()
                ], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error_critico',
                'message' => 'No se pudo conectar al servicio externo',
                'error' => $e->getMessage(),
                'http_code' => 503
            ], 503);
        }
    }
}
