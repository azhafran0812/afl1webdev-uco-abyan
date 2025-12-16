@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

        {{-- Kolom Kiri: Gambar --}}
        <div class="relative bg-gray-100 rounded-2xl overflow-hidden shadow-sm aspect-[4/3] group">
            <img src="https://source.unsplash.com/random/800x600?sig={{ $product->id }}"
                 alt="{{ $product->name }}"
                 class="w-full h-full object-cover transition duration-500 group-hover:scale-105">

            @if($product->category)
                <span class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider text-gray-800 shadow-sm">
                    {{ $product->category->name }}
                </span>
            @endif
        </div>

        {{-- Kolom Kanan: Detail --}}
        <div class="flex flex-col h-full">
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight mb-4">
                {{ $product->name }}
            </h1>

            <div class="flex items-center gap-4 mb-6">
                <span class="text-3xl font-bold text-gray-900">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
                {{-- Status Stok (Opsional) --}}
                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    Tersedia
                </span>
            </div>

            <div class="prose prose-sm text-gray-500 mb-8 leading-relaxed">
                <p>{{ $product->description }}</p>
            </div>

            <div class="mt-auto border-t border-gray-100 pt-8">
                @auth
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex gap-4">
                        @csrf
                        {{-- Tombol Keranjang --}}
                        <button type="submit"
                            class="flex-1 bg-black text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:bg-gray-800 hover:shadow-xl transition-all transform hover:-translate-y-1 flex justify-center items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            Tambah ke Keranjang
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block w-full text-center bg-gray-200 text-gray-800 font-bold py-4 rounded-xl hover:bg-gray-300 transition">
                        Login untuk Membeli
                    </a>
                @endauth

                {{-- Tombol Edit (Hanya jika admin/pemilik) --}}
                <div class="mt-4 flex gap-3 text-sm">
                    <a href="{{ route('products') }}" class="text-gray-500 hover:text-black underline">
                        &larr; Kembali ke Katalog
                    </a>
                    <span class="text-gray-300">|</span>
                    <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-700 font-medium">
                        Edit Produk
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
