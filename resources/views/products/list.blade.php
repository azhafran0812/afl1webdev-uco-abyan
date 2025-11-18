@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Daftar Produk</h1>
        <a href="{{ route('products.create') }}" class="btn btn-success">Add new product</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach($products as $item)
            <x-product-card
                :id="$item['id']"
                :name="$item['name']"
                :description="$item['description']"
                :price="$item['price']"
            />
        @endforeach
    </div>
@endsection
