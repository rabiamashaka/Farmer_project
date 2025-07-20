<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UssdController;
use App\Http\Controllers\GeminiAgricultureController;
use App\Services\NotifyAfricanService;
use Illuminate\Http\Request;

Route::post('/ussd', [UssdController::class, 'handler']);
Route::post('/askagricultureexpert', [GeminiAgricultureController::class, 'ask']);

// Test route for Gemini API (no CSRF protection)
Route::post('/test-gemini', [GeminiAgricultureController::class, 'ask']);

Route::post('/test-notifyafrican-sms', function(Request $request, NotifyAfricanService $sms) {
    $request->validate([
        'phone' => 'required|string',
        'message' => 'required|string|max:160',
    ]);
    $result = $sms->sendSms($request->phone, $request->message);
    return response()->json($result);
});