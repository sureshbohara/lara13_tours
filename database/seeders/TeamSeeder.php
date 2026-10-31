<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $teamMembers = [
            [
                'name'        => 'Rajesh Shrestha',
                'designation' => 'Founder & CEO',
                'email'       => 'rajesh@sptravel.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Founder & CEO with 15+ years of experience in Nepal\'s tourism industry. Passionate about connecting travelers with authentic Himalayan experiences and empowering local communities through sustainable tourism.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/rajesh.shrestha',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/rajesh.sptravel',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Sita Gurung',
                'designation' => 'Head of Operations',
                'email'       => 'sita@sptravel.com',
                'address'     => 'Pokhara, Nepal',
                'bio'         => 'Head of Operations with deep expertise in trekking logistics and hospitality management. Sita ensures every itinerary meets our high standards of safety, quality, and authentic cultural immersion.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/sita.gurung',
                'youtube'     => null,
                'tiktok'      => 'https://tiktok.com/@sita.sptravel',
                'instagram'   => 'https://instagram.com/sita.sptravel',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Bikash Tamang',
                'designation' => 'Chief Technology Officer',
                'email'       => 'bikash@sptravel.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Chief Technology Officer leading our digital platform development. Bikash brings 10+ years of software engineering experience to create seamless, secure, and user-friendly tour booking experiences.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/bikash.tamang',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/bikash.tech',
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'name'        => 'Anjali Maharjan',
                'designation' => 'Marketing Director',
                'email'       => 'anjali@sptravel.com',
                'address'     => 'Lalitpur, Nepal',
                'bio'         => 'Marketing Director specializing in tourism digital marketing and brand strategy. Anjali drives our global reach through innovative travel campaigns and engaging storytelling.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/anjali.maharjan',
                'youtube'     => 'https://youtube.com/@anjali.sptravel',
                'tiktok'      => 'https://tiktok.com/@anjali.sptravel',
                'instagram'   => 'https://instagram.com/anjali.marketing',
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'name'        => 'Prakash Rai',
                'designation' => 'Senior Trekking Coordinator',
                'email'       => 'prakash@sptravel.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Senior Trekking Coordinator dedicated to supporting our network of licensed mountain guides and porters. Prakash ensures every team on the trail has the resources and training to deliver world-class service.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/prakash.rai',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/prakash.guides',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'name'        => 'Maya Lama',
                'designation' => 'Customer Experience Manager',
                'email'       => 'maya@sptravel.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Customer Experience Manager leading our 24/7 traveler support team. Maya ensures every guest receives prompt, friendly, and effective assistance before, during, and after their Himalayan adventure.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/maya.lama',
                'youtube'     => null,
                'tiktok'      => 'https://tiktok.com/@maya.support',
                'instagram'   => 'https://instagram.com/maya.cx',
                'order_level' => 6,
                'status'      => true,
            ],
            [
                'name'        => 'Santosh Adhikari',
                'designation' => 'Regional Operations Manager',
                'email'       => 'santosh@sptravel.com',
                'address'     => 'Chitwan, Nepal',
                'bio'         => 'Regional Operations Manager specializing in route verification and quality assurance across popular trekking regions like Everest, Annapurna, and Chitwan. Santosh maintains our high safety standards.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/santosh.adhikari',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/santosh.regional',
                'order_level' => 7,
                'status'      => true,
            ],
            [
                'name'        => 'Kamala Thapa',
                'designation' => 'Finance Manager',
                'email'       => 'kamala@sptravel.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Finance Manager ensuring smooth financial operations. Kamala oversees secure payment processing, accounting, and financial planning for sustainable tourism growth.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/kamala.thapa',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => null,
                'order_level' => 8,
                'status'      => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            Team::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }

        $this->command->info('✓ Travel & Tour team members updated/seeded successfully without duplicates!');
    }
}