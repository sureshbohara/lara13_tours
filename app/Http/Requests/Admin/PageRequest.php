<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $id = $this->route('page')?->id;

        return [
            'title'            => 'required|string|max:255',
            'slug'             => ['nullable', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($id)],
            'icon'             => 'nullable|string|max:100',
            'image'            => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_content'    => 'nullable|string',
            'content'          => 'nullable|string',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:500',
            'show_in_menu'     => 'nullable|boolean',
            'show_in_footer'   => 'nullable|boolean',
            'is_featured'      => 'nullable|boolean',
            'order_level'      => 'nullable|integer|min:0',
            'status'           => 'nullable|boolean',
        ];
    }
}