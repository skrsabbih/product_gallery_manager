<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // validation for update product data
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'images' => ['nullable', 'array'],
            'images.*' => ['nullable', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['nullable', 'integer', 'exists:product_images,id'],
        ];
    }

    // custom messages for validation
    public function messages(): array
    {
        return [
            'name.required' => 'The product name field is required.',
            'description.required' => 'The description field is required.',
            'images.array' => 'Images must be sent as an array.',
            'images.*.image' => 'Each file must be an image.',
            'images.*.mimes' => 'Each image must be a JPEG, PNG, or WebP file.',
            'images.*.max' => 'Each image must not be larger than 2MB.',
        ];
    }
}
