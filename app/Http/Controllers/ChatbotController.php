<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chat message.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'message' => ['required', 'string', 'max:500'],
        ]);

        $userMessage = $request->input('message');

        // TODO: Integrate with real NLP/LLM service.
        // For now, return a simple echo response.
        $botResponse = __('You said: ":msg"', ['msg' => $userMessage]);

        return response()->json([
            'reply' => $botResponse,
        ]);
    }
}
