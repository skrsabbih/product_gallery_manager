<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // product seeder
        Product::factory()
            ->count(3)
            ->has(ProductImage::factory()->count(3), 'images') // each product have 3 images
            ->create();
    }
}
