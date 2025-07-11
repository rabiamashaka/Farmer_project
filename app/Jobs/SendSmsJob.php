<?php

namespace App\Jobs;

use App\Services\AfricasTalkingService;
use App\Models\SmsLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;
    protected $message;
    protected $campaignId;

    /**
     * Create a new job instance.
     */
    public function __construct($phone, $message, $campaignId = null)
    {
        $this->phone = $phone;
        $this->message = $message;
        $this->campaignId = $campaignId;
    }

    /**
     * Execute the job.
     */
    public function handle(AfricasTalkingService $sms)
    {
        $response = $sms->sendSms($this->phone, $this->message);

        // Determine status from Africa's Talking response
        $status = is_array($response)
            && isset($response['data']['SMSMessageData']['Recipients'][0]['status'])
            ? $response['data']['SMSMessageData']['Recipients'][0]['status']
            : 'Unknown';

        // Save SMS log to database
        SmsLog::create([
            'campaign_id' => $this->campaignId,
            'phone'       => $this->phone,
            'message'     => $this->message,
            'direction'   => 'outgoing',
            'status'      => $status,
            'sent_at'     => now(),
        ]);
    }
}
