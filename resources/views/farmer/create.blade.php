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


        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded">
                <form action="{{ route('farmer.store') }}" method="POST">
                    @csrf

                    @if ($errors->any())
                        <div class="mb-4 text-red-600">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Full Name -->
                    <div class="mb-4">
                        <x-input-label for="name">{{ __('Full Name') }}</x-input-label>
                        <input type="text" name="name" id="name" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Phone Number -->
                    <div class="mb-4">
                        <x-input-label for="phone">{{ __('Phone Number') }}</x-input-label>
                        <input type="text" name="phone" id="phone" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>

                    <!-- Region -->
                    <div class="mb-4">
                       <label for="region_id" class="block text-sm font-medium">{{ __('Region') }}</label>
<select name="region_id" id="region_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
    <option value="">{{ __('-- Select Region --') }}</option>
    @foreach($regions as $id => $name)
        <option value="{{ $id }}">{{ $name }}</option>
    @endforeach
</select>
</div>

                    <!-- Farming Type -->
                    <div class="mb-4">
                        <x-input-label for="farming_type">{{ __('Farming Type') }}</x-input-label>
                        <select name="farming_type" id="farming_type" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500 text-base py-2 px-3">
                            <option value="">{{ __('Select type') }}</option>
                            <option value="Crops">{{ __('Crops') }}</option>
                            <option value="Livestock">{{ __('Livestock') }}</option>
                            <option value="Mixed">{{ __('Mixed') }}</option>
                        </select>
                        <x-input-error :messages="$errors->get('farming_type')" class="mt-2" />
                    </div>

                    <!-- Crop Checkboxes -->
                    <div class="mb-4">
                        <label class="block mb-1 font-semibold text-gray-700">{{ __('Target Crop Types') }}</label>
                        <div class="grid grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-200 rounded p-2">
                            @foreach ($crops as $id => $name)
                                <label class="inline-flex items-center space-x-2">
                                    <input type="checkbox" name="crops[]" value="{{ $id }}" class="form-checkbox text-green-600">
                                    <span>{{ ucfirst($name) }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('farmer.index') }}"
                           class="inline-block px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">
                            {{ __('Cancel') }}
                        </a>
                        <x-primary-button class="ms-3">
                            {{ __('Create') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
