<?php

namespace App\Http\Requests\Admin\Users\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'google_id' => 'nullable|string|max:255',
            // users.status is enum('active','inactive')
            'status' => 'nullable|in:active,inactive',
            // user avatar
            'image' => 'nullable|string|max:500',
            // Profile fields
            'phone' => 'nullable|string|max:15|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date|before:today',
            'gender' => 'nullable|in:male,female,other',
        ];
    }

    /**
     * Hàm trả ra thông báo validate
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Tên phải là chuỗi văn bản.',
            'name.max' => 'Tên không được quá 255 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'status.in' => 'Trạng thái không hợp lệ.',
            'image.string' => 'Đường dẫn ảnh đại diện phải là chuỗi.',
            'image.max' => 'Đường dẫn ảnh đại diện không được vượt quá 500 ký tự.',
            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max' => 'Số điện thoại không được quá 15 ký tự.',
            'phone.regex' => 'Số điện thoại chỉ có thể chứa các ký tự số.',
            'address.string' => 'Địa chỉ phải là chuỗi văn bản.',
            'address.max' => 'Địa chỉ không được quá 255 ký tự.',
            'birth_date.date' => 'Ngày sinh không hợp lệ.',
            'birth_date.before' => 'Ngày sinh phải trước hôm nay.',
            'gender.in' => 'Giới tính phải là Nam, Nữ hoặc Khác.',
        ];
    }
}
