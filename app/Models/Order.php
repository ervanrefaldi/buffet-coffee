<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'orders_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'orders_id',
        'user_id',
        'order_code',
        'total_price',
        'total_weight',
        'discount',
        'shipping_address',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'users_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'orders_id', 'orders_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'orders_id', 'orders_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->orders_id)) {
                $model->orders_id = 'ORD-' . strtoupper(uniqid());
            }
        });
    }
}
