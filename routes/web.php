<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Group routes berdasarkan URI /products dan Controller ProductController
Route::prefix('products')->controller(ProductController::class)->group(function () {

    // 1. Route index (/products) - Method GET
    Route::get('/', 'index')->name('products');

    // 2. Route create (/products/create) - Method GET
    Route::get('/create', 'create')->name('products.create');

    // 3. Route store (/products/store) - Method POST
    Route::post('/store', 'store')->name('products.store');

    // 4. Route show (/products/show/{id}) - Method GET dengan parameter id
    Route::get('/show/{id}', 'show')->name('products.show');

    // 5. Route edit (/products/edit/{id}) - Method GET dengan parameter id
    Route::get('/edit/{id}', 'edit')->name('products.edit');

    // 6. Route update (/products/update/{id}) - Method POST dengan parameter id
    // Catatan: Tugas meminta Method POST, meski biasanya Laravel menggunakan PUT/PATCH
    Route::post('/update/{id}', 'update')->name('products.update');

    Route::prefix('categories')->controller(CategoryController::class)->group(function () {
    Route::get('/create', 'create')->name('categories.create'); // Halaman form
    Route::post('/store', 'store')->name('categories.store');   // Proses simpan
    });

    // --- GUEST ROUTES (Hanya bisa diakses jika BELUM login) ---
    Route::middleware(['guest'])->group(function () {
    // Register (Menggunakan UserController sesuai materi Sesi 10)
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    });

// --- AUTH ROUTES (Hanya bisa diakses jika SUDAH login) ---
    Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Masukkan route Cart & Checkout Anda di sini nantinya
        // Fitur Keranjang
    Route::prefix('cart')->controller(CartController::class)->group(function () {
        Route::get('/', 'index')->name('cart.index');           // Lihat keranjang
        Route::post('/add/{id}', 'addToCart')->name('cart.add'); // Tambah produk
        Route::post('/update/{id}', 'updateCart')->name('cart.update'); // Ubah jumlah
        Route::post('/remove/{id}', 'removeFromCart')->name('cart.remove'); // Hapus produk
    });

    // Fitur Checkout & Order
    Route::get('/checkout', [OrderController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    });
});

