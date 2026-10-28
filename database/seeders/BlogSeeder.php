<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {



         \DB::table('blog_category')->truncate();
         Blog::truncate();
        $adminId = Admin::first()?->id ?? 1;

     
        $categoryIds = Category::where('status', true)->pluck('id')->toArray();


        if (empty($categoryIds)) {
            $this->command->warn('⚠️ No active categories found. Please run CategorySeeder first.');
            return;
        }

        $blogsData = [
            [
                'title' => 'Ultimate Packing List for Everest Base Camp Trek',
                'excerpt' => 'Don\'t leave for the Himalayas without checking this comprehensive packing guide for your EBC adventure.',
                'description' => '<p>Trekking to Everest Base Camp is a dream for many, but packing the right gear is crucial for a safe and comfortable journey. This guide covers everything from layering systems to essential trekking accessories.</p><p>Remember, the key to staying warm is layering. Start with a moisture-wicking base layer, add an insulating mid-layer, and top it off with a windproof and waterproof outer shell.</p>',
                'meta_title' => 'Everest Base Camp Packing List | Ultimate Guide',
                'meta_description' => 'Discover the ultimate packing list for the Everest Base Camp trek. Ensure you have all the essential gear for a safe and memorable Himalayan adventure.',
                'views' => rand(500, 2000),
                'is_featured' => true,
                'status' => true,
                'order_level' => 1,
                'image' => 'https://images.unsplash.com/photo-1551632811-561732d1e306?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Best Time to Visit Nepal: A Month-by-Month Guide',
                'excerpt' => 'Planning a trip to Nepal? Find out the best seasons for trekking, wildlife safaris, and cultural tours.',
                'description' => '<p>Nepal is a year-round destination, but the experience varies greatly depending on the season. Autumn (September to November) is widely considered the best time for trekking due to clear skies and moderate temperatures.</p><p>Spring (March to May) is the second-best season, famous for blooming rhododendrons. Winter is great for lower altitude treks and cultural tours, while monsoon (June to August) is ideal for rain-shadow areas like Upper Mustang.</p>',
                'meta_title' => 'Best Time to Visit Nepal | Travel Guide',
                'meta_description' => 'Learn about the best time to visit Nepal for trekking, sightseeing, and wildlife safaris. Our month-by-month guide helps you plan the perfect trip.',
                'views' => rand(800, 3000),
                'is_featured' => true,
                'status' => true,
                'order_level' => 2,
                'image' => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Top 5 Hidden Gems in the Annapurna Region',
                'excerpt' => 'Escape the crowded trails and discover these breathtaking, off-the-beaten-path destinations in Annapurna.',
                'description' => '<p>While the Annapurna Circuit and Poon Hill are incredibly popular, the region holds many secret spots waiting to be explored. From the serene Nar-Phu Valley to the untouched beauty of Khopra Danda, these hidden gems offer solitude and authentic cultural experiences.</p>',
                'meta_title' => '5 Hidden Gems in Annapurna Region, Nepal',
                'meta_description' => 'Discover the top 5 hidden gems in the Annapurna region. Escape the crowds and explore off-the-beaten-path trekking routes in Nepal.',
                'views' => rand(300, 1200),
                'is_featured' => false,
                'status' => true,
                'order_level' => 3,
                'image' => 'https://images.unsplash.com/photo-1585409677983-0f6c41ca9c3b?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Understanding Sherpa Culture: More Than Just Mountaineers',
                'excerpt' => 'Dive deep into the rich traditions, beliefs, and daily life of the legendary Sherpa people of the Khumbu region.',
                'description' => '<p>The Sherpa people are renowned worldwide for their mountaineering skills, but their culture is rich with traditions, Buddhist beliefs, and a deep connection to the Himalayas. Learn about their unique festivals like Mani Rimdu, their traditional homes, and their profound respect for nature.</p>',
                'meta_title' => 'Understanding Sherpa Culture and Traditions in Nepal',
                'meta_description' => 'Explore the rich culture, traditions, and daily life of the Sherpa people in Nepal\'s Khumbu region. More than just legendary mountaineers.',
                'views' => rand(400, 1500),
                'is_featured' => true,
                'status' => true,
                'order_level' => 4,
                'image' => 'https://images.unsplash.com/photo-1582650630656-b39c9e31878f?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'Chitwan National Park: A Wildlife Safari Guide',
                'excerpt' => 'Everything you need to know about spotting rhinos, tigers, and elephants in Nepal\'s premier jungle destination.',
                'description' => '<p>Chitwan National Park is a UNESCO World Heritage site and one of the best places in Asia to see wildlife in its natural habitat. From thrilling jungle safaris on the back of an elephant to peaceful canoe rides on the Rapti River, Chitwan offers an unforgettable adventure.</p><p>Keep your eyes peeled for the elusive Bengal Tiger, the majestic One-Horned Rhinoceros, and a variety of bird species.</p>',
                'meta_title' => 'Chitwan National Park Wildlife Safari Guide | Nepal',
                'meta_description' => 'Plan your wildlife safari in Chitwan National Park, Nepal. Learn how to spot rhinos, tigers, and elephants in this comprehensive guide.',
                'views' => rand(600, 2500),
                'is_featured' => false,
                'status' => true,
                'order_level' => 5,
                'image' => 'https://images.unsplash.com/photo-1534177616072-5b039011e2d9?q=80&w=800&auto=format&fit=crop',
            ],
            [
                'title' => 'How to Prepare for High Altitude Trekking',
                'excerpt' => 'Essential tips on acclimatization, fitness, and health to ensure a safe and enjoyable high-altitude adventure.',
                'description' => '<p>High-altitude trekking in Nepal requires proper preparation. Acute Mountain Sickness (AMS) is a real risk, but it can be prevented with proper acclimatization, hydration, and a steady pace.</p><p>Start your physical preparation months in advance with cardiovascular exercises and leg strength training. During the trek, remember the golden rule: "Climb high, sleep low," and listen to your body.</p>',
                'meta_title' => 'How to Prepare for High Altitude Trekking in Nepal',
                'meta_description' => 'Essential tips on acclimatization, fitness, and health to ensure a safe and enjoyable high-altitude trekking experience in the Himalayas.',
                'views' => rand(900, 3500),
                'is_featured' => true,
                'status' => true,
                'order_level' => 6,
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=800&auto=format&fit=crop',
            ],
        ];

        foreach ($blogsData as $index => $data) {
            $data['slug'] = Str::slug($data['title']);
            $data['created_by'] = $adminId;
            $data['updated_by'] = $adminId;

            $blog = Blog::create($data);

            $randomCategories = array_rand($categoryIds, rand(1, min(2, count($categoryIds))));
            if (!is_array($randomCategories)) {
                $randomCategories = [$randomCategories];
            }
            $blog->categories()->attach($randomCategories);
        }

        $this->command->info('✓ 6+ Travel Blog Posts with Categories seeded successfully!');
    }
}