<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;

class AfricasTalkingService
{
    protected $sms;

    public function __construct()
    {
        $username = config('africastalking.username');
        $apiKey = config('africastalking.api_key');

        $at = new AfricasTalking($username, $apiKey);
        $this->sms = $at->sms();
    }

    public function sendSms($to, $message)
    {
        try {
            $result = $this->sms->send([
                'to' => $to,
                'message' => $message
            ]);
            return $result;
        } catch (\Exception $e) {
            \Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
