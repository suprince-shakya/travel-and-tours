<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $testimonials = [
            [
                'user_id' => 4,
                'name' => 'Sarah Johnson',
                'designation' => 'Marketing Manager',
                'company' => 'TechVentures Inc.',
                'photo' => 'https://i.pravatar.cc/150?img=1',
                'content' => 'The Everest Base Camp trek with Travels & Tours was absolutely life-changing. Our guide Rajesh was incredibly knowledgeable and made the experience truly unforgettable. The organization was flawless from start to finish. I cannot recommend them enough!',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(45),
                'updated_at' => $now->copy()->subDays(45),
            ],
            [
                'user_id' => 5,
                'name' => 'Michael Chen',
                'designation' => 'Software Engineer',
                'company' => 'CloudBase Solutions',
                'photo' => 'https://i.pravatar.cc/150?img=2',
                'content' => 'We took the Japan tour package and it exceeded all expectations. The itinerary was perfectly balanced between cultural sites and free time. The tea ceremony experience in Kyoto was a highlight. Already planning our next trip with them!',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(60),
                'updated_at' => $now->copy()->subDays(60),
            ],
            [
                'user_id' => null,
                'name' => 'Emma Williams',
                'designation' => 'Teacher',
                'company' => 'Westfield Primary School',
                'photo' => 'https://i.pravatar.cc/150?img=3',
                'content' => 'The Tuscany wine tour was the best vacation we have ever had. Marco our guide knew every vineyard owner personally and we got access to places tourists never see. The cooking class with a local nonna was magical.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(30),
                'updated_at' => $now->copy()->subDays(30),
            ],
            [
                'user_id' => null,
                'name' => 'James O\'Brien',
                'designation' => 'Business Consultant',
                'company' => 'Global Strategy Group',
                'photo' => 'https://i.pravatar.cc/150?img=4',
                'content' => 'Masai Mara safari was incredible! We saw the Big Five in just three days. Grace, our guide, had an eagle eye for spotting wildlife and shared so much about conservation efforts. The tented camp was luxurious beyond expectations.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(20),
                'updated_at' => $now->copy()->subDays(20),
            ],
            [
                'user_id' => 6,
                'name' => 'Priya Patel',
                'designation' => 'Doctor',
                'company' => 'City General Hospital',
                'photo' => 'https://i.pravatar.cc/150?img=5',
                'content' => 'I was nervous about solo travel but the Kerala tour made me feel completely safe and welcome. The houseboat experience on the backwaters was dreamlike. Every detail was taken care of so I could just relax and enjoy.',
                'rating' => 4,
                'status' => 1,
                'created_at' => $now->copy()->subDays(55),
                'updated_at' => $now->copy()->subDays(55),
            ],
            [
                'user_id' => null,
                'name' => 'David Schmidt',
                'designation' => 'Architect',
                'company' => 'DesignWorks Studio',
                'photo' => 'https://i.pravatar.cc/150?img=6',
                'content' => 'The Iceland Northern Lights tour was worth every penny. Bjorn was an amazing guide who knew exactly where to take us for the best views. The glacier hike was thrilling and the ice cave was surreal. Absolutely breathtaking destination.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(15),
                'updated_at' => $now->copy()->subDays(15),
            ],
            [
                'user_id' => 7,
                'name' => 'Lisa Anderson',
                'designation' => 'Freelance Photographer',
                'company' => null,
                'photo' => 'https://i.pravatar.cc/150?img=7',
                'content' => 'Bangkok temple and street food tour was an absolute feast for the senses! Our guide Somchai took us to hidden food stalls I would never have found on my own. The Grand Palace was stunning. Best food tour I have ever done.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(25),
                'updated_at' => $now->copy()->subDays(25),
            ],
            [
                'user_id' => null,
                'name' => 'Ahmed Hassan',
                'designation' => 'Banker',
                'company' => 'National Bank',
                'photo' => 'https://i.pravatar.cc/150?img=8',
                'content' => 'Dubai Luxury Experience was phenomenal. The private yacht tour around Palm Jumeirah, VIP access to Burj Khalifa, and the desert safari were all world-class. Fatima arranged every detail perfectly. True 5-star treatment throughout.',
                'rating' => 5,
                'status' => 1,
                'created_at' => $now->copy()->subDays(40),
                'updated_at' => $now->copy()->subDays(40),
            ],
        ];

        DB::table('testimonials')->insert($testimonials);
    }
}
