<?php
declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductAttributeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $attributeId = $this->route('product_attribute')?->id
            ?? $this->route('product_attribute');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('product_attributes', 'name')->ignore($attributeId),
            ],

            'type' => [
                'required',
                Rule::in(['select', 'text', 'color', 'image']),
            ],

            'values' => [
                'nullable',
                'array',
                'required_if:type,select',
            ],

            'values.*' => [
                'required',
                'string',
                'max:255',
            ],

            'order_level' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Attribute name is required.',
            'name.unique' => 'This attribute name already exists.',
            'type.required' => 'Attribute type is required.',
            'type.in' => 'Invalid attribute type selected.',
            'values.required_if' => 'Values are required for select attributes.',
            'values.array' => 'Attribute values must be an array.',
            'values.*.required' => 'Each attribute value is required.',
            'values.*.string' => 'Each attribute value must be a string.',
            'order_level.integer' => 'Order level must be an integer.',
            'status.boolean' => 'Invalid status value.',
        ];
    }
}