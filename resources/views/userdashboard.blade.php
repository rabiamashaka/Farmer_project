@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>
    <div class="flex min-h-screen bg-gray-100" x-data="{ section: 'summary' }">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">User Panel</h1>
            </div>
            <nav class="space-y-2 text-sm">
                <a href="#" @click.prevent="section = 'summary'" class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">Dashboard Summary</a>
                <a href="#" @click.prevent="section = 'weather'" class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">Weather</a>
                <a href="#" @click.prevent="section = 'messages'" class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">Messages</a>
                <a href="#" @click.prevent="section = 'feedback'" class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">Send Feedback</a>
                <a href="#" @click.prevent="section = 'cropinfo'" class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">Get Crop Information</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-4 md:p-8">
                <!-- Dashboard Summary and Stats (toggle) -->
                <section x-show="section === 'summary'">
                    <div class="mb-6">
                        <h2 class="text-2xl font-bold text-gray-800">Welcome, Farmer!</h2>
                        <p class="text-gray-500">Here is an overview of your farming activity.</p>
                        <div class="mt-4">
                            <span class="font-semibold">Region:</span>
                            <span class="text-green-700">
                                {{ optional($user->region)->name ?? 'N/A' }}
                            </span>
                        </div>
                        <div class="mt-2">
                            <span class="font-semibold">Your Crops:</span>
                            @if(isset($user) && $user->crops && $user->crops->count())
                                <span class="text-green-700">
                                    {{ $user->crops->pluck('name')->join(', ') }}
                                </span>
                            @else
                                <span class="text-gray-500">No crops registered.</span>
                            @endif
                        </div>
                    </div>
                    @if(isset($weatherSummary) && $weatherSummary)
                        <div class="mb-4 p-3 bg-green-50 rounded">
                            <strong>Latest Weather:</strong> {{ $weatherSummary }}
                        </div>
                    @endif
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Messages Received</p>
                            <h2 class="text-2xl font-bold">0</h2>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Weather</p>
                            @if(isset($weatherSummary) && $weatherSummary)
                                <p class="text-green-600 text-sm mt-1">{{ $weatherSummary }}</p>
                            @else
                                <p class="text-green-600 text-sm mt-1">No weather data</p>
                            @endif
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Market Prices</p>
                            <p class="text-green-600 text-sm mt-1">No data</p>
                        </div>
                        <div class="bg-white p-5 rounded-xl shadow">
                            <p class="text-sm text-gray-500">Updates</p>
                            <h2 class="text-2xl font-bold">0%</h2>
                        </div>
                    </div>
                </section>
                <!-- Weather Section -->
                <section id="weather" x-show="section === 'weather'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Weather for Your Region</h3>
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
                <!-- Messages Section -->
                <section id="messages" x-show="section === 'messages'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Official Messages</h3>
                    <ul>
                        @forelse($messages as $msg)
                            <li class="mb-2 border-b pb-2">
                                <div class="text-gray-800">{{ $msg->message }}</div>
                                <div class="text-xs text-gray-500">{{ $msg->sent_at ? $msg->sent_at->format('d M Y H:i') : '' }}</div>
                            </li>
                        @empty
                            <li>No messages yet.</li>
                        @endforelse
                    </ul>
                </section>
                <!-- Feedback Section -->
                <section id="feedback" x-show="section === 'feedback'" class="bg-white rounded-xl shadow p-6 mb-8">
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
                <!-- Crop Information Section -->
                <section id="cropinfo" x-show="section === 'cropinfo'" class="bg-white rounded-xl shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold mb-2">Your Crops & Information</h3>
                    @if(isset($user) && $user->crops && $user->crops->count())
                        <ul class="mb-4">
                            @foreach($user->crops as $crop)
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
            </main>
        </div>
    </div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('dashboard', () => ({
                section: 'summary',
            }));
        });
    </script>
</x-app-layout>
