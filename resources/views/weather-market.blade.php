<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Weather & Market Data') }}
        </h2>
    </x-slot>
 <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
      <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">{{ __('message.Admin Panel') }}</h1>
        <p class="text-sm"></p>
    </div>
    <nav class="space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('dashboard') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.Dashboard') }}
        </a>
        <a href="{{ route('content.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('content.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.Content Management') }}
        </a>
        <a href="{{ route('farmer.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('farmer.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.Farmer Management') }}
        </a>
        <a href="{{ route('weather-market') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('weather-market') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.Weather & Market Data') }}
        </a>
        <a href="{{ route('sms_campaigns.index') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms_campaigns.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.SMS Campaigns') }}
        </a>
        <a href="{{ route('sms.logs') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('sms.logs') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.SMS Logs') }}
        </a>
        <a href="{{ route('analytics') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('analytics') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           {{ __('message.Analytics') }}
        </a>
    </nav>
    <div class="mt-10 text-sm text-white">⚙️ {{ __('Settings') }}</div>
</aside>


        <!-- ───── Main Content ───── -->
        <main class="flex-1 py-6 px-4 sm:px-6 lg:px-8">
            <div class="py-6 px-6 max-w-7xl mx-auto bg-white shadow rounded">

                {{-- ───────────────── Weather section ───────────────── --}}
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-green-700"> Weather Conditions</h3>
                        <p class="text-sm text-gray-600">Latest weather forecasts by location</p>
                    </div>

                    <!-- Refresh button -->
                    <button
                        class="inline-flex items-center gap-1 px-4 py-2 bg-green-600 text-white text-sm font-medium rounded hover:bg-green-700 focus:outline-none"
                        x-data
                        x-on:click="
                            fetch('{{ route('weather.refresh') }}', {
                                method:'POST',
                                headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'}
                            }).then(() => location.reload())
                        "
                    >
                        🔄 Pata Hali‑ya‑Hewa Sasa
                    </button>
                </div>

                <div class="overflow-x-auto mb-8">
                    <table class="min-w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">Region</th>
                                <th class="px-4 py-2 border">Temp (°C)</th>
                                <th class="px-4 py-2 border">Humidity (%)</th>
                                <th class="px-4 py-2 border">Wind (m/s)</th>
                                <th class="px-4 py-2 border">Rain (mm)</th>
                                <th class="px-4 py-2 border">Condition</th>
                                <th class="px-4 py-2 border">Observed</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($weatherReadings as $reading)
                                <tr class="@if($loop->odd) bg-gray-50 @endif">
                                    <td class="px-4 py-2 border">{{ $reading->region->name }}</td>
                                    <td class="px-4 py-2 border">{{ number_format($reading->temperature, 1) }}</td>
                                    <td class="px-4 py-2 border">{{ $reading->humidity }}</td>
                                    <td class="px-4 py-2 border">{{ $reading->wind }}</td>
                                    <td class="px-4 py-2 border">{{ $reading->rain }}</td>
                                    <td class="px-4 py-2 border capitalize">{{ $reading->condition }}</td>
                                    <td class="px-4 py-2 border">{{ $reading->measured_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-3 text-center text-gray-500">No weather data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ───────────────── Market section ───────────────── --}}
                <h3 class="text-lg font-semibold text-green-700 mb-2"> Market Prices</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 border">Crop</th>
                                <th class="px-4 py-2 border">Region</th>
                                <th class="px-4 py-2 border">Price (TZS/kg)</th>
                                <th class="px-4 py-2 border">Updated</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($marketData as $entry)
                                <tr class="@if($loop->odd) bg-gray-50 @endif">
                                    <td class="px-4 py-2 border">{{ $entry->crop->name }}</td>
                                    <td class="px-4 py-2 border">{{ $entry->region->name }}</td>
                                    <td class="px-4 py-2 border">{{ number_format($entry->price, 0) }}</td>
                                    <td class="px-4 py-2 border">{{ $entry->updated_at->diffForHumans() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-gray-500">No market price data available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </main>
    </div>
</x-app-layout>
