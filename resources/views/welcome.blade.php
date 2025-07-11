<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgriSMS | Smart Farming Through SMS</title>

    <!-- TailwindCSS via CDN for quick prototyping. For production, install Tailwind and compile through Vite or Mix -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#16a34a',
                            50: '#f0fdf4',
                            100: '#dcfce7',
                            200: '#bbf7d0',
                            300: '#86efac',
                            400: '#4ade80',
                            500: '#22c55e',
                            600: '#16a34a',
                            700: '#15803d',
                            800: '#166534',
                            900: '#14532d',
                        },
                    },
                },
            },
        }
    </script>
</head>
<body class="antialiased min-h-full flex flex-col">

    <!-- ========== Navbar ========== -->
    <header class="w-full bg-white/70 backdrop-blur border-b border-gray-100 shadow-sm sticky top-0 z-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
            <!-- Logo / Brand -->
            <a href="/" class="flex items-center space-x-2 text-primary-600 font-extrabold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                    <path d="M2.25 12l8.954-9a.75.75 0 011.092 0l8.954 9a2.25 2.25 0 01.75 1.692v6.558A2.25 2.25 0 0119.75 22.5H4.25A2.25 2.25 0 012 20.25v-6.558A2.25 2.25 0 012.25 12z" />
                </svg>
                <span>AgriTech</span>
            </a>

            <!-- Single Login Button -->
            <div class="flex items-center">
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 transition">Login</a>
            </div>
        </div>
    </header>

    <!-- ========== Page content ========== -->
    <main class="flex-grow bg-gradient-to-br from-primary-50 to-white py-16 lg:py-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Hero -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-gray-800 mb-4">
                Smart Farming Through <span class="text-primary-600">SMS Technology</span>
            </h1>
            <p class="max-w-2xl mx-auto text-gray-600 text-lg mb-8">
                Empowering Tanzanian farmers with timely agricultural information, weather updates, and market prices delivered directly to their mobile phones.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 rounded-full text-base font-semibold text-white bg-primary-600 hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition">Register</a>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 rounded-full text-base font-semibold text-primary-600 ring-1 ring-primary-600 hover:bg-primary-50 transition">Login</a>
            </div>

            <!-- ===== Feature Cards ===== -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
                <!-- SMS Notifications -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-50 text-primary-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2M9 6h6m-6 4h6m-6 4h6" /></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">SMS Notifications</h3>
                    <p class="text-sm text-gray-500">Receive farming tips, early‑warning alerts, and announcements wherever you are.</p>
                </div>

                <!-- Weather Updates -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-50 text-primary-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75V4.5m6.364 2.146l1.061-1.061M19.5 12h2.25M18.364 17.864l1.061 1.061M12 19.5v2.25M4.575 18.925l-1.061 1.061M4.5 12H2.25M5.636 6.646L4.575 5.586" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Weather Updates</h3>
                    <p class="text-sm text-gray-500">Get timely forecasts, severe‑weather alerts, and rainfall predictions.</p>
                </div>

                <!-- Market Prices -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-50 text-primary-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.593 4.593a.75.75 0 001.06 0L21.75 10.5" /></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Market Prices</h3>
                    <p class="text-sm text-gray-500">Stay updated with current market prices and sell at the right time.</p>
                </div>

                <!-- Mobile Friendly -->
                <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6 flex flex-col items-center text-center">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full bg-primary-50 text-primary-600 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6h-7.5a.75.75 0 00-.75.75v10.5c0 .414.336.75.75.75h7.5a.75.75 0 00.75-.75V6.75a.75.75 0 00-.75-.75z" /></svg>
                    </div>
                    <h3 class="font-semibold text-gray-800 mb-1">Mobile Friendly
