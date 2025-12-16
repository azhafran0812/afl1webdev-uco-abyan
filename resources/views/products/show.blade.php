@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
    <div class="card">
        <div class="card-header">
            Detail Produk ID: {{ $product['id'] }}
        </div>
        <div class="card-body">
            <h3 class="card-title">{{ $product['name'] }}</h3>
            <p class="card-text">{{ $product['description'] }}</p>
            <h4 class="text-primary mb-3">Rp {{ number_format($product['price'], 0, ',', '.') }}</h4>

            {{-- TOMBOL ADD TO CART --}}
            @auth
                <form action="{{ route('cart.add', $product['id']) }}" method="POST" class="d-inline mb-3">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg mb-3">
                        + Keranjang Belanja
                    </button>
                </form>
                <br>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary mb-3">Login untuk Membeli</a>
                <br>
            @endauth

            <hr>
            <a href="{{ route('products') }}" class="btn btn-secondary">Kembali ke List</a>
            <a href="{{ route('products.edit', ['id' => $product['id']]) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
