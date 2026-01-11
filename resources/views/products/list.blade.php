@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="space-y-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header & Tombol Tambah (Hanya Admin) --}}
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm p-4 rounded-xl border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Daftar Produk</h1>
                <p class="text-gray-500 dark:text-gray-400 mt-1 text-sm">Kelola katalog produk Anda dengan mudah.</p>
            </div>

            {{-- Cek Role Admin --}}
            @if(Auth::check() && Auth::user()->role === 'admin')
                <div class="flex gap-2">
                    {{-- Tombol Tambah Kategori --}}
                    <a href="{{ route('categories.create') }}"
                        class="inline-flex items-center px-4 py-3 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 font-bold rounded-lg shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Kategori
                    </a>

                    {{-- Tombol Tambah Produk --}}
                    <a href="{{ route('products.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-black dark:bg-white hover:bg-gray-800 dark:hover:bg-gray-200 text-white dark:text-black font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Tambah Produk
                    </a>
                </div>
            @endif
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div class="bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded shadow-sm flex justify-between items-center transition-colors" role="alert">
                <div>
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Form Filter & Pencarian --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 transition-colors duration-300">
            <form action="{{ route('products') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    {{-- Search --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Nama atau deskripsi..."
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition placeholder-gray-400 dark:placeholder-gray-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Kategori --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Kategori</label>
                        <select name="category_id"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer transition">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Range Harga --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Min Harga</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-1">Max Harga</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                            class="w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white transition">
                    </div>

                    {{-- Sort & Tombol Submit --}}
                    <div class="md:col-span-2 flex gap-2">
                        <select name="sort"
                            class="w-full py-2 px-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-black dark:focus:ring-white focus:border-black dark:focus:border-white text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white cursor-pointer transition"
                            title="Urutkan">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                        </select>
                        <input type="hidden" name="direction" value="{{ request('sort') == 'price' ? 'asc' : 'desc' }}">

                        <button type="submit"
                            class="bg-gray-900 dark:bg-white hover:bg-black dark:hover:bg-gray-200 text-white dark:text-black font-bold py-2 px-4 rounded-lg shadow transition">
                            Go
                        </button>
                    </div>
                </div>

                @if (request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'category_id']))
                    <div class="mt-3 text-right">
                        <a href="{{ route('products') }}"
                            class="text-xs text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 font-bold hover:underline">
                            Hapus Filter &times;
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $item)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden hover:shadow-xl dark:hover:shadow-gray-900/50 transition-all duration-300 flex flex-col h-full group">

                    {{-- Gambar Produk --}}
                    <div class="h-48 bg-gray-100 dark:bg-gray-700 overflow-hidden relative">
                        <a href="{{ route('products.show', $item->id) }}">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                    alt="{{ $item->name }}"
                                    class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                            @else
                                {{-- Placeholder jika tidak ada gambar --}}
                                <div class="w-full h-full flex items-center justify-center text-gray-400 dark:text-gray-500">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </a>

                        {{-- Label Kategori --}}
                        @if ($item->category)
                            <span class="absolute top-2 right-2 bg-white/90 dark:bg-gray-800/90 backdrop-blur text-gray-800 dark:text-white text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-gray-200 dark:border-gray-600 uppercase tracking-wider">
                                {{ $item->category->name }}
                            </span>
                        @endif
                    </div>

                    {{-- Konten Text --}}
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-2">
                            @if ($item->category)
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 border-gray-200 dark:border-gray-600">
                                    {{ $item->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Tanpa Kategori</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 leading-snug group-hover:text-blue-600 dark:group-hover:text-blue-400 transition">
                            <a href="{{ route('products.show', $item->id) }}">
                                {{ $item->name }}
                            </a>
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-4 line-clamp-2 flex-1">
                            {{ $item->description }}
                        </p>

                        {{-- Harga & Tombol --}}
                        <div class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>

                            <div class="flex items-center gap-2">
                                @auth
                                    {{-- Tombol Wishlist (NEW) --}}
                                    <form action="{{ route('wishlist.toggle') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <button type="submit"
                                            class="p-2 bg-white dark:bg-gray-700 text-gray-400 hover:text-red-500 dark:hover:text-red-400 border border-gray-200 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition shadow-sm"
                                            title="Simpan ke Wishlist">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                            </svg>
                                        </button>
                                    </form>

                                    {{-- Tombol Add to Cart --}}
                                    <form action="{{ route('cart.add', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="p-2 bg-black dark:bg-white text-white dark:text-black rounded-lg hover:bg-gray-800 dark:hover:bg-gray-200 transition shadow-sm"
                                            title="Tambah ke Keranjang">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                        Login
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl transition-colors">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">Coba sesuaikan filter pencarian Anda atau tambahkan produk baru.</p>

                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <a href="{{ route('products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-black dark:bg-white text-white dark:text-black rounded hover:bg-gray-800 dark:hover:bg-gray-200 transition font-bold">
                            + Buat Produk
                        </a>
                    @endif
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
@endsection
