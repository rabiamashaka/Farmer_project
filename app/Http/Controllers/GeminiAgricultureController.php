<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class GeminiAgricultureController extends Controller
{
    public function ask(Request $request)
    {
        // Add CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Accept, X-Requested-With');
        
        // Handle preflight OPTIONS request
        if ($request->isMethod('OPTIONS')) {
            return response('', 200);
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $apiKey = config('services.gemini.api_key');
        $userQuestion = $request->input('question');

        // Check if API key is configured
        if (empty($apiKey)) {
            return response()->json([
                'error' => 'Gemini API key is not configured. Please add GEMINI_API_KEY to your .env file.'
            ], 500);
        }

        // This prompt guides Gemini to respond as an agriculture expert.
        $prompt = "You are an expert agricultural advisor. Your name is AgriBot. You will only answer questions related to agriculture, farming, crops, soil management, and other related topics. If a question is not related to agriculture, you must politely decline to answer. Here is the user's question: " . $userQuestion;

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . $apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt,
                            ],
                        ],
                    ],
                ],
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            // Log the error for debugging
            \Log::error('Gemini API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
                'api_key_length' => strlen($apiKey)
            ]);

            // Handle specific error cases
            if ($response->status() === 429) {
                return response()->json([
                    'error' => 'API quota exceeded. Please try again later or upgrade your API plan.',
                    'status' => 429,
                    'details' => 'Too many requests to Gemini API'
                ], 429);
            } elseif ($response->status() === 404) {
                return response()->json([
                    'error' => 'Gemini model not found. Please check API configuration.',
                    'status' => 404,
                    'details' => $response->body()
                ], 404);
            } else {
                return response()->json([
                    'error' => 'Failed to get a response from Gemini.',
                    'status' => $response->status(),
                    'details' => $response->body()
                ], $response->status());
            }

        } catch (\Exception $e) {
            \Log::error('Gemini API Exception', [
                'message' => $e->getMessage(),
                'api_key_length' => strlen($apiKey)
            ]);

            return response()->json([
                'error' => 'Exception occurred while calling Gemini API: ' . $e->getMessage()
            ], 500);
        }
    }
}