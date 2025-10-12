<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_id',
        'slug',
        'sku',
        'description',
        'price',
        'stock',
        'type',
        'is_active'
    ];

    protected $casts = [
        'type' => ProductType::class,
        'is_active' => 'boolean'
    ];

    public function categories() 
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
