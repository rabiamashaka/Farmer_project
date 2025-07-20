<?php

// Simple test for Gemini API key
// Run with: php test_api_key.php

echo "=== Testing Gemini API Key ===\n\n";

// Read API key from .env
$envContent = file_get_contents('.env');
preg_match('/GEMINI_API_KEY=(.*)/', $envContent, $matches);
$apiKey = trim($matches[1] ?? '');

if (empty($apiKey)) {
    echo "❌ No API key found in .env file\n";
    echo "💡 Add: GEMINI_API_KEY=your_api_key_here\n";
    exit(1);
}

echo "🔑 API Key: " . substr($apiKey, 0, 10) . "..." . substr($apiKey, -10) . "\n";
echo "📏 Length: " . strlen($apiKey) . " characters\n\n";

// Test the API
$url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-pro:generateContent?key=' . $apiKey;
$data = [
    'contents' => [
        [
            'parts' => [
                [
                    'text' => 'Say hello in a friendly way.'
                ]
            ]
        ]
    ]
];

echo "🌐 Testing API call...\n";

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
    echo "❌ Failed to connect to API\n";
    echo "💡 Your API key might be invalid or expired\n";
    echo "🔗 Get a new key from: https://makersuite.google.com/app/apikey\n";
} else {
    $response = json_decode($result, true);
    
    if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
        echo "✅ API call successful!\n";
        echo "📝 Response: " . $response['candidates'][0]['content']['parts'][0]['text'] . "\n";
        echo "\n🎉 Your API key is working correctly!\n";
    } else {
        echo "❌ API call failed\n";
        echo "📄 Response: " . $result . "\n";
        echo "\n💡 Possible issues:\n";
        echo "   - API key is invalid\n";
        echo "   - API quota exceeded\n";
        echo "   - Network issues\n";
    }
}

echo "\n=== Test Complete ===\n";
?> 