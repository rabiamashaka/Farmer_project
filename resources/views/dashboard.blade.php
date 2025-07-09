<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Kilimo Sawa</h1>
                <p class="text-sm">Admin Panel</p>
            </div>
            <nav class="space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 bg-white text-green-700 rounded font-medium">
                    Dashboard
                </a>
                <a href="{{ route('content.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Content Management</a>
                <a href="{{ route('farmer.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Farmer Management</a>
                <a href="{{ route('weather-market') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Weather & Market Data</a>
                <a href="{{ route('sms_campaigns.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Campaings</a>
                <a href="{{ route('sms.logs') }}"class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Logs</a>
                <a href="{{ route('analytics') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Analytics</a>
            </nav>
            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-2xl font-semibold">Dashboard</h1>
                <p class="text-sm text-gray-500">Welcome back, Agricultural Officer</p>
            </div>

  {{-- WEATHER NOTIFICATIONS --}}
    @foreach ($notifications as $note)
        <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 p-4 rounded">
            {{ $note }}
        </div>
    @endforeach

           <!-- Stat Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded shadow-sm border">
        <p class="text-sm text-gray-500">Active Farmers</p>
        <h2 class="text-2xl font-bold">{{ $activeFarmers }}</h2>
        <p class="text-green-600 text-sm mt-1">+12% from last month</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border">
        <p class="text-sm text-gray-500">SMS Sent Today</p>
        <h2 class="text-2xl font-bold">{{ $smsSentToday }}</h2>
        <p class="text-green-600 text-sm mt-1">+5% from last month</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border">
        <p class="text-sm text-gray-500">Published Content</p>
        <h2 class="text-2xl font-bold">{{ $publishedContent }}</h2>
        <p class="text-green-600 text-sm mt-1">+8% from last month</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border">
        <p class="text-sm text-gray-500">Delivery Rate</p>
        <h2 class="text-2xl font-bold">{{ $deliveryRate }}%</h2>
        <p class="text-green-600 text-sm mt-1">+3% from last month</p>
    </div>
</div>

            <!-- Recent Activity and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mt-6">
                <!-- Recent Activity (2/3 of the row) -->
                <div class="lg:col-span-2 bg-white p-4 shadow rounded">
                    <h3 class="text-lg font-semibold mb-2">📋 Recent Activity</h3>
                    <p class="text-sm text-gray-500">No recent activity found.</p>
                </div>

                <!-- Quick Actions (1/3 of the row) -->
                <div class="space-y-4">
                    <div class="bg-white p-4 rounded shadow border-l-4 border-green-500">
                        <h4 class="font-bold">Create Content</h4>
                        <p class="text-sm text-gray-500">Add new agricultural content</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow border-l-4 border-blue-500">
                        <h4 class="font-bold">Send SMS</h4>
                        <p class="text-sm text-gray-500">Send alert to farmers</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow border-l-4 border-purple-500">
                        <h4 class="font-bold">Add Farmer</h4>
                        <p class="text-sm text-gray-500">Register new farmer</p>
                    </div>
                    <div class="bg-white p-4 rounded shadow border-l-4 border-orange-500">
                        <h4 class="font-bold">Fetch Data</h4>
                        <p class="text-sm text-gray-500">Update weather & market info</p>
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
