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
    // 1. Tampilkan Halaman Checkout
    public function checkoutPage()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('products')->with('error', 'Keranjang Anda kosong.');
        }

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    // 2. PROSES CHECKOUT (Ini yang kemarin belum ada isinya)
    public function processCheckout(Request $request)
    {
        // Validasi Input
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:transfer_bank,cod,e-wallet',
        ]);

        // Gunakan Transaction agar data aman (semua tersimpan atau tidak sama sekali)
        DB::transaction(function () use ($request) {
            $user = Auth::user();

            // Ambil data keranjang user
            $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

            // Hitung Total Ulang (untuk keamanan, jangan ambil dari request frontend)
            $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            // A. Buat Record Order Baru
            $order = Order::create([
                'user_id' => $user->id,
                'status' => 'pending', // Default status
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'total_price' => $totalPrice,
            ]);

            // B. Pindahkan Item Keranjang ke OrderItems
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price, // Harga saat transaksi terjadi
                ]);
            }

            // C. Hapus Semua Isi Keranjang User Ini
            Cart::where('user_id', $user->id)->delete();
        });

        // Redirect ke Halaman History dengan pesan sukses
        return redirect()->route('orders.history')->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    // 3. Tampilkan Riwayat Pesanan
    public function history()
    {
        // Ambil order milik user yang sedang login, urutkan dari yang terbaru
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product') // Load relasi items dan product
                        ->latest()
                        ->get();

        return view('orders.history', compact('orders'));
    }
}
