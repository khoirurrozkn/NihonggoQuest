<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PhotoProfileController;
use App\Http\Controllers\RankController;
use App\Http\Controllers\UserController;
use App\Models\Admin;
use App\Models\PhotoProfile;
use App\Models\Rank;
use App\Models\User;
use App\Models\UserProfile;
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

    Route::middleware('auth:sanctum')->group(function() {

        Route::middleware('abilities:user,admin')->group(function() {
            Route::get('/{id}', [UserController::class, 'findById']);
            Route::delete('/{id}', [UserController::class, 'deleteById']);
        });
        
        Route::middleware('ability:user')->group(function() {
            Route::put('/email', [UserController::class, 'updateEmail']);
            Route::put('/username', [UserController::class, 'updateUsername']);
            Route::put('/password', [UserController::class, 'updatePassword']);
        });

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

Route::prefix('/rank')->middleware('auth:sanctum')->group(function () {

    Route::middleware('abilities:user,admin')->group(function() {
        Route::get('/', [RankController::class, 'findAll']);
        Route::get('/{id}', [RankController::class, 'findByIdWithTheirUsers']);
    });

    Route::middleware('ability:admin')->group(function() {
        Route::post('/', [RankController::class, 'create']);
    });
    
});

Route::prefix('/photo-profile')->middleware('auth:sanctum')->group(function () {

    Route::middleware('abilities:user,admin')->group(function() {
        Route::get('/', [PhotoProfileController::class, 'findAll']);
    });

    Route::middleware('ability:admin')->group(function() {
        Route::post('/', [PhotoProfileController::class, 'create']);
        Route::put('/{id}', [PhotoProfileController::class, 'updatePhotoUrlById']);
    });

});



Route::get('/', function(){
    return PhotoProfile::find(2);
});

Route::get('/seed', function () {
    Rank::create(['name' => 'Warior']);
    Rank::create(['name' => 'Grand Master']);
    Rank::create(['name' => 'Mythic']);

    PhotoProfile::create([
        'photo_url' => '123.jpg'
    ]);

    Admin::create([
        'id' => "1",
        'username' => 'admin',
        'password' => '$2y$10$0WirW8M9QncGcJCIhZ6oN.gI5LJ31hPksL540hOrqhDZYF1m95wmG'
    ]);

    User::create([
        'id' => '1',
        'email' => '123@gmail.com',
        'username' => '123',
        'password' => '$2y$10$CzXU8tbhk4gdU2wUMihiYOU1KNIYaQ3EF6.cMEXOShU8ODcGjrGxK',
        'last_access' => '2023-01-01'
    ]);
    
    UserProfile::create([
        'id' => '1',
        'user_id' => '1'
    ]);

    return response()->json([
        'message' => 'berhasil seed'
    ]);
    
});