@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk Baru')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">
            {{ isset($product) ? 'Edit Produk' : 'Buat Produk Baru' }}
        </h1>
        <p class="mt-2 text-sm text-gray-600">
            {{ isset($product) ? 'Perbarui informasi produk di bawah ini.' : 'Isi form di bawah untuk menambahkan produk ke katalog.' }}
        </p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sm:p-8">

        <form action="{{ isset($product) ? route('products.update', $product->id) : route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">

                <div>
                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-1">
                        Kategori Produk <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2.5 px-3 bg-gray-50 focus:bg-white transition">
                        <option value="" disabled {{ !isset($product) ? 'selected' : '' }}>-- Pilih Kategori --</option>

                        @php
                            $currentCat = isset($product) ? $product->category_id : old('category_id');
                        @endphp
                        <option value="1" {{ $currentCat == 1 ? 'selected' : '' }}>Elektronik</option>
                        <option value="2" {{ $currentCat == 2 ? 'selected' : '' }}>Pakaian</option>
                        <option value="3" {{ $currentCat == 3 ? 'selected' : '' }}>Makanan</option>
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-1">
                        Nama Produk <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name"
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2.5 px-3 placeholder-gray-400"
                           placeholder="Contoh: Sepatu Sneakers Putih"
                           value="{{ isset($product) ? $product->name : old('name') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="block text-sm font-bold text-gray-700 mb-1">
                        Harga (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input type="number" name="price" id="price"
                               class="block w-full rounded-lg border-gray-300 pl-10 focus:border-black focus:ring-black sm:text-sm py-2.5"
                               placeholder="0"
                               value="{{ isset($product) ? $product->price : old('price') }}" required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-1">
                        Deskripsi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="4"
                              class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-black focus:ring-black sm:text-sm py-2 px-3 placeholder-gray-400"
                              placeholder="Jelaskan detail produk Anda..." required>{{ isset($product) ? $product->description : old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-8 flex items-center justify-end space-x-4 border-t border-gray-100 pt-6">
                <a href="{{ route('products') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-4 py-2 rounded hover:bg-gray-100 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-black border border-transparent rounded-lg font-bold text-sm text-white hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black shadow-lg transition transform hover:-translate-y-0.5">
                    {{ isset($product) ? 'Simpan Perubahan' : 'Buat Produk' }}
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
