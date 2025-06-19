<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherMarketController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\sms_Logs;
use App\Http\Controllers\Analytics;

// Public route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route (protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Auth routes
require __DIR__.'/auth.php';

// Authenticated user routes
Route::middleware(['auth'])->group(function () {

    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Farmer & Content management (RESTful)
    Route::resource('content', ContentController::class);
    Route::resource('farmer', FarmerController::class);

    // Other authenticated routes
    Route::get('/weather-market', [WeatherMarketController::class, 'show'])->name('weather-market');
    Route::get('/sms-log', [sms_Logs::class, 'smsLogs'])->name('sms.logs');
    Route::get('/analytics', [Analytics::class, 'analytics'])->name('analytics');
});
