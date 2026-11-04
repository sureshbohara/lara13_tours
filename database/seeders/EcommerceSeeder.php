<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Brand;
use App\Models\Category;
use App\Models\ProductAttribute;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Offer;

class EcommerceSeeder extends Seeder
{
   
    public function run(): void
    {
        $this->seedBrands();
        $this->seedProductAttributes();
        $this->seedProducts();
        $this->seedProductVariants();
        $this->seedOffers();
    }

    private function seedBrands(): void
    {
        $brands = [
            [
                'name' => 'Nike',
                'slug' => 'nike',
                'logo' => null,
                'description' => 'Just do it. Leading sports apparel and footwear brand.',
                'website' => 'https://www.nike.com',
                'order_level' => 1,
                'status' => true,
                'meta_title' => 'Nike - Official Store',
                'meta_description' => 'Shop the latest Nike shoes, clothing, and accessories.',
            ],
            [
                'name' => 'Apple',
                'slug' => 'apple',
                'logo' => null,
                'description' => 'Think different. Premium consumer electronics and software.',
                'website' => 'https://www.apple.com',
                'order_level' => 2,
                'status' => true,
                'meta_title' => 'Apple - Official Store',
                'meta_description' => 'Discover the innovative world of Apple and shop everything iPhone, iPad, Mac, and more.',
            ],
            [
                'name' => 'Samsung',
                'slug' => 'samsung',
                'logo' => null,
                'description' => 'Do what you can\'t. Global leader in technology and electronics.',
                'website' => 'https://www.samsung.com',
                'order_level' => 3,
                'status' => true,
                'meta_title' => 'Samsung - Official Store',
                'meta_description' => 'Discover the latest in electronic & smart appliance technology from Samsung.',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }

    private function seedProductAttributes(): void
    {
        $attributes = [
            [
                'name' => 'Color',
                'slug' => 'color',
                'type' => 'color',
                'values' => ['Red (#FF0000)', 'Blue (#0000FF)', 'Black (#000000)', 'White (#FFFFFF)'],
                'order_level' => 1,
                'status' => true,
            ],
            [
                'name' => 'Size',
                'slug' => 'size',
                'type' => 'select',
                'values' => ['Small (S)', 'Medium (M)', 'Large (L)', 'Extra Large (XL)'],
                'order_level' => 2,
                'status' => true,
            ],
            [
                'name' => 'Storage',
                'slug' => 'storage',
                'type' => 'select',
                'values' => ['64GB', '128GB', '256GB', '512GB', '1TB'],
                'order_level' => 3,
                'status' => true,
            ],
            [
                'name' => 'Engraving Text',
                'slug' => 'engraving-text',
                'type' => 'text',
                'values' => [],
                'order_level' => 4,
                'status' => true,
            ],
        ];

        foreach ($attributes as $attribute) {
            ProductAttribute::create($attribute);
        }
    }

    private function seedProducts(): void
    {

        $categoryId = Category::first()?->id; 
        $nikeBrandId = Brand::where('slug', 'nike')->first()?->id;
        $appleBrandId = Brand::where('slug', 'apple')->first()?->id;

        $products = [
  
            [
                'brand_id' => $nikeBrandId,
                'category_id' => $categoryId,
                'name' => 'Classic Cotton T-Shirt',
                'slug' => 'classic-cotton-t-shirt',
                'sku' => 'TSH-001',
                'barcode' => '8901234567890',
                'product_type' => 'simple',
                'regular_price' => 29.99,
                'sale_price' => 24.99,
                'sale_price_start' => now(),
                'sale_price_end' => now()->addMonths(1),
                'manage_stock' => true,
                'stock_quantity' => 150,
                'stock_status' => 'in_stock',
                'low_stock_threshold' => 10,
                'short_description' => 'Comfortable, breathable, and perfect for everyday wear.',
                'description' => '<p>Made from 100% premium cotton, this classic t-shirt offers ultimate comfort and durability. Available in multiple colors and sizes.</p>',
                'tags' => ['clothing', 'casual', 'cotton'],
                'image' => null,
                'gallery' => [''],
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'faqs' => [
                    ['question' => 'Is it machine washable?', 'answer' => 'Yes, wash in cold water.'],
                    ['question' => 'Does it shrink?', 'answer' => 'Minimal shrinkage if washed correctly.']
                ],
                'is_featured' => true,
                'is_virtual' => false,
                'view_count' => 1250,
                'order_level' => 1,
                'status' => true,
                'meta_title' => 'Classic Cotton T-Shirt | Premium Quality',
                'meta_description' => 'Shop our classic cotton t-shirt. Comfortable, durable, and stylish.',
            ],
      
            [
                'brand_id' => $nikeBrandId,
                'category_id' => $categoryId,
                'name' => 'Pro Running Shoes',
                'slug' => 'pro-running-shoes',
                'sku' => 'SHOE-001',
                'barcode' => '8901234567891',
                'product_type' => 'variable',
                'regular_price' => 129.99,
                'sale_price' => null,
                'manage_stock' => true,
                'stock_quantity' => 50,
                'stock_status' => 'in_stock',
                'low_stock_threshold' => 5,
                'short_description' => 'High-performance running shoes with advanced cushioning.',
                'description' => '<p>Engineered for speed and comfort. Features breathable mesh upper and responsive foam midsole.</p>',
                'tags' => ['shoes', 'running', 'sports'],
                'image' => 'products/shoes-thumb.jpg',
                'gallery' => ['products/shoes-1.jpg', 'products/shoes-2.jpg'],
                'is_featured' => true,
                'is_virtual' => false,
                'view_count' => 3400,
                'order_level' => 2,
                'status' => true,
                'meta_title' => 'Pro Running Shoes | High Performance',
                'meta_description' => 'Get the best running experience with our Pro Running Shoes.',
            ],
          
            [
                'brand_id' => $appleBrandId,
                'category_id' => $categoryId,
                'name' => 'Ultimate Web Development Course',
                'slug' => 'ultimate-web-dev-course',
                'sku' => 'DIGI-001',
                'product_type' => 'digital',
                'regular_price' => 99.00,
                'sale_price' => 49.00,
                'manage_stock' => false,
                'stock_status' => 'in_stock',
                'short_description' => 'Master modern web development from scratch.',
                'description' => '<p>A comprehensive 40-hour video course covering HTML, CSS, JavaScript, React, and Node.js.</p>',
                'tags' => ['course', 'digital', 'education'],
                'image' => 'products/course-thumb.jpg',
                'downloadable_file' => 'downloads/web-dev-course.zip',
                'download_limit' => 3,
                'download_expiry_days' => 30,
                'is_featured' => false,
                'is_virtual' => true,
                'view_count' => 890,
                'order_level' => 3,
                'status' => true,
                'meta_title' => 'Ultimate Web Development Course',
                'meta_description' => 'Learn web development with our comprehensive digital course.',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }

    private function seedProductVariants(): void
    {
 
        $variableProduct = Product::where('slug', 'pro-running-shoes')->first();

        if ($variableProduct) {
            $variants = [
                [
                    'product_id' => $variableProduct->id,
                    'sku' => 'SHOE-001-RED-M',
                    'price' => 129.99,
                    'sale_price' => 119.99,
                    'stock_quantity' => 15,
                    'attributes' => ['Color' => 'Red (#FF0000)', 'Size' => 'Medium (M)'],
                    'image' => 'products/shoes-red-m.jpg',
                    'status' => true,
                ],
                [
                    'product_id' => $variableProduct->id,
                    'sku' => 'SHOE-001-BLUE-L',
                    'price' => 129.99,
                    'sale_price' => null,
                    'stock_quantity' => 20,
                    'attributes' => ['Color' => 'Blue (#0000FF)', 'Size' => 'Large (L)'],
                    'image' => 'products/shoes-blue-l.jpg',
                    'status' => true,
                ],
                [
                    'product_id' => $variableProduct->id,
                    'sku' => 'SHOE-001-BLACK-XL',
                    'price' => 129.99,
                    'sale_price' => 129.99,
                    'stock_quantity' => 0,
                    'attributes' => ['Color' => 'Black (#000000)', 'Size' => 'Extra Large (XL)'],
                    'image' => 'products/shoes-black-xl.jpg',
                    'status' => false,
                ],
            ];

            foreach ($variants as $variant) {
                ProductVariant::create($variant);
            }
        }
    }

    private function seedOffers(): void
    {
        $categoryId = Category::first()?->id;
        $productIds = Product::pluck('id')->toArray();

        $offers = [
            // 1. Buy X Get Y Free
            [
                'name' => 'Summer Shoe Sale: Buy 1 Get 1 Free',
                'description' => 'Buy any pair of running shoes and get another pair absolutely free!',
                'offer_type' => 'buy_x_get_y_free',
                'buy_quantity' => 1,
                'get_quantity' => 1,
                'discount_value' => null,
                'apply_on' => 'specific_products',
                'product_ids' => array_slice($productIds, 0, 2), 
                'category_ids' => null,
                'min_order_amount' => 0.00,
                'max_uses' => 100,
                'used_count' => 12,
                'max_uses_per_user' => 1,
                'start_date' => now(),
                'end_date' => now()->addMonths(2),
                'status' => true,
                'priority' => 10,
            ],
         
            [
                'name' => '20% Off All Electronics',
                'description' => 'Get a flat 20% discount on all electronic items and gadgets.',
                'offer_type' => 'percentage_discount',
                'buy_quantity' => 1,
                'get_quantity' => 0,
                'discount_value' => 20.00,
                'apply_on' => 'specific_categories',
                'product_ids' => null,
                'category_ids' => $categoryId ? [$categoryId] : null,
                'min_order_amount' => 50.00,
                'max_uses' => 500,
                'used_count' => 45,
                'max_uses_per_user' => 3,
                'start_date' => now()->subDays(5),
                'end_date' => now()->addDays(10),
                'status' => true,
                'priority' => 5,
            ],
  
            [
                'name' => 'Free Shipping on Orders Over $100',
                'description' => 'No delivery charges for orders above $100. Valid storewide.',
                'offer_type' => 'free_shipping',
                'buy_quantity' => 1,
                'get_quantity' => 0,
                'discount_value' => null,
                'apply_on' => 'all_products',
                'product_ids' => null,
                'category_ids' => null,
                'min_order_amount' => 100.00,
                'max_uses' => null, 
                'used_count' => 150,
                'max_uses_per_user' => 10,
                'start_date' => now(),
                'end_date' => now()->addYear(),
                'status' => true,
                'priority' => 1,
            ],
        ];

        foreach ($offers as $offer) {
            Offer::create($offer);
        }
    }
}