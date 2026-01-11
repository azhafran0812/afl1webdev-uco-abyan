@extends('layouts.app')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="bg-gray-50 min-h-screen py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-8 flex justify-between items-center">
            <h1 class="text-3xl font-extrabold text-gray-900">Riwayat Pesanan</h1>
            <a href="{{ route('products') }}" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                &larr; Belanja Lagi
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
            </div>
        @endif

        @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition">

                    {{-- Header Invoice --}}
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between sm:items-center gap-4">
                        <div>
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wide">Order ID #{{ $order->id }}</span>
                            <div class="text-sm text-gray-500 mt-1">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wide
                                {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' :
                                   ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $order->status }}
                            </span>
                            <span class="text-lg font-extrabold text-gray-900">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    {{-- Body Invoice (Items) --}}
                    <div class="px-6 py-4">
                        <h4 class="text-xs font-bold text-gray-500 uppercase mb-3">Detail Item</h4>
                        <ul class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                            <li class="py-3 flex justify-between items-center">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-gray-100 rounded-lg overflow-hidden">
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-gray-700">
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $item->product->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Footer Invoice (Alamat & Info) --}}
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 text-xs text-gray-500 flex flex-col md:flex-row justify-between gap-2">
                        <div>
                            <span class="font-bold">Dikirim ke:</span> {{ $order->shipping_address }}
                        </div>
                        <div>
                            <span class="font-bold">Metode:</span> {{ strtoupper(str_replace('_', ' ', $order->payment_method)) }}
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl border border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat pesanan</h3>
                <p class="mt-1 text-sm text-gray-500">Pesanan yang Anda buat akan muncul di sini.</p>
            </div>
        @endif

    </div>
</div>
@endsection
