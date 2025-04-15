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

// ==========================
// ✅ Public Routes
// ==========================
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// ==========================
// 🔒 Protected Routes (Sanctum Auth)
// ==========================
Route::middleware('auth:sanctum')->group(function () {

    // 🚗 Vehicle Management
    Route::get('/vehicles', [VehicleController::class, 'index']);
    Route::post('/vehicles', [VehicleController::class, 'store']);
    Route::put('/vehicles/{id}', [VehicleController::class, 'update']);
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy']);
    Route::get('/available-vehicles', [VehicleController::class, 'availableNearby']);


    // 🧽 Trip Management
    Route::get('/trips', [TripController::class, 'index']);
    Route::post('/trips', [TripController::class, 'store']);
    Route::put('/trips/{id}', [TripController::class, 'update']);
    Route::delete('/trips/{id}', [TripController::class, 'destroy']);
    Route::get('/trips/{id}/bookings', [TripController::class, 'tripBookings']);
    Route::post('/trips/update-status', [TripController::class, 'updateStatus']);
    Route::post('/instant-trip/complete', [BookingController::class, 'completeInstantTrip']);



    // 🔔 Notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);

   // 📦 Bookings
    Route::post('/bookings', [BookingController::class, 'store']);
    Route::get('/my-bookings', [BookingController::class, 'received']); // for vehicle owner dashboard
    Route::get('/received-bookings', [BookingController::class, 'received']); // ✅ Alias for clarity if needed
    Route::put('/bookings/{id}/status', [BookingController::class, 'updateStatus']);
    Route::get('/track/{trackingNo}', [BookingController::class, 'track']);
    Route::post('/bookings/instant', [\App\Http\Controllers\API\BookingController::class, 'instant']);

    Route::get('/my-bookings', [BookingController::class, 'myBookings']);
    Route::delete('/bookings/{id}', [BookingController::class, 'destroy']);
    Route::put('/bookings/{id}', [BookingController::class, 'updateBooking']);




    // 👤 User Profile
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/profile', [UserController::class, 'getProfile']);
    Route::post('/profile/update', [UserController::class, 'updateProfile']);
});

// ==========================
// 🔍 Trip Search (Public access)
// ==========================
Route::post('/trips/search', [TripController::class, 'search']);
