<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $primaryKey = 'events_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'events_id',
        'title',
        'description',
        'image',
        'start_date',
        'end_date',
        'instagram_link',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Backup ID generation if trigger fails (though trigger is preferred)
            if (empty($model->events_id)) {
                $model->events_id = 'EVT-' . time() . '-' . rand(100, 999);
            }
        });
    }
}
