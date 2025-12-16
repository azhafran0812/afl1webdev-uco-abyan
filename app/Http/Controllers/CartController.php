<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Lihat Keranjang & Total (10 Poin: Subtotal/Total)
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Hitung Total
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Tambah ke Keranjang (10 Poin)
    public function addToCart(Request $request, $productId)
    {
        $cart = Cart::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

        if ($cart) {
            $cart->increment('quantity');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $productId,
                'quantity' => 1
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    // Ubah Jumlah (10 Poin)
    public function updateCart(Request $request, $cartId)
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $cart = Cart::where('user_id', Auth::id())->where('id', $cartId)->first();
        if ($cart) {
            $cart->update(['quantity' => $request->quantity]);
        }

        return redirect()->back();
    }

    // Hapus dari Keranjang (10 Poin)
    public function removeFromCart($cartId)
    {
        Cart::where('user_id', Auth::id())->where('id', $cartId)->delete();
        return redirect()->back()->with('success', 'Produk dihapus');
    }
}
