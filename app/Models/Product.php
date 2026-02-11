<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'products_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'products_id',
        'name',
        'description',
        'stock_200g',  // Stock for 200g packs
        'stock_500g',  // Stock for 500g packs
        'stock_1kg',   // Stock for 1kg packs
        'price_200g',  // Variant prices
        'price_500g',
        'price_1kg',
        'category',    // Biji / Bubuk
        'coffee_variant', // Robusta / Arabica
        'image',
    ];

    public function getStockForVariant($variant)
    {
        return match($variant) {
            '200g' => $this->stock_200g,
            '500g' => $this->stock_500g,
            '1kg' => $this->stock_1kg,
            default => 0,
        };
    }

    public function getPriceByVariant($variant)
    {
        return match($variant) {
            '200g' => $this->price_200g,
            '500g' => $this->price_500g,
            '1kg' => $this->price_1kg,
            default => $this->price_200g,
        };
    }

    /**
     * Get the image URL with a safe fallback for shared hosting.
     * This avoids reliance on symbolic links which might be broken.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/default.png');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->products_id)) {
                $model->products_id = 'PROD-' . time() . '-' . rand(100, 999);
            }
        });
    }
}
