<?php

namespace App\Http\Requests\Admin\Posts\PostCategory;

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
            'slug' => 'nullable|string|max:255|unique:post_categories,slug',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:post_categories,id',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|string|max:500'
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
            'name.required' => 'Tên danh mục là bắt buộc.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'slug.unique' => 'Slug đã tồn tại.',
            'slug.max' => 'Slug không được vượt quá 255 ký tự.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'image.string' => 'Đường dẫn ảnh phải là chuỗi.',
            'image.max' => 'Đường dẫn ảnh không được vượt quá 500 ký tự.',
        ];
    }
}


