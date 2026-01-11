@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk Baru')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
            {{ isset($product) ? 'Edit Produk' : 'Buat Produk Baru' }}
        </h1>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            {{ isset($product) ? 'Perbarui informasi produk di bawah ini.' : 'Isi form di bawah untuk menambahkan produk ke katalog.' }}
        </p>
    </div>

    {{-- Form Container --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 sm:p-8 transition-colors duration-300">

        {{-- PENTING: enctype="multipart/form-data" wajib ada untuk upload file --}}
        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            {{-- Catatan: Route update menggunakan POST di web.php, jadi kita tidak perlu @method('PUT') --}}

            <div class="space-y-6">

                {{-- Dropdown Kategori --}}
                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2.5 px-3 bg-gray-50 dark:bg-gray-700 dark:text-white transition focus:bg-white dark:focus:bg-gray-600">

                        <option value="" disabled {{ !isset($product) ? 'selected' : '' }}>-- Pilih Kategori --</option>

                        @php
                            $currentCat = old('category_id', isset($product) ? $product->category_id : '');
                        @endphp

                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $currentCat == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach

                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Nama --}}
                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                           class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2.5 px-3 placeholder-gray-400 dark:bg-gray-700 dark:text-white transition"
                           placeholder="Contoh: Sepatu Sneakers Putih"
                           value="{{ old('name', isset($product) ? $product->name : '') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Harga --}}
                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 dark:text-gray-400 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="price" id="price"
                               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 pl-10 focus:border-black focus:ring-black sm:text-sm py-2.5 dark:bg-gray-700 dark:text-white transition"
                               placeholder="0"
                               value="{{ old('price', isset($product) ? $product->price : '') }}" required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Deskripsi --}}
                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-1">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="block w-full rounded-lg border-gray-300 dark:border-gray-600 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 placeholder-gray-400 dark:bg-gray-700 dark:text-white transition"
                              placeholder="Jelaskan detail produk Anda..." required>{{ old('description', isset($product) ? $product->description : '') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Input Upload Gambar (FITUR BARU) --}}
                <div>
                    <label for="image" class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-2">
                        Foto Produk (Opsional)
                    </label>

                    {{-- Preview Gambar Lama --}}
                    @if(isset($product) && $product->image)
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Gambar saat ini:</p>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Preview" class="h-32 w-32 object-cover rounded-lg border border-gray-200 dark:border-gray-600">
                        </div>
                    @endif

                    <input type="file" name="image" id="image"
                           class="block w-full text-sm text-gray-500 dark:text-gray-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-black file:text-white
                                  hover:file:bg-gray-800
                                  dark:file:bg-gray-600 dark:file:text-gray-200
                                  dark:hover:file:bg-gray-500
                                  cursor-pointer transition">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, GIF. Maks: 2MB.</p>

                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            {{-- Tombol Aksi --}}
            <div class="mt-8 flex items-center justify-end space-x-4 border-t border-gray-100 dark:border-gray-700 pt-6">
                <a href="{{ route('products') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-black dark:bg-white border border-transparent rounded-lg font-bold text-sm text-white dark:text-black hover:bg-gray-800 dark:hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black dark:focus:ring-white shadow-lg transition transform hover:-translate-y-0.5">
                    {{ isset($product) ? 'Simpan Perubahan' : 'Buat Produk' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
