@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="bg-gray-50 min-h-screen py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900">Checkout</h1>
            <p class="mt-2 text-sm text-gray-500">Selesaikan pesanan Anda dengan mengisi informasi pengiriman di bawah ini.</p>
        </div>

        <div class="lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start">

            {{-- KOLOM KIRI: FORMULIR --}}
            <div class="lg:col-span-7">
                <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                    @csrf

                    {{-- Section: Informasi Pengiriman --}}
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 mb-6 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                Alamat Pengiriman
                            </h2>
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="shipping_address" id="shipping_address" rows="4" required
                                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-black focus:border-black sm:text-sm transition p-3"
                                    placeholder="Jalan, Nomor Rumah, RT/RW, Kelurahan, Kecamatan, Kota, Kode Pos..."></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Section: Metode Pembayaran --}}
                    <div class="bg-white shadow-sm rounded-xl border border-gray-200 mb-6 overflow-hidden">
                        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
                            <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                Metode Pembayaran
                            </h2>
                        </div>
                        <div class="p-6">
                            <div class="space-y-4">
                                {{-- Option 1: Transfer Bank --}}
                                <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition ring-inset focus-within:ring-2 focus-within:ring-black">
                                    <div class="flex items-center h-5">
                                        <input id="payment_transfer" name="payment_method" type="radio" value="transfer_bank" checked class="focus:ring-black h-4 w-4 text-black border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">Transfer Bank</span>
                                        <span class="block text-gray-500">BCA, Mandiri, BNI, BRI</span>
                                    </div>
                                </label>

                                {{-- Option 2: E-Wallet --}}
                                <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition ring-inset focus-within:ring-2 focus-within:ring-black">
                                    <div class="flex items-center h-5">
                                        <input id="payment_ewallet" name="payment_method" type="radio" value="e-wallet" class="focus:ring-black h-4 w-4 text-black border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">E-Wallet / QRIS</span>
                                        <span class="block text-gray-500">GoPay, OVO, Dana, ShopeePay</span>
                                    </div>
                                </label>

                                {{-- Option 3: COD --}}
                                <label class="relative flex items-start p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition ring-inset focus-within:ring-2 focus-within:ring-black">
                                    <div class="flex items-center h-5">
                                        <input id="payment_cod" name="payment_method" type="radio" value="cod" class="focus:ring-black h-4 w-4 text-black border-gray-300">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <span class="block font-bold text-gray-900">Cash on Delivery (COD)</span>
                                        <span class="block text-gray-500">Bayar saat barang sampai</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Submit (Mobile Only - Hidden di Desktop biar layout bagus, optional) --}}
                    {{-- Kita taruh tombol submit utama di bawah ringkasan saja atau di sini --}}
                    <div class="block lg:hidden mt-6">
                        <button type="submit" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-black hover:bg-gray-800 focus:outline-none transition">
                            Bayar Sekarang (Rp {{ number_format($total, 0, ',', '.') }})
                        </button>
                    </div>

                </form>
            </div>

            {{-- KOLOM KANAN: RINGKASAN PESANAN --}}
            <div class="lg:col-span-5 mt-10 lg:mt-0">
                <div class="bg-white shadow-lg shadow-gray-200 rounded-xl border border-gray-200 sticky top-24 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 bg-gray-50">
                        <h2 class="text-lg font-bold text-gray-900">Ringkasan Pesanan</h2>
                    </div>

                    <div class="p-6">
                        <ul class="divide-y divide-gray-100">
                            @foreach($cartItems as $item)
                            <li class="flex py-4">
                                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    <img src="https://source.unsplash.com/random/100x100?sig={{ $item->product->id }}" alt="{{ $item->product->name }}" class="h-full w-full object-cover object-center">
                                </div>

                                <div class="ml-4 flex flex-1 flex-col">
                                    <div>
                                        <div class="flex justify-between text-base font-medium text-gray-900">
                                            <h3>{{ $item->product->name }}</h3>
                                            <p class="ml-4">Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</p>
                                        </div>
                                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($item->product->description, 20) }}</p>
                                    </div>
                                    <div class="flex flex-1 items-end justify-between text-sm">
                                        <p class="text-gray-500">Jml: {{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-t border-gray-100 mt-6 pt-6 space-y-4">
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <p>Subtotal</p>
                                <p>Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex items-center justify-between text-sm text-gray-600">
                                <p>Ongkos Kirim</p>
                                <p class="font-medium text-green-600">Gratis</p>
                            </div>
                            <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                                <p class="text-lg font-bold text-gray-900">Total Pembayaran</p>
                                <p class="text-2xl font-extrabold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <div class="mt-8">
                            {{-- Tombol Submit Terhubung ke Form ID --}}
                            <button type="submit" form="checkout-form" class="w-full flex justify-center py-4 px-4 border border-transparent rounded-lg shadow-xl text-base font-bold text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black transition transform hover:-translate-y-1">
                                Konfirmasi & Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
