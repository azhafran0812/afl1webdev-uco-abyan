<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\OrderPlaced;

class OrderController extends Controller
{
    /**
     * 1. Tampilkan Halaman Checkout
     */
    public function checkoutPage()
    {
        // Ambil keranjang milik user yang login
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        // Jika kosong, tendang balik ke halaman produk
        if ($cartItems->isEmpty()) {
            return redirect()->route('products')->with('error', 'Keranjang Anda kosong.');
        }

        // Hitung total harga
        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('orders.checkout', compact('cartItems', 'total'));
    }

    /**
     * 2. PROSES CHECKOUT (Logic Utama)
     */
    public function processCheckout(Request $request)
    {
        // A. Validasi Input User
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:transfer_bank,cod,e-wallet',
        ]);

        $user = Auth::user();

        try {
            // B. Mulai Transaksi Database
            // Kita tampung hasil return transaction ke variabel $order untuk dipakai kirim email
            $order = DB::transaction(function () use ($request, $user) {

                // 1. Ambil data keranjang terbaru (untuk memastikan stok/harga valid)
                $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

                if ($cartItems->isEmpty()) {
                    throw new \Exception('Keranjang kosong saat diproses.');
                }

                // --- VALIDASI STOK (BARU) ---
                foreach ($cartItems as $item) {
                    if ($item->quantity > $item->product->stock) {
                        throw new \Exception("Stok produk '{$item->product->name}' tidak mencukupi (Sisa: {$item->product->stock}).");
                    }
                }

                // 2. Hitung Total Ulang (Keamanan: jangan percaya input harga dari frontend)
                $totalPrice = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

                // 3. Buat Record Order
                $newOrder = Order::create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'payment_method' => $request->payment_method,
                    'total_price' => $totalPrice,
                ]);

                // 4. Pindahkan Item Keranjang ke Tabel OrderItem
                foreach ($cartItems as $item) {
                    OrderItem::create([
                        'order_id' => $newOrder->id,
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price, // Simpan harga saat beli (history harga)
                    ]);
                    $item->product->decrement('stock', $item->quantity);
                }


                // 5. Kosongkan Keranjang
                Cart::where('user_id', $user->id)->delete();

                // Kembalikan objek order agar bisa dipakai di luar transaction
                return $newOrder;
            });

            // --- C. PROSES KIRIM EMAIL ---
            // Ditaruh di luar transaction agar jika email gagal, order TETAP BERHASIL disimpan.
            try {
                // Kirim ke email user yang sedang login
                Mail::to($user)->send(new OrderPlaced($order));

            } catch (\Exception $e) {
                // Jika gagal kirim email, jangan crash! Cukup catat di log error.
                // Lokasi log: storage/logs/laravel.log
                Log::error('Gagal mengirim email order #' . $order->id . ': ' . $e->getMessage());
            }

            // D. Redirect Sukses
            return redirect()->route('orders.history')
                ->with('success', 'Pesanan berhasil dibuat! Cek email Anda untuk konfirmasi.');

        } catch (\Exception $e) {
            // Jika Error Database (Transkasi Gagal), balik ke halaman checkout dengan pesan error
            return back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    /**
     * 3. Tampilkan Riwayat Pesanan
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
                        ->with('items.product')
                        ->latest()
                        ->get();

        return view('orders.history', compact('orders'));
    }
}
