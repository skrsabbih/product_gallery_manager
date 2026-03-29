<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
        'description'
    ];

    // Define the relationship with ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
