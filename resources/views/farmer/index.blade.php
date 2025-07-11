<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Farmer Management') }}
        </h2>
    </x-slot>

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
        <main class="flex-1 p-6">
          <!-- Create Content Button -->
<div class="mb-4 flex justify-end">
    <a href="{{ route('farmer.create') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
        ➕ Create Farmer
    </a>
</div>


            <!-- Recent Activity Section -->
            <div class="bg-white p-6 shadow rounded">
    <h3 class="text-lg font-semibold mb-4">Farmers List</h3>

    @if($farmers->isEmpty())
        <p class="text-sm text-gray-500">No farmers found.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">#</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Phone</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">location</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Crop</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-green-700 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
    @foreach($farmers as $index => $farmer)
        <tr>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $index + 1 }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->name }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->phone }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->location }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->farming_type }}</td>
            <td class="px-4 py-2 text-sm text-gray-700">{{ $farmer->crops->pluck('name')->join(', ') }}</td>
            <td class="px-4 py-2 text-sm">
                <a href="{{ route('farmer.edit', $farmer->id) }}" class="text-blue-600 hover:underline text-sm">Edit</a> |
                <form action="{{ route('farmer.destroy', $farmer->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline text-sm">Delete</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

                
            </table>
        </div>
    @endif
</div>

        </main>
    </div>
</x-app-layout>
