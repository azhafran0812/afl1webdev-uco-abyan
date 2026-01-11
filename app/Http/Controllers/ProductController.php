<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Wajib import Storage untuk hapus/upload gambar

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk dengan fitur Search, Filter Kategori/Harga, dan Sort.
     */
    public function index(Request $request)
    {
        // 1. Ambil semua kategori untuk dropdown filter
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

        // 3. Fitur Filter Kategori
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

        // Pagination
        $products = $query->paginate(30)->withQueryString();

        return view('products.list', compact('products', 'categories'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        // Ambil kategori untuk dropdown pilihan di form
        $categories = Category::all();
        return view('products.form', compact('categories'));
    }

    /**
     * Menyimpan data produk baru beserta gambar.
     */
    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            // Validasi gambar (opsional, max 2MB, format jpg/png/dll)
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Logika Upload Gambar
        if ($request->hasFile('image')) {
            // Simpan ke folder 'products' di disk 'public'
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

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
        $categories = Category::all(); // Untuk dropdown kategori saat edit

        return view('products.form', compact('product', 'categories'));
    }

    /**
     * Mengupdate data produk dan gambar.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Cek jika ada gambar baru yang diupload
        if ($request->hasFile('image')) {
            // 1. Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            // 2. Simpan gambar baru
            $imagePath = $request->file('image')->store('products', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return redirect()->route('products')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Menghapus produk beserta gambarnya.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus file gambar dari storage jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products')->with('success', 'Produk berhasil dihapus!');
    }
}
