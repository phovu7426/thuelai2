<?php

namespace App\Http\Requests\Admin\Permissions;

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
        $permissionId = $this->route('id'); // Lấy ID từ route khi cập nhật

        return [
            'title' => 'required|string|max:255',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($permissionId),
            ],
            'guard_name' => 'nullable|string|max:25',
            'parent_id' => 'nullable|exists:permissions,id',
            'is_default' => 'boolean',
        ];
    }

    /**
     * Hàm trả ra thông báo validate
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tên hiển thị không được để trống.',
            'title.string' => 'Tên hiển thị phải là chuỗi ký tự.',
            'name.required' => 'Tên quyền không được để trống.',
            'name.unique' => 'Tên quyền đã tồn tại.',
            'guard_name.max' => 'Guard name không được vượt quá 25 ký tự.',
            'parent_id.exists' => 'Quyền cha không hợp lệ.',
            'is_default.boolean' => 'Giá trị is_default phải là true hoặc false.',
        ];
    }
}
