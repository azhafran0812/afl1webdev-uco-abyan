@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
    <div class="relative bg-white overflow-hidden rounded-xl shadow-sm border border-gray-100 mb-12">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">Temukan Produk</span>
                            <span class="block text-indigo-600 xl:inline">Terbaik Anda Disini</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Kami menyediakan berbagai macam produk berkualitas mulai dari Elektronik, Pakaian, hingga Makanan dengan harga terjangkau.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('products') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10 transition duration-300">
                                    Belanja Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full" src="https://images.unsplash.com/photo-1556740758-90de374c12ad?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Shopping Illustration">
        </div>
    </div>

    <div class="mb-12">
        <div class="text-center mb-10">
            <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Kategori</h2>
            <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Pilihan Kategori Unggulan
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <a href="{{ route('products', ['search' => 'Elektronik']) }}" class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer border-t-4 border-indigo-500">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Elektronik</h3>
                    <p class="mt-2 text-base text-gray-500">Gadget terbaru dan aksesoris.</p>
                </div>
            </a>

            <a href="{{ route('products', ['search' => 'Pakaian']) }}" class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer border-t-4 border-pink-500">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Fashion</h3>
                    <p class="mt-2 text-base text-gray-500">Pakaian pria dan wanita kekinian.</p>
                </div>
            </a>

            <a href="{{ route('products', ['search' => 'Makanan']) }}" class="block bg-white p-6 rounded-lg shadow hover:shadow-lg transition transform hover:-translate-y-1 cursor-pointer border-t-4 border-yellow-500">
                <div class="text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Makanan</h3>
                    <p class="mt-2 text-base text-gray-500">Makanan ringan dan berat.</p>
                </div>
            </a>
        </div>
    </div>
@endsection
