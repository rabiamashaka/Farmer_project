<?php

// Diagnostic script for Gemini API setup
// Run with: php diagnose_gemini.php

echo "=== Gemini API Diagnostic Tool ===\n\n";

// 1. Check if .env file exists
echo "1. Checking .env file...\n";
if (file_exists('.env')) {
    echo "✅ .env file exists\n";
} else {
    echo "❌ .env file not found\n";
    exit(1);
}

// 2. Check if GEMINI_API_KEY is set
echo "\n2. Checking GEMINI_API_KEY...\n";
$envContent = file_get_contents('.env');
if (strpos($envContent, 'GEMINI_API_KEY=') !== false) {
    echo "✅ GEMINI_API_KEY found in .env\n";
    
    // Extract the key
    preg_match('/GEMINI_API_KEY=(.*)/', $envContent, $matches);
    $apiKey = trim($matches[1] ?? '');
    
    if (!empty($apiKey)) {
        echo "✅ API key is not empty\n";
        echo "📏 API key length: " . strlen($apiKey) . " characters\n";
        
        // Check if it looks like a valid API key
        if (strlen($apiKey) > 20) {
            echo "✅ API key length looks reasonable\n";
        } else {
            echo "⚠️  API key seems too short\n";
        }
    } else {
        echo "❌ API key is empty\n";
    }
} else {
    echo "❌ GEMINI_API_KEY not found in .env\n";
    echo "💡 Add this line to your .env file:\n";
    echo "   GEMINI_API_KEY=your_api_key_here\n";
}

// 3. Test direct API call
echo "\n3. Testing direct API call...\n";
if (!empty($apiKey)) {
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . $apiKey;
    $data = [
        'contents' => [
            [
                'parts' => [
                    [
                        'text' => 'Hello, this is a test message.'
                    ]
                ]
            ]
        ]
    ];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/json\r\n",
            'method' => 'POST',
            'content' => json_encode($data)
        ]
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    
    if ($result === FALSE) {
        echo "❌ Failed to connect to Gemini API\n";
        echo "💡 Possible issues:\n";
        echo "   - Invalid API key\n";
        echo "   - Network connectivity issues\n";
        echo "   - API quota exceeded\n";
    } else {
        $response = json_decode($result, true);
        if (isset($response['candidates'])) {
            echo "✅ API call successful!\n";
            echo "📝 Response: " . substr($response['candidates'][0]['content']['parts'][0]['text'], 0, 100) . "...\n";
        } else {
            echo "❌ API call failed\n";
            echo "📄 Response: " . $result . "\n";
        }
    }
} else {
    echo "⚠️  Skipping API test - no API key available\n";
}

// 4. Check Laravel configuration
echo "\n4. Checking Laravel configuration...\n";
if (file_exists('config/services.php')) {
    echo "✅ services.php exists\n";
    
    $servicesConfig = include 'config/services.php';
    if (isset($servicesConfig['gemini']['api_key'])) {
        echo "✅ Gemini config found in services.php\n";
    } else {
        echo "❌ Gemini config missing in services.php\n";
    }
} else {
    echo "❌ services.php not found\n";
}

// 5. Check if you can get a valid API key
echo "\n5. Getting a Gemini API key...\n";
echo "🔗 Visit: https://makersuite.google.com/app/apikey\n";
echo "📝 Steps:\n";
echo "   1. Sign in with your Google account\n";
echo "   2. Click 'Create API Key'\n";
echo "   3. Copy the generated key\n";
echo "   4. Add it to your .env file as: GEMINI_API_KEY=your_key_here\n";

echo "\n=== Diagnostic Complete ===\n";
echo "💡 If you're still having issues:\n";
echo "   1. Make sure your API key is valid\n";
echo "   2. Check your internet connection\n";
echo "   3. Verify the API key has proper permissions\n";
echo "   4. Check if you've exceeded API quotas\n";
?> 