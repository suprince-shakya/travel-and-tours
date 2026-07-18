<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $blogs = [
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => '10 Essential Packing Tips for Your Next Adventure',
                'slug' => '10-essential-packing-tips-for-your-next-adventure',
                'excerpt' => 'Packing smart can make or break your trip. Here are our top 10 packing tips every traveler should know before heading out on their next adventure.',
                'content' => "Packing for a trip can be overwhelming, especially when you're heading to multiple destinations with varying climates. After years of traveling the world, our team has compiled the ultimate packing guide to help you travel lighter and smarter.\n\n1. Roll, Don't Fold: Rolling your clothes saves space and reduces wrinkles. This simple technique can free up to 30% more space in your luggage.\n\n2. Use Packing Cubes: These lightweight organizers keep your suitcase tidy and make finding items effortless. Sort by type or outfit for maximum efficiency.\n\n3. Layer Strategically: Pack base layers, mid-layers, and outer shells that can be mixed and matched. This gives you maximum outfit combinations with minimum items.\n\n4. The 3-1-1 Rule: For carry-ons, remember liquids must be in 3.4oz containers, in a 1-quart bag, 1 bag per passenger.\n\n5. Wear Your Heaviest Items: Save luggage space by wearing your boots, jacket, and bulkiest clothing during travel.\n\n6. Pack a First-Aid Kit: Include basics like band-aids, antiseptic wipes, pain relievers, and any personal medications.\n\n7. Bring a Reusable Water Bottle: Stay hydrated and reduce plastic waste. Many airports now have water refill stations.\n\n8. Digital Copies: Keep photos of your passport, visa, and important documents in your email or cloud storage.\n\n9. Leave Room for Souvenirs: Pack one empty duffel bag or leave 20% space for items you'll pick up along the way.\n\n10. The Towel Trick: A quick-dry microfiber towel is one of the most versatile items you can pack.\n\nRemember, the goal is to pack light enough to carry your own luggage but smart enough to handle any situation. Happy travels!",
                'featured_image' => 'https://picsum.photos/seed/packing+tips/1200/600',
                'tags' => 'packing, travel tips, luggage, travel hacks',
                'views' => 0,
                'status' => 1,
                'featured' => 1,
                'meta_title' => '10 Essential Packing Tips for Travelers | Travels & Tours',
                'meta_description' => 'Expert packing tips to help you travel lighter and smarter. From rolling clothes to packing cubes, master the art of efficient packing.',
                'meta_keywords' => 'packing tips, travel hacks, luggage packing, carry-on tips',
                'published_at' => $now->copy()->subDays(10),
                'created_at' => $now->copy()->subDays(10),
                'updated_at' => $now->copy()->subDays(10),
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Complete Guide to Trekking in Nepal: Everything You Need to Know',
                'slug' => 'complete-guide-to-trekking-in-nepal',
                'excerpt' => 'Planning a trek in Nepal? Our comprehensive guide covers the best treks, seasons, permits, and what to expect on the trails of the Himalayas.',
                'content' => "Nepal is a trekker's paradise, home to eight of the world's fourteen highest peaks including Mount Everest. Whether you're a first-time trekker or an experienced mountaineer, Nepal offers trails for every skill level.\n\nBest Treks for Beginners:\n- Ghorepani Poon Hill Trek (4-5 days): Stunning sunrise views over Annapurna and Dhaulagiri\n- Everest Panorama Trek (7-8 days): Great views without extreme altitude\n- Langtang Valley Trek (7-9 days): Beautiful valley close to Kathmandu\n\nBest Treks for Experienced Hikers:\n- Everest Base Camp Trek (14 days): The classic Himalayan experience\n- Annapurna Circuit (16-20 days): Diverse landscapes and cultures\n- Manaslu Circuit (14-16 days): Remote and less crowded\n\nPermits Required:\n- TIMS (Trekkers' Information Management System) card\n- National Park entry fees (specific to each region)\n- Restricted area permits (for certain regions)\n\nBest Time to Trek: March-May (spring) and September-November (autumn) offer the best weather and clearest mountain views. Winter treks are possible at lower elevations while monsoon season (June-August) brings heavy rain and leeches on lower trails.\n\nAltitude Sickness: Ascend gradually, stay hydrated, and know the symptoms. Most treks include acclimatization days. Never ascend to higher altitude if you have symptoms of Acute Mountain Sickness.\n\nTea Houses vs Camping: Most popular treks have tea houses offering basic accommodation and meals, eliminating the need for camping equipment. Remote routes may require tent camping.\n\nNepal's trekking industry is well-organized with experienced guides and porters. Always book with a registered company and ensure your guide is licensed. The Himalayas await!",
                'featured_image' => 'https://picsum.photos/seed/trekking+nepal/1200/600',
                'tags' => 'nepal, trekking, himalayas, everest, annapurna, hiking',
                'views' => 0,
                'status' => 1,
                'featured' => 1,
                'meta_title' => 'Complete Guide to Trekking in Nepal | Travels & Tours',
                'meta_description' => 'Everything you need to know about trekking in Nepal: best treks, seasons, permits, altitude sickness tips, and trail guides.',
                'meta_keywords' => 'nepal trekking, himalayas trek, everest base camp, annapurna circuit, nepal travel guide',
                'published_at' => $now->copy()->subDays(8),
                'created_at' => $now->copy()->subDays(8),
                'updated_at' => $now->copy()->subDays(8),
            ],
            [
                'user_id' => 1,
                'category_id' => 3,
                'title' => 'Chasing the Northern Lights: Our Iceland Adventure',
                'slug' => 'chasing-the-northern-lights-iceland-adventure',
                'excerpt' => 'Our team embarked on an unforgettable journey to Iceland to witness the magical Aurora Borealis. Here is the story of our Arctic adventure.',
                'content' => "The alarm went off at 10 PM, but we were already awake with anticipation. The Aurora forecast showed KP5 activity - our best chance yet to see the Northern Lights. We bundled into our Super Jeep with Bjorn, our Icelandic guide, and headed away from Reykjavik's light pollution.\n\nAfter 30 minutes of driving into the dark countryside, Bjorn pulled over. \"Look up,\" he said. At first, we saw nothing but stars. Then, faint green wisps began dancing across the sky. Within minutes, the entire sky erupted in a spectacular display of green, purple, and pink lights swirling and pulsating above us.\n\nStanding in the freezing Icelandic night, watching the Aurora Borealis perform its celestial ballet, was the most awe-inspiring experience of our lives. It was worth every layer of thermal clothing, every cold night waiting, and every early morning.\n\nBeyond the Northern Lights, Iceland offered so much more:\n- The thunderous power of Gullfoss waterfall\n- Walking between tectonic plates at Thingvellir National Park\n- The surreal experience of the Blue Lagoon's geothermal waters\n- Hiking on a glacier with crampons and ice axes\n- The otherworldly landscape of black sand beaches at Vik\n\nIceland is a destination that reminds us how wild and beautiful our planet truly is. If you're dreaming of this adventure, the best time for Northern Lights is September through March. Don't forget to pack warm - temperatures can drop to -10°C even in autumn!\n\nWould we do it again? In a heartbeat. Iceland has a piece of our hearts forever.",
                'featured_image' => 'https://picsum.photos/seed/northern+lights/1200/600',
                'tags' => 'iceland, northern lights, aurora borealis, adventure travel',
                'views' => 0,
                'status' => 1,
                'featured' => 1,
                'meta_title' => 'Chasing Northern Lights in Iceland | Travels & Tours Blog',
                'meta_description' => 'Read about our incredible Iceland adventure chasing the Northern Lights. Aurora Borealis, glaciers, and hot springs.',
                'meta_keywords' => 'iceland northern lights, aurora borealis, iceland travel, adventure blog',
                'published_at' => $now->copy()->subDays(15),
                'created_at' => $now->copy()->subDays(15),
                'updated_at' => $now->copy()->subDays(15),
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'title' => 'Exploring the Temples of Kyoto: A Journey Through Time',
                'slug' => 'exploring-temples-of-kyoto',
                'excerpt' => 'Kyoto, Japan\'s ancient capital, is home to over 2,000 temples and shrines. Discover our curated guide to the most breathtaking ones.',
                'content' => "Kyoto is a city where time seems to stand still. Despite being Japan's cultural capital for over a millennium, walking through its streets feels like stepping back in time. With over 2,000 temples and shrines, planning your visit can be overwhelming. Here are our absolute must-visits:\n\n1. Fushimi Inari Shrine: Famous for its thousands of vermilion torii gates winding up a forested mountain. Visit early morning to avoid crowds and experience the mystical atmosphere.\n\n2. Kinkaku-ji (Golden Pavilion): A Zen temple completely covered in gold leaf, reflected perfectly in its surrounding pond. One of Japan's most iconic sights.\n\n3. Arashiyama Bamboo Grove: Walk through towering bamboo stalks that seem to touch the sky. The nearby Tenryu-ji Temple and its Zen garden are equally stunning.\n\n4. Kiyomizu-dera: Built without a single nail, this wooden terrace offers panoramic views of Kyoto. Particularly beautiful during cherry blossom and autumn foliage seasons.\n\n5. Ryoan-ji: Home to Japan's most famous rock garden. Sit and contemplate the 15 carefully placed rocks on raked white gravel.\n\nPro Tips: Purchase a bus pass for unlimited travel. Many temples offer early morning or evening special viewings. Try shojin ryori (Buddhist vegetarian cuisine) at select temples. Respect photography rules - many temples prohibit photos indoors.\n\nKyoto is also famous for its geisha culture, particularly in the Gion district. While spotting a geiko or maiko requires luck, early evening walks along Shirakawa Canal offer the best chances.\n\nAutumn foliage (November) and cherry blossom season (April) are spectacular but crowded. Winter offers a serene, less crowded experience with occasional snow-covered temples.",
                'featured_image' => 'https://picsum.photos/seed/kyoto+temples/1200/600',
                'tags' => 'kyoto, japan, temples, culture, travel guide',
                'views' => 0,
                'status' => 1,
                'featured' => 0,
                'meta_title' => 'Exploring Kyoto Temples | Travels & Tours Japan Guide',
                'meta_description' => 'A comprehensive guide to Kyoto\'s most beautiful temples and shrines. Tips for visiting Fushimi Inari, Kinkaku-ji, and more.',
                'meta_keywords' => 'kyoto temples, japan travel, fushimi inari, kinkaku-ji, japanese culture',
                'published_at' => $now->copy()->subDays(5),
                'created_at' => $now->copy()->subDays(5),
                'updated_at' => $now->copy()->subDays(5),
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Travel Insurance: Why You Should Never Leave Home Without It',
                'slug' => 'travel-insurance-why-you-need-it',
                'excerpt' => 'Many travelers skip travel insurance to save money. We explain why this is a costly mistake and what you should look for in a policy.',
                'content' => "It's easy to think \"nothing will happen to me\" when planning a trip. But the reality is that travel disruptions, medical emergencies, and lost luggage happen more often than you'd think. Here's why travel insurance is non-negotiable.\n\nMedical Emergencies: Your regular health insurance likely doesn't cover you abroad. A hospital stay in the US can cost $10,000+ per day. Medical evacuation from a trekking accident in Nepal can exceed $50,000. Travel insurance covers these catastrophic costs.\n\nTrip Cancellation: Life is unpredictable. Illness, family emergencies, or natural disasters can force you to cancel. Comprehensive policies cover non-refundable flights, accommodation, and tour costs.\n\nLost or Delayed Luggage: Airlines lose millions of bags annually. Insurance covers essential purchases while you wait and compensates for permanently lost items.\n\nWhat to Look For:\n- Coverage for medical expenses (minimum $100,000 for international)\n- Emergency medical evacuation coverage\n- Trip cancellation/interruption coverage\n- Baggage loss/delay coverage\n- 24/7 emergency assistance hotline\n- Adventure sports coverage if trekking, skiing, or diving\n\nPro Tip: Buy insurance immediately after booking your trip. This covers pre-existing conditions and ensures you're protected if you need to cancel before departure.\n\nAt Travels & Tours, we recommend our customers always carry comprehensive travel insurance. Some of our remote treks and adventure tours actually require it as a condition of booking.\n\nRemember: If you can't afford travel insurance, you can't afford to travel. Stay safe out there!",
                'featured_image' => 'https://picsum.photos/seed/travel+insurance/1200/600',
                'tags' => 'travel insurance, safety, travel tips, preparation',
                'views' => 0,
                'status' => 1,
                'featured' => 0,
                'meta_title' => 'Why Travel Insurance Matters | Travels & Tours Blog',
                'meta_description' => 'Why travel insurance is essential for every trip. Medical coverage, trip cancellation, and what to look for in a policy.',
                'meta_keywords' => 'travel insurance, trip protection, medical evacuation, travel safety',
                'published_at' => $now->copy()->subDays(3),
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'user_id' => 1,
                'category_id' => 4,
                'title' => 'Travels & Tours Announces New Destinations for 2025',
                'slug' => 'new-destinations-2025-announcement',
                'excerpt' => 'We are excited to announce the expansion of our tour offerings with 8 new destinations across Asia, Europe, and Africa for the 2025 season.',
                'content' => "We are thrilled to announce that Travels & Tours is expanding our portfolio with exciting new destinations for the 2025 season. After listening to customer feedback and extensive market research, we've added the following destinations:\n\nNew Destinations:\n1. Sri Lanka - Tea plantations, ancient cities, and pristine beaches\n2. Portugal - Lisbon, Porto, and the Algarve coast\n3. Tanzania - Kilimanjaro treks and Zanzibar beach holidays\n4. Vietnam - Ha Long Bay, Hanoi, and Ho Chi Minh City\n5. Greece - Athens, Santorini, and the Greek Islands\n6. Bhutan - The happiest country on earth, with stunning monasteries\n7. Egypt - Pyramids, Nile cruises, and Red Sea diving\n8. New Zealand - North and South Island adventures\n\nWhat's New for 2025:\n- Extended group discounts for families and friends\n- New sustainable travel initiatives with carbon offset programs\n- Enhanced mobile app with real-time booking and itinerary management\n- Partnership with local communities for authentic cultural experiences\n- Flexible booking options with free date changes\n\nCustomer Feedback: We received over 5,000 responses to our destination survey, and the demand for off-the-beaten-path experiences has never been higher. Our new itineraries focus on authentic cultural immersion and sustainable tourism practices.\n\nSpecial Launch Offer: Book any new destination tour before March 31, 2025 and receive a 10% early bird discount plus free airport transfer.\n\nStay tuned for more exciting announcements as we continue to grow and bring you the world's most amazing travel experiences. Thank you for being part of our journey!",
                'featured_image' => 'https://picsum.photos/seed/new+destinations/1200/600',
                'tags' => 'travel news, new destinations, 2025 tours, company update',
                'views' => 0,
                'status' => 1,
                'featured' => 0,
                'meta_title' => 'New Destinations for 2025 | Travels & Tours News',
                'meta_description' => 'Travels & Tours announces 8 new destinations for 2025 including Sri Lanka, Portugal, Tanzania, Vietnam, and more.',
                'meta_keywords' => 'new tours 2025, travel company news, new destinations, travel announcement',
                'published_at' => $now->copy()->subDays(1),
                'created_at' => $now->copy()->subDays(1),
                'updated_at' => $now->copy()->subDays(1),
            ],
        ];

        DB::table('blogs')->insert($blogs);
    }
}
