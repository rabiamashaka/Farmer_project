{{-- resources/views/sms_campaigns/index.blade.php --}}
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
            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-2xl font-bold text-green-900">{{ __('SMS Campaigns') }}</h1>
                        <p class="text-sm text-green-800">{{ __('Manage your SMS campaigns and track their performance') }}</p>
                    </div>

                    <div class="space-x-2">
                        <a href="{{ route('sms_campaigns.create') }}"
                           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded">
                            + {{ __('New Campaign') }}
                        </a>
                    </div>
                </div>

                <!-- Campaigns Table -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold mb-4">{{ __('Campaigns') }}</h2>
                        
                        @if($campaigns->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="w-full text-sm text-left">
                                    <thead class="bg-gray-100 text-gray-600">
                                        <tr>
                                            <th class="p-3">{{ __('#') }}</th>
                                            <th class="p-3">{{ __('Title') }}</th>
                                            <th class="p-3">{{ __('Status') }}</th>
                                            <th class="p-3">{{ __('Language') }}</th>
                                            <th class="p-3">{{ __('Sent To') }}</th>
                                            <th class="p-3">{{ __('Created') }}</th>
                                            <th class="p-3">{{ __('Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($campaigns as $index => $campaign)
                                            <tr class="border-b hover:bg-gray-50">
                                                <td class="p-3">{{ $index + 1 }}</td>
                                                <td class="p-3 font-medium">{{ $campaign->title }}</td>
                                                <td class="p-3">
                                                    <span class="px-2 py-1 text-xs rounded-full 
                                                        {{ $campaign->status === 'sent' ? 'bg-green-100 text-green-800' : 
                                                           ($campaign->status === 'queued' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                        {{ ucfirst($campaign->status) }}
                                                    </span>
                                                </td>
                                                <td class="p-3">{{ strtoupper($campaign->language) }}</td>
                                                <td class="p-3">{{ $campaign->sent_to ?? 0 }}</td>
                                                <td class="p-3">{{ $campaign->created_at->format('M d, Y') }}</td>
                                                <td class="p-3">
                                                    <div class="flex space-x-2">
                                                        <a href="{{ route('sms_campaigns.show', $campaign) }}"
                                                           class="text-blue-600 hover:text-blue-800">
                                                            {{ __('View') }}
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <p class="text-gray-500">{{ __('No campaigns found.') }}</p>
                                <a href="{{ route('sms_campaigns.create') }}"
                                   class="inline-block mt-2 text-indigo-600 hover:text-indigo-800">
                                    {{ __('Create your first campaign') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- USSD Information -->
                <div class="mt-6 bg-white rounded-lg shadow p-6">
                    <h3 class="font-semibold text-lg mb-4">{{ __('USSD Farmer Registration') }}</h3>
                    <p class="text-sm mb-4 text-gray-700">{{ __('Farmers can register using USSD codes from any mobile phone') }}</p>

                    <div class="bg-blue-100 text-blue-900 px-4 py-3 rounded mb-4">
                        <strong>{{ __('USSD Code for Farmers:') }}</strong><br>
                        <span class="text-lg font-bold">*456*1#</span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between text-green-700">
                            <span>{{ __('Easy Registration') }}</span>
                            <span>{{ __('No Internet Required') }}</span>
                        </div>
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded p-4 text-sm mt-4">
                        <strong>{{ __('Registration Flow:') }}</strong>
                        <ol class="list-decimal ml-4 mt-2 space-y-1">
                            <li>{{ __('Farmer dials *456*1#') }}</li>
                            <li>{{ __('Selects "Jisajili kama Mkulima"') }}</li>
                            <li>{{ __('Enters name, location, and crops') }}</li>
                            <li>{{ __('Chooses preferred language') }}</li>
                            <li>{{ __('Receives confirmation SMS') }}</li>
                        </ol>
                    </div>

                    <div class="bg-yellow-100 text-yellow-800 mt-4 p-3 rounded text-sm">
                        <strong>{{ __('Setup Required:') }}</strong><br>
                        {{ __('Contact your telecom provider to configure the USSD shortcode') }} <code>*456*1#</code>.
                    </div>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
