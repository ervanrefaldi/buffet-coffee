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
        'price',
        'weight_kg',
        'category',
        'image',
    ];

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
