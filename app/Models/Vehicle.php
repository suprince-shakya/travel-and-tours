<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'type',
        'model',
        'brand',
        'year',
        'capacity',
        'description',
        'features',
        'price_per_day',
        'currency',
        'driver_price',
        'image',
        'gallery',
        'fuel_type',
        'mileage',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'gallery' => 'array',
        ];
    }
}
