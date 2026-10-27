<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $blogId = $this->route('blog')?->id;
        
        return [
            'title'             => 'required|string|max:255',
            'slug'              => $blogId ? 'nullable|string|max:255|unique:blogs,slug,' . $blogId : 'nullable|string|max:255|unique:blogs,slug',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'excerpt'           => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'meta_title'        => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
            'is_featured'       => 'nullable|boolean',
            'status'            => 'nullable|boolean',
            'order_level'       => 'nullable|integer|min:0',
            'category_ids'      => 'required|array|min:1', 
            'category_ids.*'    => 'exists:categories,id',
        ];
    }
}