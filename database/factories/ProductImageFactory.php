<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // product images fake data generate
            'product_id' => Product::factory(),
            'image_path' => 'products/demo-images-' . $this->faker->numberBetween(1, 9) . '.jpg'
        ];
    }
}
