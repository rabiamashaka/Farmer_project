<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class sms_logs extends Controller
{
    public function index()
    {
        // Set locale from session or fallback to default
        app()->setLocale(session('locale', config('app.locale')));

        $messages = \DB::table('sms_logs')
            ->leftJoin('farmers', 'sms_logs.phone', '=', 'farmers.phone')
            ->select('sms_logs.*', 'farmers.name')
            ->latest('sms_logs.id')
            ->take(100)
            ->get();

        // Count stats for dashboard cards
        $totalSms = DB::table('sms_logs')->count();
        $sent = DB::table('sms_logs')->where('status', 'sent')->count();
        $pending = DB::table('sms_logs')->where('status', 'pending')->count();
        $failed = DB::table('sms_logs')->where('status', 'failed')->count();

        // Pass variables to view
        return view('sms-log', compact('messages', 'totalSms', 'sent', 'pending', 'failed'));
    }
}
