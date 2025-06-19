<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create New Content') }}
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
                <a href="{{ route('sms.logs') }}"class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    SMS Logs
                </a>
                <a href="{{ route('analytics') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Analytics
                </a>
            </nav>
            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 p-8">
            <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
                <form action="{{ route('content.store') }}" method="POST">
                    @csrf

                    <!-- Title -->
                    <div class="mb-4">
                       <x-input-label for="title">Title</x-input-label>
                        <input type="text" name="title" id="title" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                   <x-input-error :messages="$errors->get('title')" class="mt-2" />
                        </div>

                   <!-- Type -->
<div class="mb-4">
    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
    <select name="type" id="type" required
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
        <option value="">Select type</option>
        <option value="Weather Alert">Weather Alert</option>
        <option value="Market Price">Market Price</option>
        <option value="Pests Alert">Pests Alert</option>
        <option value="General">General</option>
        <option value="Farming Tips">Farming Tips</option>
    </select>
</div>

<!-- Urgency Level -->
<div class="mb-4">  
    <x-input-label for="title">Urgency Level</x-input-label>
    <select name="urgency" id="urgency" required
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
        <option value="High">High</option>
        <option value="Low">Low</option>
    </select>
</div>


                    <!-- Content Body -->
                    <div class="mb-4">
                        <x-input-label for="title">Content</x-input-label>
                        <textarea name="content" id="content" rows="5" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('content.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </a>
                           <x-primary-button class="ms-3">
                {{ __('create') }}
            </x-primary-button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</x-app-layout>
