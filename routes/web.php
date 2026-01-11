<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReviewController;

// --- PUBLIC ROUTES (Bisa diakses siapa saja) ---
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

// Melihat daftar & detail produk tidak butuh login
    Route::controller(ProductController::class)->prefix('products')->group(function () {
    Route::get('/', 'index')->name('products');
    Route::get('/show/{id}', 'show')->name('products.show');
    });


// --- GUEST ROUTES (Hanya bisa diakses jika BELUM login) ---
    Route::middleware(['guest'])->group(function () {
    // Register
    Route::get('/register', [UserController::class, 'create'])->name('register');
    Route::post('/register', [UserController::class, 'store'])->name('register.store');

    // Login
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    });

// --- ADMIN ROUTES (Hanya bisa diakses oleh Admin) ---
// Middleware 'admin' harus sudah didaftarkan di bootstrap/app.php
Route::middleware(['auth', 'admin'])->group(function () {

    // --- (Dashboard & User Management) ---
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    // Manajemen Produk (Create, Edit, Update, Store)
    Route::controller(ProductController::class)->prefix('products')->group(function () {
        Route::get('/create', 'create')->name('products.create');
        Route::post('/store', 'store')->name('products.store');
        Route::get('/edit/{id}', 'edit')->name('products.edit');
        Route::post('/update/{id}', 'update')->name('products.update');
        Route::delete('/delete/{id}', 'destroy')->name('products.destroy');
            });

    // Manajemen Kategori
    Route::controller(CategoryController::class)->prefix('categories')->group(function () {
        Route::get('/create', 'create')->name('categories.create');
        Route::post('/store', 'store')->name('categories.store');
        Route::delete('/{id}', 'destroy')->name('categories.destroy');
    });

    // Manajemen Order (FITUR BARU)
    Route::get('/admin/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::patch('/admin/orders/{id}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.update');
    });


// --- AUTHENTICATED USER ROUTES (Harus Login) ---
// Berlaku untuk User Biasa maupun Admin (Admin juga butuh logout/edit profil)
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Fitur Baru: Edit Profil
    Route::get('/profile', [UserController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');

    // Fitur Review
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Fitur Baru: Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

    // Fitur Keranjang (Cart)
    Route::controller(CartController::class)->prefix('cart')->group(function () {
        Route::get('/', 'index')->name('cart.index');
        Route::post('/add/{id}', 'addToCart')->name('cart.add');
        Route::post('/update/{id}', 'updateCart')->name('cart.update');
        Route::post('/remove/{id}', 'removeFromCart')->name('cart.remove');
    });

    // Fitur Checkout & Order History
    Route::get('/checkout', [OrderController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/orders', [OrderController::class, 'history'])->name('orders.history');
    });


