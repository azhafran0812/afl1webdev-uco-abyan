<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan fitur Search, Filter, dan Sort.
     */
    public function index(Request $request)
    {
        // Mulai query dari model Product
        $query = Product::query();

        // 1. Fitur Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  // Mencari juga berdasarkan nama kategori yang berelasi
                  // Ini penting agar saat kategori di Homepage diklik, produk yang sesuai muncul
                  ->orWhereHas('category', function($subQ) use ($search) {
                      $subQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // 2. Fitur Filter Range Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 3. Fitur Urutkan (Sort)
        // Default sort by created_at desc (terbaru) jika tidak ada request
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');

        // Validasi kolom agar aman
        $validSorts = ['name', 'price', 'created_at'];
        if (in_array($sort, $validSorts)) {
            $query->orderBy($sort, $direction);
        }

        // Ambil data dengan pagination (30 per halaman atau sesuai kebutuhan)
        // withQueryString() berguna agar parameter search/filter tetap ada saat pindah halaman
        $products = $query->paginate(30)->withQueryString();

        return view('products.list', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Jika nanti butuh dropdown kategori, bisa tambahkan:
        // $categories = \App\Models\Category::all();
        // return view('products.form', compact('categories'));
        return view('products.form');
    }

    /**
     * Menyimpan data produk baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            // Pastikan category_id valid jika form sudah support kategori
            // 'category_id' => 'required|exists:categories,id',
        ]);

        // Simpan ke database menggunakan Eloquent
        // Jika form belum ada input category_id, bisa di-hardcode dulu atau tambahkan fieldnya di form
        // Contoh default category_id = 1 jika belum ada dropdown
        $validated['category_id'] = $request->input('category_id', 1);

        Product::create($validated);

        return redirect()->route('products')->with('success', 'Produk berhasil disimpan!');
    }

    /**
     * Menampilkan detail produk spesifik.
     */
    public function show($id)
    {
        // Mengambil data real dari database, error 404 jika tidak ditemukan
        $product = Product::findOrFail($id);

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('products.form', compact('product'));
    }

    /**
     * Mengupdate data produk.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        // Update data
        $product->update($validated);

        return redirect()->route('products')->with('success', 'Produk ID ' . $id . ' berhasil diupdate!');
    }

    /**
     * Menghapus produk (Opsional, jika dibutuhkan).
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products')->with('success', 'Produk berhasil dihapus!');
    }
}
