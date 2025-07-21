<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\SmsLog;
use App\Models\Weather;
use App\Models\Crop;

class UserDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load('crops', 'region');
        $regions = Region::all();
        $userRegionId = $user->region_id;
        $messages = SmsLog::where('phone', $user->phone)->latest()->take(10)->get();

        $cropInfo = session('crop_info');
        $selectedCropId = session('selected_crop_id');
        $weatherSummary = session('weather') ?? $user->latest_weather;

        return view('userdashboard', compact('regions', 'userRegionId', 'messages', 'user', 'cropInfo', 'selectedCropId', 'weatherSummary'));
    }

    public function fetchWeather(Request $request)
    {
        $region = Region::find($request->region);
        $weather = null;
        if ($region) {
            $weather = Weather::where('region_id', $region->id)
                ->latest('measured_at')
                ->first();
        }
        if ($weather) {
            $summary = "{$region->name}: {$weather->condition}, 🌡 {$weather->temperature}°C, 🌧 {$weather->rain}mm (" . $weather->measured_at->format('d M Y H:i') . ")";
        } else {
            $summary = $region ? "No weather data for {$region->name}." : "No region selected.";
        }
        // Save to user profile
        $user = auth()->user();
        $user->latest_weather = $summary;
        $user->save();
        return back()->with('weather', $summary);
    }

    public function sendFeedback(Request $request)
    {
        // Save feedback or send to admin (implement as needed)
        // Feedback::create([...]);
        return back()->with('feedback_sent', 'Thank you for your feedback!');
    }

    public function cropInfo(Request $request)
    {
        $user = auth()->user();
        $user->load('crops');
        $cropId = $request->input('crop');
        $crop = $user->crops->where('id', $cropId)->first();
        $info = null;
        if ($crop) {
            // Example: Replace with real advice/lookup/AI
            $info = "Advice for {$crop->name}: Water regularly, use organic fertilizer, and monitor for pests.";
        } else {
            $info = "Please select a crop to get information.";
        }
        return redirect()->route('userdashboard')->with(['crop_info' => $info, 'selected_crop_id' => $cropId]);
    }
}
