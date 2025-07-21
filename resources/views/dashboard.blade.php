<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
      <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">{{ __('Admin Panel') }}</h1>
        <p class="text-sm"></p>
    </div>
    <nav class="space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('Dashboard') }}
        </a>
        <a href="{{ route('content.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('content.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('Content Management') }}
        </a>
        <a href="{{ route('farmer.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('farmer.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('Farmer Management') }}
        </a>
        <a href="{{ route('weather-market') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('weather-market') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('Weather & Market Data') }}
        </a>
        <a href="{{ route('admin.cropinfo.index') }}"
        class="block px-3 py-2 rounded font-medium {{ request()->routeIs('weather-market') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
        Crop Information
</a>
        <a href="{{ route('sms_campaigns.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms_campaigns.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('SMS Campaigns') }}
        </a>
        <a href="{{ route('sms.logs') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms.logs') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('SMS Logs') }}
        </a>
        <a href="{{ route('analytics') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('analytics') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('Analytics') }}
        </a>
    </nav>
    <div class="mt-10 text-sm text-white">⚙️ {{ __('Settings') }}</div>
</aside>


        <!-- Main Dashboard -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-1">{{ __('Dashboard') }}</h1>
            <p class="text-sm text-gray-500 mb-6">{{ __('Welcome back, Agricultural Officer') }}</p>

            <!-- Weather Notifications -->
            @foreach ($notifications as $note)
                <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded">
                    {{ $note['message'] }} <span class="text-sm text-gray-500">({{ $note['time'] }})</span>
                </div>
            @endforeach

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded shadow">
                    <p class="text-sm text-gray-500">{{ __('Active Farmers') }}</p>
                    <h2 class="text-2xl font-bold">{{ $activeFarmers }}</h2>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <p class="text-sm text-gray-500">{{ __('SMS Sent Today') }}</p>
                    <h2 class="text-2xl font-bold">{{ $smsSentToday }}</h2>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <p class="text-sm text-gray-500">{{ __('Published Content') }}</p>
                    <h2 class="text-2xl font-bold">{{ $publishedContent }}</h2>
                </div>
                <div class="bg-white p-5 rounded shadow">
                    <p class="text-sm text-gray-500">{{ __('Delivery Rate') }}</p>
                    <h2 class="text-2xl font-bold">{{ number_format($deliveryRate, 1) }}%</h2>
                </div>
            </div>
            <!-- Recent Activity and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
                <!-- Recent Activity (2/3 of the row) -->
                <div class="lg:col-span-2 bg-white p-4 shadow rounded">
                    <h3 class="text-lg font-semibold mb-2">📋 {{ __('Recent Activity') }}</h3>
                    <p class="text-sm text-gray-500">{{ __('No recent activity found.') }}</p>
                </div>

                <!-- Quick Actions (1/3 of the row) -->
       <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 gap-4">
    <a href="{{ route('content.create') }}">
        <div class="bg-white p-4 rounded shadow border-l-4 border-green-500 hover:bg-green-50 transition">
            <h4 class="font-bold">{{ __('Create Content') }}</h4>
            <p class="text-sm text-gray-500">{{ __('Add new agricultural content') }}</p>
        </div>
    </a>

    <a href="">
        <div class="bg-white p-4 rounded shadow border-l-4 border-blue-500 hover:bg-blue-50 transition">
            <h4 class="font-bold">{{ __('Send SMS') }}</h4>
            <p class="text-sm text-gray-500">{{ __('Send alert to farmers') }}</p>
        </div>
    </a>

    <a href="{{ route('farmer.create') }}">
        <div class="bg-white p-4 rounded shadow border-l-4 border-purple-500 hover:bg-purple-50 transition">
            <h4 class="font-bold">{{ __('Add Farmer') }}</h4>
            <p class="text-sm text-gray-500">{{ __('Register new farmer') }}</p>
        </div>
    </a>

    <a href="">
        <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500 hover:bg-orange-50 transition">
            <h4 class="font-bold">{{ __('Fetch Data') }}</h4>
            <p class="text-sm text-gray-500">{{ __('Update weather & market info') }}</p>
        </div>
    </a>
</div>


            </div>
        </main>
    </div>
</x-app-layout>
