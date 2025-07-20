<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotifyAfricanService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.notifyafrican.api_key');
        $this->baseUrl = config('services.notifyafrican.base_url', 'https://api.notify.africa/v2');
    }

    public function sendSms($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/sms/send', [
                'to' => $phone,
                'message' => $message,
                'sender_id' => config('services.notifyafrican.sender_id'),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('NotifyAfrica SMS sent successfully', [
                    'phone' => $phone,
                    'message_id' => $data['message_id'] ?? null,
                    'status' => $data['status'] ?? 'sent'
                ]);
                return $data;
            } else {
                Log::error('NotifyAfrican SMS failed', [
                    'phone' => $phone,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ['error' => 'Failed to send SMS', 'status' => 'failed'];
            }
        } catch (\Exception $e) {
            Log::error('NotifyAfrican SMS exception', [
                'phone' => $phone,
                'error' => $e->getMessage()
            ]);
            return ['error' => $e->getMessage(), 'status' => 'failed'];
        }
    }

    /**
     * Send bulk SMS to multiple recipients by looping sendSms.
     *
     * @param array $phones
     * @param string $message
     * @return array
     */
    public function sendBulkSms(array $phones, string $message)
    {
        $results = [];
        foreach ($phones as $phone) {
            $results[$phone] = $this->sendSms($phone, $message);
        }
        return [
            'batch_id' => null,
            'results' => $results,
        ];
    }
} 