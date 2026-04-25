<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Services\NotifyAfricanService;
use Illuminate\Support\Facades\Http;

class SmsSendingTest extends TestCase
{
    public function test_send_sms_success()
    {
        // Fake HTTP response for NotifyAfricanService
        Http::fake([
            'api.notify.africa/*' => Http::response(['status' => 'sent'], 200),
        ]);

        $service = new NotifyAfricanService();
        $response = $service->sendSms('255700000001', 'Test message');

        $this->assertEquals('sent', $response['status']);
        Http::assertSent(function ($request) {
            return $request['sms'] === 'Test message'
                && $request['recipients'][0]['number'] === '255700000001';
        });
    }

    public function test_send_sms_failure()
    {
        Http::fake([
            'api.notify.africa/*' => Http::response(['error' => 'Failed'], 500),
        ]);

        $service = new NotifyAfricanService();
        $response = $service->sendSms('255700000002', 'Test fail');

        $this->assertEquals('failed', $response['status']);
    }
} 