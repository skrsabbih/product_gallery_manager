@extends('layout')

@section('content')

    {{--  success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">All Products</h2>
            <p class="text-muted mb-0">Manage your product gallery here.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
    </div>

    @if ($products->count())
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0">
                        @if ($product->images->count())
                            <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" class="card-img-top"
                                alt="{{ $product->name }}" style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                <span class="text-muted">No Image Available</span>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $product->name }}</h5>

                            <p class="card-text text-muted">
                                {{ Str::limit($product->description, 100) }}
                            </p>

                            <div class="mt-auto d-flex gap-2 flex-wrap">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-info text-white">
                                    View
                                </a>

                                <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-warning text-dark">
                                    Edit
                                </a>

                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card shadow-sm border-0">
            <div class="card-body text-center py-5">
                <h4>No Products Found</h4>
                <p class="text-muted">Start by adding your first product.</p>
            </div>
        </div>
    @endif
@endsection
