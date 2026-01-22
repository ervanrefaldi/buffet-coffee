<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_items_id';

    protected $fillable = [
        'orders_id',
        'products_id',
        'quantity',
        'variant',
        'price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id', 'orders_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'products_id');
    }
}
