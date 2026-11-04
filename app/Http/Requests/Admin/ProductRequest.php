<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }


    protected function prepareForValidation()
    {
        $this->merge([
            'is_featured'  => $this->boolean('is_featured'),
            'is_virtual'   => $this->boolean('is_virtual'),
            'status'       => $this->boolean('status'),
            'manage_stock' => $this->boolean('manage_stock'),
        ]);
    }

    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'slug' => $productId
                ? 'nullable|string|max:255|unique:products,slug,' . $productId
                : 'nullable|string|max:255|unique:products,slug',
            'sku' => $productId
                ? 'nullable|string|max:100|unique:products,sku,' . $productId
                : 'nullable|string|max:100|unique:products,sku',
            'barcode' => 'nullable|string|max:100',
            'product_type' => 'required|in:simple,variable,grouped,digital',
            'regular_price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:regular_price',
            'sale_price_start' => 'nullable|date',
            'sale_price_end' => 'nullable|date|after_or_equal:sale_price_start',
            
        
            'manage_stock' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'stock_status' => 'required|in:in_stock,out_of_stock,on_backorder',
            'low_stock_threshold' => 'nullable|integer|min:0',
            
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'video_url' => 'nullable|url|max:255',
            'tags' => 'nullable|array',
            
           
            'is_featured' => 'boolean',
            'is_virtual' => 'boolean',
            'status' => 'boolean',
            
            'order_level' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            
         
            'faqs' => 'nullable|array',
            'downloadable_file' => 'nullable|file|mimes:pdf,zip,rar|max:10240',
            'download_limit' => 'nullable|integer|min:0',
            'download_expiry_days' => 'nullable|integer|min:0',
     


            'bundle_products' => 'nullable|array',
            'bundle_products.*.child_product_id' => 'required_with:bundle_products|exists:products,id',
            'bundle_products.*.quantity' => 'required_with:bundle_products|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'name.required' => 'Product name is required.',
            'regular_price.required' => 'Regular price is required.',
            'sale_price.lt' => 'Sale price must be less than regular price.',
            'sale_price_end.after_or_equal' => 'End date must be after start date.',
        ];
    }
}