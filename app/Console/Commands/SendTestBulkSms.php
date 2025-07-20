<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotifyAfricanService;

class SendTestBulkSms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test-bulk';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test bulk SMS using NotifyAfricanService';

    /**
     * Execute the console command.
     */
    public function handle(NotifyAfricanService $sms)
    {
        $phones = ['+255700000001', '+255700000002']; // Replace with real test numbers if needed
        $message = 'This is a test bulk SMS from Artisan command.';

        $this->info('Sending bulk SMS...');
        $result = $sms->sendBulkSms($phones, $message);

        $this->info('Bulk SMS send result:');
        $this->line(print_r($result, true));
    }
} 