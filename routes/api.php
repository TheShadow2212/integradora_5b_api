<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\CalleController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\ContratoAlquilerController;
use App\Http\Controllers\InquilinoController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('user/register', [UserController::class, 'create']); 
Route::get('/verify-email/{id}', [AuthController::class, 'verifyEmail'])->name('verification.email');
Route::post('autenticar', [AuthController::class, 'authenticate']);

Route::prefix('auth')->group (function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('verificar', [AuthController::class, 'verificar']);
});

//Cambiar y quitar algunas rutas para que jale el middleware
Route::prefix('auth')->middleware(['jwtAuth', 'roleAuth'])->group(function () {
    //Rutas para el recurso pais - CRUD
    Route::get('paises', [PaisController::class, 'index'])->middleware('userAuth:1,2');
    Route::get('paises/{id}', [PaisController::class, 'show']);
    Route::post('paises', [PaisController::class, 'create']);
    Route::put('paises/{id}', [PaisController::class, 'update']);
    Route::delete('paises/{id}', [PaisController::class, 'delete']);

    //Rutas para el recurso region - CRUD
    Route::get('regiones', [RegionController::class, 'index']);
    Route::get('regiones/{id}', [RegionController::class, 'show']);
    Route::post('regiones', [RegionController::class, 'create']);
    Route::put('regiones/{id}', [RegionController::class, 'update']);
    Route::delete('regiones/{id}', [RegionController::class, 'delete']);

    //Rutas para el recurso ciudad - CRUD
    Route::get('ciudades', [CiudadController::class, 'index']);
    Route::get('ciudades/{id}', [CiudadController::class, 'show']);
    Route::post('ciudades', [CiudadController::class, 'create']);
    Route::put('ciudades/{id}', [CiudadController::class, 'update']);
    Route::delete('ciudades/{id}', [CiudadController::class, 'delete']);

    //Rutas para el recurso distrito - CRUD
    Route::get('distritos', [DistritoController::class, 'index']);
    Route::get('distritos/{id}', [DistritoController::class, 'show']);
    Route::post('distritos', [DistritoController::class, 'create']);
    Route::put('distritos/{id}', [DistritoController::class, 'update']);
    Route::delete('distritos/{id}', [DistritoController::class, 'delete']);

    //Rutas para el recurso barrio - CRUD
    Route::get('barrios', [BarrioController::class, 'index']);
    Route::get('barrios/{id}', [BarrioController::class, 'show']);
    Route::post('barrios', [BarrioController::class, 'create']);
    Route::put('barrios/{id}', [BarrioController::class, 'update']);
    Route::delete('barrios/{id}', [BarrioController::class, 'delete']);

    //Rutas para el recurso calle - CRUD
    Route::get('calles', [CalleController::class, 'index']);
    Route::get('calles/{id}', [CalleController::class, 'show']);
    Route::post('calles', [CalleController::class, 'create']);
    Route::put('calles/{id}', [CalleController::class, 'update']);
    Route::delete('calles/{id}', [CalleController::class, 'delete']);

    //Rutas para el recurso edificio - CRUD
    Route::get('edificios', [EdificioController::class, 'index']);
    Route::get('edificios/{id}', [EdificioController::class, 'show']);
    Route::post('edificios', [EdificioController::class, 'create']);
    Route::put('edificios/{id}', [EdificioController::class, 'update']);
    Route::delete('edificios/{id}', [EdificioController::class, 'delete']);

    //Rutas para el recurso apartamento - CRUD
    Route::get('apartamentos', [ApartamentoController::class, 'index']);
    Route::get('apartamentos/{id}', [ApartamentoController::class, 'show']);
    Route::post('apartamentos', [ApartamentoController::class, 'create']);
    Route::put('apartamentos/{id}', [ApartamentoController::class, 'update']);
    Route::delete('apartamentos/{id}', [ApartamentoController::class, 'delete']);

    //Rutas para el recurso contratoAlquiler - CRUD
    Route::get('contratoAlquilers', [ContratoAlquilerController::class, 'index']);
    Route::get('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'show']);
    Route::post('contratoAlquilers', [ContratoAlquilerController::class, 'create']);
    Route::put('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'update']);
    Route::delete('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'delete']);

    //Rutas para el recurso inquilino - CRUD
    Route::get('inquilinos', [InquilinoController::class, 'index']);
    Route::get('inquilinos/{id}', [InquilinoController::class, 'show']);
    Route::post('inquilinos', [InquilinoController::class, 'create']);
    Route::put('inquilinos/{id}', [InquilinoController::class, 'update']);
    Route::delete('inquilinos/{id}', [InquilinoController::class, 'delete']);

    //Rutas para el recurso usuario - CRUD
    Route::get('usuarios', [UserController::class, 'index']);
    Route::get('usuarios/{id}', [UserController::class, 'show']);
    Route::post('usuarios', [UserController::class, 'create']);
    Route::put('usuarios/{id}', [UserController::class, 'update']);
    Route::delete('usuarios/{id}', [UserController::class, 'delete']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
