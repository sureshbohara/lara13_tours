<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $couponId = $this->route('coupon')?->id;

        return [
            'code' => [
                'required',
                'string',
                'max:50',
                'regex:/^[A-Z0-9_-]+$/',
                'unique:coupons,code,' . $couponId,
            ],
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0.01',
            'min_order_amount' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'per_user_limit' => 'nullable|integer|min:1',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'applicable_packages' => 'nullable|array',
            'applicable_packages.*' => 'exists:packages,id',
            'description' => 'nullable|string|max:500',
            'status' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'code.regex' => 'Coupon code can only contain uppercase letters, numbers, hyphens, and underscores.',
            'code.unique' => 'This coupon code already exists.',
            'start_date.after_or_equal' => 'Start date must be today or later.',
            'end_date.after_or_equal' => 'End date must be after start date.',
        ];
    }
}