<?php

namespace App\Http\Requests\Admin\Users\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Hàm check validate
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->route('id')),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'phone' => [
                'nullable',
                'string',
                'max:15',
                'regex:/^[0-9]+$/',
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
            ],
            'birth_date' => [
                'nullable',
                'date',
                'before:today',
            ],
            'gender' => [
                'nullable',
                'in:male,female,other',
            ],
            'status' => [
                'nullable',
                'in:active,inactive',
            ],
            'image' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }

    /**
     * Hàm trả ra thông báo validate
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi văn bản.',
            'name.max' => 'Tên không được quá 255 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max' => 'Số điện thoại không được quá 15 ký tự.',
            'phone.regex' => 'Số điện thoại chỉ có thể chứa các ký tự số.',
            'address.string' => 'Địa chỉ phải là chuỗi văn bản.',
            'address.max' => 'Địa chỉ không được quá 255 ký tự.',
            'birth_date.date' => 'Ngày sinh không hợp lệ.',
            'birth_date.before' => 'Ngày sinh phải trước hôm nay.',
            'gender.in' => 'Giới tính phải là Nam, Nữ hoặc Khác.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'image.string' => 'Đường dẫn ảnh đại diện phải là chuỗi.',
            'image.max' => 'Đường dẫn ảnh đại diện không được vượt quá 500 ký tự.',
        ];
    }
}
