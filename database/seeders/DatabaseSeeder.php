<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            SettingSeeder::class,
            CategorySeeder::class,
            CountrySeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            GuideSeeder::class,
            TourSeeder::class,
            BlogCategorySeeder::class,
            BlogSeeder::class,
            TestimonialSeeder::class,
            FaqSeeder::class,
            PartnerSeeder::class,
            PageSeeder::class,
        ]);
    }
}
