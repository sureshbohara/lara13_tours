<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
    
        $adminId = Admin::first()?->id;

        // 1. Create Parent Categories
        $adventure = Category::create([
            'name'             => 'Adventure Tours',
            'slug'             => 'adventure-tours',
            'excerpt'          => 'Thrilling outdoor activities and expeditions across Nepal.',
            'description'      => 'Explore the ultimate adventure with our curated trekking, rafting, and mountain biking packages.',
            'image'            => null,
            'font_icon'        => 'bi bi-signpost-split',
            'order_level'      => 1,
            'display_on'       => 'home',
            'meta_keywords'    => 'adventure, trekking, rafting, nepal tours',
            'meta_description' => 'Book the best adventure tours and trekking packages in Nepal.',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        $accommodation = Category::create([
            'name'             => 'Accommodation',
            'slug'             => 'accommodation',
            'excerpt'          => 'Comfortable and authentic places to stay during your journey.',
            'description'      => 'From luxury hotels to traditional homestays, find the perfect place to rest and rejuvenate.',
            'image'            => null,
            'font_icon'        => 'bi bi-house-door',
            'order_level'      => 2,
            'display_on'       => 'home',
            'meta_keywords'    => 'hotels, homestays, resorts, nepal accommodation',
            'meta_description' => 'Find the best hotels, resorts, and authentic homestays in Nepal.',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        $culture = Category::create([
            'name'             => 'Cultural Experiences',
            'slug'             => 'cultural-experiences',
            'excerpt'          => 'Immerse yourself in the rich heritage and traditions of Nepal.',
            'description'      => 'Discover ancient temples, participate in local festivals, and experience authentic Nepali culture.',
            'image'            => null,
            'font_icon'        => 'bi bi-people',
            'order_level'      => 3,
            'display_on'       => 'default',
            'meta_keywords'    => 'culture, heritage, festivals, nepal traditions',
            'meta_description' => 'Experience the rich cultural heritage and traditions of Nepal.',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        $wellness = Category::create([
            'name'             => 'Health & Wellness',
            'slug'             => 'health-wellness',
            'excerpt'          => 'Rejuvenate your mind and body with our wellness retreats.',
            'description'      => 'Find peace and tranquility with yoga retreats, meditation sessions, and Ayurvedic treatments.',
            'image'            => null,
            'font_icon'        => 'bi bi-heart-pulse',
            'order_level'      => 4,
            'display_on'       => 'page',
            'meta_keywords'    => 'yoga, meditation, wellness, retreat, nepal',
            'meta_description' => 'Rejuvenate your mind and body with health and wellness retreats in Nepal.',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        // 2. Create Child Categories (Sub-categories)
        
        // Children of Adventure Tours
        Category::create([
            'parent_id'        => $adventure->id,
            'name'             => 'Trekking',
            'slug'             => 'trekking',
            'excerpt'          => 'World-class trekking routes in the Himalayas.',
            'description'      => 'From Everest Base Camp to the Annapurna Circuit, experience the best trekking routes.',
            'font_icon'        => 'bi bi-map',
            'order_level'      => 1,
            'display_on'       => 'default',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        Category::create([
            'parent_id'        => $adventure->id,
            'name'             => 'White Water Rafting',
            'slug'             => 'white-water-rafting',
            'excerpt'          => 'Adrenaline-pumping rafting experiences on Nepal\'s rivers.',
            'description'      => 'Navigate the thrilling rapids of the Trishuli, Bhote Koshi, and Sun Koshi rivers.',
            'font_icon'        => 'bi bi-droplet',
            'order_level'      => 2,
            'display_on'       => 'default',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        // Children of Accommodation
        Category::create([
            'parent_id'        => $accommodation->id,
            'name'             => 'Traditional Homestays',
            'slug'             => 'traditional-homestays',
            'excerpt'          => 'Live like a local in authentic Nepali homes.',
            'description'      => 'Experience genuine Nepali hospitality, traditional food, and rural lifestyle.',
            'font_icon'        => 'bi bi-house-heart',
            'order_level'      => 1,
            'display_on'       => 'home',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        Category::create([
            'parent_id'        => $accommodation->id,
            'name'             => 'Luxury Resorts',
            'slug'             => 'luxury-resorts',
            'excerpt'          => 'Premium stays with world-class amenities.',
            'description'      => 'Indulge in luxury with stunning mountain views, spa services, and gourmet dining.',
            'font_icon'        => 'bi bi-building',
            'order_level'      => 2,
            'display_on'       => 'home',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        // Children of Cultural Experiences
        Category::create([
            'parent_id'        => $culture->id,
            'name'             => 'Heritage Tours',
            'slug'             => 'heritage-tours',
            'excerpt'          => 'Explore UNESCO World Heritage Sites.',
            'description'      => 'Visit ancient temples, palaces, and historical landmarks in Kathmandu, Patan, and Bhaktapur.',
            'font_icon'        => 'bi bi-landmark',
            'order_level'      => 1,
            'display_on'       => 'default',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        Category::create([
            'parent_id'        => $culture->id,
            'name'             => 'Local Cuisine',
            'slug'             => 'local-cuisine',
            'excerpt'          => 'Taste the authentic flavors of Nepal.',
            'description'      => 'Join cooking classes and food tours to discover Dal Bhat, Momos, and other local delicacies.',
            'font_icon'        => 'bi bi-cup-hot',
            'order_level'      => 2,
            'display_on'       => 'default',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        // Children of Health & Wellness
        Category::create([
            'parent_id'        => $wellness->id,
            'name'             => 'Yoga Retreats',
            'slug'             => 'yoga-retreats',
            'excerpt'          => 'Find your inner peace in the Himalayas.',
            'description'      => 'Daily yoga sessions, meditation, and healthy organic meals in serene environments.',
            'font_icon'        => 'bi bi-person-arms-up',
            'order_level'      => 1,
            'display_on'       => 'page',
            'status'           => true,
            'created_by'       => $adminId,
            'updated_by'       => $adminId,
        ]);

        $this->command->info('✓ Categories and Sub-categories seeded successfully!');
    }
}