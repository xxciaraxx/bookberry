<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'Admin — BookBerry' }}</title>
        <link rel="icon" type="image/jpeg" href="{{ asset('images/bookberry-logo.svg')}}"> 
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <style>
        :root {
            --bb-purple:   #5A2A6E;
            --bb-lavender: #CBA0D9;
            --bb-pink:     #E94E77;
            --bb-cream:    #FFF8F2;
            --bb-charcoal: #2E2E2E;
            --sidebar-w:   240px;
        }
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background: #F3EDF7;
            -webkit-font-smoothing: antialiased;
        }
        .sidebar-link {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px; border-radius: 10px;
            font-size: 14px; font-weight: 500; color: rgba(255,255,255,0.75);
            transition: all 0.15s; text-decoration: none;
        }
        .sidebar-link:hover,
        .sidebar-link.active {
            background: rgba(255,255,255,0.12);
            color: white;
        }
        .sidebar-link.active {
            background: rgba(255,255,255,0.18);
            color: white;
        }
    </style>
</head>
<body class="flex min-h-screen" x-data="{ sidebarOpen: false }">
        <div class="flex w-full min-h-screen"> {{-- ✅ SINGLE ROOT WRAPPER --}}

        {{-- ===== SIDEBAR ===== --}}
        {{-- Mobile overlay --}}
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-20 lg:hidden" x-transition></div>

        <aside
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
            style="background: linear-gradient(180deg, #3D1A4E 0%, #5A2A6E 100%); width: var(--sidebar-w);"
            class="fixed top-0 left-0 h-screen z-30 flex flex-col transition-transform duration-300
                lg:translate-x-0 shrink-0 overflow-y-auto">

	            {{-- Logo --}}
	            <div class="px-5 py-5 border-b border-white/10">
	                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 text-xl font-bold text-white">
	                    <img src="{{ asset('images/bookberry-logo.svg') }}" alt="BookBerry" class="h-8 w-8" />
	                    <span>
	                        Book<span style="color: #CBA0D9;">Berry</span>
	                    </span>
	                </a>
	                <p class="text-xs text-purple-300 mt-0.5">Admin Panel</p>
	            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-3 space-y-1">
                <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest px-3 py-2 mt-2">
                    Main
                </p>

                <a href="{{ route('admin.dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products') }}"
                    class="sidebar-link {{ request()->routeIs('admin.products') ? 'active' : '' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Products
                </a>

                <a href="{{ route('admin.orders') }}"
                    class="sidebar-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Orders
                    @php $pendingCount = \App\Models\Order::where('status','pending')->count(); @endphp
                    @if($pendingCount > 0)
                        <span style="background: #E94E77;"
                            class="ml-auto text-white text-xs rounded-full px-2 py-0.5 font-bold">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('admin.customers') }}"
                    class="sidebar-link {{ request()->routeIs('admin.customers') ? 'active' : '' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    Customers
                </a>

                <p class="text-xs font-semibold text-purple-400 uppercase tracking-widest px-3 py-2 mt-4">
                    Store
                </p>

                <a href="{{ route('home') }}" target="_blank"
                    class="sidebar-link">
                    <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                    View Storefront
                </a>
            </nav>

            {{-- Admin user info --}}
            <div class="p-4 border-t border-white/10">
                <div class="flex items-center gap-3">
                    <div style="background: #CBA0D9;"
                        class="w-8 h-8 rounded-full flex items-center justify-center
                            text-purple-900 text-sm font-bold shrink-0">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-purple-300 truncate">Administrator</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit"
                        class="w-full text-left text-xs text-purple-300 hover:text-white transition
                            flex items-center gap-2 px-2 py-1.5 rounded-lg hover:bg-white/10">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="flex-1 flex flex-col min-w-0" style="margin-left: var(--sidebar-w);">

            {{-- Top bar --}}
            <header class="bg-white border-b border-gray-100 px-6 py-3 flex items-center gap-4 sticky top-0 z-10">
                {{-- Mobile hamburger --}}
                <button @click="sidebarOpen = !sidebarOpen"
                    class="lg:hidden text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>

                {{-- Page title slot --}}
                <div class="flex-1">
                    <p class="text-sm font-semibold text-gray-700">
                        {{ $pageTitle ?? 'Admin Panel' }}
                    </p>
                </div>

                {{-- Right actions --}}
                <div class="flex items-center gap-3">
                    {{-- Pending orders badge --}}
                    @if($pendingCount > 0)
                        <a href="{{ route('admin.orders') }}"
                            class="flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 rounded-xl"
                            style="background: #FEF2F2; color: #DC2626;">
                            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse inline-block"></span>
                            {{ $pendingCount }} pending
                        </a>
                    @endif

                    <span class="text-sm text-gray-500">
                        {{ now()->format('M d, Y') }}
                    </span>
                </div>
            </header>

            {{-- Page content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>

        {{-- Toast --}}
        <div
            x-data="{ show: false, message: '' }"
            @notify.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-end="opacity-0"
            style="background: #5A2A6E;"
            class="fixed bottom-6 right-6 z-50 text-white px-5 py-3 rounded-2xl shadow-xl text-sm font-medium flex items-center gap-2"
        >
            <svg class="w-4 h-4 text-green-300 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span x-text="message"></span>
        </div>
    </div> {{-- ✅ END ROOT WRAPPER --}}
    @livewireScripts
</body>
</html>
