<?php

// Command-line test for Gemini Agriculture API
// Run with: php test_gemini_cli.php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Http\Controllers\GeminiAgricultureController;
use Illuminate\Http\Request;

echo "=== Gemini Agriculture API Test ===\n\n";

// Test questions
$testQuestions = [
    "What are the best practices for growing tomatoes in Kenya?",
    "How can I improve soil fertility naturally?",
    "What are the common pests that affect maize crops?"
];

$controller = new GeminiAgricultureController();

foreach ($testQuestions as $index => $question) {
    echo "Test " . ($index + 1) . ": " . $question . "\n";
    echo str_repeat("-", 50) . "\n";
    
    // Create a mock request
    $request = new Request();
    $request->merge(['question' => $question]);
    
    try {
        $response = $controller->ask($request);
        $data = json_decode($response->getContent(), true);
        
        if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            echo "✅ SUCCESS!\n";
            echo "Response: " . $data['candidates'][0]['content']['parts'][0]['text'] . "\n";
        } else {
            echo "❌ Unexpected response format:\n";
            echo json_encode($data, JSON_PRETTY_PRINT) . "\n";
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n" . str_repeat("=", 50) . "\n\n";
}

echo "Testing completed!\n";

// Test error cases
echo "\n=== Testing Error Cases ===\n\n";

// Test missing question
echo "Test: Missing question field\n";
$request = new Request();
$request->merge([]);

try {
    $response = $controller->ask($request);
    $data = json_decode($response->getContent(), true);
    echo "Response: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

echo "\nTesting completed!\n";
?> 