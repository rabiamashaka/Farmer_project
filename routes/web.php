<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\weatherMarketController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FarmerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/content', [ContentController::class, 'index'])->name('content.index');
    

    Route::get('/farmer', [FarmerController::class, 'index'])->name('farmer.index');
});
Route::resource('content', \App\Http\Controllers\ContentController::class);
Route::resource('farmer', App\Http\Controllers\FarmerController::class);



    Route::get('/weather-market', [WeatherMarketController::class, 'show'])
    ->middleware(['auth'])
    ->name('weather-market');
