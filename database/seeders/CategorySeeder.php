<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $categories = [
            [
                'name' => 'Adventure Tours',
                'slug' => 'adventure-tours',
                'description' => 'Thrilling adventures for adrenaline seekers',
                'image' => 'https://picsum.photos/seed/adventure/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Cultural Tours',
                'slug' => 'cultural-tours',
                'description' => 'Immerse in local cultures and traditions',
                'image' => 'https://picsum.photos/seed/cultural/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Wildlife Safaris',
                'slug' => 'wildlife-safaris',
                'description' => 'Explore exotic wildlife in natural habitats',
                'image' => 'https://picsum.photos/seed/wildlife/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Beach Holidays',
                'slug' => 'beach-holidays',
                'description' => 'Relax on pristine beaches',
                'image' => 'https://picsum.photos/seed/beach/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mountain Treks',
                'slug' => 'mountain-treks',
                'description' => 'Conquer majestic mountain peaks',
                'image' => 'https://picsum.photos/seed/mountain/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Luxury Travel',
                'slug' => 'luxury-travel',
                'description' => 'Premium travel experiences',
                'image' => 'https://picsum.photos/seed/luxury/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 6,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Family Holidays',
                'slug' => 'family-holidays',
                'description' => 'Fun for the whole family',
                'image' => 'https://picsum.photos/seed/family/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 7,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Honeymoon Packages',
                'slug' => 'honeymoon-packages',
                'description' => 'Romantic escapes for couples',
                'image' => 'https://picsum.photos/seed/honeymoon/800/600',
                'parent_id' => null,
                'status' => 1,
                'order' => 8,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('categories')->insert($categories);
    }
}
