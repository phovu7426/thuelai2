<?php

namespace App\Http\Requests\Admin\Driver\Testimonial;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'customer_name' => 'required|string|max:255',
            'customer_title' => 'nullable|string|max:255',
            'content' => 'required|string|min:10|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|string|max:500',
            'customer_avatar' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
            'status' => 'boolean',
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
            'customer_name.required' => 'Tên khách hàng là bắt buộc',
            'customer_name.max' => 'Tên khách hàng không được vượt quá 255 ký tự',
            'customer_title.max' => 'Chức danh không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung đánh giá là bắt buộc',
            'content.min' => 'Nội dung đánh giá phải có ít nhất 10 ký tự',
            'content.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự',
            'rating.required' => 'Đánh giá sao là bắt buộc',
            'rating.integer' => 'Đánh giá sao phải là số nguyên',
            'rating.min' => 'Đánh giá sao phải từ 1-5',
            'rating.max' => 'Đánh giá sao phải từ 1-5',
            'image.string' => 'Đường dẫn ảnh phải là chuỗi',
            'image.max' => 'Đường dẫn ảnh không được vượt quá 500 ký tự',
            'customer_avatar.string' => 'Đường dẫn ảnh đại diện phải là chuỗi',
            'customer_avatar.max' => 'Đường dẫn ảnh đại diện không được vượt quá 500 ký tự',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0',
        ];
    }
}


