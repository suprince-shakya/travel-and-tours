<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'content' => "Welcome to Travels & Tours, your trusted partner in creating unforgettable travel experiences. Founded in 2015, we have grown from a small local operator in Kathmandu to an international tour company serving thousands of happy travelers every year.\n\nOur Mission: To provide authentic, sustainable, and life-changing travel experiences that connect people with cultures, nature, and themselves.\n\nOur Vision: To be the most trusted tour operator in Asia, known for exceptional service, responsible tourism, and unforgettable adventures.\n\nOur Values:\n- Safety First: Every decision prioritizes our guests' safety and well-being.\n- Cultural Respect: We promote responsible tourism that respects local communities and traditions.\n- Environmental Stewardship: We minimize our environmental footprint through sustainable practices.\n- Excellence: We strive for the highest standards in every aspect of our service.\n\nOur Team: Our team consists of experienced travel professionals, licensed guides, and passionate adventurers. From our office staff to our field guides, every team member shares a deep love for travel and a commitment to excellence.\n\nOur guides are certified professionals with years of experience in their respective regions. They undergo regular training in first aid, safety protocols, and cultural interpretation to ensure you receive the highest quality experience.\n\nSustainability: We are committed to responsible tourism. We partner with local communities, support conservation projects, offset our carbon emissions, and practice Leave No Trace principles on all our tours.\n\nJoin us on your next adventure and discover why thousands of travelers choose Travels & Tours!",
                'excerpt' => 'Learn about Travels & Tours - our mission, values, team, and commitment to sustainable travel.',
                'featured_image' => 'https://picsum.photos/seed/about+us/1200/600',
                'meta_title' => 'About Travels & Tours | Our Story and Team',
                'meta_description' => 'Learn about Travels & Tours - our mission to provide authentic travel experiences, our expert team, and commitment to sustainable tourism.',
                'meta_keywords' => 'about us, travel company, tour operator, our team, sustainable travel',
                'status' => 1,
                'order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'content' => "Last Updated: January 1, 2025\n\nAt Travels & Tours, we take your privacy seriously. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website or use our services.\n\nInformation We Collect:\n- Personal Identification Information: Name, email address, phone number, passport details, and billing information.\n- Booking Information: Travel preferences, special requirements, emergency contacts, and travel history.\n- Technical Data: IP address, browser type, device information, and cookies.\n\nHow We Use Your Information:\n- To process and manage your bookings\n- To communicate with you about your trip\n- To improve our services and website\n- To send promotional offers (with your consent)\n- To comply with legal obligations\n\nData Protection:\nWe implement appropriate security measures including SSL encryption, secure servers, and access controls to protect your personal information. Your data is stored securely and only accessible to authorized personnel.\n\nThird-Party Sharing:\nWe may share your information with:\n- Hotels, airlines, and local operators necessary for your booking\n- Payment processors for secure transactions\n- Government authorities as required by law\n\nWe never sell your personal information to third parties.\n\nCookies:\nOur website uses cookies to enhance your browsing experience. You can control cookie settings through your browser preferences.\n\nYour Rights:\nYou have the right to:\n- Access your personal data\n- Request correction of inaccurate data\n- Request deletion of your data\n- Withdraw consent for marketing communications\n- Data portability\n\nContact Us:\nFor privacy-related inquiries, contact us at privacy@travels.com or write to us at 123 Travel Street, Kathmandu, Nepal.\n\nChanges to This Policy:\nWe may update this policy periodically. Changes will be posted on this page with an updated revision date.",
                'excerpt' => 'Our commitment to protecting your privacy and how we handle your personal information.',
                'featured_image' => null,
                'meta_title' => 'Privacy Policy | Travels & Tours',
                'meta_description' => 'Read our privacy policy to understand how Travels & Tours collects, uses, and protects your personal information.',
                'meta_keywords' => 'privacy policy, data protection, personal information, cookies',
                'status' => 1,
                'order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Terms & Conditions',
                'slug' => 'terms-conditions',
                'content' => "Last Updated: January 1, 2025\n\nPlease read these Terms & Conditions carefully before booking any tour with Travels & Tours.\n\nBooking and Payment:\n- A deposit of 30% is required to confirm your booking. Full payment is due 30 days before departure.\n- For bookings made within 30 days of departure, full payment is required at the time of booking.\n- Prices are quoted in USD and are subject to change until the booking is confirmed.\n- All payments are processed securely through our payment gateway.\n\nCancellation Policy:\n- Free cancellation: Up to 30 days before departure (varies by tour - see specific tour page).\n- 50% refund: 15-30 days before departure.\n- No refund: Less than 15 days before departure.\n- Some adventure tours have different cancellation windows - please check individual tour terms.\n\nChanges and Amendments:\n- We reserve the right to alter itineraries due to weather, political conditions, or safety concerns.\n- Significant changes will be communicated promptly, and alternative arrangements will be offered.\n- If we cancel a tour, you will receive a full refund or credit for a future tour.\n\nTravel Insurance:\n- Comprehensive travel insurance is mandatory for all tours.\n- Insurance must cover medical expenses, emergency evacuation, trip cancellation, and personal liability.\n\nHealth and Fitness:\n- You must be in appropriate physical condition for the tour you select.\n- Pre-existing medical conditions must be disclosed at the time of booking.\n- We reserve the right to refuse participation if a guest is deemed unfit for safety reasons.\n\nPassports and Visas:\n- You are responsible for ensuring your passport is valid (minimum 6 months from travel date).\n- You are responsible for obtaining necessary visas for your destination.\n\nLiability:\n- Travels & Tours acts as an agent for various service providers and cannot be held liable for issues arising from third-party services.\n- We are not responsible for loss, damage, or theft of personal belongings.\n- Participants join tours at their own risk.\n\nConduct:\n- We reserve the right to remove any participant whose behavior disrupts the group or endangers others.\n- No refund will be given for removal due to misconduct.\n\nComplaints:\n- Any complaints should be reported to your guide immediately.\n- Formal complaints can be submitted in writing within 14 days of tour completion.\n\nBy booking with Travels & Tours, you acknowledge that you have read, understood, and agree to these Terms & Conditions.",
                'excerpt' => 'Our terms and conditions for booking tours, cancellation policies, and guest responsibilities.',
                'featured_image' => null,
                'meta_title' => 'Terms & Conditions | Travels & Tours',
                'meta_description' => 'Read the terms and conditions for booking tours with Travels & Tours including cancellation policies and guest responsibilities.',
                'meta_keywords' => 'terms and conditions, booking policy, cancellation, travel terms',
                'status' => 1,
                'order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Careers',
                'slug' => 'careers',
                'content' => "Join the Travels & Tours Team!\n\nAre you passionate about travel and dedicated to providing exceptional experiences? Travels & Tours is always looking for talented individuals to join our growing team.\n\nWhy Work With Us:\n- Dynamic, multicultural work environment\n- Opportunity to travel and explore new destinations\n- Competitive salary and benefits package\n- Professional development and training programs\n- Staff discounts on tours\n- flexible working arrangements\n\nCurrent Openings:\n\n1. Tour Guide (Multiple Locations)\n- Requirements: 3+ years guiding experience, multilingual, first aid certified, deep knowledge of local culture and history\n- Locations: Nepal, Thailand, Japan, Kenya, Peru\n\n2. Travel Consultant (Kathmandu Office)\n- Requirements: 2+ years in travel industry, excellent communication skills, booking system experience, destination knowledge\n- Languages: English + additional language preferred\n\n3. Marketing Coordinator (Kathmandu Office)\n- Requirements: Degree in Marketing or related field, social media expertise, content creation skills, SEO knowledge\n\n4. Operations Manager (Kathmandu Office)\n- Requirements: 5+ years travel industry experience, team management, vendor relations, logistics coordination\n\n5. Customer Support Specialist (Remote)\n- Requirements: Excellent English communication, problem-solving skills, travel industry experience preferred, ability to work in shifts\n\nHow to Apply:\nSend your CV and cover letter to careers@travels.com with the subject line: [Position Name] Application - [Your Name]\n\nWe celebrate diversity and are committed to creating an inclusive environment for all employees. Travels & Tours is an equal opportunity employer.\n\nDue to the high volume of applications, only shortlisted candidates will be contacted. Thank you for your interest in joining our team!",
                'excerpt' => 'Join our team! Explore career opportunities at Travels & Tours and help us create amazing travel experiences.',
                'featured_image' => 'https://picsum.photos/seed/careers/1200/600',
                'meta_title' => 'Careers at Travels & Tours | Join Our Team',
                'meta_description' => 'Explore career opportunities at Travels & Tours. We are hiring tour guides, travel consultants, marketers, and more.',
                'meta_keywords' => 'careers, jobs, tour guide jobs, travel jobs, join our team',
                'status' => 1,
                'order' => 4,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('pages')->insert($pages);

        DB::table('pages')->insert([
            'title' => 'Frequently Asked Questions',
            'slug' => 'faq',
            'content' => "Have questions? We've got answers! Below are some of the most frequently asked questions about our tours and services.\n\n1. How do I book a tour?\nYou can book directly through our website by selecting your desired tour and following the booking steps. You'll need to create an account or log in to complete your booking.\n\n2. What payment methods do you accept?\nWe accept major credit cards (Visa, MasterCard, Amex), PayPal, bank transfers, and cash payments at our office.\n\n3. Can I customize a tour?\nYes! Many of our tours can be customized to suit your preferences. Contact us with your requirements and we'll create a personalized itinerary.\n\n4. What is your cancellation policy?\nCancellation policies vary by tour. Generally, free cancellation is available up to 30 days before departure. Please check the specific tour page for details.\n\n5. Do I need travel insurance?\nYes, comprehensive travel insurance is mandatory for all our tours. It must cover medical expenses, emergency evacuation, trip cancellation, and personal liability.\n\n6. What should I pack?\nPacking lists vary by destination and season. We provide a detailed packing guide after booking. Generally, comfortable clothing, sturdy walking shoes, sun protection, and a reusable water bottle are recommended.\n\n7. Are your tours suitable for solo travelers?\nAbsolutely! Many of our guests travel solo. We offer single supplements and can help connect you with other solo travelers if desired.\n\n8. What is the group size?\nGroup sizes vary by tour. Our standard tours have 8-16 people, while private tours can be arranged for any group size.\n\n9. Do you offer airport transfers?\nYes, airport transfers are included in most of our tour packages. Details will be provided in your booking confirmation.\n\n10. How do I contact you in an emergency?\nOur 24/7 emergency hotline number is provided in your booking confirmation. You can also reach us via email at emergency@travels.com.\n\nStill have questions? Feel free to contact us!",
            'excerpt' => 'Find answers to frequently asked questions about booking, payments, cancellations, and more.',
            'featured_image' => null,
            'meta_title' => 'FAQ | Travels & Tours',
            'meta_description' => 'Find answers to frequently asked questions about booking tours, payments, cancellations, and travel with Travels & Tours.',
            'meta_keywords' => 'faq, frequently asked questions, travel faq, booking questions',
            'status' => 1,
            'order' => 5,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
