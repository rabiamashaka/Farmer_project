<x-app-layout>
  <div class="flex min-h-screen bg-gray-100">
    <!-- Sidebar -->
   <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
        <p class="text-sm"></p>
    </div>
    <nav class="space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Dashboard
        </a>
        <a href="{{ route('content.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('content.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Content Management
        </a>
        <a href="{{ route('farmer.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('farmer.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Farmer Management
        </a>
        <a href="{{ route('weather-market') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('weather-market') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Weather & Market Data
        </a>
        <a href="{{ route('sms_campaigns.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms_campaigns.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           SMS Campaigns
        </a>
        <a href="{{ route('sms.logs') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms.logs') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           SMS Logs
        </a>
        <a href="{{ route('analytics') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('analytics') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Analytics
        </a>
    </nav>
    <div class="mt-10 text-sm text-white">⚙️ Settings</div>
</aside>


    <!-- Main Content -->
    <main class="flex-1 max-w-4xl mx-auto py-10 px-8 bg-white rounded-xl shadow-md m-6">
      <h1 class="text-4xl font-extrabold text-gray-900 mb-10 border-b border-gray-300 pb-3 flex items-center gap-3">
        📝 Add New Content Template
      </h1>

      <form method="POST" action="{{ route('content.store') }}" class="space-y-8">
        @csrf

        <!-- Title & Category -->
        <div class="grid sm:grid-cols-2 gap-8">
          <div>
            <x-input-label for="title" value="Title" />
            <x-text-input id="title" name="title" placeholder="e.g. Rain Alert for Kilimanjaro" class=" h-10 mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required />
          </div>

          <div>
            <x-input-label for="category" value="Category" />
            <select id="category" name="category" class=" h-10 mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <option value="">Select category</option>
              <option value="weather"> Weather Alert</option>
              <option value="pest"> Pest Control</option>
              <option value="advice"> Farming Advice</option>
            </select>
          </div>
        </div>

        <!-- Message -->
        <div>
          <x-input-label for="content" value="Message (max 160 characters)" />
          <textarea id="content" name="content" maxlength="160" rows="4" placeholder="Write a short message to farmers..." required
            class="mt-3 w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
          <small id="charLeft" class="text-sm text-gray-500 mt-1 block">160 characters left</small>
        </div>

        <!-- Language & Translate -->
        <div class="grid sm:grid-cols-2 gap-8">
          <div>
            <x-input-label for="language" value="Language" />
            <select id="language" name="language" class="mt-3 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
              <option value="sw">🇹🇿 Swahili</option>
              <option value="en">🇬🇧 English</option>
            </select>
          </div>

          <div class="flex items-center mt-10">
            <input type="checkbox" id="translate" name="translate" value="1" class="form-checkbox text-indigo-600 mr-3" />
            <label for="translate" class="text-sm text-gray-700 font-medium">Also create auto‑translated version</label>
          </div>
        </div>

        <!-- Regions & Crops -->
        <div class="grid sm:grid-cols-2 gap-8">
          <div>
            <x-input-label value=" Target Regions (optional)" />
            <div
              class="mt-3 max-h-44 overflow-y-auto rounded-lg border border-gray-300 bg-gray-50 p-4 shadow-inner scrollbar-thin scrollbar-thumb-indigo-300 scrollbar-track-indigo-100">
              @foreach ($regions as $region)
                <label class="flex items-center space-x-3 text-sm text-gray-800 hover:bg-indigo-100 rounded px-2 py-1 cursor-pointer">
                  <input type="checkbox" name="regions[]" value="{{ $region }}" class="form-checkbox text-indigo-600" />
                  <span>{{ $region }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div>
            <x-input-label value=" Crops (optional)" />
            <div
              class="mt-3 max-h-44 overflow-y-auto rounded-lg border border-gray-300 bg-gray-50 p-4 shadow-inner scrollbar-thin scrollbar-thumb-green-300 scrollbar-track-green-100">
              @foreach ($crops as $crop)
                <label class="flex items-center space-x-3 text-sm text-gray-800 hover:bg-green-100 rounded px-2 py-1 cursor-pointer">
                  <input type="checkbox" name="crops[]" value="{{ $crop }}" class="form-checkbox text-green-600" />
                  <span>{{ ucfirst($crop) }}</span>
                </label>
              @endforeach
            </div>
          </div>
        </div>

        <!-- Submit Button -->
       <div>
  <button type="submit"
    class="inline-flex items-center gap-2 px-8 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow transition">
    Save Template
  </button>
</div>
      </form>
    </main>
  </div>

  <script>
    // Character counter for message
    const textarea = document.getElementById('content');
    const counter = document.getElementById('charLeft');
    textarea.addEventListener('input', () => {
      counter.textContent = (160 - textarea.value.length) + ' characters left';
    });
  </script>
</x-app-layout>
