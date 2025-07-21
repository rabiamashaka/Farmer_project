# Laravel 12 Localization Guide: English to Swahili

This guide explains how to implement proper localization in Laravel 12 from English to Swahili.

## 🚀 Quick Start

### 1. Configuration
Your `config/app.php` is already configured:
```php
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'available_locales' => ['en', 'sw'],
```

### 2. Language Files
- **English**: `resources/lang/en.json`
- **Swahili**: `resources/lang/sw.json`

### 3. Middleware
The `LocalizationMiddleware` automatically sets the locale based on session.

### 4. Routes
```php
// Switch language
GET /localization/switch/{locale}

// Test translations
GET /localization/test

// Get current locale
GET /localization/current

// Test page
GET /localization/test-page
```

## 📁 File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   └── LocalizationController.php
│   └── Middleware/
│       └── LocalizationMiddleware.php
├── Console/
│   └── Commands/
│       └── LocalizationCommand.php
resources/
├── lang/
│   ├── en.json
│   └── sw.json
└── views/
    └── localization/
        └── test.blade.php
```

## 🔧 How to Use

### In Blade Templates
```php
{{ __('Dashboard') }}  // Shows "Dashboard" or "Dashibodi"
{{ __('Save') }}       // Shows "Save" or "Hifadhi"
{{ __('Cancel') }}     // Shows "Cancel" or "Ghairi"
```

### In Controllers
```php
use Illuminate\Support\Facades\App;

// Get current locale
$locale = App::getLocale();

// Set locale
App::setLocale('sw');

// Translate text
$message = __('Dashboard');
```

### Language Switching
```php
// Via URL
GET /localization/switch/en  // Switch to English
GET /localization/switch/sw  // Switch to Swahili

// Via Route
Route::get('/localization/switch/{locale}', [LocalizationController::class, 'switchLocale']);
```

## 🧪 Testing

### 1. Web Interface
Visit: `/localization/test-page`

This comprehensive test page shows:
- Language switcher
- All translations in both languages
- Debug information
- API test buttons

### 2. Command Line
```bash
# Test English translations
php artisan localization:test en

# Test Swahili translations
php artisan localization:test sw
```

### 3. API Endpoints
```bash
# Test all translations
curl http://localhost:8000/localization/test

# Get current locale
curl http://localhost:8000/localization/current
```

## 📝 Adding New Translations

### 1. Add to English (`resources/lang/en.json`)
```json
{
  "New Key": "New Value"
}
```

### 2. Add to Swahili (`resources/lang/sw.json`)
```json
{
  "New Key": "Tafsiri ya Kiswahili"
}
```

### 3. Use in templates
```php
{{ __('New Key') }}
```

## 🎯 Common Translation Keys

### Dashboard Elements
| English | Swahili |
|---------|---------|
| Dashboard | Dashibodi |
| Admin Panel | Jopo la Usimamizi |
| Content Management | Usimamizi wa Maudhui |
| Farmer Management | Usimamizi wa Wakulima |
| Weather & Market Data | Hali ya Hewa & Bei Sokoni |
| SMS Campaigns | Kampeni za SMS |
| Analytics | Takwimu |
| Settings | Mipangilio |

### Common UI Elements
| English | Swahili |
|---------|---------|
| Save | Hifadhi |
| Cancel | Ghairi |
| Edit | Hariri |
| Delete | Futa |
| Search | Tafuta |
| Loading... | Inapakia... |
| Success | Imefanikiwa |
| Error | Hitilafu |
| Warning | Onyo |
| Info | Taarifa |

### Status Elements
| English | Swahili |
|---------|---------|
| Active | Hai |
| Inactive | Isiyo hai |
| Pending | Inasubiri |
| Completed | Imekamilika |
| Failed | Imeshindwa |

### Time Elements
| English | Swahili |
|---------|---------|
| Today | Leo |
| Yesterday | Jana |
| This Week | Wiki hii |
| This Month | Mwezi huu |
| Last Month | Mwezi uliopita |
| This Year | Mwaka huu |
| Last Year | Mwaka uliopita |

## 🔍 Debugging

### Check Current Locale
```php
// In controller
$locale = App::getLocale();

// In blade
{{ app()->getLocale() }}
```

### Check Session Locale
```php
// In controller
$sessionLocale = session('locale');

// In blade
{{ session('locale', 'Not set') }}
```

### API Debug
```bash
curl http://localhost:8000/localization/current
```

Response:
```json
{
  "current_locale": "sw",
  "session_locale": "sw",
  "available_locales": ["en", "sw"],
  "fallback_locale": "en"
}
```

## 🛠️ Troubleshooting

### Translation not working?
1. Check if key exists in both language files
2. Verify middleware is registered in `bootstrap/app.php`
3. Check session locale value
4. Clear cache: `php artisan cache:clear`

### Language not switching?
1. Check route: `/localization/switch/sw`
2. Verify session is working
3. Check browser cookies
4. Clear browser cache

### Missing translations?
1. Add key to both `en.json` and `sw.json`
2. Use `__()` helper in templates
3. Test with `php artisan localization:test sw`

## 📊 Best Practices

1. **Always use translation keys** instead of hardcoded text
2. **Keep keys descriptive** and consistent
3. **Test translations** in both languages
4. **Use context-appropriate translations**
5. **Maintain both language files** when adding new features
6. **Use the test page** to verify translations
7. **Use the command line tool** for quick testing

## 🎨 Integration with UI

### Language Switcher in Navigation
```php
<div class="flex items-center space-x-4">
    <a href="{{ route('localization.switch', 'en') }}" 
       class="px-3 py-2 rounded {{ app()->getLocale() == 'en' ? 'bg-blue-500 text-white' : 'text-gray-600' }}">
        English
    </a>
    <a href="{{ route('localization.switch', 'sw') }}" 
       class="px-3 py-2 rounded {{ app()->getLocale() == 'sw' ? 'bg-green-500 text-white' : 'text-gray-600' }}">
        Kiswahili
    </a>
</div>
```

### Current Language Display
```php
<span class="text-sm text-gray-500">
    {{ app()->getLocale() == 'en' ? 'English' : 'Kiswahili' }}
</span>
```

## 🚀 Production Deployment

1. **Cache translations** for better performance:
   ```bash
   php artisan config:cache
   ```

2. **Set default locale** in `.env`:
   ```
   APP_LOCALE=en
   APP_FALLBACK_LOCALE=en
   ```

3. **Test thoroughly** before deployment:
   ```bash
   php artisan localization:test en
   php artisan localization:test sw
   ```

## 📚 Additional Resources

- [Laravel Localization Documentation](https://laravel.com/docs/11.x/localization)
- [Laravel 12 New Features](https://laravel.com/docs/12.x)
- [Swahili Language Resources](https://en.wikipedia.org/wiki/Swahili_language)

## 🎯 Example Implementation

### Complete Blade Template
```php
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>{{ __('Welcome back, Agricultural Officer') }}</h3>
                    <p>{{ __('Here is an overview of your farming activity.') }}</p>
                    
                    <div class="mt-4">
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">
                            {{ __('Save') }}
                        </button>
                        <button class="bg-gray-500 text-white px-4 py-2 rounded ml-2">
                            {{ __('Cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
```

This will automatically display in the correct language based on the user's selection!

---

**🎉 Your Laravel 12 localization system is now ready!**

Visit `/localization/test-page` to see it in action. 