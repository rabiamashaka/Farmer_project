<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class sms_logs extends Controller
{
    public function smsLogs()
    {
        return view('sms-log');
    }

}
