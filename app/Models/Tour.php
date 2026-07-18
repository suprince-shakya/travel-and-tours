<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'country_id',
        'region_id',
        'city_id',
        'title',
        'slug',
        'duration',
        'difficulty',
        'max_elevation',
        'price',
        'discount_price',
        'currency',
        'thumbnail',
        'video_url',
        'map_embed',
        'latitude',
        'longitude',
        'description',
        'overview',
        'highlights',
        'included',
        'excluded',
        'accommodation',
        'transportation',
        'meals',
        'fitness_level',
        'packing_list',
        'best_season',
        'weather_info',
        'languages',
        'cancellation_policy',
        'terms',
        'guide_id',
        'max_group_size',
        'remaining_seats',
        'available_from',
        'available_to',
        'status',
        'featured',
        'popular',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'views',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'featured' => 'boolean',
            'popular' => 'boolean',
            'available_from' => 'date',
            'available_to' => 'date',
        ];
    }

    public function getDiscountedPriceAttribute(): ?float
    {
        if ($this->discount_price && $this->discount_price < $this->price) {
            return $this->discount_price;
        }

        return null;
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail) {
            return storage_url($this->thumbnail);
        }

        return null;
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->where('popular', true);
    }

    public function scopeByDifficulty(Builder $query, string $difficulty): Builder
    {
        return $query->where('difficulty', $difficulty);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(TourGallery::class);
    }

    public function dates(): HasMany
    {
        return $this->hasMany(TourDate::class);
    }

    public function itineraries(): HasMany
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }
}
