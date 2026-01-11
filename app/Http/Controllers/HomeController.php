<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk ditampilkan di halaman depan
        $products = Product::latest()->take(4)->get();

        return view('home.index', compact('products'));
    }
}
