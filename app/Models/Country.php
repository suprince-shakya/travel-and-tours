<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'code',
        'phone_code',
        'flag',
        'description',
        'image',
        'currency',
        'currency_symbol',
        'language',
        'timezone',
        'capital',
        'population',
        'area',
        'visa_info',
        'best_season',
        'travel_tips',
        'emergency_contacts',
        'weather_info',
        'status',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'boolean',
            'featured' => 'boolean',
        ];
    }

    protected $appends = ['flag_url', 'image_url'];

    public function getFlagUrlAttribute(): ?string
    {
        if ($this->flag) {
            return storage_url($this->flag);
        }

        return null;
    }

    public function getImageUrlAttribute(): ?string
    {
        if ($this->image) {
            return storage_url($this->image);
        }

        return null;
    }

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }

    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class);
    }
}
