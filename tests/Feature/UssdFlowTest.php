<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Farmer;
use App\Models\User;

class UssdFlowTest extends TestCase
{
    public function test_registered_farmer_gets_main_menu()
    {
        // Create a user and farmer in the DB
        $user = User::factory()->create();
        Farmer::factory()->create(['user_id' => $user->id, 'phone' => '255700000003']);

        // Simulate USSD request (first entry)
        $response = $this->post('/api/ussd', [
            'phoneNumber' => '255700000003',
            'text' => '',
        ]);

        $response->assertSee('Ulishajisajili');
        $response->assertSee('1. Endelea na huduma');
    }

    public function test_ussd_info_menu_and_sms()
    {
        // Farmer with crop, region, etc. (add factories as needed)
        $user = User::factory()->create();
        $farmer = Farmer::factory()->create(['user_id' => $user->id, 'phone' => '255700000004', 'region_id' => 1]);
        // ...add crops, prices, etc.

        // Simulate USSD: Endelea na huduma (1), Taarifa (2), Hali ya hewa (1)
        $response = $this->post('/api/ussd', [
            'phoneNumber' => '255700000004',
            'text' => '1*2*1',
        ]);

        $response->assertSee('END'); // Should end session after sending SMS
        $response->assertSee('Taarifa ya hali ya hewa imetumwa kwa SMS.');
    }
} 