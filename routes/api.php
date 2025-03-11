<?php

use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index']);
    Route::get('/reviews/{id}', [ReviewController::class, 'show']);
    Route::post('/reviews', [ReviewController::class, 'store']);
    Route::put('/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

    Route::get('/restaurants', [RestaurantController::class, 'index']);
    Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
    Route::post('/restaurants', [RestaurantController::class, 'store']);
    Route::put('/restaurants/{id}', [RestaurantController::class, 'update']);
    Route::delete('/restaurants/{id}', [RestaurantController::class, 'destroy']);

    // Logout route
    Route::post('/logout', [AuthController::class, 'logout']);
});

