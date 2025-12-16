<div class="col-md-4 mb-4">
    <div class="card h-100">
        <div class="card-body">
            <h5 class="card-title">{{ $name }}</h5>
            <h6 class="card-subtitle mb-2 text-muted">ID: {{ $id }}</h6>
            <p class="card-text">{{ $description }}</p>
            <p class="card-text fw-bold text-primary">Rp {{ number_format($price, 0, ',', '.') }}</p>
        </div>
        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">

            {{-- Tombol Add to Cart --}}
            @auth
            <form action="{{ route('cart.add', $id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-success">+ Cart</button>
            </form>
            @endauth

            <div>
                <a href="{{ route('products.show', ['id' => $id]) }}" class="btn btn-sm btn-info text-white">Detail</a>
                <a href="{{ route('products.edit', ['id' => $id]) }}" class="btn btn-sm btn-warning">Edit</a>
            </div>
        </div>
    </div>
</div>
