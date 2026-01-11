<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Tampilkan Form Buat Kategori SEKALIGUS List Kategori
    public function create()
    {
        // Kita ambil semua kategori untuk ditampilkan di list bawah form
        $categories = Category::all();

        return view('categories.create', compact('categories'));
    }

    // Simpan Kategori Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.create')->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Hapus Kategori
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Opsional: Cek apakah kategori masih dipakai produk
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Gagal hapus! Kategori ini masih digunakan oleh beberapa produk.');
        }

        $category->delete();

        return redirect()->route('categories.create')->with('success', 'Kategori berhasil dihapus!');
    }
}
