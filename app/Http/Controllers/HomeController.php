<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Import Model Product
use App\Models\Category; // Import Model Category

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk section "New Arrivals"
        $recentProducts = Product::latest()->take(4)->get();

        // Ambil kategori (jika ingin dinamis, atau bisa hardcode di view)
        // Kita hardcode di view saja untuk layouting yang lebih presisi sesuai desain

        return view('home.index', compact('recentProducts'));
    }
}
