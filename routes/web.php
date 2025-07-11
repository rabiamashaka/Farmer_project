<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    WeatherMarketController,
    ContentController,
    FarmerController,
    Sms_logs,   // ← controller ya sms_logs (tazama faili #3)
    Analytics,
    SmsCampaignsController
};

/* ----------  PUBLIC ---------- */
Route::view('/', 'welcome')->name('welcome');

/* ----------  LARAVEL AUTH (Breeze/Fortify) ---------- */
require __DIR__.'/auth.php';

/* ----------  ALL LOGGED‑IN USERS ---------- */
Route::middleware('auth')->group(function () {

    /* ----- Admin‑only ----- */
    Route::middleware('role:admin')->group(function () {

        // DASHBOARD – inatumia controller sasa
        Route::get('/dashboard', [DashboardController::class, 'index'])
             ->name('dashboard');

        Route::resource('content', ContentController::class);
        Route::resource('farmer',  FarmerController::class);
        Route::resource('sms_campaigns', SmsCampaignsController::class);
Route::post('/translate', [SmsCampaignsController::class, 'translate'])->name('translate.message');

        Route::post('/sms_campaigns/quick-sms',
                    [SmsCampaignsController::class, 'sendQuickSms'])
             ->name('sms_campaigns.quickSms');

        Route::get('/analytics', [Analytics::class, 'analytics'])
             ->name('analytics');
    });

    /* ----- Farmer/user‑only ----- */
    Route::middleware('role:user')->group(function () {
        Route::view('/userdashboard', 'userdashboard')->name('userdashboard');
        // add other farmer‑specific routes here…
    });

    /* ----- Shared by both roles ----- */
    Route::controller(WeatherMarketController::class)->group(function () {
        Route::get ('/weather-market', 'index')->name('weather-market');
        Route::post('/weather/refresh', 'refresh')->name('weather.refresh');
    });

    // SMS log viewer (hiari)
    Route::get('/sms-log', [Sms_logs::class, 'index'])
         ->name('sms.logs');

    /* ----- Profile management ----- */
    Route::controller(ProfileController::class)->group(function () {
        Route::get   ('/profile', 'edit')->name('profile.edit');
        Route::patch ('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});
