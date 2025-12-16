<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    public function index()
    {

        $recentProducts = Product::latest()->take(4)->get();


        return view('home.index', compact('recentProducts'));
    }
}
