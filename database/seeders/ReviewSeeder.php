<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $reviews = [
            [
                'name'        => 'John Smith',
                'email'       => 'john.smith@example.com',
                'address'     => 'New York, USA',
                'rating'      => 5,
                'review'      => 'Absolutely amazing experience! The homestay was clean, comfortable, and the hosts were incredibly welcoming. The view of the Himalayas was breathtaking.',
                'content'     => 'We stayed for 5 nights and it was the highlight of our Nepal trip. The traditional Nepali food served was delicious. Highly recommended for anyone visiting Pokhara.',
                'image'       => null,
                'display_on'  => 'homepage',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Sarah Johnson',
                'email'       => 'sarah.j@example.com',
                'address'     => 'London, UK',
                'rating'      => 5,
                'review'      => 'Perfect location and excellent service. The property matched the photos perfectly and the staff went above and beyond to make our stay memorable.',
                'content'     => 'The host arranged a trekking trip for us and it was fantastic. The room was spacious and had all modern amenities while maintaining traditional Nepali charm.',
                'image'       => null,
                'display_on'  => 'homepage',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Michael Chen',
                'email'       => 'michael.chen@example.com',
                'address'     => 'Sydney, Australia',
                'rating'      => 4,
                'review'      => 'Great value for money. The apartment was well-maintained and in a convenient location. Only minor issue was the WiFi speed.',
                'content'     => 'Stayed here for a week while exploring Kathmandu. The location was perfect - close to major attractions but in a quiet neighborhood. Would definitely come back.',
                'image'       => null,
                'display_on'  => 'homepage',
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'name'        => 'Emma Williams',
                'email'       => 'emma.w@example.com',
                'address'     => 'Toronto, Canada',
                'rating'      => 5,
                'review'      => 'An unforgettable experience! The cultural immersion was incredible. We learned so much about Nepali traditions and cuisine.',
                'content'     => 'The host family treated us like their own. We participated in a traditional cooking class and even joined a local festival. This is what travel should be about!',
                'image'       => null,
                'display_on'  => 'about',
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'name'        => 'David Martinez',
                'email'       => 'david.m@example.com',
                'address'     => 'Madrid, Spain',
                'rating'      => 4,
                'review'      => 'Very good property with stunning views. The jungle safari arranged by the host was the best part of our Chitwan visit.',
                'content'     => 'Clean rooms, friendly staff, and amazing food. The only suggestion would be to provide more vegetarian options. Overall, a wonderful stay.',
                'image'       => null,
                'display_on'  => 'about',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'name'        => 'Lisa Anderson',
                'email'       => 'lisa.a@example.com',
                'address'     => 'Berlin, Germany',
                'rating'      => 5,
                'review'      => 'Exceeded all expectations! The mountain views from the balcony were spectacular. Will definitely return next year.',
                'content'     => 'This was our honeymoon trip and it was perfect in every way. The host even arranged a special dinner with traditional music. Thank you for making it so special!',
                'image'       => null,
                'display_on'  => 'property',
                'order_level' => 6,
                'status'      => true,
            ],
            [
                'name'        => 'Rajesh Kumar',
                'email'       => 'rajesh.k@example.com',
                'address'     => 'Mumbai, India',
                'rating'      => 3,
                'review'      => 'Decent stay but could be improved. The location is good but the room needs some renovation.',
                'content'     => 'The host was very helpful and the breakfast was good. However, the bathroom could use some updates. Average experience overall.',
                'image'       => null,
                'display_on'  => 'property',
                'order_level' => 7,
                'status'      => true,
            ],
            [
                'name'        => 'Yuki Tanaka',
                'email'       => 'yuki.t@example.com',
                'address'     => 'Tokyo, Japan',
                'rating'      => 5,
                'review'      => 'Wonderful hospitality! Felt like home away from home. The traditional architecture and modern amenities were perfectly balanced.',
                'content'     => 'I have traveled to many countries but this homestay experience in Nepal was truly unique. The family was so kind and the food was amazing. Namaste!',
                'image'       => null,
                'display_on'  => 'homepage',
                'order_level' => 8,
                'status'      => true,
            ],
        ];

        foreach ($reviews as $review) {
            Review::create($review);
        }

        $this->command->info('✓ Reviews seeded successfully!');
    }
}