<?php

declare(strict_types=1);

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
                'email'       => 'rajesh@ezproperty.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Founder & CEO with 15+ years of experience in Nepal\'s tourism industry. Passionate about connecting travelers with authentic Nepali experiences and empowering local communities through sustainable tourism.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/rajesh.shrestha',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/rajesh.ezproperty',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Sita Gurung',
                'email'       => 'sita@ezproperty.com',
                'address'     => 'Pokhara, Nepal',
                'bio'         => 'Head of Operations with expertise in hospitality management. Sita ensures every property on our platform meets our high standards of quality and authenticity.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/sita.gurung',
                'youtube'     => null,
                'tiktok'      => 'https://tiktok.com/@sita.ezproperty',
                'instagram'   => 'https://instagram.com/sita.ezproperty',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'name'        => 'Bikash Tamang',
                'email'       => 'bikash@ezproperty.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Chief Technology Officer leading our platform development. Bikash brings 10+ years of software engineering experience to create seamless booking experiences for our users.',
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
                'email'       => 'anjali@ezproperty.com',
                'address'     => 'Lalitpur, Nepal',
                'bio'         => 'Marketing Director specializing in digital marketing and brand strategy. Anjali drives our growth through innovative campaigns and community engagement.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/anjali.maharjan',
                'youtube'     => 'https://youtube.com/@anjali.ezproperty',
                'tiktok'      => 'https://tiktok.com/@anjali.ezproperty',
                'instagram'   => 'https://instagram.com/anjali.marketing',
                'order_level' => 4,
                'status'      => true,
            ],
            [
                'name'        => 'Prakash Rai',
                'email'       => 'prakash@ezproperty.com',
                'address'     => 'Biratnagar, Nepal',
                'bio'         => 'Head of Host Relations, dedicated to supporting our growing community of property hosts. Prakash ensures every host has the tools and knowledge to succeed on our platform.',
                'image'       => null,
                'facebook'    => 'https://facebook.com/prakash.rai',
                'youtube'     => null,
                'tiktok'      => null,
                'instagram'   => 'https://instagram.com/prakash.host',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'name'        => 'Maya Lama',
                'email'       => 'maya@ezproperty.com',
                'address'     => 'Kathmandu, Nepal',
                'bio'         => 'Customer Experience Manager leading our 24/7 support team. Maya ensures every guest and host receives prompt, friendly, and effective assistance.',
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
                'email'       => 'santosh@ezproperty.com',
                'address'     => 'Chitwan, Nepal',
                'bio'         => 'Regional Manager for Central Nepal, specializing in property verification and quality assurance. Santosh maintains our high standards across all listed properties.',
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
                'email'       => 'kamala@ezproperty.com',
                'address'     => 'Pokhara, Nepal',
                'bio'         => 'Finance Manager ensuring smooth financial operations. Kamala oversees payments, accounting, and financial planning for sustainable growth.',
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
            Team::create($member);
        }

        $this->command->info('✓ Team members seeded successfully!');
    }
}