<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Register New Farmer') }}
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
        <div class="flex-1 p-8">
            <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
                <form action="{{ route('farmer.store') }}" method="POST">
                    @csrf

                    <!-- Full Name -->
                    <div class="mb-4">
                         <x-input-label for="title">Full Name</x-input-label>
                        <input type="text" name="name" id="name" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                     <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                          <x-input-label for="title">Phone Number</x-input-label>
                        <input type="text" name="phone" id="phone" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                  <!-- Location -->
<div class="mb-4">
    <x-input-label for="location">Location</x-input-label>
    <select name="location" id="location" required
        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
        <option value="">Select region</option>
        @foreach($regions as $id => $region)
            <option value="{{ $region }}">{{ $region }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('location')" class="mt-2" />
</div>


                    <!-- Farming Type -->
                    <div class="mb-4">
                         <x-input-label for="title">Farming Type</x-input-label>
                        <select name="farming_type" id="farming_type" required
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
                            <option value="">Select type</option>
                            <option value="Crops">Crops</option>
                            <option value="Livestock">Livestock</option>
                            <option value="Mixed">Mixed</option>
                        </select>
                            <x-input-error :messages="$errors->get('farming_type')" class="mt-2" />
                    </div>

                   <!-- Crops Grown -->
<div class="mb-4">
    <x-input-label for="crops">Crops Grown</x-input-label>
    <div class="flex flex-wrap gap-4">
        @foreach($crops as $id => $crop)
            <label class="flex items-center space-x-2 text-sm text-gray-700">
                <input type="checkbox" name="crops[]" value="{{ $id }}" class="rounded text-green-600">
                <span>{{ $crop }}</span>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('crops')" class="mt-2" />
</div>

 
                    <!-- Buttons -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('farmer.index') }}"
                            class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            Cancel
                        </a>
                              <x-primary-button class="ms-3">
                {{ __('create') }}
            </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
