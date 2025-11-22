<?php

namespace App\Http\Requests\Admin\Home;

use Illuminate\Foundation\Http\FormRequest;

class HomeBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image' => $this->isMethod('post') || $this->isMethod('put') || $this->isMethod('patch')
                ? 'nullable|image|mimes:jpeg,png,gif,webp|max:5120'
                : 'nullable',
            'link' => 'nullable|url|max:500',
            'button_text' => 'nullable|string|max:100',
            'status' => 'nullable|boolean',
            'is_announcement' => 'nullable|boolean',
        ];
    }
}


