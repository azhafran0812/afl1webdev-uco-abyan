@extends('layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Manajemen Pesanan</h1>

    @if(session('success'))
        <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded">{{ session('success') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">User</th>
                        <th class="px-6 py-3">Total</th>
                        <th class="px-6 py-3">Pembayaran</th>
                        <th class="px-6 py-3">Status Saat Ini</th>
                        <th class="px-6 py-3">Aksi (Update Status)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50">
                        <td class="px-6 py-4">#{{ $order->id }}</td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900 dark:text-white">{{ $order->user->name }}</div>
                            <div class="text-xs">{{ $order->created_at->format('d M Y H:i') }}</div>
                        </td>
                        {{-- Contoh kolom baru di tabel Admin Order --}}
                        <td class="px-6 py-4">
                            <div class="flex -space-x-2 overflow-hidden">
                                @foreach($order->items->take(3) as $item)
                                    <img class="inline-block h-8 w-8 rounded-full ring-2 ring-white dark:ring-gray-800 object-cover"
                                        src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}">
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-4">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 capitalize">{{ str_replace('_', ' ', $order->payment_method) }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-bold
                                {{ $order->status == 'paid' ? 'bg-green-100 text-green-800' :
                                  ($order->status == 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            {{-- Form Update Status --}}
                            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="text-xs rounded border-gray-300 dark:bg-gray-700 dark:text-white focus:ring-black focus:border-black">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $order->status == 'paid' ? 'selected' : '' }}>Paid (Lunas)</option>
                                    <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped (Dikirim)</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                </select>
                                <button type="submit" class="bg-black text-white px-3 py-1.5 rounded text-xs font-bold hover:bg-gray-800">
                                    Simpan
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
