<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title'       => 'Discover Authentic Nepali Hospitality',
                'subtitle'    => 'Book Premium Homestays Across Nepal',
                'description' => 'Experience the warmth of Nepali culture with our handpicked homestays in Kathmandu, Pokhara, Chitwan, and beyond.',
                'image'       => null,
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'title'       => 'Mountain Retreats & City Apartments',
                'subtitle'    => 'Find Your Perfect Stay',
                'description' => 'From the Himalayan foothills to the bustling streets of Kathmandu, discover unique properties for every traveler.',
                'image'       => null,
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'title'       => 'Become a Host Today',
                'subtitle'    => 'Earn from Your Property',
                'description' => 'List your property on Ez Property and start earning. Join thousands of successful hosts across Nepal.',
                'image'       => null,
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'title'       => 'Special Festival Offers',
                'subtitle'    => 'Dashain & Tihar Deals',
                'description' => 'Celebrate the festive season with exclusive discounts on premium homestays and resorts.',
                'image'       => null,
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'title'       => 'Weekend Getaways',
                'subtitle'    => 'Escape the City Life',
                'description' => 'Discover peaceful retreats just a few hours drive from Kathmandu. Perfect for weekend vacations.',
                'image'       => null,
                'order_level' => 5,
                'status'      => false,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }

        $this->command->info('✓ Banners seeded successfully!');
    }
}