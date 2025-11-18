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
            <h4 class="text-primary">Rp {{ number_format($product['price'], 0, ',', '.') }}</h4>

            <hr>
            <a href="{{ route('products') }}" class="btn btn-secondary">Kembali ke List</a>
            <a href="{{ route('products.edit', ['id' => $product['id']]) }}" class="btn btn-warning">Edit</a>
        </div>
    </div>
@endsection
