<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full"
      x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Toko Online') - Laravel</title>

    {{-- Alpine.js (Wajib untuk Logic Dropdown & Dark Mode) --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full flex flex-col bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

    <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 sticky top-0 z-50 transition-colors duration-300" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex">
                    {{-- Logo --}}
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-gray-900 dark:text-white flex items-center gap-2 transition-colors font-serif">
                        {{-- Anda bisa ganti SVG logo jika mau, atau biarkan --}}
                        <svg class="w-8 h-8 text-black dark:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.75l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                        TaleSpindle<span class="text-indigo-600 dark:text-indigo-400">Studio</span>
                        </a>
                    </div>

                    {{-- Desktop Nav Links --}}
                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'border-black dark:border-white text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            Home
                        </a>
                        <a href="{{ route('products') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-colors {{ request()->routeIs('products*') ? 'border-black dark:border-white text-gray-900 dark:text-white' : 'border-transparent text-gray-500 dark:text-gray-400 hover:border-gray-300 hover:text-gray-700 dark:hover:text-gray-200' }}">
                            Produk
                        </a>
                        {{-- MENU ADMIN (Hanya muncul jika Role = Admin) --}}
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-bold leading-5 text-red-600 hover:text-red-800 hover:border-red-600 transition duration-150 ease-in-out {{ request()->routeIs('admin*') ? 'border-red-600 text-red-800' : '' }}">
                                        Admin Panel
                                    </a>
                                @endif
                            @endauth
                    </div>
                </div>

                {{-- Desktop Right Section --}}
                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">

                    {{-- Dark Mode Toggle Button --}}
                    <button @click="darkMode = !darkMode" type="button" class="p-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-full focus:outline-none transition-colors">
                        <span class="sr-only">Toggle Dark Mode</span>
                        <svg x-show="!darkMode" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        <svg x-show="darkMode" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    </button>

                    @guest
                        <a href="{{ route('login') }}" class="text-gray-500 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white font-medium text-sm transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-black dark:hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @else
                        {{-- Wishlist Icon (New Feature) --}}
                        <a href="{{ route('wishlist.index') }}" class="group p-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors relative">
                            <span class="sr-only">Wishlist</span>
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </a>

                        {{-- Cart Icon --}}
                        <a href="{{ route('cart.index') }}" class="group relative p-2 text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 transition-colors">
                            <span class="sr-only">Keranjang</span>
                            <svg class="h-6 w-6 group-hover:text-black dark:group-hover:text-white transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </a>

                        {{-- Dropdown User (Managed by Alpine x-data) --}}
                        <div class="ml-3 relative" x-data="{ open: false }">
                            <button @click="open = !open" type="button" class="bg-white dark:bg-gray-700 rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black dark:focus:ring-white items-center gap-2 border border-gray-200 dark:border-gray-600 pl-3 pr-1 py-1 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                <span class="font-bold text-gray-700 dark:text-gray-200">{{ Auth::user()->name }}</span>
                                <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-500 dark:text-gray-300">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                            </button>

                            {{-- Dropdown Menu --}}
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 z-50"
                                 style="display: none;">

                                {{-- Link Profile Edit --}}
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Edit Profil
                                </a>

                                <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Riwayat Belanja
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 font-bold">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- Mobile Menu Button --}}
                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="bg-white dark:bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black dark:focus:ring-white transition-colors">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Content --}}
        <div x-show="mobileMenuOpen" class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 transition-colors" id="mobile-menu" style="display: none;">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors {{ request()->routeIs('home') ? 'bg-gray-50 dark:bg-gray-700 border-black dark:border-white text-black dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-800 dark:hover:text-gray-200' }}">Home</a>
                <a href="{{ route('products') }}" class="block pl-3 pr-4 py-2 border-l-4 text-base font-medium transition-colors {{ request()->routeIs('products*') ? 'bg-gray-50 dark:bg-gray-700 border-black dark:border-white text-black dark:text-white' : 'border-transparent text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 hover:text-gray-800 dark:hover:text-gray-200' }}">Produk</a>
            </div>

            <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-700">
                {{-- Mobile Dark Mode Toggle --}}
                <div class="flex items-center px-4 mb-4">
                     <button @click="darkMode = !darkMode" class="flex items-center w-full text-left text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
                        <div class="mr-3 p-1 rounded-full bg-gray-100 dark:bg-gray-700">
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </div>
                        <span x-text="darkMode ? 'Mode Terang' : 'Mode Gelap'"></span>
                    </button>
                </div>

                @guest
                    <div class="space-y-1">
                        <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Masuk</a>
                        <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700">Daftar Akun</a>
                    </div>
                @else
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <span class="font-bold text-gray-600 dark:text-gray-300">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800 dark:text-white">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ Auth::user()->email }}</div>
                        </div>
                    </div>

                    <div class="mt-3 space-y-1">
                        {{-- Mobile Wishlist --}}
                        <a href="{{ route('wishlist.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                             Wishlist Saya
                        </a>
                        {{-- Mobile Cart --}}
                        <a href="{{ route('cart.index') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                             Keranjang Belanja
                        </a>
                        {{-- Mobile Profile Edit --}}
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                             Edit Profil
                        </a>
                        <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-base font-medium text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700">
                            Riwayat Belanja
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 hover:bg-gray-100 dark:hover:bg-gray-700">Sign out</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 mt-auto transition-colors duration-300">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex space-x-6 md:order-2">
                    <a href="{{ route('about') }}" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        Tentang Kami
                    </a>
                    <a href="{{ route('faq') }}" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        FAQ
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="#" class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300">
                        Instagram
                    </a>
                </div>
                <div class="mt-8 md:mt-0 md:order-1">
                    <p class="text-center text-base text-gray-400 dark:text-gray-500">
                        &copy; {{ date('Y') }} TaleSpindle Studio. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
