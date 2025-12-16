<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Toko Online')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <span class="font-bold text-xl text-indigo-600 tracking-tight">MY STORE</span>
                    </a>
                </div>

                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="{{ request()->routeIs('home') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-indigo-600' }} px-1 py-2 text-sm font-medium transition duration-150 ease-in-out h-full flex items-center">
                        Home
                    </a>

                    <a href="{{ route('products') }}"
                        class="{{ request()->routeIs('products*') ? 'text-indigo-600 border-b-2 border-indigo-600' : 'text-gray-500 hover:text-indigo-600' }} px-1 py-2 text-sm font-medium transition duration-150 ease-in-out h-full flex items-center">
                        Products
                    </a>
                </div>
            </div>
        </div>
        <ul class="navbar-nav ms-auto">
            @guest
                {{-- Jika Belum Login --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
            @else
                {{-- Jika Sudah Login --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart.index') }}">
                        Keranjang <span class="badge bg-danger">Cart</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        Halo, {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('orders.history') }}">Riwayat Belanja</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </nav>

    <main class="flex-grow py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} My Store. All rights reserved.
        </div>
    </footer>

</body>

</html>
