{{-- resources/views/sms_campaigns/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Create SMS Campaign') }}
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
        <main class="flex-1 p-6">
            <div class="max-w-4xl mx-auto">
                <!-- Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-green-900">{{ __('Create SMS Campaign') }}</h1>
                    <p class="text-sm text-green-800">{{ __('Create a new SMS campaign to reach farmers') }}</p>
                </div>

                <!-- Add Content Button -->
                <div class="mb-6 flex justify-end">
                    <a href="{{ route('content.create') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        + {{ __('Create Content Template') }}
                    </a>
                </div>

                <!-- Fetch Content Button and Template Selector -->
                @if(isset($templates) && count($templates) > 0)
                <div class="mb-6 flex items-center gap-4">
                    <label for="content_template" class="font-semibold text-gray-700">{{ __('Choose Content Template') }}</label>
                    <select id="content_template" class="border border-gray-300 rounded px-3 py-2" onchange="fillMessageFromTemplate()">
                        <option value="">-- {{ __('Select') }} --</option>
                        @foreach($templates as $template)
                            <option value="{{ $template->content }}">{{ $template->title }} ({{ ucfirst($template->language) }})</option>
                        @endforeach
                    </select>
                    <button type="button" onclick="fillMessageFromTemplate()" class="ml-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        {{ __('Use Selected Content') }}
                    </button>
                </div>
                @endif

                <script>
                function fillMessageFromTemplate() {
                    var select = document.getElementById('content_template');
                    var message = select.value;
                    if (message) {
                        document.getElementById('message').value = message;
                        updateCount(document.getElementById('message'));
                    }
                }
                </script>

                <!-- Form -->
                <div class="bg-white rounded-lg shadow p-6">
                    <form method="POST" action="{{ route('sms_campaigns.store') }}" class="space-y-6">
                        @csrf

                        <!-- Campaign Title -->
                        <div>
                            <label for="title" class="block mb-2 font-semibold text-gray-700">
                                {{ __('Campaign Title') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="title" id="title" 
                                   placeholder="{{ __('Enter campaign title') }}" required
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                        </div>

                        <!-- Message Content -->
                        <div>
                            <label for="message" class="block mb-2 font-semibold text-gray-700">
                                {{ __('Message Content') }} <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" id="message" maxlength="160" rows="4"
                                      placeholder="{{ __('Enter your SMS message (max 160 characters)') }}" required
                                      class="w-full border border-gray-300 rounded px-3 py-2 resize-none focus:ring-2 focus:ring-indigo-400"
                                      oninput="updateCount(this)"></textarea>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ __('Characters left:') }} <span id="charCount">160</span>
                            </p>
                        </div>

                        <!-- Target Language -->
                        <div>
                            <label for="language" class="block mb-2 font-semibold text-gray-700">
                                {{ __('Target Language') }}
                            </label>
                            <select name="language" id="language"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                                <option value="sw">{{ __('Swahili') }}</option>
                                <option value="en">{{ __('English') }}</option>
                            </select>
                        </div>

                        <!-- Target Locations -->
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                {{ __('Target Locations') }}
                            </label>
                            <div class="grid grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-200 rounded p-3">
                                @if(is_array($regions) && count($regions) > 0)
                                    @foreach ($regions as $region)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="locations[]" value="{{ $region }}"
                                                   class="form-checkbox text-indigo-600">
                                            <span>{{ $region }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">{{ __('No regions available') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Target Crops -->
                        <div>
                            <label class="block mb-2 font-semibold text-gray-700">
                                {{ __('Target Crop Types') }}
                            </label>
                            <div class="grid grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-200 rounded p-3">
                                @if(is_array($crops) && count($crops) > 0)
                                    @foreach ($crops as $crop)
                                        <label class="inline-flex items-center space-x-2">
                                            <input type="checkbox" name="crops[]" value="{{ $crop }}"
                                                   class="form-checkbox text-indigo-600">
                                            <span>{{ ucfirst($crop) }}</span>
                                        </label>
                                    @endforeach
                                @else
                                    <p class="text-gray-500">{{ __('No crops available') }}</p>
                                @endif
                            </div>
                        </div>

                        <!-- Form Buttons -->
                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ route('sms_campaigns.index') }}"
                               class="px-5 py-2 rounded border border-gray-400 hover:bg-gray-100">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit"
                                    class="px-5 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                {{ __('Create Campaign') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        function updateCount(el) {
            const max = 160;
            document.getElementById('charCount').textContent = max - el.value.length;
        }
    </script>
</x-app-layout> 