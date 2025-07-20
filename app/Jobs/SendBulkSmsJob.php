<?php

namespace App\Jobs;

use App\Models\SmsLog;
use App\Models\SmsCampaign;
use App\Services\NotifyAfricanService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendBulkSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phones;
    protected $message;
    protected $campaignId;
    protected $batchSize;

    /**
     * Create a new job instance.
     */
    public function __construct($phones, $message, $campaignId = null, $batchSize = 100)
    {
        $this->phones = $phones;
        $this->message = $message;
        $this->campaignId = $campaignId;
        $this->batchSize = $batchSize;
    }

    /**
     * Execute the job.
     */
    public function handle(NotifyAfricanService $sms)
    {
        try {
            // Send bulk SMS using Modifier Africa
            $response = $sms->sendBulkSms($this->phones, $this->message);

            if (isset($response['error'])) {
                Log::error('Bulk SMS failed', [
                    'campaign_id' => $this->campaignId,
                    'error' => $response['error']
                ]);

                // Log failed attempts
                foreach ($this->phones as $phone) {
                    SmsLog::create([
                        'campaign_id' => $this->campaignId,
                        'phone' => $phone,
                        'message' => $this->message,
                        'direction' => 'outgoing',
                        'status' => 'failed',
                        'sent_at' => now(),
                    ]);
                }

                return;
            }

            // Log successful bulk send
            Log::info('Bulk SMS sent successfully', [
                'campaign_id' => $this->campaignId,
                'count' => count($this->phones),
                'response' => $response
            ]);

            // Create individual SMS logs for each phone
            foreach ($this->phones as $phone) {
                SmsLog::create([
                    'campaign_id' => $this->campaignId,
                    'phone' => $phone,
                    'message' => $this->message,
                    'direction' => 'outgoing',
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);
            }

            // Update campaign status if campaign exists
            if ($this->campaignId) {
                $campaign = SmsCampaign::find($this->campaignId);
                if ($campaign) {
                    $campaign->update([
                        'status' => 'sent',
                        'sent_to' => $campaign->sent_to + count($this->phones),
                    ]);
                }
            }

        } catch (\Exception $e) {
            Log::error('Bulk SMS job exception', [
                'campaign_id' => $this->campaignId,
                'error' => $e->getMessage()
            ]);

            // Log failed attempts
            foreach ($this->phones as $phone) {
                SmsLog::create([
                    'campaign_id' => $this->campaignId,
                    'phone' => $phone,
                    'message' => $this->message,
                    'direction' => 'outgoing',
                    'status' => 'failed',
                    'sent_at' => now(),
                ]);
            }
        }
    }
} 