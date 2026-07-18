<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $settings = [
            ['key' => 'site_name', 'value' => 'Travels & Tours', 'group' => 'general', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_description', 'value' => 'Your Gateway to Amazing Travel Experiences', 'group' => 'general', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'address', 'value' => '123 Travel Street, Kathmandu, Nepal', 'group' => 'contact', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'phone', 'value' => '+977-1-4XXXXXX', 'group' => 'contact', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'email', 'value' => 'info@travels.com', 'group' => 'contact', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_facebook', 'value' => '#', 'group' => 'social', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_twitter', 'value' => '#', 'group' => 'social', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_instagram', 'value' => '#', 'group' => 'social', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'social_youtube', 'value' => '#', 'group' => 'social', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'default_meta_title', 'value' => 'Travels & Tours - Explore Amazing Destinations', 'group' => 'seo', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'default_meta_description', 'value' => 'Discover amazing tours and travel packages to destinations worldwide. Book your next adventure with Travels & Tours.', 'group' => 'seo', 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('settings')->insert($settings);
    }
}
