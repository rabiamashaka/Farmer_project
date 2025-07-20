#!/bin/bash

# Test script for Gemini Agriculture API using cURL
# Make sure your Laravel server is running: php artisan serve

echo "=== Testing Gemini Agriculture API ===\n"

# Test 1: Basic agriculture question
echo "Test 1: Basic agriculture question"
curl -X POST http://localhost:8000/api/askagricultureexpert \
  -H "Content-Type: application/json" \
  -d '{"question": "What are the best practices for growing tomatoes in Kenya?"}' \
  | jq '.'

echo -e "\n" && echo "="*50 && echo -e "\n"

# Test 2: Soil management question
echo "Test 2: Soil management question"
curl -X POST http://localhost:8000/api/askagricultureexpert \
  -H "Content-Type: application/json" \
  -d '{"question": "How can I improve soil fertility naturally?"}' \
  | jq '.'

echo -e "\n" && echo "="*50 && echo -e "\n"

# Test 3: Pest control question
echo "Test 3: Pest control question"
curl -X POST http://localhost:8000/api/askagricultureexpert \
  -H "Content-Type: application/json" \
  -d '{"question": "What are the common pests that affect maize crops?"}' \
  | jq '.'

echo -e "\n" && echo "="*50 && echo -e "\n"

# Test 4: Invalid request (missing question)
echo "Test 4: Invalid request (missing question)"
curl -X POST http://localhost:8000/api/askagricultureexpert \
  -H "Content-Type: application/json" \
  -d '{}' \
  | jq '.'

echo -e "\n" && echo "="*50 && echo -e "\n"

# Test 5: Non-agriculture question (should be declined)
echo "Test 5: Non-agriculture question"
curl -X POST http://localhost:8000/api/askagricultureexpert \
  -H "Content-Type: application/json" \
  -d '{"question": "What is the capital of France?"}' \
  | jq '.'

echo -e "\n" && echo "Testing completed!" 