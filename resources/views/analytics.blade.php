<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Analytics') }}
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
                    <!-- dashboard start -->
                    Dashboard
                </a>
                <a href="{{ route('content.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Content Management</a>
                <a href="{{ route('farmer.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Farmer Management</a>
                <a href="{{ route('weather-market') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Weather & Market Data</a>
                <a href="#" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Campaings</a>
                <a href="{{ route('sms.logs') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Logs</a>
                <a href="{{ route('analytics') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Analytics</a>
            </nav>
            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- Analytics Dashboard -->
        <section class="p-6 bg-gray-50 flex-1">
            <h2 class="text-2xl font-bold mb-1">Analytics Dashboard</h2>
            <p class="text-gray-600 mb-4">Insights and metrics for your agritech platform</p>

            <!-- Top Metrics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Total Farmers</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Content Items</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">SMS Sent</p>
                    <p class="text-2xl font-bold">0</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Delivery Rate</p>
                    <p class="text-2xl font-bold">0%</p>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow h-60">
                    <h4 class="font-semibold mb-2">Farmers by Location</h4>
                    <p class="text-sm text-gray-500">Distribution of registered farmers across regions</p>
                    <div class="h-40 border-dashed border rounded mt-2"></div>
                </div>
                <div class="bg-white p-4 rounded shadow h-60">
                    <h4 class="font-semibold mb-2">Content Distribution</h4>
                    <p class="text-sm text-gray-500">Breakdown of content by type</p>
                    <div class="h-40 border-dashed border rounded mt-2"></div>
                </div>
            </div>

            <!-- Bottom Chart -->
            <div class="bg-white p-4 rounded shadow h-60">
                <h4 class="font-semibold mb-2">Popular Crops</h4>
                <p class="text-sm text-gray-500">Number of farmers growing each crop type</p>
                <div class="h-40 border-dashed border rounded mt-2"></div>
            </div>
        </section>
    </div>
</x-app-layout>
