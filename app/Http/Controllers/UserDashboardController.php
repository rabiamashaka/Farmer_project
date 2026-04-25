<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\SmsLog;
use App\Models\Weather;
use App\Models\Crop;
use App\Models\ContentTemplate;
use App\Models\CropAdvice;
use App\Models\CropDisease;
use App\Models\MarketPrice;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        // Fetch the Farmer model for the logged-in user
        $farmer = \App\Models\Farmer::where('user_id', $user->id)->first();
        $regions = Region::all();
        $userRegionId = $farmer ? $farmer->region_id : null;
        $messages = SmsLog::where('phone', $user->phone)->latest()->take(10)->get();

        $cropInfo = session('crop_info');
        $selectedCropId = session('selected_crop_id');
        $weatherSummary = session('weather') ?? $user->latest_weather;
        $information = session('information');
        
        // Get crops from the Farmer model, not User model
        $crops = $farmer ? $farmer->crops()->with('marketPrices')->get() : collect();

        // Debug logging
        \Log::info('UserDashboardController@index - Farmer and crops info', [
            'user_id' => $user->id,
            'farmer_id' => $farmer ? $farmer->id : null,
            'farmer_name' => $farmer ? $farmer->name : null,
            'crops_count' => $crops->count(),
            'crops_names' => $crops->pluck('name')->toArray(),
            'user_region_id' => $userRegionId
        ]);

        // Fetch market prices for user's crops and region
        $marketPrices = collect();
        if ($crops->count() && $userRegionId) {
            $marketPrices = MarketPrice::whereIn('crop_id', $crops->pluck('id'))
                ->where('region_id', $userRegionId)
                ->orderByDesc('market_date')
                ->get();
        }

        return view('userdashboard', compact(
            'regions',
            'userRegionId',
            'messages',
            'user',
            'farmer',
            'cropInfo',
            'selectedCropId',
            'weatherSummary',
            'information',
            'crops',
            'marketPrices'
        ));
    }

    public function fetchWeather(Request $request)
    {
        $region = Region::find($request->region);
        $weather = null;

        if ($region) {
            $weather = Weather::where('region_id', $region->id)->latest('measured_at')->first();
        }

        $summary = $region && $weather
            ? "{$region->name}: {$weather->condition}, 🌡 {$weather->temperature}°C, 🌧 {$weather->rain}mm (" . $weather->measured_at->format('d M Y H:i') . ")"
            : ($region ? "No weather data for {$region->name}." : "No region selected.");

        $user = auth()->user();
        $user->latest_weather = $summary;
        $user->save();

        return back()->with('weather', $summary);
    }

    public function sendFeedback(Request $request)
    {
        // You can expand this to store feedback in DB
        return back()->with('feedback_sent', 'Thank you for your feedback!');
    }

    public function cropInfo(Request $request)
    {
        $user = auth()->user();
        $user->load('crops');

        $cropId = $request->input('crop');
        $crop = $user->crops->where('id', $cropId)->first();

        $info = $crop
            ? "Advice for {$crop->name}: Water regularly, use organic fertilizer, and monitor for pests."
            : "Please select a crop to get information.";

        return redirect()->route('userdashboard')->with([
            'crop_info' => $info,
            'selected_crop_id' => $cropId,
        ]);
    }

    public function information(Request $request)
    {
        $query = $request->input('query');
        $filter = $request->input('filter');

        $info = ContentTemplate::query();

        if ($query) {
            $info->where('title', 'like', "%$query%")
                ->orWhere('content', 'like', "%$query%");
        }

        if ($filter && $filter !== 'all') {
            $info->where('category', $filter);
        }

        $information = $info->get();

        return redirect()->route('userdashboard')->with('information', $information);
    }

    /**
     * Search information by crop (only crops owned by user), region, and info type
     */
   public function searchInformation(Request $request)
    {
        $cropId = $request->input('crop_id');
        $regionId = $request->input('region_id');
        $infoType = $request->input('info_type');

        $results = collect();

        switch ($infoType) {
            case 'advice':
                $results = CropAdvice::where('crop_id', $cropId)
                    ->when($regionId, fn($q) => $q->where('region_id', $regionId))
                    ->get(['title', 'description']);
                break;

            case 'disease':
                $results = CropDisease::where('crop_id', $cropId)
                    ->get(['title', 'description']);
                break;

            case 'market':
                $results = MarketPrice::where('crop_id', $cropId)
                    ->when($regionId, fn($q) => $q->where('region_id', $regionId))
                    ->latest('market_date')
                    ->get(['price_per_kg', 'currency', 'market_date', 'source']);
                break;
        }

        return redirect()->route('userdashboard.dashboard')->with([
            'results' => $results,
            'infoType' => $infoType,
        ]);
    }

    public function searchInformationByCropAndRegion(Request $request)
    {
        $user = auth()->user();
        $farmer = \App\Models\Farmer::where('user_id', $user->id)->first();
        $crops = $farmer ? $farmer->crops : collect();

        $userCropsIds = $crops->pluck('id')->toArray();

        $request->validate([
            'crop_id' => 'required|in:' . implode(',', $userCropsIds),
            'region_id' => 'nullable|exists:regions,id',
            'info_type' => 'required|in:advice,disease,market',
        ]);

        $cropId = $request->crop_id;
        $regionId = $request->region_id;
        $infoType = $request->info_type;

        \Log::info('UserDashboardController@searchInformationByCropAndRegion called', [
            'crop_id' => $cropId,
            'region_id' => $regionId,
            'info_type' => $infoType,
            'user_id' => $user->id
        ]);

        $results = collect();

        try {
            if ($infoType === 'advice') {
                // Fetch crop advice - no region filter for advice as it's general
                $results = CropAdvice::where('crop_id', $cropId)->get();
                \Log::info('CropAdvice query executed', ['count' => $results->count()]);
            } elseif ($infoType === 'disease') {
                // Fetch crop diseases - can be filtered by region
                $query = CropDisease::where('crop_id', $cropId);
                if ($regionId) {
                    $query->where('region_id', $regionId);
                }
                $results = $query->get();
                \Log::info('CropDisease query executed', ['count' => $results->count(), 'region_filter' => $regionId]);
            } elseif ($infoType === 'market') {
                // Fetch market prices - can be filtered by region
                $query = MarketPrice::where('crop_id', $cropId);
                if ($regionId) {
                    $query->where('region_id', $regionId);
                }
                $results = $query->orderByDesc('market_date')->get();
                \Log::info('MarketPrice query executed', ['count' => $results->count(), 'region_filter' => $regionId]);
            }
        } catch (\Exception $e) {
            \Log::error('Error fetching information', [
                'error' => $e->getMessage(),
                'crop_id' => $cropId,
                'region_id' => $regionId,
                'info_type' => $infoType
            ]);
            return back()->with('error', 'Error fetching information. Please try again.');
        }

        $regions = \App\Models\Region::all();
        $messages = \App\Models\SmsLog::where('phone', $user->phone)->latest()->take(10)->get();
        $userRegionId = $farmer ? $farmer->region_id : null;
        $marketPrices = collect();
        if ($crops->count() && $userRegionId) {
            $marketPrices = \App\Models\MarketPrice::whereIn('crop_id', $crops->pluck('id'))
                ->where('region_id', $userRegionId)
                ->orderByDesc('market_date')
                ->get();
        }

        \Log::info('Returning view with results', [
            'results_count' => $results->count(),
            'info_type' => $infoType
        ]);

        return view('userdashboard', [
            'user' => $user,
            'farmer' => $farmer,
            'crops' => $crops,
            'regions' => $regions,
            'results' => $results,
            'infoType' => $infoType,
            'messages' => $messages,
            'marketPrices' => $marketPrices,
            'userRegionId' => $userRegionId,
            'activeSection' => 'getinfo',
        ]);
    }

    public function dashboard()
    {
        $user = auth()->user();
        $crops = $user->crops;
        $regions = Region::all();
        $messages = $user->messages()->latest()->get();

        return view('dashboard.farmer', [
            'user' => $user,
            'crops' => $crops,
            'regions' => $regions,
            'messages' => $messages,
            'userRegionId' => optional($user->region)->id,
            'weatherSummary' => session('weather'),
            'results' => session('results'),
            'infoType' => session('infoType'),
            'information' => collect(),
        ]);
    }

    public function marketPriceLookup(Request $request)
    {
        $user = auth()->user();
        $farmer = \App\Models\Farmer::where('user_id', $user->id)->first();
        $crops = $farmer ? $farmer->crops : collect();
        $regions = Region::all();
        $userRegionId = $farmer ? $farmer->region_id : null;
        $messages = SmsLog::where('phone', $user->phone)->latest()->take(10)->get();
        $weatherSummary = session('weather') ?? $user->latest_weather;
        $marketPrices = collect();
        if ($crops->count() && $userRegionId) {
            $marketPrices = MarketPrice::whereIn('crop_id', $crops->pluck('id'))
                ->where('region_id', $userRegionId)
                ->orderByDesc('market_date')
                ->get();
        }

        $selectedMarketCropId = $request->input('crop_id');
        $marketPriceResult = null;
        $marketPriceError = null;
        if ($selectedMarketCropId && $userRegionId) {
            $crop = $crops->where('id', $selectedMarketCropId)->first();
            $region = $regions->where('id', $userRegionId)->first();
            $latestPrice = MarketPrice::where('crop_id', $selectedMarketCropId)
                ->where('region_id', $userRegionId)
                ->orderByDesc('market_date')
                ->first();
            if ($latestPrice && $crop && $region) {
                $marketPriceResult = [
                    'crop' => $crop->name,
                    'region' => $region->name,
                    'price' => $latestPrice->price_per_kg,
                    'currency' => $latestPrice->currency,
                    'date' => $latestPrice->market_date,
                    'source' => $latestPrice->source,
                ];
            } else {
                $marketPriceError = 'No market price found for this crop in your region.';
            }
        } else {
            $marketPriceError = 'Please select a crop.';
        }

        return view('userdashboard', [
            'user' => $user,
            'farmer' => $farmer,
            'crops' => $crops,
            'regions' => $regions,
            'messages' => $messages,
            'weatherSummary' => $weatherSummary,
            'marketPrices' => $marketPrices,
            'userRegionId' => $userRegionId,
            'selectedMarketCropId' => $selectedMarketCropId,
            'marketPriceResult' => $marketPriceResult,
            'marketPriceError' => $marketPriceError,
        ]);
    }

    public function marketPricesAll(Request $request)
    {
        $user = auth()->user();
        $farmer = \App\Models\Farmer::where('user_id', $user->id)->first();
        $crops = $farmer ? $farmer->crops : collect();
        $regions = Region::all();
        $userRegionId = $farmer ? $farmer->region_id : null;
        $messages = SmsLog::where('phone', $user->phone)->latest()->take(10)->get();
        $weatherSummary = session('weather') ?? $user->latest_weather;
        $marketPrices = collect();
        if ($crops->count() && $userRegionId) {
            $marketPrices = MarketPrice::whereIn('crop_id', $crops->pluck('id'))
                ->where('region_id', $userRegionId)
                ->orderByDesc('market_date')
                ->get();
        }

        $selectedAllMarketCropId = $request->input('crop_id');
        $selectedAllMarketRegionId = $request->input('region_id');
        $allMarketPrices = collect();
        if ($selectedAllMarketCropId) {
            $query = MarketPrice::where('crop_id', $selectedAllMarketCropId);
            if ($selectedAllMarketRegionId) {
                $query->where('region_id', $selectedAllMarketRegionId);
            }
            $allMarketPrices = $query->orderByDesc('market_date')->get();
        }

        return view('userdashboard', [
            'user' => $user,
            'farmer' => $farmer,
            'crops' => $crops,
            'regions' => $regions,
            'messages' => $messages,
            'weatherSummary' => $weatherSummary,
            'marketPrices' => $marketPrices,
            'userRegionId' => $userRegionId,
            'selectedAllMarketCropId' => $selectedAllMarketCropId,
            'selectedAllMarketRegionId' => $selectedAllMarketRegionId,
            'allMarketPrices' => $allMarketPrices,
        ]);
    }
}