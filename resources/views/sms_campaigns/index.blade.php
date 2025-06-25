<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('SMS Campaigns') }}
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

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Header and Actions -->
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-green-900">SMS Campaigns</h1>
                    <p class="text-sm text-green-800">Create and manage SMS campaigns to reach farmers</p>
                </div>
                <div class="space-x-2">
                    <button onclick="document.getElementById('newCampaignModal').classList.remove('hidden')" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">+ New Campaign</button>
                    <button onclick="document.getElementById('quickSmsModal').classList.remove('hidden')" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded">Quick SMS</button>
                </div>
            </div>

            <!-- Flex Layout: Table + USSD -->
            <div class="flex gap-6 flex-wrap lg:flex-nowrap mb-6">
                <!-- SMS Campaign Table -->
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
                            <!-- Campaign rows will go here -->
                        </tbody>
                    </table>
                </div>

                <!-- USSD Registration Info -->
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
                        Contact your telecom provider to configure the USSD shortcode <code>*456*1#</code> to point to your Supabase USSD webhook endpoint.
                    </div>
                </div>
            </div>

            <!-- Create Campaign Modal -->
<div id="newCampaignModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
  <div class="bg-white p-6 rounded shadow w-full max-w-md">
    <h2 class="text-xl font-semibold mb-4">Create SMS Campaign</h2>

    <form method="POST" action="{{ route('sms_campaigns.store') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block mb-1 font-medium" for="title">Campaign Title</label>
        <input type="text" name="title" id="title" class="w-full border px-3 py-2 rounded" placeholder="Enter campaign title" required>
      </div>

      <div>
        <label class="block mb-1 font-medium" for="message">Message Content</label>
        <textarea name="message" id="message" maxlength="160" class="w-full border px-3 py-2 rounded" rows="3" placeholder="Enter your SMS message (max 160 characters)" required></textarea>
      </div>

      <div>
        <label class="block font-medium mb-1">Target Locations (optional)</label>
        <div class="grid grid-cols-3 gap-2">
          @foreach (['Dodoma', 'Mwanza', 'Arusha', 'Mbeya', 'Dar es Salaam', 'Moshi', 'Iringa'] as $location)
            <label><input type="checkbox" name="locations[]" value="{{ $location }}"> {{ $location }}</label>
          @endforeach
        </div>
      </div>

      <div>
        <label class="block font-medium mb-1">Target Crop Types (optional)</label>
        <div class="grid grid-cols-3 gap-2">
          @foreach (['maize', 'rice', 'beans', 'cassava', 'coffee', 'banana', 'sunflower', 'cotton'] as $crop)
            <label><input type="checkbox" name="crops[]" value="{{ $crop }}"> {{ ucfirst($crop) }}</label>
          @endforeach
        </div>
      </div>

      <div>
        <label class="block font-medium mb-1" for="language">Target Language (optional)</label>
        <select name="language" id="language" class="w-full border px-3 py-2 rounded">
          <option value="">Select language</option>
          <option value="Swahili">Swahili</option>
          <option value="English">English</option>
        </select>
      </div>

      <div class="flex justify-end space-x-2">
        <button type="button" onclick="document.getElementById('newCampaignModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
        <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white">Create Campaign</button>
      </div>
    </form>
  </div>
</div>


            <!-- Quick SMS Modal -->
            <div id="quickSmsModal" class="fixed inset-0 bg-black/50 flex items-center justify-center hidden z-50">
                <div class="bg-white p-6 rounded shadow w-full max-w-sm">
                    <h2 class="text-xl font-semibold mb-4">Send Quick SMS</h2>
                    <form class="space-y-4" method="POST" action="{{ route('sms_campaigns.quickSms') }}">
                        @csrf
                        <div>
                            <label class="block mb-1 font-medium">Phone Number</label>
                            <input type="text" name="phone" class="w-full border px-3 py-2 rounded" placeholder="e.g. +255712345678" required>
                        </div>
                        <div>
                            <label class="block mb-1 font-medium">Message</label>
                            <textarea name="message" maxlength="160" class="w-full border px-3 py-2 rounded" rows="3" placeholder="Enter your message (max 160 characters)" required></textarea>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="document.getElementById('quickSmsModal').classList.add('hidden')" class="px-4 py-2 rounded border">Cancel</button>
                            <button type="submit" class="px-4 py-2 rounded bg-green-600 text-white">Send SMS</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
