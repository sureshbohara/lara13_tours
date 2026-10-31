<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $galleryImages = [
            [
                'name'        => 'Mount Everest Sunrise',
                'display_on'  => 'all',
                'image'       => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?q=80&w=800&auto=format&fit=crop',
                'alt'         => 'Golden sunrise view over Mount Everest peaks',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Pokhara Phewa Lake',
                'display_on'  => 'all',
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSIHHT9QZwZCvOer-RpzjjzIiBN5_XTPPp204ixURhSqgTaG-X-8vZotrMY&s=10',
                'alt'         => 'Traditional boats on Phewa Lake with mountain reflection',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Kathmandu Durbar Square',
                'display_on'  => 'all',
                'image'       => 'https://cdn.getyourguide.com/image/format=auto%2Cfit=crop%2Cgravity=auto%2Cquality=60%2Cwidth=400%2Cheight=265%2Cdpr=2/tour_img/d269e0992a3e27befa17b14b355cdbe9a3031a38c609659cefa0b3dbd4e74435.jpeg',
                'alt'         => 'Ancient temples and architecture at Kathmandu Durbar Square',
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'name'        => 'Chitwan Jungle Safari',
                'display_on'  => 'all',
                'image'       => 'https://images.unsplash.com/photo-1535941339077-2dd1c7963098?q=80&w=800&auto=format&fit=crop',
                'alt'         => 'Elephant safari experience in Chitwan National Park',
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'name'        => 'Annapurna Base Camp Trek',
                'display_on'  => 'all',
                'image'       => 'https://images.unsplash.com/photo-1585938389612-a552a28d6914?q=80&w=800&auto=format&fit=crop',
                'alt'         => 'Trekker enjoying the panoramic view at Annapurna Base Camp',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'name'        => 'Boudhanath Stupa Evening',
                'display_on'  => 'all',
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT9ihuLEFV_a2ho4VUbHlTuwhrOVVwwQLvLjjon-Q7710zYqD_MOXhre4Y&s=10',
                'alt'         => 'Monks and devotees during evening prayers at Boudhanath Stupa',
                'order_level' => 6,
                'status'      => true,
            ],
            [
                'name'        => 'Lumbini Birthplace of Buddha',
                'display_on'  => 'all',
                'image'       => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRKf4DNJcX25sElITwVAn_JEsPdMl5c0xJMoZFhsbmQpY8D4ZiXCapBXX4v&s=10',
                'alt'         => 'Peaceful gardens and temples at Lumbini, the birthplace of Lord Buddha',
                'order_level' => 7,
                'status'      => true,
            ],

        ];

        foreach ($galleryImages as $imageData) {
            Gallery::updateOrCreate(
                ['name' => $imageData['name']], 
                $imageData
            );
        }

        $this->command->info('✓ Gallery images seeded successfully without duplicates!');
    }
}