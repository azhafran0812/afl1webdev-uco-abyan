@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="space-y-6">

        {{-- Header & Tombol Tambah --}}
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white/50 backdrop-blur-sm p-4 rounded-lg">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Produk</h1>
                <p class="text-gray-500 mt-1 text-sm">Kelola katalog produk Anda dengan mudah.</p>
            </div>

            <div class="flex gap-2">
                {{-- Tombol Tambah Kategori (Sekarang Aktif) --}}
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold rounded-lg shadow-sm transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                     </svg>
                     Kategori
                </a>

                <a href="{{ route('products.create') }}"
                   class="inline-flex items-center px-6 py-3 bg-black hover:bg-gray-800 text-white font-bold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1 focus:ring-4 focus:ring-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Produk
                </a>
            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm flex justify-between items-center" role="alert">
                <div>
                    <p class="font-bold">Sukses!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Form Filter & Pencarian --}}
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
            <form action="{{ route('products') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                    {{-- Search --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Nama atau deskripsi..."
                                   class="w-full pl-9 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm transition">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Kategori (Dinamis) --}}
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Kategori</label>
                        <select name="category_id" class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm bg-white cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Range Harga --}}
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Min Harga</label>
                        <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="0"
                               class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Max Harga</label>
                        <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="Max"
                               class="w-full py-2 px-3 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm">
                    </div>

                    {{-- Sort & Tombol Submit --}}
                    <div class="md:col-span-2 flex gap-2">
                        <select name="sort" class="w-full py-2 px-2 border border-gray-300 rounded-lg focus:ring-black focus:border-black text-sm bg-white cursor-pointer" title="Urutkan">
                            <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Harga</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nama</option>
                        </select>
                        <input type="hidden" name="direction" value="{{ request('sort') == 'price' ? 'asc' : 'desc' }}">

                        <button type="submit" class="bg-gray-900 hover:bg-black text-white font-bold py-2 px-4 rounded-lg shadow transition">
                            Go
                        </button>
                    </div>
                </div>

                @if(request()->hasAny(['search', 'min_price', 'max_price', 'sort', 'category_id']))
                    <div class="mt-3 text-right">
                        <a href="{{ route('products') }}" class="text-xs text-red-600 hover:text-red-800 font-bold hover:underline">
                            Hapus Filter &times;
                        </a>
                    </div>
                @endif
            </form>
        </div>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($products as $item)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col h-full group">
                    <div class="h-48 bg-gray-100 overflow-hidden relative">
                         <img src="https://source.unsplash.com/random/400x300?sig={{ $item->id }}" alt="{{ $item->name }}"
                              class="w-full h-full object-cover transition duration-700 group-hover:scale-110">

                         @if($item->category)
                            <span class="absolute top-2 right-2 bg-white/90 backdrop-blur text-gray-800 text-[10px] font-bold px-2 py-1 rounded shadow-sm border border-gray-200 uppercase tracking-wider">
                                {{ $item->category->name }}
                            </span>
                         @endif
                    </div>

                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-2">
                            @if($item->category)
                                <span class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wide border text-gray-600 bg-gray-100 border-gray-200">
                                    {{ $item->category->name }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs italic">Tanpa Kategori</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-1 leading-snug group-hover:text-blue-600 transition">
                            {{ $item->name }}
                        </h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-1">
                            {{ $item->description }}
                        </p>

                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                            <span class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </span>
                            <a href="{{ route('products.show', $item->id) }}" class="text-sm font-semibold text-blue-600 hover:text-blue-800 underline">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full flex flex-col items-center justify-center py-16 text-center bg-gray-50 border-2 border-dashed border-gray-300 rounded-xl">
                    <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900">Tidak ada produk ditemukan</h3>
                    <p class="text-gray-500 mt-1">Coba sesuaikan filter pencarian Anda atau tambahkan produk baru.</p>
                    <a href="{{ route('products.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-black text-white rounded hover:bg-gray-800 transition">
                        + Buat Produk
                    </a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
@endsection
