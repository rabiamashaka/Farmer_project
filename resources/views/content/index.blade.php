<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Content Management') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-md p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Kilimo Sawa</h1>
                <p class="text-sm">Admin Panel</p>
            </div>
            <nav class="space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 bg-white text-green-700 rounded font-medium">
                    Dashboard
                </a>
                <a href="{{ route('content.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Content Management
                </a>
                <a href="{{ route('farmer.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Farmer Management
                </a>
                <a href="{{ route('weather-market') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Weather & Market Data
                </a>
                  <a href="#" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Campaings</a>
                <a href="{{ route('sms.logs') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    SMS Logs
                </a>
                <a href="{{ route('analytics') }}"class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Analytics
                </a>
            </nav>
            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
          <!-- Create Content Button -->
<div class="mb-4 flex justify-end">
    <a href="{{ route('content.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
        ➕ Create Content
    </a>
</div>


            <!-- Recent Activity Section -->
            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-2">Content List</h3>
                <p class="text-sm text-gray-500">No recent activity found.</p>
            </div>
        </main>
    </div>
</x-app-layout>
