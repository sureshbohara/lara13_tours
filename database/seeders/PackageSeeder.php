<?php

namespace Database\Seeders;

use App\Models\Package;
use App\Models\Category;
use App\Models\FixedDeparture;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


          \DB::table('package_categories')->truncate();
          \DB::table('fixed_departures')->truncate();
          Package::truncate();
        $adminId = Admin::first()?->id ?? 1;

        // Common JSON Data Templates
        $defaultIncluded = [
            ['content' => 'Airport/Bus Station pickup and drop-off'],
            ['content' => 'All accommodations during the trip (Tea houses/Hotels)'],
            ['content' => 'All standard meals (Breakfast, Lunch, Dinner) during the trek/tour'],
            ['content' => 'Experienced, English-speaking licensed guide'],
            ['content' => 'Necessary trekking permits (TIMS, National Park Entry)'],
            ['content' => 'First aid medical kit and emergency oxygen (if applicable)'],
        ];

        $defaultExcluded = [
            ['content' => 'International flight tickets and Nepal Visa fees'],
            ['content' => 'Travel and medical insurance (Mandatory)'],
            ['content' => 'Personal expenses (phone calls, laundry, bar bills, battery recharge)'],
            ['content' => 'Extra night accommodation in Kathmandu due to early arrival or late departure'],
            ['content' => 'Tips for guide and porters (Expected)'],
        ];

        $packagesData = [
            [
                'name' => 'Everest Base Camp Trek',
                'excerpt' => 'Walk in the footsteps of legends to the base of the world\'s highest peak.',
                'description' => 'The Everest Base Camp trek is a classic adventure that takes you through the heart of the Khumbu region, offering breathtaking views of Mount Everest, Lhotse, Nuptse, and Ama Dablam.',
                'content' => '<p>Join us on this unforgettable journey to Everest Base Camp. The trail winds through Sherpa villages, ancient monasteries, and dramatic landscapes.</p>',
                'trip_previous_price' => 1800.00,
                'trip_price' => 1450.00,
                'duration' => '14 Days',
                'trip_grading' => 'Strenuous',
                'max_altitude' => '5,364m',
                'accommodation' => 'Tea Houses / Lodges',
                'meals' => 'Breakfast, Lunch, Dinner',
                'best_season' => 'Spring (Mar-May) & Autumn (Sep-Nov)',
                'transportation' => 'Flight (KTM-LUK-KTM)',
                'destination' => 'Everest Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'itinerary_data' => [
                    ['name' => 'Day 1: Arrival in Kathmandu', 'content' => 'Arrive at Tribhuvan International Airport. Transfer to hotel and brief orientation.', 'max_elevation' => '1,350m', 'duration' => '30 mins drive', 'meals' => 'Dinner', 'accommodation' => 'Hotel'],
                    ['name' => 'Day 2: Fly to Lukla & Trek to Phakding', 'content' => 'Scenic mountain flight to Lukla. Start trekking downhill to Phakding.', 'max_elevation' => '2,610m', 'duration' => '3-4 hours', 'meals' => 'B, L, D', 'accommodation' => 'Tea House'],
                ],
                'highlight_key' => ['Sagarmatha National Park', 'Namche Bazaar', 'Tengboche Monastery', 'Kala Patthar Sunrise'],
                'activities' => ['Trekking', 'Photography', 'Cultural Immersion'],
                'view_count' => rand(150, 500),
                'status' => true,
                'order_level' => 1,
                'display_on' => 'header,footer',
            ],
            [
                'name' => 'Annapurna Circuit Trek',
                'excerpt' => 'Diverse landscapes from subtropical forests to high-altitude desert.',
                'description' => 'The Annapurna Circuit is widely considered one of the best long-distance treks in the world, crossing the Thorong La Pass at 5,416m.',
                'content' => '<p>Experience the ultimate Himalayan adventure crossing the famous Thorong La Pass.</p>',
                'trip_previous_price' => 1200.00,
                'trip_price' => 950.00,
                'duration' => '18 Days',
                'trip_grading' => 'Strenuous',
                'max_altitude' => '5,416m',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Autumn & Spring',
                'transportation' => 'Jeep / Bus',
                'destination' => 'Annapurna Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'itinerary_data' => [
                    ['name' => 'Day 1: Drive to Besisahar', 'content' => 'Scenic drive along the Trishuli and Marsyangdi rivers.', 'max_elevation' => '800m', 'duration' => '7 hours', 'meals' => 'L, D', 'accommodation' => 'Hotel'],
                ],
                'highlight_key' => ['Thorong La Pass', 'Muktinath Temple', 'Tilicho Lake'],
                'activities' => ['Trekking', 'Mountain Biking', 'Hot Springs'],
                'view_count' => rand(100, 400),
                'status' => true,
                'order_level' => 2,
                'display_on' => 'header',
            ],
            [
                'name' => 'Langtang Valley Trek',
                'excerpt' => 'The valley of glaciers, close to Kathmandu and rich in Tamang culture.',
                'description' => 'A beautiful and relatively short trek offering stunning mountain views and a deep dive into Tamang heritage.',
                'content' => '<p>Langtang is known as the valley of glaciers, offering a perfect blend of nature and culture.</p>',
                'trip_price' => 650.00,
                'duration' => '10 Days',
                'trip_grading' => 'Moderate',
                'max_altitude' => '4,984m (Tserko Ri)',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Year Round (Best: Autumn)',
                'transportation' => 'Jeep',
                'destination' => 'Langtang Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Kyanjin Gompa', 'Cheese Factory', 'Tserko Ri'],
                'activities' => ['Trekking', 'Cultural Tour'],
                'view_count' => rand(80, 250),
                'status' => true,
                'order_level' => 3,
                'display_on' => 'header',
            ],
            [
                'name' => 'Chitwan Jungle Safari',
                'excerpt' => 'Explore the wild heart of Nepal, home to rhinos, tigers, and elephants.',
                'description' => 'A thrilling wildlife adventure in the UNESCO World Heritage listed Chitwan National Park.',
                'content' => '<p>Spot the endangered Bengal Tiger and One-horned Rhinoceros in their natural habitat.</p>',
                'trip_price' => 350.00,
                'duration' => '3 Days / 2 Nights',
                'trip_grading' => 'Easy',
                'max_altitude' => '200m',
                'accommodation' => 'Jungle Resort',
                'meals' => 'All Meals',
                'best_season' => 'October to March',
                'transportation' => 'Tourist Bus / Flight',
                'destination' => 'Chitwan',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Elephant Bathing', 'Tharu Cultural Dance', 'Canoe Ride'],
                'activities' => ['Wildlife Safari', 'Bird Watching', 'Cultural Experience'],
                'view_count' => rand(200, 600),
                'status' => true,
                'order_level' => 4,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Pokhara Leisure Tour',
                'excerpt' => 'Relax by the serene Phewa Lake with stunning views of the Machhapuchhre.',
                'description' => 'The perfect getaway for relaxation, boating, and enjoying the laid-back vibe of Pokhara.',
                'content' => '<p>Pokhara is the tourism capital of Nepal, offering peace, adventure, and natural beauty.</p>',
                'trip_price' => 250.00,
                'duration' => '3 Days / 2 Nights',
                'trip_grading' => 'Easy',
                'max_altitude' => '827m',
                'accommodation' => '3-Star Hotel',
                'meals' => 'Breakfast',
                'best_season' => 'Year Round',
                'transportation' => 'Tourist Bus / Flight',
                'destination' => 'Pokhara',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Phewa Lake Boating', 'Davis Fall', 'World Peace Pagoda'],
                'activities' => ['Sightseeing', 'Paragliding', 'Boating'],
                'view_count' => rand(300, 800),
                'status' => true,
                'order_level' => 5,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Manaslu Circuit Trek',
                'excerpt' => 'A remote and restricted trek around the 8th highest mountain in the world.',
                'description' => 'Experience the untouched beauty and rich Tibetan culture of the Manaslu region.',
                'content' => '<p>Manaslu Circuit is a hidden gem, offering a less crowded alternative to Annapurna and Everest.', 'trip_price' => 1350.00,
                'duration' => '16 Days',
                'trip_grading' => 'Strenuous',
                'max_altitude' => '5,106m (Larkya La)',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Autumn & Spring',
                'transportation' => 'Jeep',
                'destination' => 'Manaslu Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Larkya La Pass', 'Samagaon', 'Birendra Lake'],
                'activities' => ['Trekking', 'Cultural Immersion'],
                'view_count' => rand(50, 150),
                'status' => true,
                'order_level' => 6,
                'display_on' => 'header',
            ],
            [
                'name' => 'Ghorepani Poon Hill Trek',
                'excerpt' => 'Short and sweet trek famous for the spectacular sunrise over the Annapurna range.',
                'description' => 'Ideal for beginners and families, offering maximum reward for minimal effort.',
                'content' => '<p>Wake up early to witness the golden sunrise hitting the peaks of Annapurna South and Dhaulagiri.',
                'trip_price' => 450.00,
                'duration' => '5 Days',
                'trip_grading' => 'Easy to Moderate',
                'max_altitude' => '3,210m',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Year Round',
                'transportation' => 'Jeep',
                'destination' => 'Annapurna Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Poon Hill Sunrise', 'Rhododendron Forests', 'Ghandruk Village'],
                'activities' => ['Trekking', 'Photography'],
                'view_count' => rand(400, 900),
                'status' => true,
                'order_level' => 7,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Upper Mustang Trek',
                'excerpt' => 'Journey into the forbidden kingdom, a high-altitude desert with ancient caves.',
                'description' => 'Explore the trans-Himalayan landscape and the walled city of Lo Manthang.',
                'content' => '<p>Upper Mustang retains a rich, traditional Tibetan culture that has remained intact for centuries.',
                'trip_price' => 2200.00,
                'duration' => '14 Days',
                'trip_grading' => 'Moderate to Strenuous',
                'max_altitude' => '3,840m',
                'accommodation' => 'Tea Houses / Camping',
                'meals' => 'All Meals',
                'best_season' => 'Spring & Autumn',
                'transportation' => 'Jeep / Flight',
                'destination' => 'Mustang Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => array_merge($defaultExcluded, [['content' => 'Mustang Restricted Area Permit ($500)']]),
                'highlight_key' => ['Lo Manthang', 'Sky Caves', 'Tiji Festival'],
                'activities' => ['Trekking', 'Mountain Biking', 'History'],
                'view_count' => rand(60, 200),
                'status' => true,
                'order_level' => 8,
                'display_on' => 'header',
            ],
            [
                'name' => 'Lumbini Spiritual Tour',
                'excerpt' => 'Visit the birthplace of Lord Buddha and explore ancient monasteries.',
                'description' => 'A peaceful pilgrimage to the sacred garden of Lumbini, a UNESCO World Heritage Site.',
                'content' => '<p>Walk in the footsteps of Siddhartha Gautama and find inner peace.',
                'trip_price' => 300.00,
                'duration' => '3 Days / 2 Nights',
                'trip_grading' => 'Easy',
                'max_altitude' => '150m',
                'accommodation' => 'Hotel',
                'meals' => 'Breakfast',
                'best_season' => 'October to April',
                'transportation' => 'Bus / Flight',
                'destination' => 'Lumbini',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Maya Devi Temple', 'Ashoka Pillar', 'Monastic Zone'],
                'activities' => ['Meditation', 'Sightseeing', 'Cycling'],
                'view_count' => rand(100, 300),
                'status' => true,
                'order_level' => 9,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Gokyo Lakes Trek',
                'excerpt' => 'Trek to the highest freshwater lake system in the world, with fewer crowds.',
                'description' => 'An alternative to EBC, offering stunning views of four 8,000m peaks from Gokyo Ri.',
                'content' => '<p>The turquoise Gokyo Lakes are considered sacred by both Hindus and Buddhists.',
                'trip_price' => 1500.00,
                'duration' => '13 Days',
                'trip_grading' => 'Strenuous',
                'max_altitude' => '5,357m (Gokyo Ri)',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Autumn & Spring',
                'transportation' => 'Flight',
                'destination' => 'Everest Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Gokyo Lakes', 'Cho La Pass', 'Gokyo Ri'],
                'activities' => ['Trekking', 'Photography'],
                'view_count' => rand(70, 180),
                'status' => true,
                'order_level' => 10,
                'display_on' => 'header',
            ],
            [
                'name' => 'Mardi Himal Trek',
                'excerpt' => 'A hidden gem offering close-up views of Machhapuchhre (Fishtail) mountain.',
                'description' => 'A relatively new and less crowded trekking route in the Annapurna sanctuary.',
                'content' => '<p>Walk through dense rhododendron forests to reach the stunning Mardi Himal Base Camp.',
                'trip_price' => 550.00,
                'duration' => '7 Days',
                'trip_grading' => 'Moderate',
                'max_altitude' => '4,500m',
                'accommodation' => 'Tea Houses',
                'meals' => 'All Meals',
                'best_season' => 'Spring & Autumn',
                'transportation' => 'Jeep',
                'destination' => 'Annapurna Region',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Mardi Himal Base Camp', 'Low Camp', 'Forest Trail'],
                'activities' => ['Trekking', 'Camping'],
                'view_count' => rand(120, 350),
                'status' => true,
                'order_level' => 11,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Kathmandu Valley Cultural Tour',
                'excerpt' => 'Discover the ancient cities of Kathmandu, Patan, and Bhaktapur.',
                'description' => 'A comprehensive tour of the UNESCO World Heritage Sites in the Kathmandu Valley.',
                'content' => '<p>Explore intricate wood carvings, ancient stupas, and vibrant local markets.',
                'trip_price' => 200.00,
                'duration' => '3 Days',
                'trip_grading' => 'Easy',
                'max_altitude' => '1,400m',
                'accommodation' => 'Hotel',
                'meals' => 'Breakfast',
                'best_season' => 'Year Round',
                'transportation' => 'Private Vehicle',
                'destination' => 'Kathmandu Valley',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Swayambhunath', 'Pashupatinath', 'Bhaktapur Durbar Square'],
                'activities' => ['Sightseeing', 'Cultural Tour', 'Shopping'],
                'view_count' => rand(250, 700),
                'status' => true,
                'order_level' => 12,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Everest Helicopter Tour',
                'excerpt' => 'Experience the roof of the world in just a few hours without the strenuous trek.',
                'description' => 'A luxury helicopter flight taking you to Kala Patthar and Everest Base Camp.',
                'content' => '<p>Perfect for those short on time but wanting the ultimate Everest experience.',
                'trip_previous_price' => 1200.00,
                'trip_price' => 950.00,
                'duration' => '4-5 Hours',
                'trip_grading' => 'Easy',
                'max_altitude' => '5,545m',
                'accommodation' => 'N/A',
                'meals' => 'Breakfast at Hotel Everest View',
                'best_season' => 'Year Round (Weather permitting)',
                'transportation' => 'Helicopter',
                'destination' => 'Everest Region',
                'included_data' => [['content' => 'Helicopter Flight'], ['content' => 'Landing at Kala Patthar'], ['content' => 'Breakfast at Hotel Everest View'], ['content' => 'All taxes and fees']],
                'excluded_data' => [['content' => 'Nepal Visa'], ['content' => 'Travel Insurance'], ['content' => 'Personal expenses']],
                'highlight_key' => ['Kala Patthar Landing', 'Hotel Everest View', 'Aerial Views of 4 Peaks'],
                'activities' => ['Sightseeing', 'Luxury Tour'],
                'view_count' => rand(300, 800),
                'status' => true,
                'order_level' => 13,
                'display_on' => 'header',
            ],
            [
                'name' => 'Trishuli River Rafting',
                'excerpt' => 'Adrenaline-pumping white water rafting experience close to Kathmandu.',
                'description' => 'Navigate through exciting rapids on the pristine Trishuli River.',
                'content' => '<p>Suitable for both beginners and experienced rafters, offering a perfect day of adventure.',
                'trip_price' => 80.00,
                'duration' => '1 Day',
                'trip_grading' => 'Moderate',
                'max_altitude' => '300m',
                'accommodation' => 'N/A',
                'meals' => 'Lunch',
                'best_season' => 'October to May',
                'transportation' => 'Bus',
                'destination' => 'Trishuli',
                'included_data' => [['content' => 'Rafting Equipment'], ['content' => 'Professional Guide'], ['content' => 'Lunch'], ['content' => 'Transport from KTM']],
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Grade 3 & 4 Rapids', 'Riverside Lunch', 'Scenic Drive'],
                'activities' => ['Rafting', 'Adventure', 'Swimming'],
                'view_count' => rand(150, 400),
                'status' => true,
                'order_level' => 14,
                'display_on' => 'footer',
            ],
            [
                'name' => 'Bandipur Heritage Village Tour',
                'excerpt' => 'Step back in time in this beautifully preserved Newari hilltop town.',
                'description' => 'Enjoy the tranquil atmosphere, traditional architecture, and panoramic mountain views of Bandipur.',
                'content' => '<p>Bandipur is a living museum of Newari culture, free from vehicle traffic in its core area.',
                'trip_price' => 150.00,
                'duration' => '2 Days / 1 Night',
                'trip_grading' => 'Easy',
                'max_altitude' => '1,030m',
                'accommodation' => 'Boutique Hotel',
                'meals' => 'Breakfast & Dinner',
                'best_season' => 'Year Round',
                'transportation' => 'Private Vehicle',
                'destination' => 'Bandipur',
                'included_data' => $defaultIncluded,
                'excluded_data' => $defaultExcluded,
                'highlight_key' => ['Tundikhel Viewpoint', 'Siddha Cave', 'Newari Architecture'],
                'activities' => ['Sightseeing', 'Hiking', 'Cultural Experience'],
                'view_count' => rand(90, 250),
                'status' => true,
                'order_level' => 15,
                'display_on' => 'footer',
            ],
        ];

   
        $categoryIds = Category::where('status', true)->pluck('id')->toArray();

        foreach ($packagesData as $index => $data) {

            $data['slug'] = Str::slug($data['name']);
            $data['created_by'] = $adminId;
            $data['updated_by'] = $adminId;
            
       
            $data['image'] = 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=800&auto=format&fit=crop'; 
            $data['feature_image'] = 'https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=800&auto=format&fit=crop';

     
            $package = Package::create($data);

   
            $randomCategories = array_rand($categoryIds, rand(1, min(3, count($categoryIds))));
            if (!is_array($randomCategories)) {
                $randomCategories = [$randomCategories];
            }
            $package->categories()->attach($randomCategories);

      
            $numDepartures = rand(1, 2);
            for ($i = 1; $i <= $numDepartures; $i++) {
                $startDate = now()->addDays(rand(15, 90))->format('Y-m-d');
                $endDate = now()->addDays(rand(15, 90) + (int)Str::of($data['duration'])->toInteger())->format('Y-m-d');
                
                FixedDeparture::create([
                    'package_id' => $package->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'discount_price' => rand(0, 1) ? $data['trip_price'] * 0.9 : null,
                    'max_seats' => rand(8, 15),
                    'booked_seats' => rand(0, 5),
                    'description' => 'Guaranteed departure. Join our expert guide for this amazing journey.',
                    'status' => 'active',
                ]);
            }
        }

        $this->command->info('✓ 15+ Travel Packages with Categories and Fixed Departures seeded successfully!');
    }
}