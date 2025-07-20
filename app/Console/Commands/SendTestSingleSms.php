<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotifyAfricanService;

class SendTestSingleSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test-single';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test single SMS using NotifyAfricanService';

    /**
     * Execute the console command.
     */
    public function handle(NotifyAfricanService $sms)
    {
        $phone = '+255686477074';
        $message = 'This is a test single SMS from Artisan command.';

        $this->info('Sending single SMS...');
        $result = $sms->sendSms($phone, $message);

        $this->info('Single SMS send result:');
        $this->line(print_r($result, true));
    }
} 