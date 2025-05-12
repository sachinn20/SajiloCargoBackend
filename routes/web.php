<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminController;

// Redirect root URL to admin login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// =============================
// Admin Auth Routes
// =============================
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

// =============================
// Admin Protected Routes
// =============================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Vehicles
    Route::get('/vehicles', [AdminController::class, 'vehicles'])->name('vehicles.index');

    // Trips
    Route::get('/trips', [AdminController::class, 'trips'])->name('trips.index');

    // Bookings
    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');

    // Payments
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');

    // Logout
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');
    Route::put('/pricing', [AdminController::class, 'updatePricing'])->name('pricing.update');
    

});
