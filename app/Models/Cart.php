<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'carts_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'carts_id',
        'user_id',
        'products_id',
        'quantity',
        'variant',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'products_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->carts_id)) {
                $model->carts_id = 'CRT-' . strtoupper(uniqid());
            }
        });
    }
}
