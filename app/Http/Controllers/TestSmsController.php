<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModifierAfricaService;

class TestSmsController extends Controller
{
    public function showForm()
    {
        return view('test-sms');
    }

    public function send(Request $request, ModifierAfricaService $sms)
    {
        $request->validate([
            'phone' => 'required|string',
            'message' => 'required|string|max:160',
        ]);

        $result = $sms->sendSms($request->phone, $request->message);

        if (isset($result['message_id']) || (isset($result['status']) && $result['status'] === 'sent')) {
            return redirect()->route('test-sms.form')->with('success', 'SMS sent successfully!');
        } elseif (isset($result['error'])) {
            return redirect()->route('test-sms.form')->with('error', 'Error: ' . $result['error']);
        } else {
            return redirect()->route('test-sms.form')->with('error', 'Unknown error.');
        }
    }
} 