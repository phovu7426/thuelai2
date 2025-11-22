<?php

namespace App\Http\Requests\Admin\Slides;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => $this->isMethod('post') ? 'required|string|max:500' : 'nullable|string|max:500',
            'link' => 'nullable|url',
            'status' => 'required|boolean',
        ];
    }
}
