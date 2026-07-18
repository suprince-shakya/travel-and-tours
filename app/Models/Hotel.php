<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'country_id',
        'city_id',
        'description',
        'address',
        'latitude',
        'longitude',
        'phone',
        'email',
        'website',
        'star_rating',
        'amenities',
        'check_in',
        'check_out',
        'images',
        'status',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'amenities' => 'array',
        ];
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(HotelRoom::class);
    }
}
