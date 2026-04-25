<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('content Management') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">{{ __('Admin Panel') }}</h1>
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
            <!-- Create Content Button -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('content.create') }}"
                   class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                    ➕ {{ __('Create Content') }}
                </a>
            </div>

            <!-- Content List Table -->
            <div class="bg-white p-6 shadow rounded">
                <h3 class="text-lg font-semibold mb-2">{{ __('Content List') }}</h3>
                <div class="overflow-x-auto rounded shadow">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-gray-100 font-bold text-gray-700">
                            <tr>
                                <th class="px-4 py-2">Number</th>
                                <th class="px-4 py-2">Title</th>
                                <th class="px-4 py-2">Content</th>
                                <th class="px-4 py-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $content)
                                <tr class="border-t hover:bg-green-50 transition">
                                    <td class="px-4 py-2">{{ $content->id }}</td>
                                    <td class="px-4 py-2">{{ $content->title }}</td>
                                    <td class="px-4 py-2 max-w-xs truncate" title="{{ $content->content }}">
                                        {{ \Illuminate\Support\Str::limit($content->content, 60) }}
                                    </td>
                                    <td class="px-4 py-2">
                                        <form action="{{ route('content.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Delete this content?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-gray-400 py-4">No content found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</x-app-layout>
