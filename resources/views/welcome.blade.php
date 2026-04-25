
<!-- DEBUG: app()->getLocale() = {{ app()->getLocale() }}, session('locale') = {{ session('locale') }} -->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
@vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="h-full flex flex-col">
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
            <div class="flex items-center space-x-4">
                <!-- Language selector -->
                <select id="lang-switcher" class="rounded-md border-gray-300 text-sm focus:ring-primary-600 focus:border-primary-600">
                     <option value="en" {{ session()->get('locale', 'en') == 'en' ? 'selected' : '' }}>English</option>
                     <option value="sw" {{ session()->get('locale', 'en') == 'sw' ? 'selected' : '' }}>Kiswahili</option>
                 </select>
                <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 transition">{{ __('Login') }}</a>
            </div>
        </div>
    </header>

    <!-- ========== Page content ========== -->
    <main class="flex-grow bg-gradient-to-br from-primary-50 to-white py-16 lg:py-24">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <!-- Hero -->
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight text-gray-800 mb-4">
                <span id="typed-headline"></span>
            </h1>
            @php
                $headline = __('Smart Farming Through :tech', ['tech' => 'SMS Technology']);
            @endphp
            <script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    new Typed('#typed-headline', {
                        strings: [@json($headline)],
                        typeSpeed: 40,
                        backSpeed: 0,
                        showCursor: false,
                        loop: false
                    });
                });
            </script>
            <p class="max-w-2xl mx-auto text-gray-600 text-lg mb-8">
                {{ __('Empowering Tanzanian farmers with timely agricultural information, weather updates, and market prices delivered directly to their mobile phones.') }}
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center mb-12">
                <a href="{{ route('register') }}" class="inline-block px-6 py-3 rounded-full text-base font-semibold text-white bg-primary-600 hover:bg-primary-700 shadow-lg shadow-primary-600/20 transition">{{ __('Register') }}</a>
                <a href="{{ route('login') }}" class="inline-block px-6 py-3 rounded-full text-base font-semibold text-primary-600 ring-1 ring-primary-600 hover:bg-primary-50 transition">{{ __('Login') }}</a>
            </div>

           

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @php
        $features = [
          ['title' => 'Accurate Weather', 'description' => 'Get reliable local forecasts to help plan your planting, irrigation, and harvesting.'],
          ['title' => 'Market Prices', 'description' => 'Stay informed about the latest prices of your crops in different markets.'],
          ['title' => 'Best Farming Practices', 'description' => 'Learn new and efficient methods of planting, weeding, and harvesting.'],
          ['title' => 'Disease & Pest Alerts', 'description' => 'Early detection and solutions to protect your crops from diseases and pests.'],
          ['title' => 'Personalized SMS', 'description' => 'Messages based on your crop, region, and preferred language.'],
          ['title' => 'Works Without Internet', 'description' => 'No smartphone? No problem. SMS works on all phones.']
        ];
      @endphp

      @foreach ($features as $feature)
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition p-6">
          <h3 class="text-xl font-semibold mb-2">{{ $feature['title'] }}</h3>
          <p class="text-gray-600 text-sm">{{ $feature['description'] }}</p>
        </div>
      @endforeach
    </div>
  </section>

  <!-- How It Works Section -->
  <section class="max-w-7xl mx-auto px-4 py-16">
    <h2 class="text-3xl font-bold text-center mb-6">How AgriSMS Works</h2>
    <p class="text-center text-gray-600 mb-12">Simple steps to start receiving SMS advice for your farm.</p>


<script src="https://widget.cxgenie.ai/widget.js" data-aid="0a9c4453-a60a-4634-a949-c732325c607a"></script>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <div class="text-4xl font-bold text-blue-600 mb-4">1</div>
        <h3 class="text-xl font-semibold mb-2">Register Your Farm</h3>
        <p class="text-gray-600 text-sm">Sign up with your location, crops, and language to get personalized content.</p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <div class="text-4xl font-bold text-blue-600 mb-4">2</div>
        <h3 class="text-xl font-semibold mb-2">Receive SMS Alerts</h3>
        <p class="text-gray-600 text-sm">Get useful farming info on weather, markets, and tips directly on your phone.</p>
      </div>

      <div class="bg-white border border-gray-100 rounded-xl shadow-sm hover:shadow-md transition p-6 text-center">
        <div class="text-4xl font-bold text-blue-600 mb-4">3</div>
        <h3 class="text-xl font-semibold mb-2">Grow and Earn More</h3>
        <p class="text-gray-600 text-sm">Make smart decisions, improve productivity, and increase your profits.</p>
      </div>
    </div>
  </section>

  <!-- Call to Action -->
  <section class="text-center py-12 bg-blue-50">
    <h3 class="text-2xl font-semibold mb-4">Ready to Boost Your Farming?</h3>
    <p class="text-gray-700 mb-6">Join thousands of Tanzanian farmers improving their yields with AgriSMS.</p>
    <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-semibold rounded-full hover:bg-blue-700 transition">
      Register Now
    </a>
  </section>

</body>
</html>

