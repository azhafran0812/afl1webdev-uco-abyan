@extends('layouts.app')

@section('title', isset($product) ? 'Edit Produk' : 'Tambah Produk')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ isset($product) ? 'Edit Produk' : 'Buat Produk Baru' }}
                </div>
                <div class="card-body">
                    {{--
                        Jika ada data product (mode edit), arahkan ke route update.
                        Jika tidak (mode create), arahkan ke route store.
                    --}}
                    <form action="{{ isset($product) ? route('products.update', ['id' => $product['id']]) : route('products.store') }}" method="POST">
                        @csrf

                        {{-- Input Name --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Masukkan nama produk"
                                   value="{{ isset($product) ? $product['name'] : '' }}" required>
                        </div>

                        {{-- Input Description --}}
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ isset($product) ? $product['description'] : '' }}</textarea>
                        </div>

                        {{-- Input Price --}}
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                   placeholder="Masukkan harga"
                                   value="{{ isset($product) ? $product['price'] : '' }}" required>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="btn btn-primary">
                            {{ isset($product) ? 'Update Product' : 'Submit' }}
                        </button>
                        <a href="{{ route('products') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
