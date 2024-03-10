<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaisController;

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


Route::prefix('auth')->middleware(['api'])->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('verificar', [AuthController::class, 'verificar']);
    
    //Rutas para el recurso pais - CRUD
    Route::get('paises', [PaisController::class, 'index']);
    Route::get('paises/{id}', [PaisController::class, 'show']);
    Route::post('paises', [PaisController::class, 'create']);
    Route::put('paises/{id}', [PaisController::class, 'update']);
    Route::delete('paises/{id}', [PaisController::class, 'delete']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
