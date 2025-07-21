<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Test Translation') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">{{ __('Translation Test Page') }}</h1>
        
        <!-- Language Switcher -->
        <div class="bg-white p-4 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Language Settings') }}</h2>
            <div class="flex items-center space-x-4">
                <span class="font-medium">{{ __('Current Language') }}:</span>
                <span class="text-blue-600 font-bold">{{ app()->getLocale() == 'en' ? 'English' : 'Kiswahili' }}</span>
                
                <form method="POST" action="{{ url('/set-locale/en') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        English
                    </button>
                </form>
                
                <form method="POST" action="{{ url('/set-locale/sw') }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Kiswahili
                    </button>
                </form>
            </div>
        </div>

        <!-- Dashboard Translations Test -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Dashboard Elements') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border rounded">
                    <strong>{{ __('Dashboard') }}</strong>: {{ __('Dashboard') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Admin Panel') }}</strong>: {{ __('Admin Panel') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Content Management') }}</strong>: {{ __('Content Management') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Farmer Management') }}</strong>: {{ __('Farmer Management') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Weather & Market Data') }}</strong>: {{ __('Weather & Market Data') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('SMS Campaigns') }}</strong>: {{ __('SMS Campaigns') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Analytics') }}</strong>: {{ __('Analytics') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Settings') }}</strong>: {{ __('Settings') }}
                </div>
            </div>
        </div>

        <!-- Common UI Elements -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Common UI Elements') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="p-4 border rounded">
                    <strong>{{ __('Save') }}</strong>: {{ __('Save') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Cancel') }}</strong>: {{ __('Cancel') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Edit') }}</strong>: {{ __('Edit') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Delete') }}</strong>: {{ __('Delete') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Search') }}</strong>: {{ __('Search') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Loading...') }}</strong>: {{ __('Loading...') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Success') }}</strong>: {{ __('Success') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Error') }}</strong>: {{ __('Error') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Warning') }}</strong>: {{ __('Warning') }}
                </div>
            </div>
        </div>

        <!-- Navigation Elements -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Navigation Elements') }}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="p-4 border rounded">
                    <strong>{{ __('Profile') }}</strong>: {{ __('Profile') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Log Out') }}</strong>: {{ __('Log Out') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Login') }}</strong>: {{ __('Login') }}
                </div>
                <div class="p-4 border rounded">
                    <strong>{{ __('Register') }}</strong>: {{ __('Register') }}
                </div>
            </div>
        </div>

        <!-- Debug Information -->
        <div class="bg-gray-800 text-white p-6 rounded-lg">
            <h2 class="text-xl font-semibold mb-4">{{ __('Debug Information') }}</h2>
            <div class="space-y-2 text-sm">
                <div><strong>App Locale:</strong> {{ app()->getLocale() }}</div>
                <div><strong>Session Locale:</strong> {{ session('locale', 'Not set') }}</div>
                <div><strong>Config Locale:</strong> {{ config('app.locale') }}</div>
                <div><strong>Available Locales:</strong> {{ implode(', ', config('app.available_locales', ['en', 'sw'])) }}</div>
                <div><strong>Fallback Locale:</strong> {{ config('app.fallback_locale') }}</div>
            </div>
        </div>

        <!-- Test Translation Function -->
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Test Translation Function') }}</h2>
            <div class="space-y-2">
                <div><strong>Test Phrase:</strong> {{ __('Test Phrase') }}</div>
                <div><strong>Welcome:</strong> {{ __('Welcome') }}</div>
                <div><strong>Dashboard:</strong> {{ __('Dashboard') }}</div>
                <div><strong>Login:</strong> {{ __('Login') }}</div>
            </div>
        </div>
    </div>
</body>
</html> 