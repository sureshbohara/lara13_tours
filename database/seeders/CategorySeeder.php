<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $adminId = Admin::first()?->id;

        /*
        |--------------------------------------------------------------------------
        | A. Trekking
        |--------------------------------------------------------------------------
        */
        $trekking = $this->createCategory([
            'name' => 'Trekking',
            'slug' => 'trekking',
            'excerpt' => 'Explore the best trekking regions of Nepal and Tibet.',
            'description' => 'Discover Himalayan trekking adventures, remote trails, and spectacular mountain landscapes.',
            'font_icon' => 'bi bi-signpost-split',
            'order_level' => 1,
            'display_on' => 'home',
        ], $adminId);

        $trekkingRegions = [
            'Everest Region',
            'Annapurna Region',
            'Langtang Region',
            'Manaslu Region',
            'Kanchenjunga Region',
            'Dolpa Region',
            'Nepal Eastern Region',
            'Nepal Western Region',
            'Great Himalayan',
            'Tibet Tour Trek',
        ];

        $this->createChildren($trekking, $trekkingRegions, $adminId);

        /*
        |--------------------------------------------------------------------------
        | B. Climbing
        |--------------------------------------------------------------------------
        */
        $climbing = $this->createCategory([
            'name' => 'Climbing',
            'slug' => 'climbing',
            'excerpt' => 'Experience Himalayan peak climbing and mountaineering.',
            'description' => 'Explore trekking peaks, technical climbing, and high-altitude Himalayan expeditions.',
            'font_icon' => 'bi bi-mountain',
            'order_level' => 2,
            'display_on' => 'home',
        ], $adminId);

        $climbingTypes = [
            '6000m Trekking Peaks',
            '6500m–7000m Technical Peaks',
            '8000m Expeditions',
            'Climbing & Trekking Tours',
        ];

        $this->createChildren($climbing, $climbingTypes, $adminId);

        /*
        |--------------------------------------------------------------------------
        | C. Tours & Activities
        |--------------------------------------------------------------------------
        */
        $tours = $this->createCategory([
            'name' => 'Tours & Activities',
            'slug' => 'tours-activities',
            'excerpt' => 'Discover cultural tours, wildlife safaris, and outdoor adventures.',
            'description' => 'Enjoy cultural experiences, sightseeing, jungle safaris, adventure sports, and hiking across Nepal.',
            'font_icon' => 'bi bi-compass',
            'order_level' => 3,
            'display_on' => 'home',
        ], $adminId);

        $tourTypes = [
            'Multi-Day Cultural Tours',
            'Day Tours',
            'Jungle Safari',
            'Adventure Sports',
            'Day Hiking',
        ];

        $this->createChildren($tours, $tourTypes, $adminId);

        /*
        |--------------------------------------------------------------------------
        | D. Blogs
        |--------------------------------------------------------------------------
        */
        $blogs = $this->createCategory([
            'name' => 'Blogs',
            'slug' => 'blogs',
            'excerpt' => 'Travel stories, guides, and tips for your Nepal adventure.',
            'description' => 'Read travel and tour guides, trekking information, destination highlights, and helpful travel tips.',
            'font_icon' => 'bi bi-journal-richtext',
            'order_level' => 4,
            'display_on' => 'default',
        ], $adminId);

        $blogTypes = [
            'Travel And Tour',
        ];

        $this->createChildren($blogs, $blogTypes, $adminId);

        /*
        |--------------------------------------------------------------------------
        | Destinations
        |--------------------------------------------------------------------------
        */
        $destinations = $this->createCategory([
            'name' => 'Destinations',
            'slug' => 'destinations',
            'excerpt' => 'Explore the most popular travel destinations in Nepal.',
            'description' => 'Discover the natural beauty, culture, and adventures of Nepal’s top destinations.',
            'font_icon' => 'bi bi-geo-alt',
            'order_level' => 5,
            'display_on' => 'home',
        ], $adminId);

        $destinationNames = [
            'Chitwan',
            'Kathmandu',
            'Pokhara',
            'Mustang',
        ];

        $this->createChildren($destinations, $destinationNames, $adminId);

        $this->command?->info(
            'Categories, sub-categories, and destinations seeded successfully!'
        );
    }

    private function createCategory(array $data, ?int $adminId): Category
    {
        return Category::updateOrCreate(
            ['slug' => $data['slug']],
            array_merge([
                'parent_id' => null,
                'image' => null,
                'meta_keywords' => $data['name'],
                'meta_description' => $data['excerpt'],
                'status' => true,
                'created_by' => $adminId,
                'updated_by' => $adminId,
            ], $data)
        );
    }

    private function createChildren(
        Category $parent,
        array $names,
        ?int $adminId
    ): void {
        foreach ($names as $index => $name) {
            $slug = Str::slug($name);

            Category::updateOrCreate(
                ['slug' => $slug],
                [
                    'parent_id' => $parent->id,
                    'name' => $name,
                    'excerpt' => "Explore {$name} with our Nepal travel packages.",
                    'description' => "Discover {$name} and experience unforgettable travel adventures.",
                    'image' => null,
                    'font_icon' => 'bi bi-geo-alt',
                    'order_level' => $index + 1,
                    'display_on' => 'default',
                    'meta_keywords' => $name,
                    'meta_description' => "Explore {$name} with our travel and tour packages.",
                    'status' => true,
                    'created_by' => $adminId,
                    'updated_by' => $adminId,
                ]
            );
        }
    }
}