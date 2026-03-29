@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1">{{ $product->name }}</h2>
            <p class="text-muted mb-0">Product details and image gallery</p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <h5 class="mb-3">Description</h5>
            <p class="mb-0">{{ $product->description }}</p>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Product Images</h5>
            </div>

            @if ($product->images->count())
                <div class="row g-3">
                    @foreach ($product->images as $image)
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                    class="card-img-top" style="height: 250px; object-fit: cover;">
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning mb-0">
                    No images available for this product.
                </div>
            @endif
        </div>
    </div>
@endsection
