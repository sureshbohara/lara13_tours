<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255',
            'address'     => 'nullable|string|max:255',
            'rating'      => 'required|integer|min:1|max:5',
            'review'      => 'required|string',
            'content'     => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'display_on'  => 'nullable|string|max:100',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }
}