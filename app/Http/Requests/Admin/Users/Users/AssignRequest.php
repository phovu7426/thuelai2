<?php

namespace App\Http\Requests\Admin\Users\Users;

use Illuminate\Foundation\Http\FormRequest;

class AssignRequest extends FormRequest
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
        return [
            'roles' => 'array', // Cho phép mảng rỗng
        ];
    }

    /**
     * Hàm trả ra thông báo validate
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'roles.array' => 'Định dạng không hợp lệ',
        ];
    }
}
