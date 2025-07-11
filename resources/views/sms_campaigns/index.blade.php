{{-- resources/views/sms_campaigns/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('SMS Campaigns') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- ▒▒▒ Sidebar ▒▒▒ -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">Kilimo Sawa</h1>
                <p class="text-sm">Admin Panel</p>
            </div>

            <nav class="space-y-2 text-sm">
                <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 bg-white text-green-700 rounded font-medium">Dashboard</a>
                <a href="{{ route('content.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Content Management</a>
                <a href="{{ route('farmer.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Farmer Management</a>
                <a href="{{ route('weather-market') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Weather & Market Data</a>
                <a href="{{ route('sms_campaigns.index') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Campaigns</a>
                <a href="{{ route('sms.logs') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">SMS Logs</a>
                <a href="{{ route('analytics') }}" class="block px-3 py-2 text-green-100 hover:text-white hover:bg-green-700 rounded">Analytics</a>
            </nav>

            <div class="mt-10 text-sm text-white">⚙️ Settings</div>
        </aside>

        <!-- ▒▒▒ Main Content ▒▒▒ -->
        <main class="flex-1 p-6">
            <!-- Header na Action Buttons -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-green-900">SMS Campaigns</h1>
                    <p class="text-sm text-green-800">Create and manage SMS campaigns to reach farmers</p>
                </div>

                <div class="space-x-2">
                    <!-- NEW CAMPAIGN button -->
                    <button
                        onclick="document.getElementById('newCampaignModal').classList.remove('hidden')"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                        + New Campaign
                    </button>

                    <!-- QUICK SMS button -->
                    <button
                        onclick="document.getElementById('quickSmsModal').classList.remove('hidden')"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">
                        Quick SMS
                    </button>
                </div>
            </div>

          
            <div class="flex gap-6 flex-wrap lg:flex-nowrap mb-6">
                
                <div class="flex-1 bg-white p-4 rounded shadow">
                    <h2 class="text-lg font-semibold mb-2">SMS Campaigns</h2>
                    <p class="text-sm text-gray-600 mb-4">Manage your SMS campaigns and track their performance</p>

                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-100 text-gray-600">
                            <tr>
                                <th class="p-2">Title</th>
                                <th class="p-2">Status</th>
                                <th class="p-2">Recipients</th>
                                <th class="p-2">Sent</th>
                                <th class="p-2">Delivered</th>
                                <th class="p-2">Failed</th>
                                <th class="p-2">Created</th>
                                <th class="p-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Campaign rows go here --}}
                        </tbody>
                    </table>
                </div>

                
                <div class="w-full lg:w-1/3 bg-white p-4 rounded shadow">
                    <h3 class="font-semibold text-lg mb-2">USSD Farmer Registration</h3>
                    <p class="text-sm mb-2 text-gray-700">Farmers can register using USSD codes from any mobile phone</p>

                    <div class="bg-blue-100 text-blue-900 px-4 py-2 rounded mb-3">
                        <strong>USSD Code for Farmers:</strong><br>
                        <span class="text-lg font-bold">*456*1#</span>
                    </div>

                    <div class="flex justify-between text-sm text-green-700 mb-3">
                        <span>✅ Easy Registration</span>
                        <span>🌐 No Internet Required</span>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded p-3 text-sm">
                        <strong>Registration Flow:</strong>
                        <ol class="list-decimal ml-4 mt-1">
                            <li>Farmer dials *456*1#</li>
                            <li>Selects "Jisajili kama Mkulima"</li>
                            <li>Enters name, location, and crops</li>
                            <li>Chooses preferred language</li>
                            <li>Receives confirmation SMS</li>
                        </ol>
                    </div>

                    <div class="bg-yellow-100 text-yellow-800 mt-3 p-3 rounded text-sm">
                        <strong>Setup Required:</strong><br>
                        Contact your telecom provider to configure the USSD shortcode <code>*456*1#</code>.
                    </div>
                </div>
            </div>

            <!-- ▒▒▒ NEW CAMPAIGN MODAL ▒▒▒ -->
            <div id="newCampaignModal"
                 class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
                <!-- Backdrop click = close -->
                <div class="absolute inset-0" onclick="document.getElementById('newCampaignModal').classList.add('hidden')"></div>

                <!-- Modal card -->
                <div class="relative bg-white p-6 rounded-xl shadow w-full max-w-2xl overflow-y-auto max-h-[90vh]">
                    <h2 class="text-2xl font-semibold mb-6">Create SMS Campaign</h2>

                    <!-- Refresh data buttons -->
                    <div class="flex items-center space-x-3 mb-4 text-sm">
                        <button type="button" wire:click="refreshRegions"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-100 rounded hover:bg-gray-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                 d="M4 4v6h6M20 20v-6h-6M4 20l6-6M14 10l6-6"/></svg>
                            Refresh Regions
                        </button>
                        <button type="button" wire:click="refreshCrops"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-100 rounded hover:bg-gray-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                 d="M4 4v6h6M20 20v-6h-6M4 20l6-6M14 10l6-6"/></svg>
                            Refresh Crops
                        </button>
                        <button type="button" onclick="translateMessage()"
                            class="inline-flex items-center px-3 py-1.5 bg-indigo-100 text-indigo-800 rounded hover:bg-indigo-200">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                                 d="M3 5h12M9 3v2m-1 4h2m10 0h2m-2 4h2m-2 4h2M16 3l5 5-5 5"/></svg>
                            Auto‑translate
                        </button>
                    </div>

                    <form method="POST" action="{{ route('sms_campaigns.store') }}" class="space-y-5">
                        @csrf

                        {{-- TEMPLATE SELECT --}}
                        <div x-data="{ selectedTemplate: '' }" class="space-y-2">
                            <label class="block font-semibold text-gray-700">Pre‑filled Content</label>
                            <div class="flex space-x-2">
                                <select id="templateSelect" x-model="selectedTemplate"
                                        class="flex-1 border-gray-300 rounded px-3 py-2 focus:ring-indigo-400">
                                    <option value="">Choose template…</option>
                                    @foreach($templates as $template)
                                        <option value="{{ $template->id }}"
                                                data-language="{{ $template->language }}"
                                                data-crops="{{ implode(',', $template->crops) }}"
                                                data-regions="{{ implode(',', $template->regions) }}"
                                                data-title="{{ $template->title }}"
                                                data-content="{{ $template->content }}">
                                            {{ $template->title }} ({{ ucfirst($template->category) }})
                                        </option>
                                    @endforeach
                                </select>

                                <button type="button" onclick="useTemplate()"
                                        class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                    Use Template
                                </button>
                            </div>
                        </div>

                        {{-- TITLE --}}
                        <div>
                            <label for="title" class="block mb-1 font-semibold text-gray-700">Campaign Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title" id="title" placeholder="Enter campaign title" required
                                   class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                        </div>

                        {{-- MESSAGE --}}
                        <div>
                            <label for="message" class="block mb-1 font-semibold text-gray-700">Message Content <span
                                    class="text-red-500">*</span></label>
                            <textarea name="message" id="message" maxlength="160" rows="4"
                                      placeholder="Enter your SMS message (max 160 characters)" required
                                      class="w-full border border-gray-300 rounded px-3 py-2 resize-none focus:ring-2 focus:ring-indigo-400"
                                      oninput="updateCount(this)"></textarea>
                            <p class="text-sm text-gray-500 mt-1">Characters left:
                                <span id="charCount">160</span>
                            </p>
                        </div>

                        {{-- LOCATIONS --}}
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Target Locations</label>
                            <div
                                class="grid grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-200 rounded p-2">
                                @foreach ($regions as $region)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="locations[]" value="{{ $region }}"
                                               class="form-checkbox text-indigo-600 region-checkbox">
                                        <span>{{ $region }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- CROPS --}}
                        <div>
                            <label class="block mb-1 font-semibold text-gray-700">Target Crop Types</label>
                            <div
                                class="grid grid-cols-3 gap-3 max-h-40 overflow-y-auto border border-gray-200 rounded p-2">
                                @foreach ($crops as $crop)
                                    <label class="inline-flex items-center space-x-2">
                                        <input type="checkbox" name="crops[]" value="{{ $crop }}"
                                               class="form-checkbox text-indigo-600 crop-checkbox">
                                        <span>{{ ucfirst($crop) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- LANGUAGE --}}
                        <div>
                            <label for="language" class="block mb-1 font-semibold text-gray-700">Target Language</label>
                            <select name="language" id="language"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:ring-2 focus:ring-indigo-400">
                                <option value="sw">Swahili</option>
                                <option value="en">English</option>
                            </select>
                        </div>

                        {{-- MODAL BUTTONS --}}
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button"
                                    onclick="document.getElementById('newCampaignModal').classList.add('hidden')"
                                    class="px-5 py-2 rounded border border-gray-400 hover:bg-gray-100">
                                Cancel
                            </button>
                            <button type="submit"
                                    class="px-5 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700 transition">
                                Create Campaign
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- ▒▒▒ QUICK SMS MODAL ▒▒▒ -->
            <div id="quickSmsModal"
                 class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50"
                 onclick="document.getElementById('quickSmsModal').classList.add('hidden')">
                <!-- Modal card -->
                <div class="bg-white p-6 rounded shadow w-full max-w-sm relative"
                     onclick="event.stopPropagation()">
                    <h2 class="text-xl font-semibold mb-4">Send Quick SMS</h2>

                    <form class="space-y-4" method="POST" action="{{ route('sms_campaigns.quickSms') }}">
                        @csrf
                        <div>
                            <label class="block mb-1 font-medium">Phone Number</label>
                            <input type="text" name="phone"
                                   class="w-full border px-3 py-2 rounded" placeholder="e.g. +255712345678" required>
                        </div>

                        <div>
                            <label class="block mb-1 font-medium">Message</label>
                            <textarea name="message" maxlength="160"
                                      class="w-full border px-3 py-2 rounded" rows="3"
                                      placeholder="Enter your message (max 160 characters)" required></textarea>
                        </div>

                        <div class="flex justify-end space-x-2">
                            <button type="button"
                                    onclick="document.getElementById('quickSmsModal').classList.add('hidden')"
                                    class="px-4 py-2 rounded border">Cancel</button>
                            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white">Send SMS</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    {{-- JS helpers --}}
    <script>
        // Counter for message box
        function updateCount(el) {
            const max = 160;
            document.getElementById('charCount').textContent = max - el.value.length;
        }

        // Use template autofill
        function useTemplate() {
            const select  = document.getElementById('templateSelect');
            const option  = select.options[select.selectedIndex];
            if (!option.value) return;

            // Autofill title & message
            document.getElementById('title').value   = option.dataset.title;
            document.getElementById('message').value = option.dataset.content;
            updateCount(document.getElementById('message'));

            // Language
            document.getElementById('language').value = option.dataset.language;

            // Checkboxes
            const regionSet = new Set(option.dataset.regions.split(','));
            const cropSet   = new Set(option.dataset.crops.split(','));

            document.querySelectorAll('.region-checkbox')
                .forEach(cb => cb.checked = regionSet.has(cb.value));
            document.querySelectorAll('.crop-checkbox')
                .forEach(cb => cb.checked   = cropSet.has(cb.value));
        }

       
function translateMessage() {
    const messageEl = document.getElementById('message');
    const language = document.getElementById('language').value;
    const message = messageEl.value;

    if (!message.trim()) {
        alert('Please enter a message to translate.');
        return;
    }

    fetch("{{ route('translate.message') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ text: message, lang: language })
    })
    .then(res => res.json())
    .then(data => {
        if (data.translated) {
            messageEl.value = data.translated;
            updateCount(messageEl);
        } else {
            alert('Translation failed.');
        }
    })
    .catch(() => {
        alert('An error occurred while translating.');
    });
}


    </script>
</x-app-layout>
