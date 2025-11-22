<?php

namespace App\Http\Requests\Admin\Driver\DriverDistanceTier;

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
            'description' => 'nullable|string|max:500',
            'from_distance' => 'required|numeric|min:0',
            'to_distance' => 'nullable|numeric|min:0|gt:from_distance',
            'display_text' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'color' => 'nullable|string|max:7',
            'icon' => 'nullable|string|max:255',
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
            'name.required' => 'Tên khoảng cách là bắt buộc.',
            'name.max' => 'Tên khoảng cách không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
            'from_distance.required' => 'Khoảng cách từ là bắt buộc.',
            'from_distance.numeric' => 'Khoảng cách từ phải là số.',
            'from_distance.min' => 'Khoảng cách từ không được nhỏ hơn 0.',
            'to_distance.numeric' => 'Khoảng cách đến phải là số.',
            'to_distance.min' => 'Khoảng cách đến không được nhỏ hơn 0.',
            'to_distance.gt' => 'Khoảng cách đến phải lớn hơn khoảng cách từ.',
            'display_text.required' => 'Text hiển thị là bắt buộc.',
            'display_text.max' => 'Text hiển thị không được vượt quá 255 ký tự.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0.',
            'color.max' => 'Màu sắc không được vượt quá 7 ký tự.',
            'icon.max' => 'Icon không được vượt quá 255 ký tự.',
        ];
    }
}
