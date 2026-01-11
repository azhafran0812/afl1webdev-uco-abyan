<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        // Ambil wishlist user beserta data produknya
        $wishlists = Wishlist::with('product')->where('user_id', Auth::id())->get();
        return view('wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request)
    {
        $productId = $request->product_id;
        $userId = Auth::id();

        $exists = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

        if ($exists) {
            $exists->delete();
            $message = 'Produk dihapus dari wishlist.';
        } else {
            Wishlist::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            $message = 'Produk ditambahkan ke wishlist.';
        }

        return back()->with('success', $message);
    }
}
