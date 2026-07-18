<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogCategorySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $categories = [
            ['name' => 'Travel Tips', 'slug' => 'travel-tips', 'description' => 'Helpful tips and advice for travelers', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Destination Guides', 'slug' => 'destination-guides', 'description' => 'In-depth guides to popular travel destinations', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Adventure Stories', 'slug' => 'adventure-stories', 'description' => 'Inspiring tales from the trail', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'News & Updates', 'slug' => 'news-updates', 'description' => 'Latest news and company updates', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('blog_categories')->insert($categories);
    }
}
