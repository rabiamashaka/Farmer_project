<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>AgriSMS – Farmer Dashboard</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ["Inter", "ui-sans-serif", "system-ui"],
          },
          colors: {
            brand: {
              50:  "#ecfdf5",
              100: "#d1fae5",
              200: "#a7f3d0",
              300: "#6ee7b7",
              400: "#34d399",
              500: "#10b981",
              600: "#059669",
              700: "#047857",
              800: "#065f46",
              900: "#064e3b"
            }
          }
        }
      }
    }
  </script>

  <style>
    /* Custom scrollbar for sidebar */
    .sidebar::-webkit-scrollbar {
      width: 6px;
    }
    .sidebar::-webkit-scrollbar-thumb {
      background-color: rgba(255, 255, 255, 0.25);
      border-radius: 3px;
    }
  </style>
</head>
<body class="h-full bg-gray-100 text-gray-800">

 <!-- Sidebar -->
<aside class="sidebar fixed inset-y-0 left-0 w-64 overflow-y-auto bg-green-600 text-white z-20">
  <div class="px-6 pt-20 pb-16">
    <h2 class="text-2xl font-bold mb-2">AgriSMS</h2>
    <p class="text-sm font-medium text-white/80 mb-6">Dashboard Overview</p>
    <nav class="space-y-2">
      <a href="#" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium bg-white/10 text-white">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6M5 12v8a2 2 0 002 2h3m10 0a2 2 0 002-2v-8" />
        </svg>
        Dashboard
      </a>
      <a href="#profile" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/20 hover:text-white text-white/80">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
          <path d="M4 20v-2a4 4 0 014-4h8a4 4 0 014 4v2" />
        </svg>
        Profile
      </a>
      <a href="#messages" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 text-white/80 hover:text-white">
        Messages
      </a>
      <a href="#weather" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 text-white/80 hover:text-white">
        Weather
      </a>
      <a href="#market" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 text-white/80 hover:text-white">
        Market
      </a>
      <a href="#chatbot" class="flex items-center gap-3 px-4 py-2 rounded-lg text-sm font-medium hover:bg-white/10 text-white/80 hover:text-white">
        Chatbot
      </a>
    </nav>
  </div>
</aside>

<!-- HEADER (unchanged) -->
<header class="fixed top-0 left-0 right-0 bg-white shadow px-6 py-2 z-30">
  <div class="ml-64 flex justify-end items-center h-10">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <x-responsive-nav-link :href="route('logout')"
          onclick="event.preventDefault(); this.closest('form').submit();"
          class="text-sm text-red-600 hover:text-red-700">
          {{ __('Log Out') }}
      </x-responsive-nav-link>
    </form>
  </div>
</header>

<!-- MAIN -->
<main class="ml-64 pt-24 p-6 space-y-8">
  <!-- ▸ Welcome banner ---------------------------------------- -->
   <div>
      <h2> WelcomeJohn Mkulima</h2>
      <p class="text-sm text-gray-500 mt-1">Moshi • Maize, Beans, Coffee</p>
    </div>
    <!-- Room for future quick‑action buttons -->
    <!-- <button class="mt-4 sm:mt-0 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow">
         + New Action
       </button> -->
 

  <!-- ▸ Stats cards ------------------------------------------- -->
  <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div class="bg-white p-5 rounded shadow-sm border" id="weather">
      <p class="text-sm text-gray-500">Weather</p>
      <p class="text-green-600 text-sm mt-1">No weather data available</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border" id="market">
      <p class="text-sm text-gray-500">Market Prices</p>
      <p class="text-green-600 text-sm mt-1">No market prices available</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border" id="messages">
      <p class="text-sm text-gray-500">Recent Messages</p>
      <h2 class="text-2xl font-bold">0</h2>
      <p class="text-green-600 text-sm mt-1">Messages this week</p>
    </div>
    <div class="bg-white p-5 rounded shadow-sm border" id="updates">
      <p class="text-sm text-gray-500">New Updates</p>
      <h2 class="text-2xl font-bold">0%</h2>
      <p class="text-green-600 text-sm mt-1">Updates today</p>
    </div>
  </section>

  <!-- ▸ Recent activity --------------------------------------- -->
  <section>
    <div class="bg-white p-5 rounded shadow-sm">
      <h3 class="text-lg font-semibold mb-2">Recent Updates</h3>
      <p class="text-green-600 text-sm">Latest farming news and advice</p>
      <p class="text-green-600 text-sm">No recent updates available</p>
    </div>
  </section>
</main>
