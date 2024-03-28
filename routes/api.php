<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\InquilinoController;

/*use App\Http\Controllers\PaisController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CiudadController;
use App\Http\Controllers\DistritoController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\CalleController;
use App\Http\Controllers\EdificioController;
use App\Http\Controllers\ApartamentoController;
use App\Http\Controllers\ContratoAlquilerController;
use App\Http\Controllers\InteractionController;
use App\Http\Controllers\NotificationController;
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

    //Rutas para el recurso inquilino - CRUD
    Route::get('inquilinos', [InquilinoController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('inquilinos/{id}', [InquilinoController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('inquilinos', [InquilinoController::class, 'create']) ->middleware('userAuth:1');
    Route::put('inquilinos/{id}', [InquilinoController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('inquilinos/{id}', [InquilinoController::class, 'delete']) ->middleware('userAuth:1');
    
    //Rutas para el recurso usuario - CRUD
    Route::get('usuarios', [UserController::class, 'index'])->middleware('userAuth:1');
    Route::get('usuario/{id}', [UserController::class, 'show'])->middleware('userAuth:1');
    Route::post('usuarios', [UserController::class, 'create']) ->middleware('userAuth:1');
    Route::put('usuarios/{id}', [UserController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('usuarios/{id}', [UserController::class, 'delete']) ->middleware('userAuth:1');

    //Rutas para el recurso habitacion - CRUD
    Route::get('habitaciones', [HabitacionController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('habitaciones/{id}', [HabitacionController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('habitaciones', [HabitacionController::class, 'create']) ->middleware('userAuth:1');
    Route::put('habitaciones/{id}', [HabitacionController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('habitaciones/{id}', [HabitacionController::class, 'delete']) ->middleware('userAuth:1');
    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
