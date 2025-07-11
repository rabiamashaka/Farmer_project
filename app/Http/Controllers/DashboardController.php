<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Weather;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $activeFarmers    = 0;
        $smsSentToday     = 0;
        $publishedContent = 0;
        $deliveryRate     = 0;

        // ACTIVE FARMERS
        if (Schema::hasTable('farmers')) {
            $activeFarmers = DB::table('farmers')->count();
        }

        // SMS STATS
        if (Schema::hasTable('sms_logs')) {
            $smsSentToday = DB::table('sms_logs')
                ->whereDate('sent_at', $today)
                ->count();

            $totalSent = DB::table('sms_logs')->count();
            $totalDelivered = DB::table('sms_logs')
                ->where('status', 'delivered')
                ->count();

            $deliveryRate = $totalSent
                ? round(($totalDelivered / $totalSent) * 100, 1)
                : 0;
        }

        // PUBLISHED CONTENT
        if (Schema::hasTable('contents')) {
            $publishedContent = DB::table('contents')
                ->where('status', 'published')
                ->count();
        }

        // WEATHER NOTIFICATIONS (recent, extreme or rainy)
        $notifications = [];

        if (Schema::hasTable('weather')) {
            $latestWeather = Weather::with('region')
                ->latest('measured_at')
                ->take(5)
                ->get();

            foreach ($latestWeather as $weather) {
                if ($weather->rain > 0 || $weather->temperature > 35 || $weather->temperature < 15) {
                    $notifications[] = [
                        'message' => "📍 {$weather->region->name} - {$weather->condition}, 🌡 {$weather->temperature}°C, 🌧 {$weather->rain}mm",
                        'time'    => $weather->measured_at->diffForHumans(),
                    ];
                }
            }
        }

        return view('dashboard', compact(
            'activeFarmers',
            'smsSentToday',
            'publishedContent',
            'deliveryRate',
            'notifications'
        ));
    }
}
