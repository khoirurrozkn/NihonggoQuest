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
    Route::put('/email', [UserController::class, 'updateEmail']);
    Route::put('/username', [UserController::class, 'updateUsername']);
    Route::put('/password', [UserController::class, 'updatePassword']);
    Route::delete('/{id}', [UserController::class, 'deleteById']);
});

// Route::get('/', function(){
//     return response()->json([
//         "message" => "wadawd"
//     ]);
// })->middleware('abilities:admin');