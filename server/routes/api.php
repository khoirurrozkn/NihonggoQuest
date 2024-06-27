<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RankController;
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

Route::prefix('/user')->group(function () {

    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);

    Route::middleware(['auth:sanctum', 'abilities:user,admin'])->group(function() {
        Route::get('/{id}', [UserController::class, 'findById']);
        Route::delete('/{id}', [UserController::class, 'deleteById']);
    });
    
    Route::middleware(['auth:sanctum', 'ability:user'])->group(function() {
        Route::put('/email', [UserController::class, 'updateEmail']);
        Route::put('/username', [UserController::class, 'updateUsername']);
        Route::put('/password', [UserController::class, 'updatePassword']);
    });

});

Route::prefix('/admin')->group(function () {

    Route::post('/login', [AdminController::class, 'login']);

    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function() {
        Route::post('/register', [AdminController::class, 'register']);
        Route::get('/', [AdminController::class, 'findAll']);
        Route::delete('/{id}', [AdminController::class, 'deleteById']);
    });
    
});

Route::prefix('/rank')->group(function () {

    Route::middleware(['auth:sanctum', 'ability:admin'])->group(function() {
        Route::post('/', [RankController::class, 'create']);
    });
    
});

Route::get('/', function(){
    // try{

    $tes = (new a)->b();

    // }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
    //     return response()->json([
    //         'code' => $e->getMessage()
    //     ]);
    // }
});

class a{
    public function b(){
        throw new \Illuminate\Database\Eloquent\ModelNotFoundException("tidak di temukan");
    }
}