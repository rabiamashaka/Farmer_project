<?php

use Illuminate\Support\Facades\Route;
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

/* ----------  PUBLIC ---------- */
Route::view('/', 'welcome')->name('welcome');

// Language switch route
Route::post('/set-locale/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'sw'])) {
        session(['locale' => $locale]);
    }
    return back();
});

// Public translation API
Route::post('/translate-text', [SmsCampaignsController::class, 'translate'])->name('translate.text');

/* ----------  AUTH ---------- */
require __DIR__.'/auth.php';

/* ----------  LOGGED-IN USERS ---------- */
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
            Route::get('/', [CropInformationController::class, 'index'])->name('index');
            Route::get('/create', [CropInformationController::class, 'create'])->name('create');
            Route::post('/store', [CropInformationController::class, 'store'])->name('store');
            Route::get('/{cropinfo}/edit', [CropInformationController::class, 'edit'])->name('edit');
            Route::put('/{cropinfo}', [CropInformationController::class, 'update'])->name('update');
            Route::delete('/{cropinfo}', [CropInformationController::class, 'destroy'])->name('destroy');
        });
    });

    /* ----- Farmer (User) ----- */
    Route::middleware('role:user')->group(function () {
        Route::get('/userdashboard', [UserDashboardController::class, 'index'])->name('userdashboard');
        Route::post('/userdashboard/weather', [UserDashboardController::class, 'fetchWeather'])->name('userdashboard.weather');
        Route::post('/userdashboard/feedback', [UserDashboardController::class, 'sendFeedback'])->name('userdashboard.feedback');
        Route::post('/userdashboard/cropinfo', [UserDashboardController::class, 'cropInfo'])->name('userdashboard.cropinfo');

        // Add this route for information search
        Route::post('/userdashboard/information-search', [UserDashboardController::class, 'searchInformationByCropAndRegion'])->name('userdashboard.information_search');
        // Friendly fallback for GET requests
        Route::get('/userdashboard/information-search', function() {
            return redirect()->route('userdashboard')->with('error', 'Please use the form to search for information.');
        });

        // Market price quick lookup
        Route::post('/userdashboard/market-price', [UserDashboardController::class, 'marketPriceLookup'])->name('userdashboard.market_price');

        // All market prices for a crop
        Route::post('/userdashboard/market-prices-all', [UserDashboardController::class, 'marketPricesAll'])->name('userdashboard.market_prices_all');

        // ✅ FIXED: This was misplaced before
        Route::get('/dashboard/information', [UserDashboardController::class, 'information'])->name('userdashboard.information');
    });

    /* ----- Shared Routes (Admins & Farmers) ----- */
    Route::controller(WeatherMarketController::class)->group(function () {
        Route::get('/weather-market', 'index')->name('weather-market');
        Route::post('/weather/refresh', 'refresh')->name('weather.refresh');
    });

    Route::get('/sms-log', [Sms_logs::class, 'index'])->name('sms.logs');

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile', 'update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });
});

/* ----------  SMS Testing (Admin Only) ---------- */
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/test-sms', [TestSmsController::class, 'showForm'])->name('test-sms.form');
    Route::post('/test-sms', [TestSmsController::class, 'send'])->name('test-sms.send');
});

/* ----------  NotifyAfrica SMS Test Route ---------- */
Route::match(['get', 'post'], '/test-notifyafrican-sms', function (Request $request, \App\Services\NotifyAfricanService $sms) {
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
