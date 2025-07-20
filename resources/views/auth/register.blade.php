<x-guest-layout>
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('welcome') }}" class="text-sm text-gray-600 hover:text-primary-600">&larr; {{ __('Back to Home') }}</a>
    </div>

    <div class="text-center mb-6">
        <div class="mx-auto w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </div>
        <h2 class="text-xl font-bold text-green-700">{{ __('Register') }}</h2>
        <p class="text-sm text-gray-500">{{ __('Create your farmer account to get started') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <!-- Hidden role, default to user -->
        <input type="hidden" name="role" value="user">

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full"
                          type="text" name="name"
                          :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mt-4">
            <x-input-label for="phone" :value="__('Phone')" />
            <x-text-input id="phone" class="block mt-1 w-full"
                          type="text" name="phone"
                          :value="old('phone')" required autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <!-- Region -->
        <div class="mt-4">
            <x-input-label for="region_id" :value="__('Region')" />
            <select id="region_id" name="region_id" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">{{ __('-- Select Region --') }}</option>
                @foreach(App\Models\Region::orderBy('name')->get() as $region)
                    <option value="{{ $region->id }}" @selected(old('region_id') == $region->id)>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('region_id')" class="mt-2" />
        </div>

        <!-- Farming Type -->
        <div class="mt-4">
            <x-input-label for="farming_type" :value="__('Farming Type')" />
            <select id="farming_type" name="farming_type" required
                    class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                <option value="">{{ __('-- Select Farming Type --') }}</option>
                <option value="Crops" @selected(old('farming_type') == 'Crops')>{{ __('Crops') }}</option>
                <option value="Livestock" @selected(old('farming_type') == 'Livestock')>{{ __('Livestock') }}</option>
                <option value="Mixed" @selected(old('farming_type') == 'Mixed')>{{ __('Mixed') }}</option>
            </select>
            <x-input-error :messages="$errors->get('farming_type')" class="mt-2" />
        </div>
<!-- Crops -->
<div class="mt-4">
    <x-input-label for="crops" :value="__('Crops')" />
    <div class="grid grid-cols-3 gap-2 max-h-40 overflow-y-auto border border-gray-300 rounded p-2">
        @foreach($crops as $crop)
            <label class="inline-flex items-center space-x-2">
                <input
                    type="checkbox"
                    name="crops[]"
                    value="{{ $crop->id }}"
                    class="form-checkbox text-green-600"
                    @if(is_array(old('crops')) && in_array($crop->id, old('crops'))) checked @endif
                >
                <span>{{ ucfirst($crop->name) }}</span>
            </label>
        @endforeach
    </div>
    <x-input-error :messages="$errors->get('crops')" class="mt-2" />
</div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation"
                          required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Submit + Already Registered -->
        <div class="flex items-center justify-end mt-4">
            <a href="{{ route('login') }}"
               class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
