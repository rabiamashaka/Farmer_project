<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
class sms_logs extends Controller
{
    
    public function index()
    {
        $logs = DB::table('sms_logs')
            ->latest('sent_at')
            ->paginate(50);

        return view('sms-log', compact('logs'));
    }
}


