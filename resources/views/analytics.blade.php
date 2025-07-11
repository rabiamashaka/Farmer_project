<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
             Analytics Dashboard
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
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


        <!-- Main Dashboard Section -->
        <main class="flex-1 p-6">
            <h3 class="text-xl font-bold mb-1">Overview</h3>
            <p class="text-gray-600 mb-6">Key insights for your Agritech system</p>

            <!-- Top Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach ([['label' => 'Total Farmers', 'value' => $totalFarmers],
                          ['label' => 'Content Items', 'value' => $totalContent],
                          ['label' => 'SMS Sent', 'value' => $smsSent],
                          ['label' => 'Delivery Rate', 'value' => number_format($deliveryRate, 1) . '%']] as $metric)
                    <div class="bg-white rounded-xl p-5 shadow hover:shadow-lg transition">
                        <p class="text-gray-500 text-sm">{{ $metric['label'] }}</p>
                        <p class="text-3xl font-bold text-green-700 mt-1">{{ $metric['value'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Charts: Middle -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl p-5 shadow h-80">
                    <h4 class="font-semibold mb-3"> Farmers by Region</h4>
                    <canvas id="regionChart" class="w-full h-full"></canvas>
                </div>
                <div class="bg-white rounded-xl p-5 shadow h-80">
                    <h4 class="font-semibold mb-3"> Content by Category</h4>
                    <canvas id="contentChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Bottom Charts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white rounded-xl p-5 shadow h-80">
                    <h4 class="font-semibold mb-3">Most Grown Crops</h4>
                    <canvas id="cropChart" class="w-full h-full"></canvas>
                </div>
                <div class="bg-white rounded-xl p-5 shadow h-80">
                    <h4 class="font-semibold mb-3"> Monthly Weather Trends</h4>
                    <canvas id="weatherTrendChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </main>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Chart Scripts -->
    <script>
      
        new Chart(document.getElementById('regionChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($farmersByRegion->pluck('region')) !!},
                datasets: [{
                    label: 'Farmers',
                    data: {!! json_encode($farmersByRegion->pluck('total')) !!},
                    backgroundColor: '#16a34a'
                }]
            }
        });

       
        new Chart(document.getElementById('contentChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($contentDistribution->pluck('category')) !!},
                datasets: [{
                    data: {!! json_encode($contentDistribution->pluck('total')) !!},
                    backgroundColor: ['#16a34a', '#4ade80', '#bbf7d0']
                }]
            }
        });

       
        new Chart(document.getElementById('cropChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($popularCrops->pluck('crop')) !!},
                datasets: [{
                    label: 'Farmers',
                    data: {!! json_encode($popularCrops->pluck('total')) !!},
                    backgroundColor: '#16a34a'
                }]
            }
        });

        new Chart(document.getElementById('weatherTrendChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($weatherTrends->pluck('month')) !!},
                datasets: [
                    {
                        label: ' Temp (°C)',
                        data: {!! json_encode($weatherTrends->pluck('avg_temp')) !!},
                        borderColor: '#ef4444',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: ' Humidity (%)',
                        data: {!! json_encode($weatherTrends->pluck('avg_humidity')) !!},
                        borderColor: '#3b82f6',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: ' Wind (m/s)',
                        data: {!! json_encode($weatherTrends->pluck('avg_wind')) !!},
                        borderColor: '#10b981',
                        fill: false,
                        tension: 0.3
                    },
                    {
                        label: ' Rain (mm)',
                        data: {!! json_encode($weatherTrends->pluck('total_rain')) !!},
                        borderColor: '#8b5cf6',
                        fill: false,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: false
                    },
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
