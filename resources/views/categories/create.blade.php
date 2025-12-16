@extends('layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Tambah Kategori Baru</h2>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
            <input type="text" name="name" class="w-full border p-2 rounded" placeholder="Contoh: Otomotif" required>
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Kategori
        </button>
    </form>
</div>
@endsection
