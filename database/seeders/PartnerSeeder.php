<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $partners = [
            [
                'name' => 'Himalayan Air',
                'slug' => 'himalayan-air',
                'logo' => 'https://picsum.photos/seed/himalayan+air-logo/200/100',
                'website' => 'https://www.himalayanair.com',
                'description' => 'Premium airline partner offering direct flights to Kathmandu, Bangkok, and Tokyo with special rates for our customers.',
                'order' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Global Hotels & Resorts',
                'slug' => 'global-hotels-resorts',
                'logo' => 'https://picsum.photos/seed/global+hotels-logo/200/100',
                'website' => 'https://www.globalhotels.com',
                'description' => 'International hotel chain providing优质 accommodation at exclusive rates for our tour packages across all destinations.',
                'order' => 2,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Adventure Gear Pro',
                'slug' => 'adventure-gear-pro',
                'logo' => 'https://picsum.photos/seed/adventure+gear-logo/200/100',
                'website' => 'https://www.adventuregearpro.com',
                'description' => 'Leading outdoor equipment supplier offering our customers 15% discount on trekking and camping gear purchases.',
                'order' => 3,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SafeGuard Insurance',
                'slug' => 'safeguard-insurance',
                'logo' => 'https://picsum.photos/seed/safeguard-logo/200/100',
                'website' => 'https://www.safeguardinsure.com',
                'description' => 'Trusted travel insurance partner offering comprehensive coverage for all our tours including adventure sports and high-altitude trekking.',
                'order' => 4,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Luxury Coach Lines',
                'slug' => 'luxury-coach-lines',
                'logo' => 'https://picsum.photos/seed/luxury+coach-logo/200/100',
                'website' => 'https://www.luxurycoach.com',
                'description' => 'Premium ground transportation partner providing comfortable, air-conditioned coaches for our overland tours.',
                'order' => 5,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'EcoStay Foundation',
                'slug' => 'ecostay-foundation',
                'logo' => 'https://picsum.photos/seed/ecostay-logo/200/100',
                'website' => 'https://www.ecostayfoundation.org',
                'description' => 'Sustainable tourism partner helping us offset carbon emissions and support local conservation projects in the destinations we visit.',
                'order' => 6,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('partners')->insert($partners);
    }
}
