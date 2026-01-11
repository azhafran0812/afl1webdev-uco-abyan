@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-300">
        <div class="md:flex">

            {{-- Bagian Kiri: Gambar Produk --}}
            <div class="md:flex-shrink-0 md:w-1/2 bg-gray-100 dark:bg-gray-700 flex items-center justify-center relative">
                @if($product->image)
                    <img class="h-96 w-full object-cover md:h-full md:w-full transition-opacity duration-300 hover:opacity-95"
                         src="{{ asset('storage/' . $product->image) }}"
                         alt="{{ $product->name }}">
                @else
                    <div class="h-96 w-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-500">
                        <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span class="text-sm font-medium">Tidak ada gambar</span>
                    </div>
                @endif
            </div>

            {{-- Bagian Kanan: Detail Informasi --}}
            <div class="p-8 md:w-1/2 flex flex-col justify-center">

                {{-- Kategori --}}
                <div class="mb-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-black text-white dark:bg-white dark:text-black">
                        {{ $product->category->name ?? 'Uncategorized' }}
                    </span>
                </div>

                {{-- Judul Produk --}}
                <h1 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ $product->name }}
                </h1>

                {{-- Harga --}}
                <p class="mt-4 text-3xl font-bold text-gray-900 dark:text-gray-100">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </p>

                {{-- Deskripsi --}}
                <div class="mt-6 prose prose-sm text-gray-500 dark:text-gray-300">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                    <div class="flex gap-4">
                        {{-- Tombol Tambah ke Keranjang (Untuk Customer) --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-black dark:bg-white text-white dark:text-black font-bold py-3 px-6 rounded-xl hover:opacity-90 dark:hover:opacity-90 transition transform hover:-translate-y-0.5 shadow-lg flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                Tambah ke Keranjang
                            </button>
                        </form>

                        {{-- Tombol Wishlist --}}
                        <form action="{{ route('wishlist.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="p-3 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/30 text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- AREA ADMIN: Edit & Delete --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="mt-6 pt-6 border-t border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Admin Control</p>
                        <div class="flex gap-3">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('products.edit', $product->id) }}" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2.5 px-4 rounded-lg text-center transition">
                                Edit Produk
                            </a>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus produk ini selamanya?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-lg transition">
                                    Hapus Produk
                                </button>
                            </form>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>
@endsection
