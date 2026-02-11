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

    /**
     * Get the image URL with absolute path for all devices.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            $imagePath = trim($this->image);
            if (str_starts_with($imagePath, 'http')) {
                if (str_contains($imagePath, '/image-proxy')) {
                    return $imagePath;
                }
                return url('/image-proxy?url=' . urlencode($imagePath));
            }
            // Handle local files
            $storagePath = 'storage/' . $imagePath;
            // Split by / and encode each segment to handle spaces/special chars
            $segments = explode('/', $storagePath);
            $encodedPath = implode('/', array_map('rawurlencode', $segments));
            return asset($encodedPath);
        }
        return asset('images/default_event.png');
    }
}
