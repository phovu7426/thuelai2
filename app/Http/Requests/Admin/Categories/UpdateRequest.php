<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Hàm check validate
     * @return string[]
     */
    public function rules(): array
    {
        $categoryId = $this->route('id');

        return [
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                Rule::unique('categories', 'code')->ignore($categoryId),
                'max:100',
            ],
            'slug' => [
                'required',
                'string',
                Rule::unique('categories', 'slug')->ignore($categoryId),
                'max:255',
            ],
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'boolean',
        ];
    }

    /**
     * Hàm trả ra thông báo validate
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên danh mục không được để trống.',
            'code.required' => 'Mã danh mục không được để trống.',
            'code.unique' => 'Mã danh mục đã tồn tại.',
            'slug.required' => 'Slug không được để trống.',
            'slug.unique' => 'Slug đã tồn tại.',
            'parent_id.exists' => 'Danh mục cha không hợp lệ.',
        ];
    }
}
