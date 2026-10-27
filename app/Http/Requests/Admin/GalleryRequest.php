<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class GalleryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'display_on'  => 'nullable|string|max:100',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'alt'         => 'nullable|string|max:255',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }
}