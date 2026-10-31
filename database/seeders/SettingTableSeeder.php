<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    public function run(): void
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                // ==========================================
                // 1. General Info 
                // ==========================================
                'system_name'       => 'SP Travel and Tours',
                'email'             => 'info@sptravel.com',
                'extra_email'       => 'booking@sptravel.com',
                'phone'             => '+977-1-4XXXXXX',
                'extra_phone'       => '+977-98XXXXXXXX',
                'address'           => 'Bansbari, Chowk, Nagarjun, Kathmandu, Nepal',
                'opening_hr'        => 'Sun - Fri: 9:00 AM - 6:00 PM',
                'work_hours'        => 'Your gateway to authentic Nepali hospitality and Himalayan adventures.',
                'google_map'        => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0284987496536!2d85.32405831506056!3d27.717245933190117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19a8b5b88e43%3A0x6d64b8f8b8b8b8b8!2sKathmandu!5e0!3m2!1sen!2snp!4v1620000000000',
                'footer_copyright'  => '© ' . date('Y') . ' SP Travel and Tours. All Rights Reserved.',

                // ==========================================
                // 2. Social Links
                // ==========================================
                'facebook'  => 'https://facebook.com/sptravel',
                'twitter'   => 'https://twitter.com/sptravel',
                'linkedin'  => 'https://linkedin.com/company/sptravel',
                'instagram' => 'https://instagram.com/sptravel',
                'youtube'   => 'https://youtube.com/@sptravel',
                'google'    => null,
                'yelp'      => null,

                // ==========================================
                // 3. Media
                // ==========================================
                'logo'               => null,
                'favicon'            => null,
                'loader'             => null,
                'footer_gateway_img' => null,
                'bg_image'           => null,
                'breadcrumb'         => null,
                'image1'             => null,
                'image2'             => null,

                // ==========================================
                // 4. SEO Meta Data
                // ==========================================
                'meta_author'      => 'SP Travel and Tours',
                'meta_title'       => 'SP Travel | Premium Trekking, Tours & Expeditions in Nepal',
                'meta_keywords'    => 'nepal trekking, everest base camp, annapurna circuit, nepal travel agency, himalayan expeditions, chitwan safari',
                'meta_description' => 'Discover authentic Nepali hospitality with SP Travel and Tours. Book premium treks, cultural tours, jungle safaris, and mountain expeditions across Nepal.',

                // ==========================================
                // 5. Info Texts 
                // ==========================================
                'info1' => '<p>With over <strong>19 years of experience</strong> in the travel industry, SP Travel and Tours has established itself as a premier destination for exploring Nepal and beyond. Our expert team of local guides and travel specialists are dedicated to crafting personalized journeys that exceed your expectations.</p>
                            <p>From the towering peaks of the Himalayas to the lush jungles of Chitwan, we offer authentic experiences that connect you with the rich culture, breathtaking landscapes, and warm hospitality of Nepal. Whether you are seeking a challenging high-altitude expedition or a relaxing cultural tour, we have the perfect itinerary for you.</p>
                            <p>We are deeply committed to <strong>sustainable and responsible tourism</strong>. By empowering local communities and ensuring the highest safety standards, we guarantee that your adventure is not only unforgettable but also leaves a positive impact on the beautiful destinations we explore together.</p>',
                
                'info2' => 'Founded in Kathmandu, SP Travel is dedicated to connecting travelers with unforgettable Himalayan adventures, breathtaking landscapes, and genuine local experiences.',
                'info3' => 'Our mission is to empower local communities by providing sustainable tourism experiences, making authentic Nepali adventures accessible to travelers from around the world.',
                'info4' => 'Your gateway to authentic Nepali hospitality. Find your perfect mountain trek, cultural tour, jungle safari, or adventure expedition.',
                'info5' => 'Secure Online Payments',
                'info6' => '24/7 Local Support',
                'info7' => 'Best Price Guarantee',

                // ==========================================
                // 6. SMTP / Mail Configuration
                // ==========================================
                'mail_transport' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_username' => 'ezbooking42@gmail.com',
                'mail_password' => 'uqxr fnvu uznf zisi',
                'mail_encryption' => 'tls',
                'mail_from' => 'noreply@sptravel.com',
                'mail_from_name' => 'SP Travel and Tours',
                'smtp_check' => true,

                // ==========================================
                // 7-10. Security & Analytics 
                // ==========================================
                'recaptcha_site_key'   => '',
                'recaptcha_secret_key' => '',
                'is_recaptcha'         => false,
                'google_analytic_id'   => '',
                'facebook_analytic_id' => '',
                'google_client_id'     => '',
                'google_client_secret' => '',
                'google_redirect'      => '',
                'is_google'            => false,
                'facebook_client_id'     => '',
                'facebook_client_secret' => '',
                'facebook_redirect'      => '',
                'is_facebook'            => false,

                // ==========================================
                // 11. Process Section 
                // ==========================================
                'process_title'    => 'How We Work',
                'process_sub_title'=> 'Your journey to the Himalayas in 4 simple steps',
                'process_item'     => [
                    [
                        'icon'    => 'bi bi-chat-dots',
                        'title'   => 'Share Your Dreams',
                        'content' => 'Tell us about your preferred destinations, budget, and travel style.'
                    ],
                    [
                        'icon'    => 'bi bi-pencil-square',
                        'title'   => 'Custom Itinerary',
                        'content' => 'Our experts craft a personalized, day-by-day travel plan just for you.'
                    ],
                    [
                        'icon'    => 'bi bi-check-circle',
                        'title'   => 'Secure Booking',
                        'content' => 'Confirm your trip with our easy, transparent, and secure payment process.'
                    ],
                    [
                        'icon'    => 'bi bi-airplane-engines',
                        'title'   => 'Start Your Adventure',
                        'content' => 'Arrive in Nepal and let our local team handle the rest. Enjoy the journey!'
                    ]
                ],

                // ==========================================
                // 12. Work Section (USED FOR "Why Choose Us"
                // ==========================================
                'work_title'     => 'Why Choose SP Travel?',
                'work_sub_title' => 'From your first trek to a full expedition, we ensure everything is perfect.',
                'work_item'      => [
                    [
                        'icon'    => 'bi bi-people-fill', 
                        'title'   => 'Expert Local Guides',
                        'content' => 'Our certified and experienced local guides ensure your safety and provide deep insights into Nepal\'s rich culture and history.'
                    ],
                    [
                        'icon'    => 'bi bi-shield-check',
                        'title'   => 'Safety-Focused Planning',
                        'content' => 'Good mountain journeys begin long before reaching the trail. We carefully consider acclimatization, weather, logistics, and equipment.'
                    ],
                    [
                        'icon'    => 'bi bi-compass', 
                        'title'   => 'Tailor-Made Itineraries',
                        'content' => 'We customize every trip to match your pace, interests, and budget, ensuring a truly personalized Himalayan adventure.'
                    ],
                    [
                        'icon'    => 'bi bi-headset', 
                        'title'   => '24/7 Dedicated Support',
                        'content' => 'From the moment you book until you return home, our dedicated local team is always just a call or message away.'
                    ]
                ],

                // ==========================================
                // 13. Counter Section (Dynamic JSON)
                // ==========================================
                'counter_title'     => 'Our Achievements',
                'counter_sub_title' => 'Trusted by Travelers Across the Globe',
                'counter_item'      => [
                    [
                        'icon'    => 'bi bi-calendar-check',
                        'title'   => '19+',
                        'content' => 'Years of Experience'
                    ],
                    [
                        'icon'    => 'bi bi-people',
                        'title'   => '10K+',
                        'content' => 'Happy Travelers'
                    ],
                    [
                        'icon'    => 'bi bi-map',
                        'title'   => '50+',
                        'content' => 'Destinations Covered'
                    ],
                    [
                        'icon'    => 'bi bi-star-fill',
                        'title'   => '4.9',
                        'content' => 'Average Rating'
                    ]
                ],
            ]
        );

        $this->command->info('✓ Setting table seeded successfully for SP Travel!');
    }
}