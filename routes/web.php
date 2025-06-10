<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TripController;
use App\Http\Controllers\Admin\BookingController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['web'])->group(function () {
    // Trips routes
    Route::prefix('trips')->name('trips.')->group(function () {
        Route::get('/', [TripController::class, 'index'])->name('index');
        Route::get('/create', [TripController::class, 'create'])->name('create');
        Route::post('/', [TripController::class, 'store'])->name('store');
        Route::get('/{trip}', [TripController::class, 'show'])->name('show');
        Route::get('/{trip}/edit', [TripController::class, 'edit'])->name('edit');
        Route::put('/{trip}', [TripController::class, 'update'])->name('update');
        Route::delete('/{trip}', [TripController::class, 'destroy'])->name('destroy');
    });
    
    // Bookings routes
    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/create', [BookingController::class, 'create'])->name('create');
        Route::post('/', [BookingController::class, 'store'])->name('store');
        Route::get('/{booking}', [BookingController::class, 'show'])->name('show');
        Route::get('/{booking}/edit', [BookingController::class, 'edit'])->name('edit');
        Route::put('/{booking}', [BookingController::class, 'update'])->name('update');
        Route::put('/{booking}/status/{status}', [BookingController::class, 'updateStatus'])->name('status');
        Route::delete('/{booking}', [BookingController::class, 'destroy'])->name('destroy');
    });
});

// Keep the old route for backward compatibility
Route::get('/trips', TripController::class)->name('admin.trips.index');
