@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100" x-data="{ section: '{{ $activeSection ?? 'summary' }}' }">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">User Panel</h1>
            </div>
            <nav class="space-y-2 text-sm">
                <a href="#" @click.prevent="section = 'summary'" :class="section === 'summary' ? 'block px-3 py-2 rounded font-medium bg-white text-green-700' : 'block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700'">Dashboard Summary</a>
                <a href="#" @click.prevent="section = 'weather'" :class="section === 'weather' ? 'block px-3 py-2 rounded font-medium bg-white text-green-700' : 'block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700'">Weather</a>
                <a href="#" @click.prevent="section = 'messages'" :class="section === 'messages' ? 'block px-3 py-2 rounded font-medium bg-white text-green-700' : 'block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700'">Messages</a>
                <a href="#" @click.prevent="section = 'feedback'" :class="section === 'feedback' ? 'block px-3 py-2 rounded font-medium bg-white text-green-700' : 'block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700'">Send Feedback</a>
                <a href="#" @click.prevent="section = 'getinfo'" :class="section === 'getinfo' ? 'block px-3 py-2 rounded font-medium bg-white text-green-700' : 'block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700'">Get Information</a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-4 md:p-8">
                <!-- Summary Section -->
                <section x-show="section === 'summary'">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Welcome, {{ $user->name ?? 'Farmer' }}!</h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Messages Received</p>
                            <h2 class="text-2xl font-bold">{{ $messages->count() }}</h2>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Weather</p>
                            <p class="text-green-600 text-sm mt-1">{{ $weatherSummary ?? 'No weather data' }}</p>
                        </div>
                        
                        <!-- Market Price Cards for Each Crop -->
                        @foreach($crops as $crop)
                            @php
                                $latestPrice = $crop->marketPrices
                                    ->where('region_id', $userRegionId)
                                    ->sortByDesc('market_date')
                                    ->first();
                            @endphp
                            <div class="bg-blue-50 p-5 rounded-xl shadow flex flex-col items-center">
                                <p class="text-sm text-blue-800 font-semibold mb-1">{{ $crop->name }} Market Price</p>
                                @if($latestPrice)
                                    <div class="text-2xl font-bold text-blue-700 mb-1">{{ $latestPrice->price_per_kg }} {{ $latestPrice->currency }}</div>
                                @else
                                    <div class="text-blue-600 text-sm">No price data for your region.</div>
                                @endif
                        </div>
                        @endforeach
                    </div>
                </section>

                <!-- Weather -->
                <section x-show="section === 'weather'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Weather for Your Region</h3>
                    @if(isset($weatherSummary))
                        <div class="mb-4 p-3 bg-green-50 rounded">
                            <strong>Latest Weather:</strong> {{ $weatherSummary }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('userdashboard.weather') }}" class="flex items-center gap-2 mb-4">
                        @csrf
                        <select name="region" class="border rounded px-2 py-1">
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ $region->id == $userRegionId ? 'selected' : '' }}>
                                    {{ $region->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Fetch Weather</button>
                    </form>
                    @if(session('weather'))
                        <div class="mt-2 p-3 bg-green-50 rounded">
                            <strong>Weather:</strong> {{ session('weather') }}
                        </div>
                    @endif
                </section>

                <!-- Messages -->
                <section x-show="section === 'messages'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Official Messages</h3>
                    <ul>
                        @forelse($messages as $msg)
                            <li class="mb-2 border-b pb-2">
                                <div class="text-gray-800">{{ $msg->message }}</div>
                                <div class="text-xs text-gray-500">{{ $msg->sent_at?->format('d M Y H:i') }}</div>
                            </li>
                        @empty
                            <li>No messages yet.</li>
                        @endforelse
                    </ul>
                </section>

                <!-- Feedback -->
                <section x-show="section === 'feedback'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Send Feedback</h3>
                    @if(session('feedback_sent'))
                        <div class="mb-2 p-2 bg-green-100 text-green-800 rounded">{{ session('feedback_sent') }}</div>
                    @endif
                    <form method="POST" action="{{ route('userdashboard.feedback') }}">
                        @csrf
                        <textarea name="feedback" rows="3" class="w-full border rounded p-2 mb-2" placeholder="Type your feedback..."></textarea>
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Send</button>
                    </form>
                </section>

                <!-- Crop Information -->
                <section x-show="section === 'cropinfo'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Your Crops & Information</h3>
                    @if($crops && $crops->count())
                        <ul class="mb-4">
                            @foreach($crops as $crop)
                                <li class="mb-2 p-3 bg-green-50 rounded">
                                    <strong>{{ $crop->name }}</strong><br>
                                    Advice: Water regularly, use organic fertilizer, and monitor for pests.
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="mb-2 p-2 bg-yellow-100 text-yellow-800 rounded">No crops registered for your account.</div>
                    @endif
                </section>

                <!-- Get Information -->
                <section x-show="section === 'getinfo'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-2xl font-bold mb-6 text-green-800 flex items-center gap-2">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 1.343-3 3 0 1.657 1.343 3 3 3s3-1.343 3-3c0-1.657-1.343-3-3-3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 2v2m0 16v2m10-10h-2M4 12H2m15.364-7.364l-1.414 1.414M6.05 17.95l-1.414 1.414m12.728 0l-1.414-1.414M6.05 6.05L4.636 4.636"/></svg>
                        Get Information for Your Crop & Region
                    </h3>
                    
                    <form method="POST" action="{{ route('userdashboard.information_search') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8 bg-green-50 p-4 rounded-lg shadow">
                        @csrf
                        <div>
                            <label for="crop_id" class="block text-sm font-semibold text-green-700 mb-1">Crop</label>
                            @if($crops && $crops->count())
                                <select name="crop_id" id="crop_id" class="w-full border border-green-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400" required>
                                    <option value="">Select your crop</option>
                                    @foreach ($crops as $crop)
                                        <option value="{{ $crop->id }}">{{ $crop->name }}</option>
                                    @endforeach
                                </select>
                            @else
                                <div class="p-3 bg-yellow-100 text-yellow-800 rounded">
                                    No crops in your profile. Please <a href="{{ route('farmer.create') }}" class="underline text-green-700">add crops</a> first.
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <label for="region_id" class="block text-sm font-semibold text-green-700 mb-1">Region</label>
                            <select name="region_id" id="region_id" class="w-full border border-green-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400">
                                <option value="">-- Your Region ({{ optional($farmer->region)->name ?? 'Not set' }}) --</option>
                                @foreach ($regions as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label for="info_type" class="block text-sm font-semibold text-green-700 mb-1">Information Type</label>
                            <select name="info_type" id="info_type" class="w-full border border-green-300 rounded px-3 py-2 focus:ring-2 focus:ring-green-400" required>
                                <option value="">Select type</option>
                                <option value="advice"> Advice</option>
                                <option value="disease"> Disease</option>
                                <option value="market">Market Price</option>
                            </select>
                        </div>
                        
                        <div class="flex items-end">
                            <button type="submit" class="w-full bg-green-700 text-white px-4 py-2 rounded-lg hover:bg-green-800 font-semibold shadow" {{ $crops && $crops->count() ? '' : 'disabled' }}>
                                Search
                            </button>
                        </div>
                    </form>

                    @if(isset($results) && $results->count())
                        <div class="mt-6">
                            <h4 class="text-lg font-semibold mb-4 text-green-800">
                                @if($infoType === 'advice')
                                     Crop Advice
                                @elseif($infoType === 'disease')
                                     Crop Diseases
                                @elseif($infoType === 'market')
                                     Market Prices
                                @endif
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @if ($infoType === 'advice')
                                    @foreach ($results as $advice)
                                        <div class="p-5 bg-green-100 border-l-4 border-green-600 rounded-lg shadow">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-green-600 text-xl"></span>
                                                <strong class="text-green-800">{{ $advice->title }}</strong>
                                            </div>
                                            <p class="text-green-900">{{ $advice->description }}</p>
                                        </div>
                                    @endforeach
                                @elseif ($infoType === 'disease')
                                    @foreach ($results as $disease)
                                        <div class="p-5 bg-red-100 border-l-4 border-red-600 rounded-lg shadow">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-red-600 text-xl">🦠</span>
                                                <strong class="text-red-800">{{ $disease->name }}</strong>
                                            </div>
                                            <p class="text-red-900">{{ $disease->description }}</p>
                                        </div>
                                    @endforeach
                                @elseif ($infoType === 'market')
                                    @foreach ($results as $price)
                                        <div class="p-5 bg-blue-100 border-l-4 border-blue-600 rounded-lg shadow">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="text-blue-600 text-xl">💰</span>
                                                <strong class="text-blue-800">Market Price</strong>
                                            </div>
                                            <p class="text-blue-900 font-semibold">{{ $price->price_per_kg }} {{ $price->currency }}</p>
                                            <div class="text-xs text-blue-700">Date: {{ $price->market_date }}</div>
                                            <div class="text-xs text-blue-700">Source: {{ $price->source }}</div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @elseif(isset($results))
                        <div class="text-gray-500 mt-4 p-4 bg-gray-50 rounded-lg">
                            <p class="text-center">No information found for your selection.</p>
                        </div>
                    @endif
                </section>

                <!-- Market Price Quick Lookup -->
                <section x-show="section === 'marketprice'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Check Market Price for Your Crop</h3>
                    <form method="POST" action="{{ route('userdashboard.market_price') }}" class="flex items-center gap-2 mb-4">
                        @csrf
                        <select name="crop_id" class="border rounded px-2 py-1" required>
                            <option value="">Select Crop</option>
                            @foreach($crops as $crop)
                                <option value="{{ $crop->id }}" {{ (isset($selectedMarketCropId) && $selectedMarketCropId == $crop->id) ? 'selected' : '' }}>{{ $crop->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Check Price</button>
                    </form>
                    @if(isset($marketPriceResult))
                        <div class="p-4 bg-blue-50 rounded shadow">
                            <div class="font-semibold text-blue-800">Latest Market Price for {{ $marketPriceResult['crop'] }} in {{ $marketPriceResult['region'] }}:</div>
                            <div class="text-2xl font-bold text-blue-700 my-2">{{ $marketPriceResult['price'] }} {{ $marketPriceResult['currency'] }}</div>
                            <div class="text-xs text-blue-700">Date: {{ $marketPriceResult['date'] }}</div>
                            <div class="text-xs text-blue-700">Source: {{ $marketPriceResult['source'] }}</div>
                    </div>
                    @elseif(isset($marketPriceError))
                        <div class="p-3 bg-red-100 text-red-800 rounded">{{ $marketPriceError }}</div>
                    @endif
                </section>

                <!-- All Market Prices for a Crop -->
                <section x-show="section === 'marketpricesall'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">All Market Prices for a Crop</h3>
                    <form method="POST" action="{{ route('userdashboard.market_prices_all') }}" class="flex items-center gap-2 mb-4">
                        @csrf
                        <select name="crop_id" class="border rounded px-2 py-1" required>
                            <option value="">Select Crop</option>
                            @foreach($crops as $crop)
                                <option value="{{ $crop->id }}" {{ (isset($selectedAllMarketCropId) && $selectedAllMarketCropId == $crop->id) ? 'selected' : '' }}>{{ $crop->name }}</option>
                            @endforeach
                        </select>
                        <select name="region_id" class="border rounded px-2 py-1">
                            <option value="">All Regions</option>
                            @foreach($regions as $region)
                                <option value="{{ $region->id }}" {{ (isset($selectedAllMarketRegionId) && $selectedAllMarketRegionId == $region->id) ? 'selected' : '' }}>{{ $region->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="bg-green-600 text-white px-4 py-1 rounded">Show Prices</button>
                    </form>
                    @if(isset($allMarketPrices) && count($allMarketPrices))
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border rounded">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b">Region</th>
                                        <th class="px-4 py-2 border-b">Price per Kg</th>
                                        <th class="px-4 py-2 border-b">Currency</th>
                                        <th class="px-4 py-2 border-b">Date</th>
                                        <th class="px-4 py-2 border-b">Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($allMarketPrices as $price)
                                        <tr>
                                            <td class="px-4 py-2 border-b">{{ $price->region->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 border-b">{{ $price->price_per_kg }}</td>
                                            <td class="px-4 py-2 border-b">{{ $price->currency }}</td>
                                            <td class="px-4 py-2 border-b">{{ $price->market_date }}</td>
                                            <td class="px-4 py-2 border-b">{{ $price->source }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @elseif(isset($allMarketPrices))
                        <div class="p-3 bg-yellow-100 text-yellow-800 rounded">No market prices found for this crop{{ isset($selectedAllMarketRegionId) && $selectedAllMarketRegionId ? ' in this region' : '' }}.</div>
                    @endif
                </section>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                section: '{{ $activeSection ?? 'summary' }}',
            }));
        });
    </script>
</x-app-layout>
