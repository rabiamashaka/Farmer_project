<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Farmer Management') }}
        </h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white p-6 rounded shadow">
            <h3 class="text-lg font-bold mb-4">Manage Registered Farmers</h3>
            <p class="text-gray-600">This page will allow you to view, add, or update farmer records.</p>
        </div>
    </div>
</x-app-layout>
