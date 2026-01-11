@extends('layouts.app')

@section('title', 'TaleSpindle Studio')

@section('content')
<div class="bg-white dark:bg-gray-900 transition-colors duration-300">

    {{-- HERO SECTION --}}
    <div class="relative overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 min-h-[80vh] flex flex-col justify-center">

                {{-- Dekorasi Background Miring (Opsional) --}}
                <svg class="hidden lg:block absolute right-0 inset-y-0 h-full w-48 text-white dark:text-gray-900 transform translate-x-1/2" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none" aria-hidden="true">
                    <polygon points="50,0 100,0 50,100 0,100" />
                </svg>

                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl font-serif">
                            <span class="block xl:inline">Weave Your Story</span>
                            <span class="block text-indigo-600 dark:text-indigo-400 xl:inline">with TaleSpindle.</span>
                        </h1>
                        <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Temukan koleksi eksklusif yang dirancang untuk menceritakan kisah Anda. Estetika modern bertemu dengan kenyamanan abadi di TaleSpindle Studio.
                        </p>
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('products') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-black dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 md:py-4 md:text-lg transition">
                                    Belanja Sekarang
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        {{-- HERO IMAGE --}}
        <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            {{--
                Ganti URL src di bawah ini dengan gambar pilihan Anda.
                Bisa menggunakan URL internet atau asset('images/namafoto.jpg')
            --}}
            <img class="h-56 w-full object-cover sm:h-72 md:h-96 lg:w-full lg:h-full transition duration-500 hover:scale-105"
                 src="{{ asset('images/hero-bg.png') }}"
                 alt="TaleSpindle Studio Collection">
        </div>
    </div>

    {{-- NEW ARRIVALS SECTION --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24">
        <div class="text-center mb-12">
            <h2 class="text-base font-semibold text-indigo-600 dark:text-indigo-400 tracking-wide uppercase">Koleksi Terbaru</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 dark:text-white sm:text-5xl sm:tracking-tight lg:text-4xl font-serif">
                New Arrivals
            </p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500 dark:text-gray-400">
                Pilihan terbaik minggu ini, dikurasi khusus untuk Anda.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-y-10 sm:grid-cols-2 gap-x-6 lg:grid-cols-4 xl:gap-x-8">
            @foreach($products as $product)
                <div class="group relative">
                    <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none shadow-sm hover:shadow-lg transition-all">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-center object-cover lg:w-full lg:h-full">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800 text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="mt-4 flex justify-between">
                        <div>
                            <h3 class="text-sm text-gray-700 dark:text-gray-200 font-bold">
                                <a href="{{ route('products.show', $product->id) }}">
                                    <span aria-hidden="true" class="absolute inset-0"></span>
                                    {{ $product->name }}
                                </a>
                            </h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ $product->category->name ?? 'Uncategorized' }}</p>
                        </div>
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('products') }}" class="inline-block border border-black dark:border-white text-black dark:text-white px-8 py-3 font-bold hover:bg-black hover:text-white dark:hover:bg-white dark:hover:text-black transition uppercase tracking-widest text-sm">
                Lihat Semua Produk
            </a>
        </div>
    </div>

    {{-- ABOUT SECTION (Banner Bawah) --}}
    <div class="bg-gray-50 dark:bg-gray-800 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white sm:text-4xl font-serif mb-4">
                The TaleSpindle Philosophy
            </h2>
            <p class="max-w-2xl text-lg text-gray-500 dark:text-gray-300 mb-8">
                Kami percaya bahwa setiap produk memiliki cerita. TaleSpindle Studio didirikan untuk merajut kualitas, estetika, dan keberlanjutan menjadi satu kesatuan yang harmonis.
            </p>
        </div>
    </div>

</div>
@endsection
