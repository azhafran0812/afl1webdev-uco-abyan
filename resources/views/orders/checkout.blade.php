@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Checkout</h2>
    <p>Total yang harus dibayar: <strong>Rp {{ number_format($total, 2) }}</strong></p>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Alamat Pengiriman</label>
            <textarea name="shipping_address" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label>Metode Pembayaran</label>
            <select name="payment_method" class="form-control" required>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="cod">Cash on Delivery (COD)</option>
                <option value="e-wallet">E-Wallet</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Buat Pesanan</button>
    </form>
</div>
@endsection
