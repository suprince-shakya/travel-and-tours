<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $cities = [
            // Nepal - Kathmandu Valley (region_id=1)
            ['region_id' => 1, 'country_id' => 1, 'name' => 'Kathmandu', 'slug' => 'kathmandu', 'description' => 'The capital city, a vibrant blend of ancient temples and modern life', 'latitude' => 27.7172, 'longitude' => 85.3240, 'attractions' => 'Durbar Square, Swayambhunath Stupa, Pashupatinath Temple, Boudhanath Stupa, Thamel', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 1, 'country_id' => 1, 'name' => 'Patan', 'slug' => 'patan', 'description' => 'Ancient city known for its rich artistic heritage and temples', 'latitude' => 27.6710, 'longitude' => 85.3240, 'attractions' => 'Patan Durbar Square, Golden Temple, Krishna Mandir, Patan Museum', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 1, 'country_id' => 1, 'name' => 'Bhaktapur', 'slug' => 'bhaktapur', 'description' => 'Well-preserved medieval city with exquisite architecture', 'latitude' => 27.6720, 'longitude' => 85.4278, 'attractions' => 'Bhaktapur Durbar Square, Nyatapola Temple, Pottery Square, Dattatreya Temple', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Nepal - Pokhara Region (region_id=2)
            ['region_id' => 2, 'country_id' => 1, 'name' => 'Pokhara', 'slug' => 'pokhara', 'description' => 'Gateway to the Annapurna range with stunning lakeside views', 'latitude' => 28.2096, 'longitude' => 83.9856, 'attractions' => 'Phewa Lake, Sarangkot, Devi\'s Fall, World Peace Pagoda, Annapurna Base Camp', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Nepal - Everest Region (region_id=3)
            ['region_id' => 3, 'country_id' => 1, 'name' => 'Namche Bazaar', 'slug' => 'namche-bazaar', 'description' => 'The gateway to Everest, a bustling Sherpa town in the Khumbu region', 'latitude' => 27.8044, 'longitude' => 86.7117, 'attractions' => 'Everest View Hotel, Sagarmatha National Park, Sherpa Museum, Khumjung Village', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 3, 'country_id' => 1, 'name' => 'Lukla', 'slug' => 'lukla', 'description' => 'Starting point for Everest treks, home to the famous Tenzing-Hillary Airport', 'latitude' => 27.6873, 'longitude' => 86.7295, 'attractions' => 'Tenzing-Hillary Airport, Lukla Monastery, Everest Base Camp trek start', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Thailand - Northern Thailand (region_id=4)
            ['region_id' => 4, 'country_id' => 2, 'name' => 'Chiang Mai', 'slug' => 'chiang-mai', 'description' => 'The cultural capital of Northern Thailand with ancient temples', 'latitude' => 18.7883, 'longitude' => 98.9853, 'attractions' => 'Doi Suthep, Old City Temples, Night Bazaar, Elephant Nature Park', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 4, 'country_id' => 2, 'name' => 'Chiang Rai', 'slug' => 'chiang-rai', 'description' => 'Northern city known for its unique white temple and hill tribes', 'latitude' => 19.9105, 'longitude' => 99.8406, 'attractions' => 'White Temple (Wat Rong Khun), Blue Temple, Golden Triangle, Hill Tribe Villages', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Thailand - Southern Beaches (region_id=5)
            ['region_id' => 5, 'country_id' => 2, 'name' => 'Phuket', 'slug' => 'phuket', 'description' => 'Thailand\'s largest island with stunning beaches and vibrant nightlife', 'latitude' => 7.8804, 'longitude' => 98.3923, 'attractions' => 'Patong Beach, Phi Phi Islands, Big Buddha, Phang Nga Bay, James Bond Island', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 5, 'country_id' => 2, 'name' => 'Krabi', 'slug' => 'krabi', 'description' => 'Coastal province with limestone cliffs and crystal clear waters', 'latitude' => 8.0863, 'longitude' => 98.9063, 'attractions' => 'Railay Beach, Ao Nang, Tiger Cave Temple, Emerald Pool, Hong Islands', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Thailand - Bangkok Region (region_id=6)
            ['region_id' => 6, 'country_id' => 2, 'name' => 'Bangkok', 'slug' => 'bangkok', 'description' => 'Thailand\'s vibrant capital city', 'latitude' => 13.7563, 'longitude' => 100.5018, 'attractions' => 'Grand Palace, Wat Pho, Wat Arun, Chatuchak Market, Khao San Road', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Japan - Kanto Region (region_id=7)
            ['region_id' => 7, 'country_id' => 3, 'name' => 'Tokyo', 'slug' => 'tokyo', 'description' => 'Japan\'s bustling capital blending ultramodern and traditional', 'latitude' => 35.6762, 'longitude' => 139.6503, 'attractions' => 'Senso-ji Temple, Shibuya Crossing, Tokyo Tower, Meiji Shrine, Akihabara', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 7, 'country_id' => 3, 'name' => 'Yokohama', 'slug' => 'yokohama', 'description' => 'Japan\'s second-largest city with a beautiful waterfront', 'latitude' => 35.4437, 'longitude' => 139.6380, 'attractions' => 'Minato Mirai, Chinatown, Sankeien Garden, Cup Noodles Museum', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Japan - Kansai Region (region_id=8)
            ['region_id' => 8, 'country_id' => 3, 'name' => 'Kyoto', 'slug' => 'kyoto', 'description' => 'Japan\'s ancient capital with over 2000 temples and shrines', 'latitude' => 35.0116, 'longitude' => 135.7681, 'attractions' => 'Fushimi Inari Shrine, Kinkaku-ji, Arashiyama Bamboo Grove, Kiyomizu-dera, Geisha District', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 8, 'country_id' => 3, 'name' => 'Osaka', 'slug' => 'osaka', 'description' => 'Japan\'s food capital with a vibrant street food culture', 'latitude' => 34.6937, 'longitude' => 135.5023, 'attractions' => 'Osaka Castle, Dotonbori, Universal Studios, Shinsaibashi Shopping', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Japan - Hokkaido (region_id=9)
            ['region_id' => 9, 'country_id' => 3, 'name' => 'Sapporo', 'slug' => 'sapporo', 'description' => 'Hokkaido\'s largest city known for skiing and beer', 'latitude' => 43.0618, 'longitude' => 141.3545, 'attractions' => 'Odori Park, Sapporo Snow Festival, Sapporo Beer Museum, Mount Moiwa', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Italy - Tuscany (region_id=10)
            ['region_id' => 10, 'country_id' => 4, 'name' => 'Florence', 'slug' => 'florence', 'description' => 'Renaissance birthplace with world-class art and architecture', 'latitude' => 43.7696, 'longitude' => 11.2558, 'attractions' => 'Duomo, Uffizi Gallery, Ponte Vecchio, Michelangelo\'s David, Boboli Gardens', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 10, 'country_id' => 4, 'name' => 'Siena', 'slug' => 'siena', 'description' => 'Medieval Tuscan city famous for its Palio horse race', 'latitude' => 43.3186, 'longitude' => 11.3306, 'attractions' => 'Piazza del Campo, Siena Cathedral, Torre del Mangia, Palio di Siena', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 10, 'country_id' => 4, 'name' => 'Pisa', 'slug' => 'pisa', 'description' => 'Home to the iconic Leaning Tower of Pisa', 'latitude' => 43.7228, 'longitude' => 10.4017, 'attractions' => 'Leaning Tower of Pisa, Piazza dei Miracoli, Pisa Cathedral', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Italy - Amalfi Coast (region_id=11)
            ['region_id' => 11, 'country_id' => 4, 'name' => 'Positano', 'slug' => 'positano', 'description' => 'Picturesque cliffside village on the Amalfi Coast', 'latitude' => 40.6282, 'longitude' => 14.4825, 'attractions' => 'Spiaggia Grande, Positano Cathedral, Path of the Gods, Li Galli Islands', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 11, 'country_id' => 4, 'name' => 'Amalfi', 'slug' => 'amalfi', 'description' => 'Historic maritime republic with stunning coastal views', 'latitude' => 40.6340, 'longitude' => 14.6026, 'attractions' => 'Amalfi Cathedral, Chiostro del Paradiso, Valle delle Ferriere', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Italy - Sicily (region_id=12)
            ['region_id' => 12, 'country_id' => 4, 'name' => 'Palermo', 'slug' => 'palermo', 'description' => 'Sicily\'s vibrant capital with layers of history', 'latitude' => 38.1157, 'longitude' => 13.3615, 'attractions' => 'Palermo Cathedral, Teatro Massimo, Ballarò Market, Palatine Chapel', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Kenya - Nairobi Region (region_id=13)
            ['region_id' => 13, 'country_id' => 5, 'name' => 'Nairobi', 'slug' => 'nairobi', 'description' => 'Kenya\'s bustling capital city', 'latitude' => -1.2921, 'longitude' => 36.8219, 'attractions' => 'Nairobi National Park, David Sheldrick Elephant Orphanage, Giraffe Centre, Karen Blixen Museum', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Kenya - Masai Mara (region_id=14)
            ['region_id' => 14, 'country_id' => 5, 'name' => 'Masai Mara', 'slug' => 'masai-mara', 'description' => 'World-famous wildlife reserve', 'latitude' => -1.4833, 'longitude' => 35.0000, 'attractions' => 'Mara River, Great Migration, Big Five Safari, Maasai Villages', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Kenya - Coast Region (region_id=15)
            ['region_id' => 15, 'country_id' => 5, 'name' => 'Mombasa', 'slug' => 'mombasa', 'description' => 'Historic coastal city with beautiful beaches', 'latitude' => -4.0435, 'longitude' => 39.6682, 'attractions' => 'Fort Jesus, Diani Beach, Old Town, Haller Park, Mtwapa Creek', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Peru - Cusco Region (region_id=16)
            ['region_id' => 16, 'country_id' => 6, 'name' => 'Cusco', 'slug' => 'cusco', 'description' => 'Ancient Inca capital and UNESCO World Heritage site', 'latitude' => -13.5320, 'longitude' => -71.9675, 'attractions' => 'Sacsayhuaman, Plaza de Armas, San Pedro Market, Inca Trail starting point', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 16, 'country_id' => 6, 'name' => 'Machu Picchu Pueblo', 'slug' => 'machu-picchu-pueblo', 'description' => 'Town at the base of Machu Picchu', 'latitude' => -13.1548, 'longitude' => -72.5233, 'attractions' => 'Machu Picchu, Huayna Picchu, Sun Gate, Temple of the Sun', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Peru - Lima Region (region_id=17)
            ['region_id' => 17, 'country_id' => 6, 'name' => 'Lima', 'slug' => 'lima', 'description' => 'Peru\'s capital with world-class cuisine', 'latitude' => -12.0464, 'longitude' => -77.0428, 'attractions' => 'Plaza Mayor, Larco Museum, Miraflores, Barranco, Huaca Pucllana', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Peru - Amazon Basin (region_id=18)
            ['region_id' => 18, 'country_id' => 6, 'name' => 'Iquitos', 'slug' => 'iquitos', 'description' => 'Gateway to the Peruvian Amazon', 'latitude' => -3.7491, 'longitude' => -73.2538, 'attractions' => 'Amazon River, Pacaya Samiria Reserve, Manatee Rescue Center, Belen Market', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Australia - New South Wales (region_id=19)
            ['region_id' => 19, 'country_id' => 7, 'name' => 'Sydney', 'slug' => 'sydney', 'description' => 'Australia\'s iconic harbour city', 'latitude' => -33.8688, 'longitude' => 151.2093, 'attractions' => 'Sydney Opera House, Harbour Bridge, Bondi Beach, Taronga Zoo, The Rocks', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Australia - Queensland (region_id=20)
            ['region_id' => 20, 'country_id' => 7, 'name' => 'Cairns', 'slug' => 'cairns', 'description' => 'Gateway to the Great Barrier Reef', 'latitude' => -16.9186, 'longitude' => 145.7781, 'attractions' => 'Great Barrier Reef, Daintree Rainforest, Kuranda Railway, Skyrail Cableway', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Australia - Victoria (region_id=21)
            ['region_id' => 21, 'country_id' => 7, 'name' => 'Melbourne', 'slug' => 'melbourne', 'description' => 'Australia\'s cultural capital with great food and art', 'latitude' => -37.8136, 'longitude' => 144.9631, 'attractions' => 'Federation Square, Great Ocean Road, Yarra Valley, Queen Victoria Market', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // UAE - Dubai (region_id=22)
            ['region_id' => 22, 'country_id' => 8, 'name' => 'Dubai', 'slug' => 'dubai', 'description' => 'Ultramodern city of architectural wonders', 'latitude' => 25.2048, 'longitude' => 55.2708, 'attractions' => 'Burj Khalifa, Palm Jumeirah, Dubai Mall, Burj Al Arab, Desert Safari', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // UAE - Abu Dhabi (region_id=23)
            ['region_id' => 23, 'country_id' => 8, 'name' => 'Abu Dhabi', 'slug' => 'abu-dhabi', 'description' => 'The UAE capital with culture and luxury', 'latitude' => 24.4539, 'longitude' => 54.3773, 'attractions' => 'Sheikh Zayed Grand Mosque, Louvre Abu Dhabi, Ferrari World, Yas Island', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // UAE - Sharjah (region_id=24)
            ['region_id' => 24, 'country_id' => 8, 'name' => 'Sharjah', 'slug' => 'sharjah', 'description' => 'Cultural hub of the UAE', 'latitude' => 25.3463, 'longitude' => 55.4209, 'attractions' => 'Sharjah Art Museum, Al Noor Mosque, Sharjah Aquarium, Blue Souk', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Morocco - Marrakech (region_id=25)
            ['region_id' => 25, 'country_id' => 9, 'name' => 'Marrakech', 'slug' => 'marrakech', 'description' => 'The Red City with vibrant souks and palaces', 'latitude' => 31.6295, 'longitude' => -7.9811, 'attractions' => 'Jemaa el-Fnaa, Bahia Palace, Majorelle Garden, Koutoubia Mosque, Souk markets', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Morocco - Fes (region_id=26)
            ['region_id' => 26, 'country_id' => 9, 'name' => 'Fes', 'slug' => 'fes', 'description' => 'Ancient imperial city with the oldest university', 'latitude' => 34.0181, 'longitude' => -5.0000, 'attractions' => 'Fes el-Bali, Al Quaraouiyine University, Chouara Tannery, Bou Inania Madrasa', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Morocco - Chefchaouen (region_id=27)
            ['region_id' => 27, 'country_id' => 9, 'name' => 'Chefchaouen', 'slug' => 'chefchaouen', 'description' => 'The famous blue-washed mountain city', 'latitude' => 35.1688, 'longitude' => -5.2636, 'attractions' => 'Blue Medina, Spanish Mosque, Ras El Ma waterfall, Outa el Hammam Square', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Iceland - Reykjavik Area (region_id=28)
            ['region_id' => 28, 'country_id' => 10, 'name' => 'Reykjavik', 'slug' => 'reykjavik', 'description' => 'World\'s northernmost capital city', 'latitude' => 64.1466, 'longitude' => -21.9426, 'attractions' => 'Hallgrímskirkja, Blue Lagoon, Harpa Concert Hall, Perlan, Old Harbour', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 28, 'country_id' => 10, 'name' => 'Keflavik', 'slug' => 'keflavik', 'description' => 'International gateway to Iceland', 'latitude' => 64.0072, 'longitude' => -22.5710, 'attractions' => 'Keflavik International Airport, Viking World Museum, Bridge Between Continents', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Iceland - South Coast (region_id=29)
            ['region_id' => 29, 'country_id' => 10, 'name' => 'Vik', 'slug' => 'vik', 'description' => 'Iceland\'s southernmost village with black sand beaches', 'latitude' => 63.4190, 'longitude' => -19.0098, 'attractions' => 'Reynisfjara Black Sand Beach, Dyrhólaey, Skógafoss, Seljalandsfoss, Solheimasandur', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Iceland - Golden Circle (region_id=30)
            ['region_id' => 30, 'country_id' => 10, 'name' => 'Thingvellir', 'slug' => 'thingvellir', 'description' => 'National park with historical and geological significance', 'latitude' => 64.2554, 'longitude' => -21.1293, 'attractions' => 'Thingvellir National Park, Silfra Fissure, Almannagjá Gorge, Oxarárfoss', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['region_id' => 30, 'country_id' => 10, 'name' => 'Geysir', 'slug' => 'geysir', 'description' => 'Home to the famous Geysir hot spring', 'latitude' => 64.3167, 'longitude' => -20.3000, 'attractions' => 'Geysir Hot Springs, Strokkur, Gullfoss Waterfall, Laugarvatn Fontana', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('cities')->insert($cities);
    }
}
