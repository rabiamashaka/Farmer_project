# Translation System Guide

This guide explains how to use the translation system in the Farmer Management application.

## Overview

The application supports multiple languages (English and Swahili) using Laravel's built-in localization system.

## Available Languages

- **English (en)**: Default language
- **Swahili (sw)**: Secondary language

## How to Use Translations

### 1. In Blade Templates

Use the `__()` helper function to translate text:

```php
{{ __('Dashboard') }}
{{ __('Welcome back, Agricultural Officer') }}
{{ __('Save') }}
```

### 2. In Controllers

```php
use Illuminate\Support\Facades\App;

// Get current locale
$locale = App::getLocale();

// Set locale
App::setLocale('sw');

// Translate text
$message = __('Dashboard');
```

### 3. In JavaScript

```javascript
// The translation helper is available globally
const message = window.translate('Dashboard');
```

## Language Switching

### Via URL
```
POST /set-locale/en  # Switch to English
POST /set-locale/sw  # Switch to Swahili
```

### Via Navigation
The language switcher is available in the top navigation bar.

## Translation Files

### English Translations
File: `resources/lang/en.json`

### Swahili Translations
File: `resources/lang/sw.json`

## Adding New Translations

1. **Add to English file** (`resources/lang/en.json`):
```json
{
  "New Key": "New Value"
}
```

2. **Add to Swahili file** (`resources/lang/sw.json`):
```json
{
  "New Key": "Tafsiri ya Kiswahili"
}
```

3. **Use in templates**:
```php
{{ __('New Key') }}
```

## Testing Translations

### 1. Test Page
Visit: `/test-translation-page`

This page shows all translations and allows you to switch languages.

### 2. API Endpoints

- **Test all translations**: `GET /translation/test`
- **Get specific translation**: `GET /translation/get?key=Dashboard`
- **Debug system**: `GET /translation/debug`

### 3. JSON Response
```json
{
  "locale": "sw",
  "session_locale": "sw",
  "translations": {
    "Dashboard": "Dashibodi",
    "Welcome": "Karibu"
  }
}
```

## Common Translation Keys

### Dashboard Elements
- `Dashboard` → `Dashibodi`
- `Admin Panel` → `Jopo la Usimamizi`
- `Content Management` → `Usimamizi wa Maudhui`
- `Farmer Management` → `Usimamizi wa Wakulima`
- `Weather & Market Data` → `Hali ya Hewa & Bei Sokoni`
- `SMS Campaigns` → `Kampeni za SMS`
- `Analytics` → `Takwimu`
- `Settings` → `Mipangilio`

### Common UI Elements
- `Save` → `Hifadhi`
- `Cancel` → `Ghairi`
- `Edit` → `Hariri`
- `Delete` → `Futa`
- `Search` → `Tafuta`
- `Loading...` → `Inapakia...`
- `Success` → `Imefanikiwa`
- `Error` → `Hitilafu`
- `Warning` → `Onyo`
- `Info` → `Taarifa`

### Navigation
- `Profile` → `Wasifu`
- `Log Out` → `Toka`
- `Login` → `Ingia`
- `Register` → `Sajili`

### Status
- `Active` → `Hai`
- `Inactive` → `Isiyo hai`
- `Pending` → `Inasubiri`
- `Completed` → `Imekamilika`
- `Failed` → `Imeshindwa`

### Time
- `Today` → `Leo`
- `Yesterday` → `Jana`
- `This Week` → `Wiki hii`
- `This Month` → `Mwezi huu`
- `Last Month` → `Mwezi uliopita`
- `This Year` → `Mwaka huu`
- `Last Year` → `Mwaka uliopita`

## Middleware

The `SetLocale` middleware automatically sets the application locale based on the session value.

### Registration
Located in `bootstrap/app.php`:
```php
$middleware->prependToGroup('web', \App\Http\Middleware\SetLocale::class);
```

## Configuration

### App Config (`config/app.php`)
```php
'locale' => env('APP_LOCALE', 'en'),
'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),
'available_locales' => ['en', 'sw'],
```

## Best Practices

1. **Always use translation keys** instead of hardcoded text
2. **Keep keys descriptive** and consistent
3. **Test translations** in both languages
4. **Use context-appropriate translations**
5. **Maintain both language files** when adding new features

## Troubleshooting

### Translation not working?
1. Check if the key exists in both language files
2. Verify the middleware is registered
3. Check the session locale value
4. Clear application cache: `php artisan cache:clear`

### Language not switching?
1. Check the route is working: `/set-locale/sw`
2. Verify session is working
3. Check browser cookies
4. Clear browser cache

### Debug Information
Visit `/translation/debug` to see system status.

## Examples

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

This will automatically display in the correct language based on the user's selection. 