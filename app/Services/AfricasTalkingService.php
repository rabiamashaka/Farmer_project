<?php

namespace App\Services;

use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;

class AfricasTalkingService
{
    protected $sms;

    public function __construct()
    {
        
        $username = config('services.africastalking.username'); 
        $apiKey = config('services.africastalking.api_key');    

        
        $at = new AfricasTalking($username, $apiKey);

      
        $this->sms = $at->sms();
    }

    /**
     * Send SMS using Africa's Talking SDK
     *
     * @param string $phone
     * @param string $message
     * @return array|false
     */
    public function sendSms($phone, $message)
    {
        try {
            $response = $this->sms->send([
                'to'      => $phone,
                'message' => $message,
                'from'    => config('services.africastalking.sender_id'), 
            ]);

            return $response;
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());

            return false;
        }
    }
}
