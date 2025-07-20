<?php

namespace App\Jobs;

use App\Services\ModifierAfricaService;
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
    public function handle(ModifierAfricaService $sms)
    {
        $response = $sms->sendSms($this->phone, $this->message);

        // Determine status from Modifier Africa response
        $status = isset($response['status']) ? $response['status'] : 'Unknown';
        
        if (isset($response['error'])) {
            $status = 'failed';
        }

        // Save SMS log to database
        SmsLog::create([
            'campaign_id' => $this->campaignId,
            'phone'       => $this->phone,
            'message'     => $this->message,
            'direction'   => 'outgoing',
            'status'      => $status,
            'sent_at'     => now(),
            'message_id'  => $response['message_id'] ?? null,
        ]);
    }
}
