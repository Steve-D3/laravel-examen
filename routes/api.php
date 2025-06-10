<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/trips', [TripController::class, 'index']);

// Bookings endpoints
Route::prefix('bookings')->group(function () {
    Route::get('/', [BookingController::class, 'index']);
    Route::post('/', [BookingController::class, 'store']);
});
