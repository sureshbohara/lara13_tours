<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title'              => 'Homestay Booking',
                'subtitle'           => 'Experience Authentic Nepali Living',
                'icon'               => 'bi-house-heart',
                'short_content'      => 'Stay with local families and experience genuine Nepali hospitality in traditional homes across the country.',
                'long_content'       => '<p>Our homestay service connects you with verified local families throughout Nepal. Each homestay is carefully selected to ensure comfort, safety, and authentic cultural experiences.</p><p>Enjoy traditional Nepali meals, participate in daily activities, and learn about local customs firsthand. Our hosts are experienced in welcoming international travelers while maintaining their traditional way of life.</p>',
                'slug'               => 'homestay-booking',
                'image'              => null,
                'feature_image'      => null,
              
                'process_item'       => [
                    ['icon' => 'fa-solid fa-search', 'title' => 'Browse Properties', 'content' => 'Explore our curated list of verified homestays across Nepal'],
                    ['icon' => 'fa-solid fa-calendar-check', 'title' => 'Select Dates', 'content' => 'Choose your preferred dates and check availability'],
                    ['icon' => 'fa-solid fa-credit-card', 'title' => 'Secure Booking', 'content' => 'Complete your booking with our secure payment system'],
                    ['icon' => 'fa-solid fa-handshake', 'title' => 'Enjoy Your Stay', 'content' => 'Experience authentic Nepali hospitality'],
                ],
                'highlight'          => [
                    'Verified local families',
                    'Authentic cultural experience',
                    'Traditional Nepali meals included',
                    '24/7 support available',
                ],
                'order_level'        => 1,
                'status'             => true,
                'meta_keywords'      => 'homestay nepal, local stay, cultural experience, authentic nepal',
                'meta_description'   => 'Book authentic homestays across Nepal. Experience genuine Nepali hospitality with verified local families.',
            ],
            [
                'title'              => 'Trekking Packages',
                'subtitle'           => 'Explore the Himalayas',
                'icon'               => 'bi-signpost-split',
                'short_content'      => 'Guided trekking adventures through the world\'s most spectacular mountain landscapes.',
                'long_content'       => '<p>Discover the majesty of the Himalayas with our expert-guided trekking packages. From the famous Everest Base Camp trek to the lesser-known but equally stunning routes, we have something for every adventure seeker.</p><p>All our treks include experienced guides, porters, necessary permits, and quality accommodation along the route.</p>',
                'slug'               => 'trekking-packages',
                'image'              => null,
                'feature_image'      => null,
          
                'process_item'       => [
                    ['icon' => 'fa-solid fa-map-location-dot', 'title' => 'Choose Your Trek', 'content' => 'Select from our range of trekking packages'],
                    ['icon' => 'fa-solid fa-user-check', 'title' => 'Fitness Assessment', 'content' => 'We ensure you\'re prepared for the journey'],
                    ['icon' => 'fa-solid fa-backpack', 'title' => 'Gear Preparation', 'content' => 'Get expert advice on necessary equipment'],
                    ['icon' => 'fa-solid fa-mountain', 'title' => 'Begin Adventure', 'content' => 'Start your unforgettable trekking experience'],
                ],
                'highlight'          => [
                    'Expert local guides',
                    'All permits included',
                    'Quality accommodation',
                    'Emergency support',
                ],
                'order_level'        => 2,
                'status'             => true,
                'meta_keywords'      => 'trekking nepal, himalaya trek, everest base camp, adventure',
                'meta_description'   => 'Expert-guided trekking packages in the Himalayas. From Everest Base Camp to Annapurna Circuit.',
            ],
            [
                'title'              => 'Airport Transfers',
                'subtitle'           => 'Comfortable & Reliable',
                'icon'               => 'bi-airplane',
                'short_content'      => 'Hassle-free airport pickup and drop-off services with professional drivers.',
                'long_content'       => '<p>Start and end your journey smoothly with our reliable airport transfer service. Our professional drivers will be waiting for you at Tribhuvan International Airport with a name board.</p><p>We offer 24/7 service, flight tracking, and comfortable vehicles for individuals and groups of all sizes.</p>',
                'slug'               => 'airport-transfers',
                'image'              => null,
                'feature_image'      => null,
           
                'process_item'       => [
                    ['icon' => 'fa-solid fa-phone', 'title' => 'Book Online', 'content' => 'Reserve your transfer in advance'],
                    ['icon' => 'fa-solid fa-plane-arrival', 'title' => 'Flight Tracking', 'content' => 'We monitor your flight status'],
                    ['icon' => 'fa-solid fa-car', 'title' => 'Meet & Greet', 'content' => 'Driver awaits with name board'],
                    ['icon' => 'fa-solid fa-house', 'title' => 'Safe Arrival', 'content' => 'Comfortable ride to your destination'],
                ],
                'highlight'          => [
                    '24/7 availability',
                    'Flight monitoring',
                    'Professional drivers',
                    'Air-conditioned vehicles',
                ],
                'order_level'        => 3,
                'status'             => true,
                'meta_keywords'      => 'airport transfer nepal, kathmandu pickup, taxi service',
                'meta_description'   => 'Reliable airport transfer service in Kathmandu. Professional drivers, 24/7 availability, comfortable vehicles.',
            ],
            [
                'title'              => 'Tour Guide Services',
                'subtitle'           => 'Expert Local Knowledge',
                'icon'               => 'bi-people',
                'short_content'      => 'Professional licensed guides who bring Nepal\'s history and culture to life.',
                'long_content'       => '<p>Our certified tour guides are passionate about sharing Nepal\'s rich heritage with visitors. Fluent in multiple languages and trained in history, culture, and hospitality, they ensure you get the most out of your visit.</p><p>Available for city tours, heritage site visits, and custom itineraries.</p>',
                'slug'               => 'tour-guide-services',
                'image'              => null,
                'feature_image'      => null,

                'process_item'       => [
                    ['icon' => 'fa-solid fa-comments', 'title' => 'Consultation', 'content' => 'Discuss your interests and preferences'],
                    ['icon' => 'fa-solid fa-user-tie', 'title' => 'Guide Assignment', 'content' => 'Matched with the perfect guide'],
                    ['icon' => 'fa-solid fa-route', 'title' => 'Custom Itinerary', 'content' => 'Tailored to your schedule'],
                    ['icon' => 'fa-solid fa-camera', 'title' => 'Memorable Experience', 'content' => 'Unforgettable guided tours'],
                ],
                'highlight'          => [
                    'Licensed professionals',
                    'Multi-lingual guides',
                    'Custom itineraries',
                    'Cultural insights',
                ],
                'order_level'        => 4,
                'status'             => true,
                'meta_keywords'      => 'tour guide nepal, kathmandu guide, cultural tours',
                'meta_description'   => 'Professional licensed tour guides in Nepal. Expert local knowledge, multi-lingual, custom itineraries.',
            ],
            [
                'title'              => 'Vehicle Rental',
                'subtitle'           => 'Cars, Bikes & SUVs',
                'icon'               => 'bi-car-front',
                'short_content'      => 'Wide range of well-maintained vehicles for your travel needs across Nepal.',
                'long_content'       => '<p>Explore Nepal at your own pace with our vehicle rental service. From compact cars for city driving to rugged SUVs for mountain roads, we have the perfect vehicle for your journey.</p><p>All vehicles come with comprehensive insurance, 24/7 roadside assistance, and optional driver service.</p>',
                'slug'               => 'vehicle-rental',
                'image'              => null,
                'feature_image'      => null,
    
                'process_item'       => [
                    ['icon' => 'fa-solid fa-car-side', 'title' => 'Choose Vehicle', 'content' => 'Select from our diverse fleet'],
                    ['icon' => 'fa-solid fa-file-contract', 'title' => 'Documentation', 'content' => 'Quick and easy paperwork'],
                    ['icon' => 'fa-solid fa-key', 'title' => 'Get Keys', 'content' => 'Pick up your vehicle'],
                    ['icon' => 'fa-solid fa-road', 'title' => 'Hit the Road', 'content' => 'Start your journey'],
                ],
                'highlight'          => [
                    'Wide vehicle selection',
                    'Comprehensive insurance',
                    '24/7 roadside assistance',
                    'Optional driver service',
                ],
                'order_level'        => 5,
                'status'             => true,
                'meta_keywords'      => 'car rental nepal, vehicle hire, suv rental kathmandu',
                'meta_description'   => 'Rent cars, bikes, and SUVs in Nepal. Well-maintained vehicles with insurance and optional driver service.',
            ],
            [
                'title'              => 'Cultural Programs',
                'subtitle'           => 'Experience Nepali Traditions',
                'icon'               => 'bi-music-note-beamed',
                'short_content'      => 'Immerse yourself in traditional Nepali music, dance, and cultural performances.',
                'long_content'       => '<p>Experience the vibrant culture of Nepal through our curated cultural programs. From traditional Newari dance performances to cooking classes and pottery workshops, discover the richness of Nepali heritage.</p><p>Perfect for groups, families, and cultural enthusiasts looking for authentic experiences.</p>',
                'slug'               => 'cultural-programs',
                'image'              => null,
                'feature_image'      => null,
         
                'process_item'       => [
                    ['icon' => 'fa-solid fa-palette', 'title' => 'Choose Program', 'content' => 'Select from various cultural activities'],
                    ['icon' => 'fa-solid fa-calendar', 'title' => 'Schedule', 'content' => 'Pick your preferred date and time'],
                    ['icon' => 'fa-solid fa-users', 'title' => 'Group Size', 'content' => 'Suitable for individuals to large groups'],
                    ['icon' => 'fa-solid fa-heart', 'title' => 'Cultural Immersion', 'content' => 'Experience authentic traditions'],
                ],
                'highlight'          => [
                    'Traditional performances',
                    'Cooking classes',
                    'Craft workshops',
                    'Custom programs available',
                ],
                'order_level'        => 6,
                'status'             => true,
                'meta_keywords'      => 'cultural programs nepal, traditional dance, nepali cooking class',
                'meta_description'   => 'Authentic Nepali cultural programs. Traditional dance, cooking classes, and craft workshops.',
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }

        $this->command->info('✓ Services seeded successfully!');
    }
}