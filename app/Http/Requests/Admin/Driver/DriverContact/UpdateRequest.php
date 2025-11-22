<?php

namespace App\Http\Requests\Admin\Driver\DriverContact;

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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'topic' => 'required|in:khiếu nại,tư vấn dịch vụ,phản hồi,khác',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|min:10|max:2000',
            'status' => 'required|in:unread,read,replied,closed',
            'admin_notes' => 'nullable|string',
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
            'name.required' => 'Tên là bắt buộc',
            'email.required' => 'Email là bắt buộc',
            'email.email' => 'Email không hợp lệ',
            'phone.required' => 'Số điện thoại là bắt buộc',
            'topic.required' => 'Chủ đề là bắt buộc',
            'topic.in' => 'Chủ đề không hợp lệ',
            'message.required' => 'Nội dung tin nhắn là bắt buộc',
            'message.min' => 'Nội dung tin nhắn phải có ít nhất 10 ký tự',
            'message.max' => 'Nội dung tin nhắn không được vượt quá 2000 ký tự',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
}


