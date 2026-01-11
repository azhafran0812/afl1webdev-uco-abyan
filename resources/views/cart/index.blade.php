@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900">Keranjang Belanja</h1>
        <span class="text-sm text-gray-500">{{ $cartItems->count() }} Item</span>
    </div>

    @if($cartItems->count() > 0)
        <div class="bg-white shadow-sm rounded-xl border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="relative px-6 py-4"><span class="sr-only">Hapus</span></th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($cartItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0 bg-gray-100 rounded-md overflow-hidden">
                                     <img class="h-10 w-10 object-cover" src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                        class="h-24 w-24 object-cover rounded-md border border-gray-200 dark:border-gray-700">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product->name }}</div>
                                    <div class="text-sm text-gray-500">{{ Str::limit($item->product->description, 20) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">Rp {{ number_format($item->product->price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" min="1"
                                       class="w-16 text-center text-sm border-gray-300 rounded-md shadow-sm focus:ring-black focus:border-black">
                                <button type="submit" class="ml-2 text-xs text-blue-600 hover:text-blue-900 font-semibold">
                                    Update
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">
                                Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-red-500 hover:text-red-700 font-bold transition">
                                    &times;
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Footer Keranjang (Total & Checkout) --}}
            <div class="px-6 py-6 bg-gray-50 border-t border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
                <div class="text-gray-500 text-sm">
                    Belanja lagi? <a href="{{ route('products') }}" class="font-medium text-gray-900 hover:underline">Kembali ke katalog</a>
                </div>
                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <span class="block text-xs text-gray-500 uppercase tracking-wide">Total Pembayaran</span>
                        <span class="block text-2xl font-extrabold text-gray-900">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>
                    <a href="{{ route('checkout.page') }}" class="bg-black text-white px-8 py-3 rounded-lg font-bold shadow-md hover:bg-gray-800 transition transform hover:-translate-y-0.5">
                        Checkout &rarr;
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-20 bg-white rounded-xl border border-dashed border-gray-300">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Keranjang Anda kosong</h3>
            <p class="mt-1 text-sm text-gray-500">Mulailah dengan menambahkan beberapa produk.</p>
            <div class="mt-6">
                <a href="{{ route('products') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800 focus:outline-none">
                    Lihat Produk
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
