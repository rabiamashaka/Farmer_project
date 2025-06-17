<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Register New Farmer') }}
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
                <a href="#" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    SMS Logs
                </a>
                <a href="#" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">
                    Analytics
                </a>
            </nav>
            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
                <form action="{{ route('farmer.store') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="text" name="phone" id="phone" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    </div>

                    <!-- Farming Type -->
                    <div class="mb-4">
                        <label for="farming_type" class="block text-sm font-medium text-gray-700">Farming Type</label>
                        <select name="farming_type" id="farming_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
                            <option value="">Select type</option>
                            <option value="Crops">Crops</option>
                            <option value="Livestock">Livestock</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                    </div>

                    <!-- Crops Grown -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Crops Grown</label>
                        <div class="flex flex-wrap gap-4">
                            @foreach(['Maize', 'Rice', 'Beans', 'Cassava', 'Sorghum', 'Tomatoes', 'Onions'] as $crop)
                                <label class="flex items-center space-x-2 text-sm text-gray-700">
                                    <input type="checkbox" name="crops[]" value="{{ $crop }}" class="rounded text-green-600">
                                    <span>{{ $crop }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('farmer.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
