@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Riwayat Pembelian</h2>
    @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-header">
                Order #{{ $order->id }} - Status: {{ $order->status }} <br>
                Tanggal: {{ $order->created_at->format('d M Y') }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($order->items as $item)
                        <li>
                            {{ $item->product->name }} x {{ $item->quantity }}
                            (Rp {{ number_format($item->price, 2) }})
                        </li>
                    @endforeach
                </ul>
                <hr>
                <strong>Total: Rp {{ number_format($order->total_price, 2) }}</strong>
                <p>Alamat: {{ $order->shipping_address }} | Metode: {{ $order->payment_method }}</p>
            </div>
        </div>
    @endforeach
</div>
@endsection
