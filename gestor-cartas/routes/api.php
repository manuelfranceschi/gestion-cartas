<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usuariosController;
use App\Http\Controllers\cartasController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//
//     return $request->user();
// });

Route::put('registrar', [usuariosController::class, 'registrar']);
Route::put('login', [usuariosController::class, 'login']);
Route::put('recuperacion', [usuariosController::class, 'recuperarPassword']);
Route::put('crearCarta', [cartasController::class, 'crearCarta']);
Route::put('crearColeccion', [cartasController::class, 'crearColeccion']);

