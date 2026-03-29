@extends('layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h2 class="mb-1">Edit Product</h2>
            <p class="text-muted mb-0">Update product information and manage images</p>
        </div>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="5"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label d-block">Existing Images</label>

                    @if ($product->images->count())
                        <div class="row g-3" id="existing-images-wrapper">
                            @foreach ($product->images as $image)
                                <div class="col-md-4 existing-image-item" data-image-id="{{ $image->id }}">
                                    <div class="card shadow-sm border-0 h-100">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"
                                            class="card-img-top" style="height: 220px; object-fit: cover;">

                                        <div class="card-body p-3">
                                            <button type="button" class="btn btn-sm btn-danger w-100 remove-image-btn"
                                                data-image-id="{{ $image->id }}">
                                                Remove Image
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning mb-0">
                            No existing images found for this product.
                        </div>
                    @endif

                    {{-- add hidden inputs for removed images --}}
                    <div id="remove-images-inputs"></div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Add New Images</label>
                    <input type="file" name="images[]" id="images"
                        class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror"
                        multiple accept=".jpg,.jpeg,.png,.webp">
                    <div class="form-text">
                        Optionally upload (add or remove) more images. Allowed types: JPEG, PNG, WebP. Max size: 2MB each.
                    </div>

                    @error('images')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @error('images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Product</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        {{-- for image remove --}}
        document.addEventListener('DOMContentLoaded', function() {
            const removeButtons = document.querySelectorAll('.remove-image-btn');
            const removeInputsWrapper = document.getElementById('remove-images-inputs');

            removeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const imageId = this.getAttribute('data-image-id');
                    const imageCard = document.querySelector(
                        '.existing-image-item[data-image-id="' + imageId + '"]');
                    const existingInput = document.querySelector('input[data-remove-input-id="' +
                        imageId + '"]');

                    if (!imageCard || existingInput) {
                        return;
                    }

                    imageCard.style.display = 'none';

                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'remove_images[]';
                    hiddenInput.value = imageId;
                    hiddenInput.setAttribute('data-remove-input-id', imageId);

                    removeInputsWrapper.appendChild(hiddenInput);
                });
            });
        });
    </script>
@endpush
