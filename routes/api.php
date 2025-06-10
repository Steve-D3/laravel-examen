<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::prefix('trips')->group(function () {
    Route::get('/', [TripController::class, 'index']);
    Route::get('/{trip}', [TripController::class, 'show']);

    // Protected routes (add auth middleware if needed)
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [TripController::class, 'store']);
        Route::put('/{trip}', [TripController::class, 'update']);
        Route::delete('/{trip}', [TripController::class, 'destroy']);
    });
});

// Bookings endpoints
Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index']);
    Route::get('/{booking}', [BookingController::class, 'show']);
    Route::post('/', [BookingController::class, 'store']);

    // Protected routes (add auth middleware if needed)
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/{booking}', [BookingController::class, 'update']);
        Route::put('/{booking}/status/{status}', [BookingController::class, 'updateStatus']);
        Route::delete('/{booking}', [BookingController::class, 'destroy']);
    });
});
