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

                {{-- Harga & Stok --}}
                <div class="mt-4 flex items-center justify-between">
                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </p>

                    {{-- Badge Stok (FITUR BARU) --}}
                    @if($product->stock > 0)
                        <span class="px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full dark:bg-green-900 dark:text-green-300">
                            Stok: {{ $product->stock }}
                        </span>
                    @else
                        <span class="px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full dark:bg-red-900 dark:text-red-300">
                            Stok Habis
                        </span>
                    @endif
                </div>

                {{-- Deskripsi --}}
                <div class="mt-6 prose prose-sm text-gray-500 dark:text-gray-300">
                    <p>{{ $product->description }}</p>
                </div>

                <div class="mt-8 border-t border-gray-100 dark:border-gray-700 pt-8">
                    <div class="flex gap-4">
                        {{-- Tombol Tambah ke Keranjang (Logika Stok) --}}
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex-1">
                            @csrf

                            @if($product->stock > 0)
                                <button type="submit" class="w-full bg-black dark:bg-white text-white dark:text-black font-bold py-3 px-6 rounded-xl hover:opacity-90 dark:hover:opacity-90 transition transform hover:-translate-y-0.5 shadow-lg flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    Tambah ke Keranjang
                                </button>
                            @else
                                <button type="button" disabled class="w-full bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-bold py-3 px-6 rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" /></svg>
                                    Stok Habis
                                </button>
                            @endif
                        </form>

                        {{-- Tombol Wishlist --}}
                        <form action="{{ route('wishlist.toggle') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <button type="submit" class="p-3 bg-gray-100 dark:bg-gray-700 rounded-xl hover:bg-red-50 dark:hover:bg-red-900/30 text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition" title="Tambah ke Wishlist">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" /></svg>
                            </button>
                        </form>
                    </div>
                </div>

                {{-- SECTION REVIEW & RATING --}}
                <div class="mt-12 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-8">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Ulasan Pelanggan</h2>

                    {{-- Form Tambah Review (Hanya jika Login) --}}
                    @auth
                        <form action="{{ route('reviews.store') }}" method="POST" class="mb-10 bg-gray-50 dark:bg-gray-700/50 p-6 rounded-xl border border-gray-100 dark:border-gray-600">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Tulis Ulasan Anda</h3>

                            {{-- Rating Bintang --}}
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Rating</label>
                                <div class="flex flex-row-reverse justify-end gap-1">
                                    {{-- Trik CSS sederhana untuk rating bintang (input radio) --}}
                                    @for($i = 5; $i >= 1; $i--)
                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="peer hidden" required />
                                        <label for="star{{ $i }}" class="cursor-pointer text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 transition">
                                            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </label>
                                    @endfor
                                </div>
                            </div>

                            {{-- Komentar --}}
                            <div class="mb-4">
                                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Komentar</label>
                                <textarea name="comment" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white shadow-sm focus:border-black focus:ring-black transition" placeholder="Bagaimana pengalaman Anda dengan produk ini?"></textarea>
                            </div>

                            <button type="submit" class="bg-black dark:bg-white text-white dark:text-black font-bold py-2 px-6 rounded-lg hover:opacity-80 transition">
                                Kirim Ulasan
                            </button>
                        </form>
                    @else
                        <div class="mb-8 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg">
                            Silakan <a href="{{ route('login') }}" class="font-bold underline">Login</a> untuk memberikan ulasan.
                        </div>
                    @endauth

                    {{-- Daftar Review --}}
                    <div class="space-y-6">
                        @forelse($product->reviews as $review)
                            <div class="pb-6 border-b border-gray-100 dark:border-gray-700 last:border-0">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center font-bold text-gray-600 dark:text-gray-300">
                                            {{ substr($review->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-900 dark:text-white">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex text-yellow-400">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $review->rating)
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300 dark:text-gray-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-600 dark:text-gray-300 leading-relaxed">{{ $review->comment }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-center py-4">Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
                        @endforelse
                    </div>
                </div>

                {{-- FITUR SHARE SOCIAL MEDIA --}}
                <div class="mt-8">
                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-4">Bagikan Produk Ini:</h3>
                    <div class="flex space-x-4">
                        {{-- WhatsApp --}}
                        <a href="https://wa.me/?text=Cek produk keren ini: {{ $product->name }} - {{ route('products.show', $product->id) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 hover:bg-green-600 text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                        {{-- Twitter / X --}}
                        <a href="https://twitter.com/intent/tweet?text=Cek produk ini: {{ $product->name }}&url={{ route('products.show', $product->id) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-black text-white hover:bg-gray-800 transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        {{-- Facebook --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('products.show', $product->id) }}" target="_blank" class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 hover:bg-blue-700 text-white transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.791-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    </div>
                </div>

                {{-- AREA ADMIN: Edit & Delete --}}
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <div class="mt-6 pt-6 border-t border-dashed border-gray-200 dark:border-gray-700">
                        <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">Admin Control</p>
                        <div class="flex gap-3">
                            <a href="{{ route('products.edit', $product->id) }}" class="flex-1 bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-2.5 px-4 rounded-lg text-center transition">
                                Edit Produk
                            </a>
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
