<?php

namespace App\Http\Requests\Admin\Roles;

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
        $roleId = $this->route('id'); // Lấy ID từ route khi cập nhật

        return [
            'title' => 'required|string|max:255',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
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
            'name.required' => 'Tên vai trò không được để trống.',
            'name.unique' => 'Tên vai trò đã tồn tại.',
            'permissions.array' => 'Quyền phải là một mảng.',
            'permissions.*.exists' => 'Quyền không hợp lệ.',
        ];
    }
}
