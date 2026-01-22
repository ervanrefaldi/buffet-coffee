<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $primaryKey = 'transactions_id';
    public $incrementing = false;
    protected $keyType = 'string';
    const UPDATED_AT = null;

    protected $fillable = [
        'transactions_id',
        'orders_id',
        'transaction_code',
        'payment_method',
        'transaction_date',
        'confirmed_at',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'orders_id', 'orders_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->transactions_id)) {
                $model->transactions_id = 'TRX-' . strtoupper(uniqid());
            }
        });
    }
}
