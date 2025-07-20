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
            $payload = [
                'recipients' => [$phone],
                'sms' => $message,
                'schedule' => 'none',
                'sender_id' => config('services.notifyafrican.sender_id'),
            ];
            Log::info('NotifyAfrica SMS request payload', $payload);
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->baseUrl . '/send-sms', $payload);

            Log::info('NotifyAfrica SMS response', [
                'status' => $response->status(),
                'body' => $response->body(),
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
     * Send bulk SMS to multiple recipients.
     *
     * @param array $phones
     * @param string $message
     * @return array
     */
    public function sendBulkSms(array $phones, string $message)
    {
        try {
            $payload = [
                'recipients' => $phones,
                'sms' => $message,
                'schedule' => 'none',
                'sender_id' => config('services.notifyafrican.sender_id'),
            ];
            Log::info('NotifyAfrica Bulk SMS request payload', $payload);
            $response = Http::asForm()->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
            ])->post($this->baseUrl . '/send-sms', $payload);

            Log::info('NotifyAfrica Bulk SMS response', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('NotifyAfrica Bulk SMS sent successfully', [
                    'phones' => $phones,
                    'status' => $data['status'] ?? 'sent'
                ]);
                return $data;
            } else {
                Log::error('NotifyAfrican Bulk SMS failed', [
                    'phones' => $phones,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ['error' => 'Failed to send bulk SMS', 'status' => 'failed'];
            }
        } catch (\Exception $e) {
            Log::error('NotifyAfrican Bulk SMS exception', [
                'phones' => $phones,
                'error' => $e->getMessage()
            ]);
            return ['error' => $e->getMessage(), 'status' => 'failed'];
        }
    }
} 