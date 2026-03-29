<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // validation for store product with images
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images' => ['required', 'array', 'min:3'],
            'images.*' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'The product name field is required.',
            'description.required' => 'The description field is required.',
            'images.required' => 'Please upload product images.',
            'images.array' => 'Images must be sent as an array.',
            'images.min' => 'Please upload at least 3 images.',
            'images.*.required' => 'Each image field is required.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a JPEG, PNG, or WebP file.',
            'images.*.max' => 'Each image must not be larger than 2MB.',
        ];
    }
}
