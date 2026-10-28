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
                'title'            => 'About Us',
                'slug'             => 'about-us',
                'icon'             => 'bi-info-circle',
                'image'            => null,
                'short_content'    => 'Learn about Ez Property\'s mission to connect travelers with authentic Nepali experiences.',
                'content'          => '<h2>Our Story</h2><p>Ez Property was founded in 2020 with a simple mission: to make authentic Nepali hospitality accessible to travelers worldwide. What started as a small homestay network in Kathmandu has grown into Nepal\'s leading property booking platform.</p><h3>Our Mission</h3><p>We believe travel should be more than just sightseeing. It should be about connecting with local communities, experiencing genuine culture, and creating meaningful memories. That\'s why we partner exclusively with verified local hosts who share our passion for authentic experiences.</p><h3>Our Vision</h3><p>To become the most trusted platform for authentic travel experiences in South Asia, empowering local communities while providing unforgettable journeys for travelers.</p><h3>Our Values</h3><ul><li><strong>Authenticity:</strong> Real experiences with real people</li><li><strong>Trust:</strong> Verified properties and secure transactions</li><li><strong>Community:</strong> Supporting local hosts and their families</li><li><strong>Sustainability:</strong> Promoting responsible tourism</li></ul>',
                'meta_title'       => 'About Us - Ez Property | Nepal\'s Leading Homestay Platform',
                'meta_description' => 'Learn about Ez Property\'s mission to connect travelers with authentic Nepali experiences and empower local communities.',
                'meta_keywords'    => 'about ez property, nepal homestay platform, our story',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 1,
                'status'           => true,
            ],
            [
                'title'            => 'Contact Us',
                'slug'             => 'contact-us',
                'icon'             => 'bi-envelope',
                'image'            => null,
                'short_content'    => 'Get in touch with our friendly support team. We\'re here to help 24/7.',
                'content'          => '<h2>Get In Touch</h2><p>We\'d love to hear from you! Whether you have questions about booking, need help with your stay, or want to list your property, our team is here to assist you.</p><h3>Customer Support</h3><p>Our customer support team is available 24/7 to help you with any inquiries.</p><ul><li><strong>Email:</strong> support@ezproperty.com</li><li><strong>Phone:</strong> +977-1-4XXXXXX</li><li><strong>WhatsApp:</strong> +977-98XXXXXXXX</li></ul><h3>Office Address</h3><p>Ez Property Pvt. Ltd.<br>Thamel, Kathmandu<br>Nepal - 44600</p><h3>Business Hours</h3><p>Monday - Friday: 9:00 AM - 6:00 PM<br>Saturday: 10:00 AM - 4:00 PM<br>Sunday: Closed (Emergency support available)</p><h3>For Hosts</h3><p>Interested in listing your property? Contact our host relations team at hosts@ezproperty.com or call +977-1-4XXXXXX.</p>',
                'meta_title'       => 'Contact Us - Ez Property | 24/7 Customer Support',
                'meta_description' => 'Contact Ez Property customer support. Available 24/7 via email, phone, and WhatsApp for all your booking needs.',
                'meta_keywords'    => 'contact ez property, customer support, nepal homestay contact',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 2,
                'status'           => true,
            ],
            [
                'title'            => 'Terms & Conditions',
                'slug'             => 'terms-conditions',
                'icon'             => 'bi-file-earmark-text',
                'image'            => null,
                'short_content'    => 'Please read our terms and conditions carefully before using our services.',
                'content'          => '<h2>Terms and Conditions</h2><p><em>Last updated: ' . date('F d, Y') . '</em></p><h3>1. Acceptance of Terms</h3><p>By accessing and using Ez Property services, you agree to be bound by these Terms and Conditions. If you do not agree with any part of these terms, you must not use our services.</p><h3>2. User Accounts</h3><p>Users must provide accurate and complete information when creating an account. You are responsible for maintaining the confidentiality of your account credentials and for all activities under your account.</p><h3>3. Booking and Payments</h3><p>All bookings are subject to availability and confirmation. Prices are displayed in Nepalese Rupees (NPR) unless otherwise stated. Payment must be completed to confirm a booking.</p><h3>4. Cancellation Policy</h3><p>Cancellation policies vary by property. Please review the specific property\'s cancellation policy before booking. Refunds are processed according to the stated policy.</p><h3>5. Host Responsibilities</h3><p>Hosts must maintain accurate listings, respond to inquiries promptly, and ensure properties match their descriptions. Hosts are responsible for compliance with local laws and regulations.</p><h3>6. Guest Responsibilities</h3><p>Guests must respect property rules, treat hosts and their properties with respect, and comply with all applicable laws during their stay.</p><h3>7. Limitation of Liability</h3><p>Ez Property acts as a platform connecting guests and hosts. We are not liable for any disputes, damages, or losses arising from stays booked through our platform.</p><h3>8. Intellectual Property</h3><p>All content on Ez Property, including text, graphics, logos, and software, is the property of Ez Property or its licensors and is protected by copyright laws.</p><h3>9. Modifications</h3><p>We reserve the right to modify these terms at any time. Continued use of our services after changes constitutes acceptance of the new terms.</p><h3>10. Governing Law</h3><p>These terms are governed by the laws of Nepal. Any disputes shall be resolved in the courts of Kathmandu.</p>',
                'meta_title'       => 'Terms & Conditions - Ez Property',
                'meta_description' => 'Read Ez Property\'s terms and conditions. Understand our policies on bookings, payments, cancellations, and user responsibilities.',
                'meta_keywords'    => 'terms and conditions, ez property terms, booking policy',
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
                'content'          => '<h2>Privacy Policy</h2><p><em>Last updated: ' . date('F d, Y') . '</em></p><h3>Introduction</h3><p>At Ez Property, we take your privacy seriously. This policy explains how we collect, use, and protect your personal information when you use our services.</p><h3>Information We Collect</h3><p>We collect information you provide directly, including:</p><ul><li>Name, email address, and contact details</li><li>Payment information (processed securely through payment gateways)</li><li>Property details (for hosts)</li><li>Reviews and communications</li></ul><h3>How We Use Your Information</h3><p>We use your information to:</p><ul><li>Process bookings and payments</li><li>Communicate with you about your account and bookings</li><li>Improve our services and user experience</li><li>Ensure safety and security on our platform</li><li>Comply with legal obligations</li></ul><h3>Data Protection</h3><p>We implement industry-standard security measures to protect your data, including SSL encryption, secure servers, and regular security audits.</p><h3>Third-Party Services</h3><p>We may share information with trusted third parties (payment processors, analytics services) only as necessary to provide our services.</p><h3>Your Rights</h3><p>You have the right to access, correct, or delete your personal information. Contact us at privacy@ezproperty.com for any privacy-related requests.</p><h3>Cookies</h3><p>We use cookies to improve your browsing experience. You can control cookie settings through your browser preferences.</p><h3>Changes to This Policy</h3><p>We may update this privacy policy periodically. We\'ll notify you of significant changes via email or through our platform.</p>',
                'meta_title'       => 'Privacy Policy - Ez Property | Data Protection',
                'meta_description' => 'Ez Property\'s privacy policy. Learn how we collect, use, and protect your personal information.',
                'meta_keywords'    => 'privacy policy, data protection, ez property privacy',
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
                'short_content'    => 'A simple guide to booking your perfect stay with Ez Property.',
                'content'          => '<h2>How Ez Property Works</h2><p>Booking your perfect stay with Ez Property is simple, secure, and straightforward. Here\'s a step-by-step guide to help you get started.</p><h3>For Guests</h3><h4>Step 1: Browse Properties</h4><p>Explore our curated collection of verified homestays, apartments, and resorts across Nepal. Use filters to find properties that match your preferences, budget, and travel dates.</p><h4>Step 2: Select Your Stay</h4><p>Click on any property to view detailed information, photos, amenities, and guest reviews. Check availability for your desired dates.</p><h4>Step 3: Book Securely</h4><p>Once you\'ve found the perfect property, click "Book Now" and complete your reservation. Choose from multiple secure payment options.</p><h4>Step 4: Receive Confirmation</h4><p>You\'ll receive instant confirmation via email with all booking details, host contact information, and check-in instructions.</p><h4>Step 5: Enjoy Your Stay</h4><p>Arrive at your property and enjoy an authentic Nepali experience. Our support team is available 24/7 if you need any assistance.</p><h3>For Hosts</h3><h4>Step 1: Create Account</h4><p>Sign up as a host and complete your profile with necessary verification documents.</h4><h4>Step 2: List Your Property</h4><p>Add photos, descriptions, amenities, pricing, and availability for your property.</h4><h4>Step 3: Get Verified</h4><p>Our team reviews your listing and verifies your documents within 24-48 hours.</h4><h4>Step 4: Start Earning</h4><p>Once approved, your property goes live and you can start receiving bookings.</h4>',
                'meta_title'       => 'How It Works - Book Your Stay with Ez Property',
                'meta_description' => 'Learn how to book properties on Ez Property. Simple step-by-step guide for guests and hosts.',
                'meta_keywords'    => 'how it works, booking guide, ez property guide',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => true,
                'order_level'      => 5,
                'status'           => true,
            ],
            [
                'title'            => 'Become a Host',
                'slug'             => 'become-a-host',
                'icon'             => 'bi-house-add',
                'image'            => null,
                'short_content'    => 'Turn your property into a source of income. Join our growing community of hosts.',
                'content'          => '<h2>Become an Ez Property Host</h2><p>Join thousands of successful hosts across Nepal and start earning from your property. Whether you have a spare room, an entire apartment, or a resort, Ez Property makes it easy to list and manage your property.</p><h3>Why Host with Us?</h3><ul><li><strong>Large Audience:</strong> Access to thousands of travelers looking for authentic experiences</li><li><strong>Easy Management:</strong> User-friendly dashboard to manage bookings and availability</li><li><strong>Secure Payments:</strong> Get paid reliably and on time</li><li><strong>24/7 Support:</strong> Our team is here to help you succeed</li><li><strong>Marketing Tools:</strong> We promote your property to maximize bookings</li></ul><h3>Requirements</h3><p>To become a host, you\'ll need:</p><ul><li>Valid citizenship or passport</li><li>Property ownership or rental agreement</li><li>PAN/VAT registration (if applicable)</li><li>Clear photos of your property</li><li>Bank account for payments</li></ul><h3>Getting Started</h3><p>Ready to list your property? Click the "Sign Up as Host" button below and follow the simple registration process. Our team will guide you through every step.</p>',
                'meta_title'       => 'Become a Host - List Your Property on Ez Property',
                'meta_description' => 'Earn from your property by becoming an Ez Property host. Easy registration, secure payments, and 24/7 support.',
                'meta_keywords'    => 'become a host, list property, earn from property, nepal homestay host',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => true,
                'order_level'      => 6,
                'status'           => true,
            ],
            [
                'title'            => 'FAQ',
                'slug'             => 'faq',
                'icon'             => 'bi-question-circle-fill',
                'image'            => null,
                'short_content'    => 'Find answers to common questions about booking, hosting, and our services.',
                'content'          => '<h2>Frequently Asked Questions</h2><p>Find quick answers to the most common questions about Ez Property. Can\'t find what you\'re looking for? Contact our support team anytime.</p><h3>For Guests</h3><p>Visit our <a href="/pages/booking-faq">Booking FAQ</a> page for detailed information about reservations, payments, and cancellations.</p><h3>For Hosts</h3><p>Visit our <a href="/pages/hosting-faq">Hosting FAQ</a> page for information about listing your property, payments, and host responsibilities.</p><h3>General Questions</h3><p>For general questions about Ez Property, our services, or policies, please contact our customer support team.</p>',
                'meta_title'       => 'FAQ - Frequently Asked Questions | Ez Property',
                'meta_description' => 'Find answers to common questions about Ez Property. Booking, hosting, payments, and more.',
                'meta_keywords'    => 'faq, frequently asked questions, ez property help',
                'show_in_menu'     => true,
                'show_in_footer'   => true,
                'is_featured'      => false,
                'order_level'      => 7,
                'status'           => true,
            ],
        ];

        foreach ($pages as $page) {
            Page::create($page);
        }

        $this->command->info('✓ Pages seeded successfully!');
    }
}