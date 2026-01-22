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
        'stock',       // Shared stock in Kg
        'price_200g',  // Variant prices
        'price_500g',
        'price_1kg',
        'category',
        'image',
    ];

    public function getPriceByVariant($variant)
    {
        return match($variant) {
            '200g' => $this->price_200g,
            '500g' => $this->price_500g,
            '1kg' => $this->price_1kg,
            default => $this->price_200g,
        };
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
