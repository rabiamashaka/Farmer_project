<?php

// Test script for Modifier Africa with your specific credentials
// Run with: php test_modifier_africa.php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Services\ModifierAfricaService;

echo "=== Modifier Africa Test ===\n\n";

// Your credentials
$apiKey = '936|ozMnSRZdDkKN2B8dFDxQikdB5NqUrIuJr4hkWjVG638f79c9';
$senderId = '55';

echo "🔑 API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -10) . "\n";
echo "📱 Sender ID: {$senderId}\n\n";

// Create service instance
$sms = new ModifierAfricaService();

// Test 1: Account Balance
echo "1️⃣ Testing Account Balance...\n";
try {
    $balance = $sms->getBalance();
    if (isset($balance['balance'])) {
        echo "✅ Balance: {$balance['balance']} credits\n";
    } elseif (isset($balance['error'])) {
        echo "❌ Error: {$balance['error']}\n";
    } else {
        echo "⚠️  Unexpected response: " . json_encode($balance) . "\n";
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Test 2: Single SMS
echo "2️⃣ Testing Single SMS...\n";
try {
    $result = $sms->sendSms('+255712345678', 'Test message from Modifier Africa - ' . date('Y-m-d H:i:s'));
    
    if (isset($result['message_id'])) {
        echo "✅ SMS sent successfully!\n";
        echo "📝 Message ID: {$result['message_id']}\n";
        echo "📊 Status: {$result['status']}\n";
        if (isset($result['cost'])) {
            echo "💰 Cost: {$result['cost']}\n";
        }
    } elseif (isset($result['error'])) {
        echo "❌ Error: {$result['error']}\n";
    } else {
        echo "⚠️  Unexpected response: " . json_encode($result) . "\n";
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("-", 50) . "\n\n";

// Test 3: Bulk SMS (small test)
echo "3️⃣ Testing Bulk SMS...\n";
try {
    $phones = ['+255712345678', '+255798765432']; // Test with 2 numbers
    $result = $sms->sendBulkSms($phones, 'Bulk test message from Modifier Africa - ' . date('Y-m-d H:i:s'));
    
    if (isset($result['batch_id'])) {
        echo "✅ Bulk SMS sent successfully!\n";
        echo "📦 Batch ID: {$result['batch_id']}\n";
        echo "📊 Status: {$result['status']}\n";
        echo "📱 Total SMS: " . count($phones) . "\n";
        if (isset($result['estimated_cost'])) {
            echo "💰 Estimated Cost: {$result['estimated_cost']}\n";
        }
    } elseif (isset($result['error'])) {
        echo "❌ Error: {$result['error']}\n";
    } else {
        echo "⚠️  Unexpected response: " . json_encode($result) . "\n";
    }
} catch (Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎉 Test completed!\n\n";

echo "💡 Next Steps:\n";
echo "1. Check your Modifier Africa dashboard for delivery reports\n";
echo "2. Test through the web interface: http://localhost:8000/sms_campaigns\n";
echo "3. Try creating a campaign with multiple farmers\n";
echo "4. Monitor the SMS logs for delivery status\n";

?> 