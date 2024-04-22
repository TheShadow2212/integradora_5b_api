<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\InquilinoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SensorController;




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

Route::prefix('auth')->middleware(['JWTAuthenticate'])->group(function () {

    //Rutas para el recurso inquilino - CRUD
    Route::get('inquilinos', [InquilinoController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('inquilinos/{id}', [InquilinoController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('inquilinos', [InquilinoController::class, 'create']) ->middleware('userAuth:1');
    Route::put('inquilinos/{id}', [InquilinoController::class, 'update']) ->middleware('userAuth:1');
    Route::delete('inquilinos/{id}', [InquilinoController::class, 'delete']) ->middleware('userAuth:1');
    
    //Rutas para el recurso usuario - CRUD
    Route::get('usuarios', [UserController::class, 'index'])->middleware('userAuth:1');
    Route::get('usuario', [UserController::class, 'show'])->middleware('userAuth:1,2,3');
    Route::get('usuarios/{id}', [UserController::class, 'show_one'])->middleware('userAuth:1,2');
    Route::post('usuarios', [UserController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('usuarios/{id}', [UserController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('usuarios/{id}', [UserController::class, 'delete']) ->middleware('userAuth:1,2');

    //Rutas para el recurso habitacion - CRUD
    Route::get('habitaciones', [HabitacionController::class, 'index']) ->middleware('userAuth:1,2,3');
    Route::get('habitaciones/{id}', [HabitacionController::class, 'show']) ->middleware('userAuth:1,2,3');
    Route::post('habitaciones', [HabitacionController::class, 'create']) ->middleware('userAuth:1,2');
    Route::put('habitaciones/{id}', [HabitacionController::class, 'update']) ->middleware('userAuth:1,2');
    Route::delete('habitaciones/{id}', [HabitacionController::class, 'delete']) ->middleware('userAuth:1,2');
    Route::get('habitacionesTodas', [HabitacionController::class, 'all'])->middleware('userAuth:1,2,3');

    //Rutas para el recurso roles - CRUD
    Route::get('roles', [RolesController::class, 'index']) ->middleware('userAuth:1,2,3');

    //Rutas para el recurso notificaciones - CRUD
    Route::get('notificaciones', [NotificationController::class, 'getHighNotifications']) ->middleware('userAuth:1,2');
    Route::get('notificaciones/{id}', [NotificationController::class, 'getNotificationsByRoomId']) ->middleware('userAuth:1,2');
    Route::put('notificaciones/{id}', [NotificationController::class, 'update']) ->middleware('userAuth:1,2');
    Route::post('notificaciones', [NotificationController::class, 'create']) ->middleware('userAuth:1,2');       

    //Rutas para el recurso sensores - CRUD
    Route::get('sensores/{id}', [SensorController::class, 'getSensorsByRoomId']) ->middleware('userAuth:1,2');
    Route::get('sensores/{id}/{name}', [SensorController::class, 'getSensorByNameAndRoomId']) ->middleware('userAuth:1,2');
    Route::post('sensores', [SensorController::class, 'create']) ->middleware('userAuth:1,2');

    Route::put('alarmaActiva/{id}', [SensorController::class, 'alarmaActiva']) ->middleware('userAuth:1,2');
    Route::put('alarma/{id}', [SensorController::class, 'apagarAlarma']) ->middleware('userAuth:1,2');
    Route::get('alarma/estado', [SensorController::class, 'estadoAlarma']) ->middleware('userAuth:1,2');

    
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
