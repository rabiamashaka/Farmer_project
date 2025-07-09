<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        /* ---------- DEFAULTS ---------- */
        $activeFarmers    = 0;
        $smsSentToday     = 0;
        $publishedContent = 0;
        $deliveryRate     = 0;

        /* ---------- ACTIVE FARMERS ---------- */
        if (Schema::hasTable('farmers')) {
            $activeFarmers = DB::table('farmers')->count();
        }

        /* ---------- SMS METRICS ---------- */
        if (Schema::hasTable('sms_logs')) {          // badilisha jina kama meza ni nyingine
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

        /* ---------- PUBLISHED CONTENT ---------- */
        if (Schema::hasTable('contents')) {
            $publishedContent = DB::table('contents')
                ->where('status', 'published')
                ->count();
        }

        /* ---------- WEATHER NOTIFICATIONS ---------- */
        $notifications = $request->session()->get('weather_notifications', []);
        if (!is_array($notifications)) {
            $notifications = [];
        }

        /* ---------- SEND TO VIEW ---------- */
        return view('dashboard', compact(
            'activeFarmers',
            'smsSentToday',
            'publishedContent',
            'deliveryRate',
            'notifications'
        ));
    }
}
