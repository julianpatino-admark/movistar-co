<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

use App\Http\Controllers\ApiInsercionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/pdf/{filename}', function ($filename) {

    if (!Storage::disk('documents')->exists($filename)) {
        abort(404);
    }

    $file = Storage::get($filename);
    $type = Storage::mimeType($filename);



    return response()->file($file);

});

Route::prefix('local')->group(function () {
    Route::post('/idlead-cobalt', [ApiInsercionController::class, 'obtenerDatosApi'])->middleware('auth:api');
});