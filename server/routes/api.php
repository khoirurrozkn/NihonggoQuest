<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('/auth')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
});

Route::prefix('/user')->middleware('auth:sanctum')->group(function () {
    Route::get('/{id}', [UserController::class, 'findById']);
    
    Route::put('/update/email', [UserController::class, 'updateEmail']);
    Route::put('/update/username', [UserController::class, 'updateUsername']);
    Route::put('/update/password', [UserController::class, 'updatePassword']);
});