<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Toko Online') - Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="h-full flex flex-col">

    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">

                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-black tracking-tighter text-gray-900 flex items-center gap-2">
                            <svg class="w-8 h-8 text-black" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.75l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
                            TOKO<span class="text-gray-400">APP</span>
                        </a>
                    </div>

                    <div class="hidden sm:ml-8 sm:flex sm:space-x-8">
                        <a href="{{ route('home') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-black text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Home
                        </a>
                        <a href="{{ route('products') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium {{ request()->routeIs('products*') ? 'border-black text-gray-900' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' }}">
                            Produk
                        </a>
                    </div>
                </div>

                <div class="hidden sm:ml-6 sm:flex sm:items-center sm:space-x-4">

                    @guest
                        {{-- Tombol Login (Minimalis) --}}
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-gray-900 font-medium text-sm transition">
                            Masuk
                        </a>

                        {{-- Tombol Register (Solid Black) --}}
                        <a href="{{ route('register') }}" class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            Daftar Sekarang
                        </a>
                    @else
                        {{-- Icon Keranjang --}}
                        <a href="{{ route('cart.index') }}" class="group relative p-2 text-gray-400 hover:text-gray-500">
                            <span class="sr-only">Keranjang</span>
                            <svg class="h-6 w-6 group-hover:text-black transition" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            {{-- Badge Count (Opsional, jika ada logic count) --}}
                            {{-- <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-600 rounded-full">3</span> --}}
                        </a>

                        {{-- Dropdown User --}}
                        <div class="ml-3 relative group">
                            <button type="button" class="bg-white rounded-full flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black items-center gap-2 border border-gray-200 pl-3 pr-1 py-1 hover:bg-gray-50 transition">
                                <span class="font-bold text-gray-700">{{ Auth::user()->name }}</span>
                                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                </div>
                            </button>

                            {{-- Dropdown Content (Hover or Click logic handled by Alpine usually, here using CSS group-hover for simplicity or you can use standard toggle) --}}
                            <div class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 hidden group-hover:block transition z-50">
                                <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Riwayat Belanja</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-bold">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <div class="-mr-2 flex items-center sm:hidden">
                    <button type="button" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')" class="bg-white inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                        <span class="sr-only">Open main menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="hidden sm:hidden bg-white border-t border-gray-100" id="mobile-menu">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="bg-gray-50 border-black text-black block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Home</a>
                <a href="{{ route('products') }}" class="border-transparent text-gray-600 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-800 block pl-3 pr-4 py-2 border-l-4 text-base font-medium">Produk</a>
            </div>
            <div class="pt-4 pb-4 border-t border-gray-200">
                @guest
                    <div class="space-y-1">
                        <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-50">Masuk</a>
                        <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-bold text-black hover:bg-gray-50">Daftar Akun</a>
                    </div>
                @else
                    <div class="flex items-center px-4">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                <span class="font-bold text-gray-600">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                            <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                        </div>
                        <a href="{{ route('cart.index') }}" class="ml-auto flex-shrink-0 p-1 text-gray-400 hover:text-gray-500">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        </a>
                    </div>
                    <div class="mt-3 space-y-1">
                        <a href="{{ route('orders.history') }}" class="block px-4 py-2 text-base font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100">Riwayat Belanja</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-base font-medium text-red-600 hover:text-red-800 hover:bg-gray-100">Sign out</button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
            <div class="mt-8 md:mt-0 md:order-1">
                <p class="text-center text-base text-gray-400">
                    &copy; {{ date('Y') }} Toko Aplikasi Laravel. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

</body>
</html>
