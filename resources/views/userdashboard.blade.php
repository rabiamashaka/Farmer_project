@push('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Farmer Dashboard') }}
        </h2>
    </x-slot>

    <!-- Main Layout -->
    <div class="flex min-h-screen bg-gray-100">
        <aside class="w-64 bg-green-600 text-white shadow-sm p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold">User Panel</h1>
        <p class="text-sm"></p>
    </div>
    <nav class="space-y-2 text-sm">
        <a href="{{ route('userdashboard') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->is('userdashboard') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Overview
        </a>
        <a href="{{ route('profile.edit') }}"
           class="block px-3 py-2 rounded font-medium {{ request()->routeIs('profile.*') ? 'bg-white text-green-700' : 'text-green-100 hover:text-white hover:bg-green-700' }}">
           Profile
        </a>
        <a href="#messages"
           class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">
           Messages
        </a>
        <a href="#weather"
           class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">
           Weather
        </a>
        <a href="#market"
           class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">
           Market Prices
        </a>
        <a href="#chatbot"
           class="block px-3 py-2 rounded font-medium text-green-100 hover:text-white hover:bg-green-700">
           Chatbot
        </a>
    </nav>
</aside>


        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <main class="flex-1 p-4 md:p-8">
                <!-- Welcome -->
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-gray-800">Welcome, Farmer!</h2>
                    <p class="text-gray-500">Here is an overview of your farming activity.</p>
                </div>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-5 rounded-xl shadow">
                        <p class="text-sm text-gray-500">Messages Received</p>
                        <h2 class="text-2xl font-bold">0</h2>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow">
                        <p class="text-sm text-gray-500">Weather</p>
                        <p class="text-green-600 text-sm mt-1">No weather data</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow">
                        <p class="text-sm text-gray-500">Market Prices</p>
                        <p class="text-green-600 text-sm mt-1">No data</p>
                    </div>
                    <div class="bg-white p-5 rounded-xl shadow">
                        <p class="text-sm text-gray-500">Updates</p>
                        <h2 class="text-2xl font-bold">0%</h2>
                    </div>
                </div>

                <!-- Recent Updates -->
                <section class="bg-white p-6 rounded-xl shadow mb-8">
                    <h3 class="text-lg font-semibold mb-2">Recent Updates</h3>
                    <p class="text-green-600 text-sm">No recent updates available</p>
                </section>
            </main>
        </div>

        <!-- Floating Chatbot Button -->
        <button id="chatbotToggle"
            class="fixed bottom-6 right-6 bg-green-600 text-white rounded-full h-14 w-14 shadow-lg flex items-center justify-center z-50"
            onclick="document.getElementById('chatbotModal').classList.remove('hidden')">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M17 8h2a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2v-8a2 2 0 012-2h2M9 6h6m-6 4h6m-6 4h6" />
            </svg>
        </button>

        <!-- Chatbot Modal -->
        <div id="chatbotModal"
            class="fixed inset-0 bg-black bg-opacity-40 flex items-end md:items-center justify-center z-50 hidden">
            <div class="bg-white rounded-t-2xl md:rounded-2xl shadow-2xl w-full md:w-96 max-w-full p-0 flex flex-col">
                <div class="flex items-center justify-between px-6 py-4 bg-green-600 rounded-t-2xl">
                    <span class="font-bold text-lg text-white"> AgriBot</span>
                    <button onclick="document.getElementById('chatbotModal').classList.add('hidden')"
                            class="text-2xl text-white hover:text-green-100 transition">&times;</button>
                </div>
                <div id="chatMessages" class="h-64 overflow-y-auto px-5 py-4 bg-green-50 text-sm"></div>
                <form class="flex items-center gap-2 border-t border-green-100 bg-white px-4 py-3"
                      onsubmit="event.preventDefault(); sendMessage();">
                    <input id="chatInput" type="text" placeholder="Type your agriculture question…"
                        class="flex-1 px-3 py-2 rounded-lg border border-green-200 focus:ring-2 focus:ring-green-400 focus:outline-none bg-white text-gray-700 placeholder-gray-400 shadow-sm">
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 transition text-white font-semibold rounded-lg px-6 py-2 shadow">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Chatbot JS -->
    <script>
        function appendMessage(content, from = 'user') {
            const messages = document.getElementById('chatMessages');
            const msgDiv = document.createElement('div');
            msgDiv.className = from === 'user' ? 'text-right mb-2' : 'text-left mb-2';
            msgDiv.innerHTML = `<div class="${from === 'user' ? 'bg-green-600 text-white' : 'bg-green-100 text-green-900'} rounded-lg px-4 py-2 inline-block max-w-xs break-words">${content}</div>`;
            messages.appendChild(msgDiv);
            messages.scrollTop = messages.scrollHeight;
        }

        function sendMessage() {
            const input = document.getElementById('chatInput');
            const text = input.value.trim();
            if (!text) return;
            appendMessage(text, 'user');
            input.value = '';
            appendMessage('...', 'bot');
            fetch('/api/askagricultureexpert', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ question: text })
            })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('chatMessages').lastChild.remove();
                    appendMessage(data.answer || 'Sorry, no answer received.', 'bot');
                })
                .catch(() => {
                    document.getElementById('chatMessages').lastChild.remove();
                    appendMessage('Sorry, there was an error contacting the server.', 'bot');
                });
        }
    </script>
</x-app-layout>
