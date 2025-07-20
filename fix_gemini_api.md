# 🔧 Fix Gemini API Issues

## 🚨 Current Issue: API Quota Exceeded (429 Error)

Your Gemini API key is valid, but you've hit the rate limit/quota. Here's how to fix it:

## 📋 Solutions:

### 1. 🆕 Get a New API Key (Recommended)

1. **Visit Google AI Studio:**
   ```
   https://makersuite.google.com/app/apikey
   ```

2. **Create a new API key:**
   - Sign in with your Google account
   - Click "Create API Key"
   - Copy the new key

3. **Update your `.env` file:**
   ```env
   GEMINI_API_KEY=your_new_api_key_here
   ```

4. **Clear Laravel cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   ```

### 2. 🔄 Wait and Retry

- The 429 error means you've exceeded the free tier quota
- Wait a few minutes and try again
- Free tier has limits on requests per minute/hour

### 3. 💰 Upgrade API Plan

- Visit: https://ai.google.dev/pricing
- Consider upgrading for higher quotas

## 🧪 Test Your Fix:

### Option A: Command Line Test
```bash
php test_api_key.php
```

### Option B: Web Interface
1. Start your server: `php artisan serve`
2. Visit: `http://localhost:8000/test_gemini_simple.html`
3. Test with a question

### Option C: cURL Test
```bash
curl -X POST http://localhost:8000/api/test-gemini \
  -H "Content-Type: application/json" \
  -d '{"question": "What are the best practices for growing tomatoes?"}'
```

## ✅ Expected Success Response:

```json
{
  "candidates": [
    {
      "content": {
        "parts": [
          {
            "text": "As AgriBot, I can help you with agriculture-related questions..."
          }
        ]
      }
    }
  ]
}
```

## ❌ Common Error Responses:

### Quota Exceeded (429):
```json
{
  "error": "API quota exceeded. Please try again later or upgrade your API plan.",
  "status": 429
}
```

### Invalid API Key:
```json
{
  "error": "Failed to get a response from Gemini.",
  "status": 401
}
```

## 🎯 Quick Fix Steps:

1. **Get new API key** from Google AI Studio
2. **Update `.env` file** with new key
3. **Clear cache:** `php artisan config:clear`
4. **Test:** `php test_api_key.php`

## 📞 Need Help?

- Check your API key format (should be ~40 characters)
- Ensure you're using the correct Google account
- Verify the API key has proper permissions
- Check your internet connection

---

**The good news:** Your code is working correctly! The issue is just the API quota. Get a new key and you'll be good to go! 🚀 