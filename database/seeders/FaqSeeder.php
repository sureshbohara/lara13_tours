<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // General FAQs
            [
                'display_on'  => 'general',
                'question'    => 'How do I book a property on Ez Property?',
                'answer'      => 'Booking is simple! Browse our listings, select your preferred dates, and click "Book Now". You can pay securely online or choose to pay at the property. You\'ll receive instant confirmation via email.',
                'order_level' => 1,
                'status'      => true,
            ],
            [
                'display_on'  => 'general',
                'question'    => 'What payment methods do you accept?',
                'answer'      => 'We accept all major credit/debit cards (Visa, MasterCard, American Express), eSewa, Khalti, bank transfers, and cash payments at select properties. All online payments are processed through our secure payment gateway.',
                'order_level' => 2,
                'status'      => true,
            ],
            [
                'display_on'  => 'general',
                'question'    => 'Is it safe to book through Ez Property?',
                'answer'      => 'Absolutely! All properties on our platform are verified by our team. We use SSL encryption for all transactions, and your personal information is protected. Additionally, our customer support team is available 24/7 to assist you.',
                'order_level' => 3,
                'status'      => true,
            ],
            [
                'display_on'  => 'general',
                'question'    => 'Can I cancel or modify my booking?',
                'answer'      => 'Yes, you can cancel or modify your booking through your account dashboard. Cancellation policies vary by property - some offer free cancellation up to 24-48 hours before check-in. Please review the specific property\'s policy before booking.',
                'order_level' => 4,
                'status'      => true,
            ],

            // Host FAQs
            [
                'display_on'  => 'host',
                'question'    => 'How do I list my property on Ez Property?',
                'answer'      => 'Creating an account is the first step. Once registered, click "Become a Host" and follow the simple listing process. You\'ll need to provide property details, photos, pricing, and availability. Our team will review and approve your listing within 24-48 hours.',
                'order_level' => 5,
                'status'      => true,
            ],
            [
                'display_on'  => 'host',
                'question'    => 'What documents do I need to become a host?',
                'answer'      => 'You\'ll need a valid citizenship certificate or passport, PAN/VAT registration (if applicable), property ownership documents or rental agreement, and recent photos of your property. All documents are verified for security purposes.',
                'order_level' => 6,
                'status'      => true,
            ],
            [
                'display_on'  => 'host',
                'question'    => 'How and when do I get paid?',
                'answer'      => 'Payments are processed within 24 hours after guest check-in. You can receive payments via bank transfer, eSewa, or Khalti. We deduct a small service fee (typically 10-15%) from each booking.',
                'order_level' => 7,
                'status'      => true,
            ],
            [
                'display_on'  => 'host',
                'question'    => 'What are the host responsibilities?',
                'answer'      => 'As a host, you\'re responsible for maintaining accurate listings, responding to inquiries promptly, ensuring the property matches the description, providing clean and safe accommodation, and following our community standards and local regulations.',
                'order_level' => 8,
                'status'      => true,
            ],

            // Guest FAQs
            [
                'display_on'  => 'guest',
                'question'    => 'What should I bring for my stay?',
                'answer'      => 'Bring a valid ID (passport for international guests, citizenship for Nepali guests), your booking confirmation, and personal items. Most properties provide towels, linens, and basic toiletries. Check your specific listing for amenities included.',
                'order_level' => 9,
                'status'      => true,
            ],
            [
                'display_on'  => 'guest',
                'question'    => 'Can I bring pets to the property?',
                'answer'      => 'Pet policies vary by property. Some homestays welcome pets while others don\'t. Please check the property listing for pet policy details or contact the host directly before booking if you plan to bring a pet.',
                'order_level' => 10,
                'status'      => true,
            ],
            [
                'display_on'  => 'guest',
                'question'    => 'What if I have problems during my stay?',
                'answer'      => 'Contact the property host first - they\'re usually the quickest to resolve issues. If you can\'t reach them or the issue isn\'t resolved, contact our 24/7 customer support team through the app, phone, or email. We\'re here to help!',
                'order_level' => 11,
                'status'      => true,
            ],
            [
                'display_on'  => 'guest',
                'question'    => 'Are the prices inclusive of all taxes?',
                'answer'      => 'Yes, all prices displayed on Ez Property are inclusive of applicable taxes and service charges. The price you see is the price you pay - no hidden fees. Some properties may charge additional fees for extra services, which will be clearly mentioned.',
                'order_level' => 12,
                'status'      => true,
            ],

            // Safety FAQs
            [
                'display_on'  => 'safety',
                'question'    => 'How does Ez Property verify hosts and properties?',
                'answer'      => 'We have a rigorous verification process including document verification, property inspection (for premium listings), and guest review monitoring. All hosts must provide valid identification and property ownership/rental documents.',
                'order_level' => 13,
                'status'      => true,
            ],
            [
                'display_on'  => 'safety',
                'question'    => 'What safety measures are in place for guests?',
                'answer'      => 'We provide verified listings with real photos, secure payment processing, 24/7 customer support, emergency contact information, and a review system. All hosts are background-checked and properties must meet basic safety standards.',
                'order_level' => 14,
                'status'      => true,
            ],
            [
                'display_on'  => 'safety',
                'question'    => 'Is my personal information secure?',
                'answer'      => 'Yes, we use industry-standard SSL encryption and follow strict data protection protocols. Your personal information is never shared with third parties without your consent. We comply with Nepal\'s data protection regulations.',
                'order_level' => 15,
                'status'      => true,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }

        $this->command->info('✓ FAQs seeded successfully!');
    }
}