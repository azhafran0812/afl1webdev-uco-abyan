@extends('layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Kelola Kategori</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Tambah kategori baru atau hapus kategori yang sudah tidak digunakan.
            </p>
        </div>
        <a href="{{ route('products') }}" class="text-sm font-bold text-gray-600 dark:text-gray-400 hover:text-black dark:hover:text-white transition">
            &larr; Kembali ke Produk
        </a>
    </div>

    {{-- Pesan Sukses / Error --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 rounded shadow-sm">
            <p class="font-bold">Berhasil!</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 rounded shadow-sm">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: Form Tambah --}}
        <div class="md:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Buat Kategori Baru</h2>

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                            Nama Kategori
                        </label>
                        <input type="text" name="name" id="name"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-black focus:ring-black dark:bg-gray-700 dark:text-white sm:text-sm py-2 px-3"
                               placeholder="Contoh: Elektronik" required>
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-black dark:bg-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition">
                        Simpan Kategori
                    </button>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN: List Kategori Existing --}}
        <div class="md:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white">Daftar Kategori Saat Ini</h2>
                </div>

                @if($categories->isEmpty())
                    <div class="p-8 text-center text-gray-500 dark:text-gray-400">
                        Belum ada kategori yang dibuat.
                    </div>
                @else
                    <ul class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($categories as $category)
                            <li class="px-6 py-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                <span class="text-gray-700 dark:text-gray-200 font-medium">
                                    {{ $category->name }}
                                </span>

                                <div class="flex items-center gap-4">
                                    <span class="text-xs text-gray-400">
                                        {{ $category->products()->count() }} Produk
                                    </span>

                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-bold text-sm transition" title="Hapus">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
