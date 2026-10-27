<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class FaqRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        return [
            'display_on'  => 'required|string|max:100',
            'question'    => 'required|string',
            'answer'      => 'required|string',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }
}