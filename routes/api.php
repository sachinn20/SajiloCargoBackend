<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NotificationController;



// Public routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Protected routes
Route::middleware(['auth:sanctum'])->group(function () {



    // ✅ Vehicle Management
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::put('/trips/{id}', [TripController::class, 'update']);
    Route::delete('/trips/{id}', [TripController::class, 'destroy']);

});

Route::post('/trips/search', [TripController::class, 'search']);

Route::middleware('auth:sanctum')->get('/trips/{id}/bookings', [TripController::class, 'tripBookings']);


Route::middleware('auth:sanctum')->get('/notifications', [NotificationController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'received']);
    Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
    Route::get('/user', [UserController::class, 'user']);

});