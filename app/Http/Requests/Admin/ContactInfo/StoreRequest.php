<?php

namespace App\Http\Requests\Admin\ContactInfo;

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
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'working_time' => 'nullable|string|max:255',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'map_embed' => 'nullable|string',
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
            'email.email' => 'Email không đúng định dạng.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'working_time.max' => 'Thời gian làm việc không được vượt quá 255 ký tự.',
            'facebook.url' => 'Link Facebook không đúng định dạng.',
            'instagram.url' => 'Link Instagram không đúng định dạng.',
            'youtube.url' => 'Link YouTube không đúng định dạng.',
            'linkedin.url' => 'Link LinkedIn không đúng định dạng.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'address' => 'Địa chỉ',
            'phone' => 'Số điện thoại',
            'email' => 'Email',
            'working_time' => 'Thời gian làm việc',
            'facebook' => 'Facebook',
            'instagram' => 'Instagram',
            'youtube' => 'YouTube',
            'linkedin' => 'LinkedIn',
            'map_embed' => 'Mã nhúng bản đồ',
        ];
    }
}
