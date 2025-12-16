<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Halaman Checkout (Form alamat & pembayaran)
    public function checkoutPage()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    // Proses Checkout (10 Poin)
    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        DB::transaction(function () use ($request) {
            $user = Auth::user();
            $cartItems = Cart::where('user_id', $user->id)->get();

            // Hitung ulang total untuk keamanan
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // 1. Buat Order
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'total_price' => $total,
                'status' => 'pending'
            ]);

            // 2. Pindahkan item dari Cart ke OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price, // Simpan harga saat ini
                ]);
            }

            // 3. Kosongkan Keranjang
            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.history')->with('success', 'Pembelian berhasil!');
    }

    // Daftar Pembelian (10 Poin)
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product')
                        ->orderByDesc('created_at')
                        ->get();
        return view('orders.history', compact('orders'));
    }
}
