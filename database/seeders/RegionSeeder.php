<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $regions = [
            ['country_id' => 1, 'name' => 'Kathmandu Valley', 'slug' => 'kathmandu-valley', 'description' => 'The cultural heart of Nepal, home to ancient temples and palaces', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 1, 'name' => 'Pokhara Region', 'slug' => 'pokhara-region', 'description' => 'Gateway to the Annapurna range with stunning lakes and mountains', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 1, 'name' => 'Everest Region', 'slug' => 'everest-region', 'description' => 'Home to the world\'s highest peak, a trekker\'s paradise', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 2, 'name' => 'Northern Thailand', 'slug' => 'northern-thailand', 'description' => 'Mountainous region with rich cultural heritage and hill tribes', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 2, 'name' => 'Southern Beaches', 'slug' => 'southern-beaches', 'description' => 'World-famous tropical islands and pristine beaches', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 2, 'name' => 'Bangkok Region', 'slug' => 'bangkok-region', 'description' => 'The vibrant capital region with temples, markets, and nightlife', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 3, 'name' => 'Kanto Region', 'slug' => 'kanto-region', 'description' => 'Tokyo and surrounding areas, the modern heart of Japan', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 3, 'name' => 'Kansai Region', 'slug' => 'kansai-region', 'description' => 'Ancient capitals of Kyoto and Osaka, cultural treasures', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 3, 'name' => 'Hokkaido', 'slug' => 'hokkaido', 'description' => 'Northern island known for natural beauty, skiing, and lavender fields', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 4, 'name' => 'Tuscany', 'slug' => 'tuscany', 'description' => 'Rolling hills, vineyards, and Renaissance art and architecture', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 4, 'name' => 'Amalfi Coast', 'slug' => 'amalfi-coast', 'description' => 'Stunning coastal cliffs, colorful villages, and Mediterranean views', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 4, 'name' => 'Sicily', 'slug' => 'sicily', 'description' => 'The largest Mediterranean island with rich history and cuisine', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 5, 'name' => 'Nairobi Region', 'slug' => 'nairobi-region', 'description' => 'The capital region, gateway to Kenyan safaris', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 5, 'name' => 'Masai Mara', 'slug' => 'masai-mara', 'description' => 'World-renowned wildlife reserve and site of the Great Migration', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 5, 'name' => 'Coast Region', 'slug' => 'coast-region', 'description' => 'Beautiful Indian Ocean beaches and Swahili culture', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 6, 'name' => 'Cusco Region', 'slug' => 'cusco-region', 'description' => 'Ancient Inca capital and gateway to Machu Picchu', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 6, 'name' => 'Lima Region', 'slug' => 'lima-region', 'description' => 'Coastal capital region with world-class cuisine', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 6, 'name' => 'Amazon Basin', 'slug' => 'amazon-basin', 'description' => 'Peruvian Amazon rainforest teeming with biodiversity', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 7, 'name' => 'New South Wales', 'slug' => 'new-south-wales', 'description' => 'Sydney and the stunning eastern coastline', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 7, 'name' => 'Queensland', 'slug' => 'queensland', 'description' => 'Great Barrier Reef, tropical islands, and golden beaches', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 7, 'name' => 'Victoria', 'slug' => 'victoria', 'description' => 'Melbourne, culture, and the Great Ocean Road', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 8, 'name' => 'Dubai', 'slug' => 'dubai', 'description' => 'Ultramodern city of superlatives and luxury shopping', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 8, 'name' => 'Abu Dhabi', 'slug' => 'abu-dhabi', 'description' => 'The capital city with culture, heritage, and modern attractions', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 8, 'name' => 'Sharjah', 'slug' => 'sharjah', 'description' => 'Cultural capital of the UAE with museums and heritage sites', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 9, 'name' => 'Marrakech', 'slug' => 'marrakech', 'description' => 'The Red City with bustling souks and palaces', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 9, 'name' => 'Fes', 'slug' => 'fes', 'description' => 'Ancient imperial city with the world\'s oldest university', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 9, 'name' => 'Chefchaouen', 'slug' => 'chefchaouen', 'description' => 'The famous blue pearl of Morocco in the Rif Mountains', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 10, 'name' => 'Reykjavik Area', 'slug' => 'reykjavik-area', 'description' => 'The capital region, starting point for Icelandic adventures', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 10, 'name' => 'South Coast', 'slug' => 'south-coast', 'description' => 'Waterfalls, glaciers, and black sand beaches', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['country_id' => 10, 'name' => 'Golden Circle', 'slug' => 'golden-circle', 'description' => 'Þingvellir, Geysir, and Gullfoss - Iceland\'s top attractions', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('regions')->insert($regions);
    }
}
