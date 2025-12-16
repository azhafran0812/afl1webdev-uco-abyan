<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        // Simpan ke database
        Category::create($validated);

        // Kembali ke halaman produk dengan pesan sukses
        return redirect()->route('products')->with('success', 'Kategori baru berhasil ditambahkan!');
    }
}
