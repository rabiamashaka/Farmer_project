<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Weather & Market Data') }}
        </h2>
    </x-slot>

    <div class="py-6 px-6 max-w-7xl mx-auto bg-white shadow rounded">

        <h3 class="text-lg font-semibold text-green-700 mb-4">🌦️ Weather Conditions</h3>
        <p class="mb-4 text-sm text-gray-600">Latest weather forecasts by location</p>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Temperature (°C)</th>
                        <th class="px-4 py-2">Humidity (%)</th>
                        <th class="px-4 py-2">Rainfall (mm)</th>
                        <th class="px-4 py-2">Condition</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Source</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($weatherData as $weather)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $weather->location }}</td>
                            <td class="px-4 py-2">{{ $weather->temperature }}</td>
                            <td class="px-4 py-2">{{ $weather->humidity }}</td>
                            <td class="px-4 py-2">{{ $weather->rainfall }}</td>
                            <td class="px-4 py-2">{{ $weather->condition }}</td>
                            <td class="px-4 py-2">{{ $weather->date }}</td>
                            <td class="px-4 py-2">{{ $weather->source }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500">No weather data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <h3 class="text-lg font-semibold text-green-700 mb-4">💰 Market Prices</h3>
        <p class="mb-4 text-sm text-gray-600">Current crop prices across major markets</p>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm text-left">
                <thead class="bg-green-600 text-white">
                    <tr>
                        <th class="px-4 py-2">Crop</th>
                        <th class="px-4 py-2">Location</th>
                        <th class="px-4 py-2">Price per Kg</th>
                        <th class="px-4 py-2">Currency</th>
                        <th class="px-4 py-2">Market Date</th>
                        <th class="px-4 py-2">Source</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($marketData as $market)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $market->crop }}</td>
                            <td class="px-4 py-2">{{ $market->location }}</td>
                            <td class="px-4 py-2">{{ $market->price_per_kg }}</td>
                            <td class="px-4 py-2">{{ $market->currency }}</td>
                            <td class="px-4 py-2">{{ $market->market_date }}</td>
                            <td class="px-4 py-2">{{ $market->source }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-500">No market data found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
