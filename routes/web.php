<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;

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

});
