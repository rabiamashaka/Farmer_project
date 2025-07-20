<x-guest-layout>
     <div class="flex items-center justify-between">
                <a href="{{ route('welcome') }}" class="text-sm text-gray-600 hover:text-primary-600">&larr; {{ __('Back to Home') }}</a>
            </div>

            <div class="text-center">
                <div class="mx-auto w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-green-700">{{ __('Login') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Access for dashboard') }}</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Phone Number -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('Email') }}</label>
                    <input id="email" name="email" type="text" inputmode="tel"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-amber-50 focus:border-green-500 focus:ring-green-500 shadow-sm"
                        placeholder="{{ __('Enter your email') }}" required autofocus value="{{ old('email') }}">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    <input id="password" name="password" type="password" placeholder="{{ __('Enter your password') }}" required
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white focus:border-green-500 focus:ring-green-500 shadow-sm">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Login Button -->
                <div>
                    <button type="submit"
                        class="w-full py-2 px-4 text-white font-semibold bg-green-600 hover:bg-green-700 rounded-md shadow-sm transition">
                        {{ __('Login') }}
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-600">
                {{ __("Don't have an account?") }}
                <a href="{{ route('register') }}" class="text-green-600 hover:text-green-800 underline">
                    {{ __('Register here') }}
                </a>
            </div>
        <!-- Password -->


<!-- Forgot Password -->
<div class="text-right">
    <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-800 underline">
        {{ __('Forgot your password?') }}
    </a>
</div>

   
</x-guest-layout>
