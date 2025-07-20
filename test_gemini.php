<?php

// Test script for Gemini Agriculture API
// Make sure you have GEMINI_API_KEY in your .env file

// Test data
$testQuestions = [
    "What are the best practices for growing tomatoes in Kenya?",
    "How can I improve soil fertility naturally?",
    "What are the common pests that affect maize crops?",
    "What is the best time to plant beans in Kenya?",
    "How do I control weeds in my farm without chemicals?"
];

echo "=== Testing Gemini Agriculture API ===\n\n";

foreach ($testQuestions as $index => $question) {
    echo "Test " . ($index + 1) . ": " . $question . "\n";
    echo "Response:\n";
    
    // Make API call
    $response = testGeminiAPI($question);
    echo $response . "\n";
    echo str_repeat("-", 50) . "\n\n";
}

function testGeminiAPI($question) {
    $url = 'http://localhost:8000/api/askagricultureexpert';
    
    $data = [
        'question' => $question
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
        return "Error: Could not connect to API";
    }
    
    return $result;
}

echo "Testing completed!\n";
?> 