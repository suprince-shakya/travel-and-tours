<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourGallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'image',
        'caption',
        'order',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return storage_url($this->image);
        }

        return null;
    }

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }
}
