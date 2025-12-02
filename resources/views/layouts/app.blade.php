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
