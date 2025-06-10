<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TripController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::get('/trips', TripController::class)->name('admin.trips.index');
