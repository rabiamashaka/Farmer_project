<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Farmer Management') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
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
        <main class="flex-1 p-8">
            <!-- Success/Error Messages -->
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

            <!-- Create Farmer Button -->
            <div class="mb-6 flex justify-end">
                <a href="{{ route('farmer.create') }}"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-5 py-2 rounded shadow transition">
                    ➕ {{ __('Create Farmer') }}
                </a>
            </div>

            <!-- Farmers List -->
            <section class="bg-white rounded shadow p-6">
                <h3 class="text-lg font-semibold mb-6 text-green-700">{{ __('Farmers List') }}</h3>

                @if($farmers->isEmpty())
                    <p class="text-gray-500 text-sm">{{ __('No farmers found.') }}</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-green-100">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('#') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Name') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Phone') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Region') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Farming Type') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Crops') }}</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">{{ __('Action') }}</th>
                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($farmers as $index => $farmer)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->name }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->phone }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->region->name ?? __('N/A') }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->farming_type }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->crops->pluck('name')->join(', ') }}</td>
                                        <td class="px-4 py-2 text-sm whitespace-nowrap">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('farmer.show', $farmer->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600 transition">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                    {{ __('View') }}
                                                </a>
                                                <a href="{{ route('farmer.edit', $farmer->id) }}" 
                                                   class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600 transition">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                    {{ __('Edit') }}
                                                </a>
                                                <form action="{{ route('farmer.destroy', $farmer->id) }}" method="POST" class="inline-block">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('{{ __('Are you sure you want to delete') }} {{ $farmer->name }}? {{ __('This action cannot be undone.') }}')"
                                                            class="inline-flex items-center px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600 transition">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                        {{ __('Delete') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $farmers->links() }}
                    </div>
                @endif
            </section>
        </main>
    </div>
</x-app-layout>
