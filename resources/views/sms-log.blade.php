<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('SMS Delivery Logs') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">{{ __('message.Admin Panel') }}</h1>
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

        <!-- Main Content -->
        <main class="flex-1 p-8">
            {{-- Success/Error Messages --}}
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Total SMS</p>
                    <p class="text-2xl font-bold">{{ $totalSms }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Sent</p>
                    <p class="text-2xl font-bold text-green-600">{{ $sent }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Pending</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $pending }}</p>
                </div>
                <div class="bg-white p-4 rounded shadow">
                    <p class="text-gray-500">Failed</p>
                    <p class="text-2xl font-bold text-red-600">{{ $failed }}</p>
                </div>
            </div>

            {{-- SMS Messages Table --}}
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-xl font-semibold mb-2">Recent SMS Messages</h3>
                <p class="text-sm text-gray-500 mb-4">Latest SMS delivery attempts and their status</p>
                <div class="overflow-x-auto rounded shadow">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 font-bold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Farmer</th>
                                <th class="px-4 py-2">Phone Number</th>
                                <th class="px-4 py-2">Message</th>
                                <th class="px-4 py-2">Sent At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($messages as $message)
                                <tr class="border-t hover:bg-green-50 transition">
                                    <td class="px-4 py-2 text-center">
                                        @if($message->status === 'sent')
                                            <span class="inline-flex items-center text-green-600 font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                                Sent
                                            </span>
                                        @elseif($message->status === 'failed')
                                            <span class="inline-flex items-center text-red-600 font-semibold">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                                                Failed
                                            </span>
                                        @else
                                            <span class="text-gray-600">{{ ucfirst($message->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 font-semibold text-green-800">{{ $message->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 text-blue-700">{{ $message->phone }}</td>
                                    <td class="px-4 py-2 max-w-xs truncate" title="{{ $message->message }}">
                                        {{ \Illuminate\Support\Str::limit($message->message, 40) }}
                                    </td>
                                    <td class="px-4 py-2 text-gray-500">
                                        {{ $message->sent_at ? \Carbon\Carbon::parse($message->sent_at)->format('Y-m-d H:i:s') : 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr class="border-t">
                                    <td class="px-4 py-2 text-center text-gray-400" colspan="5">No messages found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
