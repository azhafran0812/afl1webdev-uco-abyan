@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Keranjang Belanja</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cartItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>Rp {{ number_format($item->product->price, 2) }}</td>
                <td>
                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                        @csrf
                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" style="width: 60px;">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                    </form>
                </td>
                <td>Rp {{ number_format($item->product->price * $item->quantity, 2) }}</td>
                <td>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Pembelian: Rp {{ number_format($total, 2) }}</h3>

    @if($cartItems->count() > 0)
        <a href="{{ route('checkout.page') }}" class="btn btn-success">Lanjut ke Checkout</a>
    @endif
</div>
@endsection
