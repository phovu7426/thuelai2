<?php

namespace App\Http\Requests\Admin\Driver\DriverService;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
            'status' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'nullable|string|max:500',
            'icon' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên dịch vụ là bắt buộc.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'short_description.max' => 'Mô tả ngắn không được vượt quá 500 ký tự.',
            'image.string' => 'Đường dẫn ảnh phải là chuỗi.',
            'image.max' => 'Đường dẫn ảnh không được vượt quá 500 ký tự.',
            'icon.string' => 'Đường dẫn icon phải là chuỗi.',
            'icon.max' => 'Đường dẫn icon không được vượt quá 500 ký tự.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0.',
        ];
    }
}


