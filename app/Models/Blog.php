<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'tags',
        'views',
        'status',
        'featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'featured' => 'boolean',
            'published_at' => 'datetime',
            'tags' => 'array',
        ];
    }

    protected $appends = ['featured_image_url'];

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return storage_url($this->featured_image);
        }

        return null;
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', true);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(BlogComment::class);
    }
}
