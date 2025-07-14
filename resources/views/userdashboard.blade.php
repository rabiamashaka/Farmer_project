<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <div class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
            <div class="mb-6">
                <h1 class="text-2xl font-bold">AgriSMS</h1>
                <p class="text-sm">{{ __('Quick Links') }}</p>
            </div>
            <nav class="space-y-2 text-sm">
                <a href="{{ route('userdashboard') }}"
                   class="block px-3 py-2 rounded font-medium {{ request()->is('userdashboard') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
                   {{ __('Overview') }}
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="block px-3 py-2 rounded font-medium {{ request()->routeIs('profile.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
                   {{ __('Profile') }}
                </a>
                <a href="#messages"
                   class="block px-3 py-2 rounded font-medium text-green-100">
                   {{ __('Messages') }}
                </a>
                <a href="#weather" class="block px-3 py-2 rounded font-medium text-green-100">
                    {{ __('Weather') }}
                </a>
                <a href="#market" class="block px-3 py-2 rounded font-medium text-green-100">
                    {{ __('Market Prices') }}
                {{-- </a>
                <a href="javascript:void(0)" onclick="openChat()" class="block px-3 py-2 rounded font-medium text-green-100">
                    {{ __('Chatbot') }}
                </a> --}}
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h1 class="text-2xl font-semibold mb-1">{{ __('Welcome') }}, {{ Auth::user()->name }}</h1>
            <p class="text-sm text-gray-500 mb-6">{{ __('Here is an overview of your farming activity.') }}</p>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-5 rounded shadow">
                    <p class="text-sm text-gray-500">{{ __('Messages Received') }}</p>
                    <h2 class="text-2xl font-bold">0</h2>
                </div>
                <div class="bg-white p-5 rounded shadow" id="weather">
                    <p class="text-sm text-gray-500">{{ __('Weather') }}</p>
                    <p class="text-green-600 text-sm mt-1">{{ __('No weather data') }}</p>
                </div>
                <div class="bg-white p-5 rounded shadow" id="market">
                    <p class="text-sm text-gray-500">{{ __('Market Prices') }}</p>
                    <p class="text-green-600 text-sm mt-1">{{ __('No data') }}</p>
                </div>
                <div class="bg-white p-5 rounded shadow" id="updates">
                    <p class="text-sm text-gray-500">{{ __('Updates') }}</p>
                    <h2 class="text-2xl font-bold">0%</h2>
                </div>
            </div>

            <!-- Recent Updates -->
            <section class="bg-white p-4 shadow rounded">
                <h3 class="text-lg font-semibold mb-2">{{ __('Recent Updates') }}</h3>
                <p class="text-green-600 text-sm">{{ __('No recent updates available') }}</p>
            </section>
        </main>
    </div>
</x-app-layout>
    <!-- Font Awesome for chat icons -->
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-2mJ3xC3u5QEU9sNqF6jO+Rbk1P1Cf90cWqX2VNfzOEx+kt1lEuzMdGII4XESyqCCpt5TR1+t0NenE2no0LYRow==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    @vite('resources/js/script.js') --}}

    {{-- <style>#chatbot{display:none;}#chatbot.active{display:block;}</style>

    <!-- Fallback for openChat/closeChat if script not yet compiled -->
    <script>
        if (typeof openChat !== 'function') {
            function openChat(){
                document.getElementById('chatbot').style.display='block';
                const btn=document.getElementById('chatToggle');
                if(btn) btn.style.display='none';
            }
            function closeChat(){
                document.getElementById('chatbot').style.display='none';
                const btn=document.getElementById('chatToggle');
                if(btn) btn.style.display='block';
            }
            function toggleChat(){
                const chat=document.getElementById('chatbot');
                if(chat.style.display==='none'||chat.style.display==='') openChat(); else closeChat();
            }
        }
    </script> --}}

    <!-- Floating Chatbot button & widget -->
    <button id="chatToggle"
            onclick="toggleChat()"
            class="fixed bottom-6 right-6 bg-green-600 text-white rounded-full h-14 w-14 shadow-lg flex items-center justify-center z-50">
        <i class="fas fa-comments text-xl"></i>
    </button>

    <div id="chatbot" class="fixed bottom-24 right-6 w-80 md:w-96 rounded-2xl shadow-2xl z-50 backdrop-blur-lg bg-white/80 border border-green-200" style="display:none;">
    <!-- Minimal glassy header -->
    <div class="flex items-center justify-between px-6 py-3 rounded-t-2xl" style="background: rgba(34,197,94,0.8);">
        <span class="font-bold text-lg tracking-wide text-white drop-shadow">🤖 Chatbot</span>
        <button onclick="closeChat()" class="text-2xl text-white hover:text-green-100 transition">&times;</button>
    </div>
    <!-- Messages area -->
    <div id="chatMessages" class="h-64 overflow-y-auto px-5 py-4 space-y-4 bg-gradient-to-b from-green-50/80 to-white/60 rounded-b-xl" style="scrollbar-width:thin;"></div>
    <!-- Input area -->
    <div class="flex items-center gap-2 border-t border-green-100 bg-white/70 rounded-b-2xl px-4 py-3">
        <input id="chatInput" onkeydown="handleKeyPress(event)" type="text" placeholder="Type your message…" class="flex-1 px-3 py-2 rounded-lg border border-green-200 focus:ring-2 focus:ring-green-400 focus:outline-none bg-white/80 text-gray-700 placeholder-gray-400 shadow-sm">
        <button onclick="sendMessage()" class="bg-green-500 hover:bg-green-600 transition text-white font-semibold rounded-lg px-6 py-2 shadow">Send</button>
    </div>
</div>
  {{-- <meta name="viewport" content="width=device-width, initial-scale=1" />
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
      <h2> Welcome John Mkulima</h2>
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

    </div>
  </section>
</main> --}} 
<script src="script.js"></script>