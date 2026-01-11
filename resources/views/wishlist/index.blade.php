@extends('layouts.app')

@section('title', 'Wishlist Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Wishlist Saya</h2>

    @if($wishlists->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-8 text-center">
            <p class="text-gray-500 dark:text-gray-400 mb-4">Belum ada produk di wishlist Anda.</p>
            <a href="{{ route('products') }}" class="inline-block bg-black dark:bg-white text-white dark:text-black px-6 py-2 rounded-md font-bold hover:opacity-80 transition">Jelajahi Produk</a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $item)
                <div class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition">
                    {{-- Gambar --}}
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-200 dark:bg-gray-700 lg:aspect-none group-hover:opacity-75 lg:h-64">
                         {{-- Ganti src dengan path gambar produk Anda --}}
                        <img src="https://placehold.co/400" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                    </div>

                    <div class="p-4">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">
                            <a href="{{ route('products.show', $item->product->id) }}">
                                <span aria-hidden="true" class="absolute inset-0"></span>
                                {{ $item->product->name }}
                            </a>
                        </h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                    </div>

                    {{-- Tombol Hapus dari Wishlist --}}
                    <form action="{{ route('wishlist.toggle') }}" method="POST" class="absolute top-2 right-2 z-10">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <button type="submit" class="p-2 bg-white dark:bg-gray-700 rounded-full shadow hover:bg-red-50 dark:hover:bg-red-900/30 text-red-500 transition">
                            <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
