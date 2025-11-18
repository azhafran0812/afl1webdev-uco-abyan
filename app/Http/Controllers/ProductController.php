<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk (20 data dummy).
     */
    public function index()
    {
        // Membuat 20 data dummy random
        $products = [];
        for ($i = 1; $i <= 20; $i++) {
            $products[] = [
                'id' => $i,
                'name' => 'Produk ' . $i,
                'description' => 'Deskripsi untuk produk nomor ' . $i . '. Lorem ipsum dolor sit amet.',
                'price' => rand(10000, 500000)
            ];
        }

        return view('products.list', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        return view('products.form');
    }

    /**
     * Menyimpan data produk baru.
     */
    public function store(Request $request)
    {
        // Logika penyimpanan (simulasi)
        // Bisa ditambahkan validasi $request->validate(...)

        // Redirect kembali ke list atau tampilkan pesan sukses
        return redirect()->route('products')->with('success', 'Produk berhasil disimpan!');
    }

    /**
     * Menampilkan detail produk spesifik.
     */
    public function show($id)
    {
        // Simulasi data berdasarkan ID
        $product = [
            'id' => $id,
            'name' => 'Produk ' . $id,
            'description' => 'Ini adalah detail lengkap dari produk ' . $id,
            'price' => rand(10000, 500000)
        ];

        return view('products.show', compact('product'));
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit($id)
    {
        // Simulasi data yang akan diedit
        $product = [
            'id' => $id,
            'name' => 'Produk ' . $id,
            'description' => 'Deskripsi lama produk ' . $id,
            'price' => 150000
        ];

        // Kita menggunakan view form yang sama, tapi mengirimkan data product
        return view('products.form', compact('product'));
    }

    /**
     * Mengupdate data produk.
     */
    public function update(Request $request, $id)
    {
        // Logika update (simulasi)
        return redirect()->route('products')->with('success', 'Produk ID ' . $id . ' berhasil diupdate!');
    }
}
