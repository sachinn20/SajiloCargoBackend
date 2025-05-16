<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\API\PriceSettingController;

use App\Http\Controllers\API\VehicleController;
use App\Http\Controllers\API\TripController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\Auth\NewPasswordController;




// ==========================
// ✅ Public Routes
// ==========================
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Forgot password (send reset link)
Route::post('/forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store']);

// Reset password
Route::post('/reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store']);



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

    Route::post('/khalti/initiate', [PaymentController::class, 'initiate']);
    Route::post('/khalti/lookup', [PaymentController::class, 'lookup'])->name('khalti.mobile.verify');

    Route::post('/instant-trip/complete', [BookingController::class, 'completeInstantTrip']);
    Route::post('/vehicles/{id}/maintain', [VehicleController::class, 'markAsMaintained']);



    // 👤 User Profile
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/profile', [UserController::class, 'getProfile']);

    Route::post('/profile/update', [UserController::class, 'updateProfile']);

    Route::post('/profile/change-password', [UserController::class, 'changePassword']);

    //priceSetting
    Route::get('/pricing', [PriceSettingController::class, 'getPricing']);


    //earning
    Route::get('/earnings', [BookingController::class, 'earnings']);
    Route::put('/bookings/{id}/mark-paid', function (Request $request, $id) {
    $booking = \App\Models\Booking::with('trip')->findOrFail($id);

    if (
        $booking->payment_mode === 'cash' &&
        $booking->trip &&
        $booking->trip->user_id === $request->user()->id
    ) {
        $booking->is_paid = true;
        $booking->save();
        return response()->json(['message' => 'Marked as paid']);
    }

    return response()->json(['error' => 'Unauthorized or not cash payment'], 403);
});

});


// ==========================
// 🔍 Trip Search (Public access)
// ==========================
Route::post('/trips/search', [TripController::class, 'search']);




Route::post('/verify-token', [NewPasswordController::class, 'verifyToken'])
    ->middleware('guest');