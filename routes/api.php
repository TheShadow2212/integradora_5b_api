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
use App\Http\Controllers\RolesController;
use App\Http\Controllers\InteractionController;

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
    Route::get('verificar', [AuthController::class, 'verificar'])->middleware('roleAuth');
});

//Cambiar y quitar algunas rutas para que jale el middleware
Route::prefix('auth')->middleware(['JWTAuthenticate', 'roleAuth'])->group(function () {

    //Rutas para el recurso interaction - CRUD
    Route::get('interactions', [InteractionController::class, 'index']);
    
    //Rutas para el recurso pais - CRUD
    Route::get('paises', [PaisController::class, 'index'])->middleware('userAuth:1,2,3');
    Route::get('paises/{id}', [PaisController::class, 'show'])->middleware('userAuth:1,2,3');
    Route::post('paises', [PaisController::class, 'create'])->middleware('userAuth:1,2');
    Route::put('paises/{id}', [PaisController::class, 'update'])->middleware('userAuth:1,2');
    Route::delete('paises/{id}', [PaisController::class, 'delete'])->middleware('userAuth:1');

    //Rutas para el recurso region - CRUD
    Route::get('regiones', [RegionController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('regiones/{id}', [RegionController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('regiones', [RegionController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('regiones/{id}', [RegionController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('regiones/{id}', [RegionController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso ciudad - CRUD
    Route::get('ciudades', [CiudadController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('ciudades/{id}', [CiudadController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('ciudades', [CiudadController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('ciudades/{id}', [CiudadController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('ciudades/{id}', [CiudadController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso distrito - CRUD
    Route::get('distritos', [DistritoController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('distritos/{id}', [DistritoController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('distritos', [DistritoController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('distritos/{id}', [DistritoController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('distritos/{id}', [DistritoController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso barrio - CRUD
    Route::get('barrios', [BarrioController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('barrios/{id}', [BarrioController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('barrios', [BarrioController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('barrios/{id}', [BarrioController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('barrios/{id}', [BarrioController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso calle - CRUD
    Route::get('calles', [CalleController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('calles/{id}', [CalleController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('calles', [CalleController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('calles/{id}', [CalleController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('calles/{id}', [CalleController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso edificio - CRUD
    Route::get('edificios', [EdificioController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('edificios/{id}', [EdificioController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('edificios', [EdificioController::class, 'create']) ->middleware('userAuth:1');
    Route::put('edificios/{id}', [EdificioController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('edificios/{id}', [EdificioController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso apartamento - CRUD
    Route::get('apartamentos', [ApartamentoController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('apartamentos/{id}', [ApartamentoController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('apartamentos', [ApartamentoController::class, 'create']) ->middleware('userAuth:1');
    Route::put('apartamentos/{id}', [ApartamentoController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('apartamentos/{id}', [ApartamentoController::class, 'delete']) ->middleware('userAuth:1');
    Route::get('apartamentosDisponibles', [ApartamentoController::class, 'apartamentosDisponibles'])->middleware('userAuth:1');

    //Rutas para el recurso contratoAlquiler - CRUD
    Route::get('contratoAlquilers', [ContratoAlquilerController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('contratoAlquilers', [ContratoAlquilerController::class, 'create']) ->middleware('userAuth:1');
    Route::put('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('contratoAlquilers/{id}', [ContratoAlquilerController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso inquilino - CRUD
    Route::get('inquilinos', [InquilinoController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('inquilinos/{id}', [InquilinoController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('inquilinos', [InquilinoController::class, 'create']) ->middleware('userAuth:1');
    Route::put('inquilinos/{id}', [InquilinoController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('inquilinos/{id}', [InquilinoController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso usuario - CRUD
    Route::get('usuarios', [UserController::class, 'index'])->middleware('userAuth:1');
    Route::get('usuarios/{id}', [UserController::class, 'show'])->middleware('userAuth:1');
    Route::post('usuarios', [UserController::class, 'create']) ->middleware('userAuth:1');
    Route::put('usuarios/{id}', [UserController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('usuarios/{id}', [UserController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso roles - CRUD
    Route::get('roles', [RolesController::class, 'index']);
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
