<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\PhotoController;

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


Route::post("/login", [AuthController::class, "login"]);
Route::post("/comparar-rostros", [AuthController::class, "compareFaces"]);
Route::post("/signup", [AuthController::class, "signup"]);


Route::group(["middleware" => "auth:sanctum"], function () {
    Route::post("/logout", [AuthController::class, "logout"]);
    // Route::get('events',EventController::class);
});

Route::get('listar-categoria',[AuthController::class,"listarCategorias"]);
Route::post('listar-nivel',[AuthController::class,"listarNiveles"]);
Route::post('listar-ejercicio',[AuthController::class,"listarEjercicios"]);
Route::post('enviar-respuesta',[AuthController::class,"enviarRespuesta"]);
Route::post('enviar-intento',[AuthController::class,"enviarIntento"]);
Route::post('obtener-recomendacion-nivel',[AuthController::class,"obtenerRecomendaciones"]);
Route::post('upload-profile1',[AuthController::class, 'uploadProfile1']);
Route::post('obtener-respuesta',[AuthController::class,"obtenerRespuesta"]);

Route::post('generar-lectura',[AuthController::class,"generarLectura"]);

Route::get('pago/{token}/{plan}/{user_id}/{orden_id}',[App\Http\Controllers\PagoController::class,'index'])->name('pagar');
Route::post('pago/confirmar',[App\Http\Controllers\PagoController::class,'confirmar']);
Route::post('pago/callback/{token}',[App\Http\Controllers\PagoController::class,'callback']);
