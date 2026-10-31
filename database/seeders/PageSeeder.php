<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title'            => 'Terms & Conditions',
                'slug'             => 'terms-conditions',
                'icon'             => 'bi-file-earmark-text',
                'image'            => null,
                'short_content'    => 'Please read our terms and conditions carefully before using our services.',
                'content'          => '<h2>Terms and Conditions</h2><p><em>Last updated: ' . date('F d, Y') . '</em></p><h3>1. Acceptance of Terms</h3><p>By accessing and using our services, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</p><h3>2. User Accounts</h3><p>Users must provide accurate and complete information when creating an account. You are responsible for maintaining the confidentiality of your account credentials.</p><h3>3. Booking and Payments</h3><p>All bookings are subject to availability and confirmation. Prices are displayed in the local currency unless otherwise stated. Payment must be completed to confirm a booking.</p><h3>4. Cancellation Policy</h3><p>Cancellation policies vary by property or tour. Please review the specific cancellation policy before booking. Refunds are processed according to the stated policy.</p><h3>5. Limitation of Liability</h3><p>We act as a platform connecting guests and service providers. We are not liable for any disputes, damages, or losses arising from stays or tours booked through our platform.</p><h3>6. Governing Law</h3><p>These terms are governed by the laws of Nepal. Any disputes shall be resolved in the courts of Kathmandu.</p>',
                'meta_title'       => 'Terms & Conditions',
                'meta_description' => 'Read our terms and conditions. Understand our policies on bookings, payments, cancellations, and user responsibilities.',
                'meta_keywords'    => 'terms and conditions, booking policy, travel terms',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 3,
                'status'           => true,
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'icon'             => 'bi-shield-lock',
                'image'            => null,
                'short_content'    => 'Learn how we protect and handle your personal information.',
                'content'          => '<h2>Privacy Policy</h2><p><em>Last updated: ' . date('F d, Y') . '</em></p><h3>Introduction</h3><p>We take your privacy seriously. This policy explains how we collect, use, and protect your personal information when you use our services.</p><h3>Information We Collect</h3><p>We collect information you provide directly, including name, email address, contact details, and payment information (processed securely through payment gateways).</p><h3>How We Use Your Information</h3><p>We use your information to process bookings, communicate with you, improve our services, ensure safety, and comply with legal obligations.</p><h3>Data Protection</h3><p>We implement industry-standard security measures to protect your data, including SSL encryption and secure servers.</p><h3>Your Rights</h3><p>You have the right to access, correct, or delete your personal information. Contact us for any privacy-related requests.</p>',
                'meta_title'       => 'Privacy Policy | Data Protection',
                'meta_description' => 'Learn how we collect, use, and protect your personal information.',
                'meta_keywords'    => 'privacy policy, data protection, user privacy',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 4,
                'status'           => true,
            ],
            [
                'title'            => 'How It Works',
                'slug'             => 'how-it-works',
                'icon'             => 'bi-question-circle',
                'image'            => null,
                'short_content'    => 'A simple guide to booking your perfect stay or tour with us.',
                'content'          => '<h2>How It Works</h2><p>Booking your perfect stay or tour is simple, secure, and straightforward. Here\'s a step-by-step guide to help you get started.</p><h3>Step 1: Browse Properties or Tours</h3><p>Explore our curated collection of verified options. Use filters to find what matches your preferences, budget, and travel dates.</p><h3>Step 2: Select Your Choice</h3><p>Click on any listing to view detailed information, photos, amenities, and guest reviews. Check availability for your desired dates.</p><h3>Step 3: Book Securely</h3><p>Once you\'ve found the perfect option, click "Book Now" and complete your reservation. Choose from multiple secure payment options.</p><h3>Step 4: Receive Confirmation</h3><p>You\'ll receive instant confirmation via email with all booking details and instructions.</p><h3>Step 5: Enjoy Your Experience</h3><p>Arrive and enjoy an authentic experience. Our support team is available 24/7 if you need any assistance.</p>',
                'meta_title'       => 'How It Works - Booking Guide',
                'meta_description' => 'Learn how to book properties or tours. Simple step-by-step guide.',
                'meta_keywords'    => 'how it works, booking guide, step by step',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => true,
                'order_level'      => 5,
                'status'           => true,
            ],
            [
                'title'            => 'Travel Insurance',
                'slug'             => 'travel-insurance',
                'icon'             => 'bi-shield-check',
                'image'            => null,
                'short_content'    => 'Why travel insurance is essential and how to get covered for your trip.',
                'content'          => '<h2>Travel Insurance</h2><p>Traveling is exciting, but unexpected events can happen. We strongly recommend that all travelers obtain comprehensive travel insurance before booking their trip.</p><h3>Why Do You Need Travel Insurance?</h3><ul><li><strong>Medical Emergencies:</strong> Covers hospital bills, doctor visits, and emergency evacuation, especially important in remote or high-altitude areas.</li><li><strong>Trip Cancellation:</strong> Reimburses non-refundable costs if you need to cancel your trip due to illness, family emergencies, or other covered reasons.</li><li><strong>Lost or Delayed Baggage:</strong> Provides compensation for lost, stolen, or delayed luggage.</li><li><strong>Trip Interruption:</strong> Covers additional expenses if your trip is cut short due to unforeseen circumstances.</li></ul><h3>What to Look for in a Policy</h3><p>Ensure your policy covers high-altitude trekking (if applicable), emergency helicopter evacuation, and adventure activities. Always read the fine print and declare any pre-existing medical conditions.</p><h3>Our Recommendation</h3><p>While we do not sell insurance directly, we can recommend reputable insurance providers. Please contact our support team for a list of trusted partners.</p>',
                'meta_title'       => 'Travel Insurance Guide | Essential Coverage',
                'meta_description' => 'Learn why travel insurance is essential for your trip and what to look for in a policy.',
                'meta_keywords'    => 'travel insurance, trip cancellation, medical emergency, helicopter evacuation',
                'show_in_menu'     => false,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 8,
                'status'           => true,
            ],
            [
                'title'            => 'How to Book',
                'slug'             => 'how-to-book',
                'icon'             => 'bi-calendar-check',
                'image'            => null,
                'short_content'    => 'A complete step-by-step guide to making a secure reservation.',
                'content'          => '<h2>How to Book</h2><p>Making a reservation with us is easy and secure. Follow these simple steps to book your next adventure.</p><h3>Step 1: Find Your Perfect Trip</h3><p>Use our search filters to browse destinations, durations, and difficulty levels. Click on any package to view the detailed itinerary, inclusions, and pricing.</p><h3>Step 2: Check Availability</h3><p>Select your preferred travel dates and the number of travelers. Our system will instantly show you if the trip is available.</p><h3>Step 3: Fill in Your Details</h3><p>Click "Book Now" and fill out the booking form with your personal information, passport details (if required), and any special requests (e.g., dietary requirements).</p><h3>Step 4: Secure Payment</h3><p>Proceed to the secure payment gateway. We accept major credit cards, bank transfers, and other local payment methods. A small deposit may be required to confirm your booking.</p><h3>Step 5: Confirmation</h3><p>Once payment is successful, you will receive a booking confirmation email with your voucher, detailed itinerary, and pre-departure information. Our team will also contact you to finalize any remaining details.</p>',
                'meta_title'       => 'How to Book | Step-by-Step Reservation Guide',
                'meta_description' => 'Learn how to make a secure booking. Step-by-step guide to reserving your trip.',
                'meta_keywords'    => 'how to book, reservation guide, secure booking, travel booking',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 9,
                'status'           => true,
            ],
            [
                'title'            => 'Group Booking',
                'slug'             => 'group-booking',
                'icon'             => 'bi-people-fill',
                'image'            => null,
                'short_content'    => 'Special rates and customized itineraries for groups of 6 or more.',
                'content'          => '<h2>Group Booking</h2><p>Traveling with friends, family, or a corporate team? We offer special group rates and customized itineraries to make your group travel seamless and memorable.</p><h3>Benefits of Group Booking</h3><ul><li><strong>Exclusive Discounts:</strong> Enjoy special group rates for parties of 6 or more travelers.</li><li><strong>Customized Itineraries:</strong> We can tailor the trip duration, activities, and accommodation to suit your group\'s specific needs.</li><li><strong>Dedicated Support:</strong> A dedicated group coordinator will assist you from the planning stage until the end of your trip.</li><li><strong>Flexible Payment Options:</strong> We offer flexible deposit and payment schedules for large groups.</li></ul><h3>How to Request a Group Quote</h3><p>1. Contact us via email or call our group desk.<br>2. Provide details: number of travelers, preferred dates, destination, and any special requirements.<br>3. We will send you a customized proposal and quote within 48 hours.<br>4. Once approved, we will secure your booking with a group deposit.</p><h3>Minimum Group Size</h3><p>Group rates apply to a minimum of 6 paying travelers. For larger groups (15+), we can arrange private guides, dedicated vehicles, and exclusive accommodations.</p>',
                'meta_title'       => 'Group Booking | Special Rates & Custom Itineraries',
                'meta_description' => 'Get special group rates and customized itineraries for 6 or more travelers. Contact us for a group quote.',
                'meta_keywords'    => 'group booking, group travel, custom itinerary, group discount',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 10,
                'status'           => true,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']], 
                $pageData
            );
        }

        $this->command->info('✓ Pages seeded/updated successfully without duplicates!');
    }
}