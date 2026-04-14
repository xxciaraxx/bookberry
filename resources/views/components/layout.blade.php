<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'BookBerry' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        :root {
            --bb-purple:   #5A2A6E;
            --bb-lavender: #CBA0D9;
            --bb-pink:     #E94E77;
            --bb-cream:    #FFF8F2;
            --bb-charcoal: #2E2E2E;
        }

        body {
            background-color: var(--bb-cream);
            color: var(--bb-charcoal);
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bb-cream); }
        ::-webkit-scrollbar-thumb { background: var(--bb-lavender); border-radius: 3px; }

        /* Livewire loading indicator */
        [wire\:loading] { opacity: 0.6; pointer-events: none; }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    {{-- ===== NAVBAR ===== --}}
    <nav style="background: var(--bb-purple);" class="sticky top-0 z-50 px-4 md:px-8 py-3 shadow-lg">
        <div class="max-w-7xl mx-auto flex items-center gap-3">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-xl font-bold text-white tracking-wide shrink-0">
                Book<span style="color: var(--bb-lavender);">Berry</span>
            </a>

            {{-- Search bar --}}
            <form action="{{ route('products') }}" method="GET"
                class="flex flex-1 max-w-xl bg-white rounded-xl overflow-hidden mx-2">
                <input
                    name="search"
                    type="text"
                    placeholder="Search books, manga, Wattpad stories..."
                    value="{{ request('search') }}"
                    class="flex-1 px-4 py-2 text-sm outline-none text-gray-700 bg-transparent"
                />
                <button type="submit"
                    style="background: var(--bb-pink);"
                    class="text-white px-4 py-2 text-sm font-semibold hover:opacity-90 transition shrink-0">
                    Search
                </button>
            </form>

            {{-- Nav links --}}
            <div class="ml-auto flex items-center gap-3 text-sm shrink-0">
                @guest
                    <a href="{{ route('login') }}"
                        class="text-white/80 hover:text-white font-medium transition">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        style="background: var(--bb-pink);"
                        class="text-white px-4 py-1.5 rounded-xl font-medium hover:opacity-90 transition">
                        Register
                    </a>
                @endguest

                @auth
                    <livewire:cart-counter />

                    {{-- User dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-1.5 text-white/80 hover:text-white transition">
                            <div style="background: var(--bb-lavender);"
                                class="w-7 h-7 rounded-full flex items-center justify-center
                                    text-xs font-bold text-purple-900">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg
                                border border-purple-100 py-1 z-50">
                            <div class="px-4 py-2 border-b border-purple-50">
                                <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-400">{{ auth()->user()->email }}</p>
                            </div>

                            <a href="{{ route('products') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">
                                Browse Books
                            </a>
                            <a href="{{ route('cart') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-50">
                                My Cart
                            </a>

                            @if(auth()->user()->isAdmin())
                                <div class="border-t border-purple-50 mt-1">
                                    <a href="{{ route('admin.products') }}"
                                        class="block px-4 py-2 text-sm font-medium hover:bg-purple-50"
                                        style="color: var(--bb-purple);">
                                        Admin Panel
                                    </a>
                                </div>
                            @endif

                            <div class="border-t border-purple-50 mt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full text-left px-4 py-2 text-sm text-red-500 hover:bg-red-50">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    {{-- ===== FOOTER ===== --}}
    <footer style="background: var(--bb-purple);" class="mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <h3 class="text-lg font-bold text-white mb-2">
                    Book<span style="color: var(--bb-lavender);">Berry</span>
                </h3>
                <p class="text-sm text-white/60 leading-relaxed">
                    Your cozy corner for Filipino Wattpad books and Japanese manga.
                </p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white/80 mb-3">Quick Links</h4>
                <ul class="space-y-1.5 text-sm text-white/60">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ route('products') }}" class="hover:text-white transition">Browse Books</a></li>
                    @auth
                        <li><a href="{{ route('cart') }}" class="hover:text-white transition">My Cart</a></li>
                    @endauth
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white/80 mb-3">Categories</h4>
                <ul class="space-y-1.5 text-sm text-white/60">
                    <li><a href="{{ route('products') }}?category=wattpad" class="hover:text-white transition">📚 Wattpad Books</a></li>
                    <li><a href="{{ route('products') }}?category=manga" class="hover:text-white transition">🎌 Manga</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-white/10 py-4 text-center text-xs text-white/40">
            © {{ date('Y') }} BookBerry. All rights reserved.
        </div>
    </footer>

    @livewireScripts

    {{-- Global toast notification (Alpine.js) --}}
    <div
        x-data="{ show: false, message: '', type: 'success' }"
        @notify.window="
            message = $event.detail.message;
            type = $event.detail.type ?? 'success';
            show = true;
            setTimeout(() => show = false, 3000)
        "
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="background: var(--bb-purple);"
        class="fixed bottom-6 right-6 z-50 text-white px-5 py-3 rounded-2xl shadow-xl
            text-sm font-medium flex items-center gap-2 max-w-xs"
    >
        <span>✓</span>
        <span x-text="message"></span>
    </div>

</body>
</html>
