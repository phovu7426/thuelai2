<?php

namespace App\Http\Requests\Admin\Driver\DriverPricingTier;

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
            'time_slot' => 'required|string|max:255',
            'time_icon' => 'required|string|max:255',
            'time_color' => 'required|string|max:255',
            'to_distance' => 'nullable|numeric|min:0|gt:from_distance',
            'price' => 'required|string|max:255',
            'price_type' => 'required|in:fixed,per_km',
            'description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
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
            'time_slot.required' => 'Khung giờ là bắt buộc.',
            'time_slot.max' => 'Khung giờ không được vượt quá 255 ký tự.',
            'time_icon.required' => 'Icon thời gian là bắt buộc.',
            'time_icon.max' => 'Icon thời gian không được vượt quá 255 ký tự.',
            'time_color.required' => 'Màu sắc thời gian là bắt buộc.',
            'time_color.max' => 'Màu sắc thời gian không được vượt quá 255 ký tự.',
            'to_distance.numeric' => 'Khoảng cách đến phải là số.',
            'to_distance.min' => 'Khoảng cách đến không được nhỏ hơn 0.',
            'to_distance.gt' => 'Khoảng cách đến phải lớn hơn khoảng cách từ.',
            'price.required' => 'Giá là bắt buộc.',
            'price.string' => 'Giá phải là chuỗi ký tự.',
            'price.max' => 'Giá không được vượt quá 255 ký tự.',
            'price_type.required' => 'Loại giá là bắt buộc.',
            'price_type.in' => 'Loại giá không hợp lệ.',
            'description.max' => 'Mô tả không được vượt quá 500 ký tự.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0.',
        ];
    }
}
