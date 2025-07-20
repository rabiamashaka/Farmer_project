<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
class sms_logs extends Controller
{
    
    public function index()
    {
        app()->setLocale(session('locale', config('app.locale')));
        $logs = DB::table('sms_logs')
            ->latest('sent_at')
            ->paginate(50);

        return view('sms-log', compact('logs'));
    }
}


