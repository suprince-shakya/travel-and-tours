<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $faqs = [
            // Booking
            ['category' => 'Booking', 'question' => 'How do I book a tour?', 'answer' => 'You can book a tour directly through our website by selecting your desired tour and dates, then completing the online booking form. Alternatively, you can call our booking team at +977-1-4XXXXXX or email us at info@travels.com. We accept bookings up to 24 hours before departure for most tours, subject to availability.', 'order' => 1, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Booking', 'question' => 'Can I modify or cancel my booking?', 'answer' => 'Yes, modifications and cancellations are possible depending on the tour\'s cancellation policy. Most tours offer free cancellation within a certain period before departure. Please refer to the specific tour\'s cancellation policy on its page or contact our support team for assistance with changes.', 'order' => 2, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Booking', 'question' => 'What documents do I need to book?', 'answer' => 'You will need a valid passport (with at least 6 months validity from travel date), any required visas for your destination, and travel insurance details. For some adventure tours, we may also require a medical clearance form. All documents can be uploaded through your booking portal.', 'order' => 3, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Payment
            ['category' => 'Payment', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept major credit cards (Visa, Mastercard, American Express), PayPal, bank transfers, and mobile payment systems. For group bookings, we also offer installment payment plans. Full payment is required at least 30 days before departure for most tours.', 'order' => 4, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Payment', 'question' => 'Is my payment information secure?', 'answer' => 'Absolutely. We use industry-standard SSL encryption to protect all payment transactions. We are PCI-DSS compliant and never store your full credit card details on our servers. Your financial security is our top priority.', 'order' => 5, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Payment', 'question' => 'Do you offer refunds if a tour is cancelled?', 'answer' => 'If we cancel a tour due to insufficient participants, weather conditions, or safety concerns, you will receive a full refund or the option to transfer to another tour. If you cancel voluntarily, the refund amount depends on how far in advance you cancel as outlined in our cancellation policy.', 'order' => 6, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Tours
            ['category' => 'Tours', 'question' => 'What is the typical group size?', 'answer' => 'Group sizes vary by tour. Our standard cultural tours typically have 10-15 participants, while adventure treks are limited to 6-12 people for safety and quality. Luxury tours are kept to small groups of 2-8. We believe smaller groups provide a more personalized experience.', 'order' => 7, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Tours', 'question' => 'Are your tours suitable for solo travelers?', 'answer' => 'Yes! Many of our guests travel solo. We offer single room options at an additional cost, or you can share with another solo traveler of the same gender at no extra charge. Solo travelers often find our group tours are a great way to meet like-minded people from around the world.', 'order' => 8, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Tours', 'question' => 'What fitness level is required for trekking tours?', 'answer' => 'Fitness requirements vary by trek difficulty. Easy treks require no specific fitness level. Moderate treks require reasonable fitness with 4-6 hours of daily walking. Challenging treks require good fitness with uphill hiking at altitude. Each tour page specifies the required fitness level. We recommend consulting your doctor before booking.', 'order' => 9, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Tours', 'question' => 'Do you provide airport transfers?', 'answer' => 'Yes, airport transfers are included for most of our tours. Our representative will meet you at the airport holding a sign with your name and our company logo. Please provide your flight details at least 72 hours before arrival to ensure smooth coordination.', 'order' => 10, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            // Travel
            ['category' => 'Travel', 'question' => 'What should I pack for my tour?', 'answer' => 'Packing lists vary by destination and tour type. Each tour page includes a detailed packing list. Generally, we recommend comfortable walking shoes, weather-appropriate clothing, sunscreen, insect repellent, a reusable water bottle, and any personal medications. Specific gear requirements (like trekking boots or thermal layers) are listed on individual tour pages.', 'order' => 11, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['category' => 'Travel', 'question' => 'Do I need travel insurance?', 'answer' => 'Yes, travel insurance is mandatory for all our tours, especially adventure and trekking packages. Your insurance should cover medical expenses, emergency evacuation, trip cancellation, and personal belongings. We require proof of insurance before departure for certain adventure tours for your safety.', 'order' => 12, 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ];

        DB::table('faqs')->insert($faqs);
    }
}
