<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category; // Import Model Category
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan fitur Search, Filter Kategori/Harga, dan Sort.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk mengisi dropdown filter di View
        $categories = Category::all();

        // Mulai Query
        $query = Product::query();

        // 2. Fitur Pencarian (Search)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 3. Fitur Filter Kategori (Baru)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // 4. Fitur Filter Range Harga
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // 5. Fitur Urutkan (Sort)
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        $validSorts = ['name', 'price', 'created_at'];

        if (in_array($sort, $validSorts)) {
            $query->orderBy($sort, $direction);
        }

        // Pagination & Query String (agar filter tidak hilang saat pindah halaman)
        $products = $query->paginate(30)->withQueryString();

        // Kirim data produk DAN data kategori ke view
        return view('products.list', compact('products', 'categories'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Ambil semua kategori untuk dropdown di form
        $categories = Category::all();

        return view('products.form', compact('categories'));
    }

    /**
     * Menyimpan data produk baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id', // Wajib valid
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
        ]);

        Product::create($validated);

        return redirect()->route('products')->with('success', 'Produk berhasil disimpan!');
    }

    /**
     * Menampilkan detail produk spesifik.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        // Ambil kategori untuk dropdown edit (agar bisa ganti kategori)
        $categories = Category::all();

        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Mengupdate data produk.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products')->with('success', 'Produk ID ' . $id . ' berhasil diupdate!');
    }

    /**
     * Menghapus produk.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products')->with('success', 'Produk berhasil dihapus!');
    }
}
