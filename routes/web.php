<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    WeatherMarketController,
    ContentController,
    FarmerController,
    Sms_logs,
    Analytics,
    SmsCampaignsController,
    TestSmsController,
    UserDashboardController,
    CropInformationController
};

use App\Services\NotifyAfricanService;

/* ----------  PUBLIC ---------- */
Route::view('/', 'welcome')->name('welcome');

// Switch language route (sets session('locale'))
Route::post('/set-locale/{locale}', function ($locale, Request $request) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
    }
    return back();
});

// Public translation API
Route::post('/translate-text', [SmsCampaignsController::class, 'translate'])->name('translate.text');

/* ----------  AUTH ---------- */
require __DIR__.'/auth.php';

/* ----------  LOGGED‑IN USERS ---------- */
Route::middleware(['auth', 'verified'])->group(function () {
    /* ----- Admin ----- */
    Route::middleware('role:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('content', ContentController::class);
        Route::resource('farmer', FarmerController::class);
        Route::resource('sms_campaigns', SmsCampaignsController::class);

        Route::post('/translate', [SmsCampaignsController::class, 'translate'])->name('translate.message');
        Route::post('/sms_campaigns/quick-sms', [SmsCampaignsController::class, 'sendQuickSms'])->name('sms_campaigns.quickSms');
        Route::get('/sms_campaigns/balance', [SmsCampaignsController::class, 'getBalance'])->name('sms_campaigns.balance');
        Route::post('/sms_campaigns/delivery-status', [SmsCampaignsController::class, 'getDeliveryStatus'])->name('sms_campaigns.deliveryStatus');
        Route::get('/analytics', [Analytics::class, 'analytics'])->name('analytics');
        Route::prefix('admin/crop-information')->name('admin.cropinfo.')->group(function () {
            Route::get('/', [\App\Http\Controllers\CropInformationController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\CropInformationController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\CropInformationController::class, 'store'])->name('store');
            Route::get('/{cropinfo}/edit', [\App\Http\Controllers\CropInformationController::class, 'edit'])->name('edit');
            Route::put('/{cropinfo}', [\App\Http\Controllers\CropInformationController::class, 'update'])->name('update');
            Route::delete('/{cropinfo}', [\App\Http\Controllers\CropInformationController::class, 'destroy'])->name('destroy');
        });
    });

    /* ----- Farmer ----- */
    Route::middleware('role:user')->group(function () {
        Route::get('/userdashboard', [\App\Http\Controllers\UserDashboardController::class, 'index'])->name('userdashboard');
        Route::post('/userdashboard/weather', [\App\Http\Controllers\UserDashboardController::class, 'fetchWeather'])->name('userdashboard.weather');
        Route::post('/userdashboard/feedback', [\App\Http\Controllers\UserDashboardController::class, 'sendFeedback'])->name('userdashboard.feedback');
        Route::post('/userdashboard/cropinfo', [\App\Http\Controllers\UserDashboardController::class, 'cropInfo'])->name('userdashboard.cropinfo');
    });

    /* ----- Shared Routes ----- */
    Route::controller(WeatherMarketController::class)->group(function () {
        Route::get ('/weather-market', 'index')->name('weather-market');
        Route::post('/weather/refresh', 'refresh')->name('weather.refresh');
    });

    Route::get('/sms-log', [Sms_logs::class, 'index'])->name('sms.logs');

    Route::controller(ProfileController::class)->group(function () {
        Route::get   ('/profile', 'edit')->name('profile.edit');
        Route::patch ('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

// Test SMS page
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/test-sms', [TestSmsController::class, 'showForm'])->name('test-sms.form');
    Route::post('/test-sms', [TestSmsController::class, 'send'])->name('test-sms.send');
});

Route::match(['get', 'post'], '/test-notifyafrican-sms', function(Request $request, NotifyAfricanService $sms) {
    if ($request->isMethod('post')) {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
        ]);
        $result = $sms->sendSms($request->phone, $request->message);
        return response()->json($result);
    }
    return view('test-sms');
});
