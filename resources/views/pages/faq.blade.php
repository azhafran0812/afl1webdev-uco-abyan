@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <h1 class="text-3xl font-bold text-center text-gray-900 dark:text-white mb-8">Pertanyaan Umum (FAQ)</h1>

    <div class="space-y-4">
        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Bagaimana cara melakukan pemesanan?</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Anda cukup memilih produk, menambahkannya ke keranjang, dan mengikuti langkah checkout. Pastikan Anda sudah login terlebih dahulu.</p>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Metode pembayaran apa saja yang tersedia?</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Saat ini kami menerima Transfer Bank (BCA, Mandiri), E-Wallet (GoPay, OVO), dan Cash on Delivery (COD).</p>
        </div>

        <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg p-6 shadow-sm">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Berapa lama pengiriman barang?</h3>
            <p class="mt-2 text-gray-500 dark:text-gray-400">Pengiriman reguler memakan waktu 2-4 hari kerja tergantung lokasi Anda.</p>
        </div>
    </div>
</div>
@endsection
