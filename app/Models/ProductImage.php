<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'product_id',
        'image_path'
    ];

    // Define the relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
