<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('SMS Delivery Logs') }}
        </h2>
    </x-slot>

    <div class="flex bg-gray-100 min-h-screen">
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
        <main class="flex-1 p-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Total SMS</p>
                        <p class="text-2xl font-bold">0</p>
                    </div>
                    <span class="text-blue-500 text-2xl">💬</span>
                </div>
                <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Delivered</p>
                        <p class="text-2xl font-bold text-green-600">0</p>
                    </div>
                    <span class="text-green-500 text-2xl">✅</span>
                </div>
                <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Pending</p>
                        <p class="text-2xl font-bold text-yellow-600">0</p>
                    </div>
                    <span class="text-yellow-500 text-2xl">🕒</span>
                </div>
                <div class="bg-white p-4 rounded shadow flex items-center justify-between">
                    <div>
                        <p class="text-gray-500">Failed</p>
                        <p class="text-2xl font-bold text-red-600">0</p>
                    </div>
                    <span class="text-red-500 text-2xl">❌</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-xl font-semibold mb-2">Recent SMS Messages</h3>
                <p class="text-sm text-gray-500 mb-4">Latest SMS delivery attempts and their status</p>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Farmer</th>
                                <th class="px-4 py-2">Phone Number</th>
                                <th class="px-4 py-2">Content</th>
                                <th class="px-4 py-2">Message Preview</th>
                                <th class="px-4 py-2">Sent At</th>
                                <th class="px-4 py-2">Delivered At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-t">
                                <td class="px-4 py-2 text-center text-gray-400" colspan="7">No messages found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
