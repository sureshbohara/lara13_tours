<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return auth('admin')->check();
    }


    public function rules(): array
    {
        return [
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'permission' => ['nullable', 'array'],
        ];
    }
}