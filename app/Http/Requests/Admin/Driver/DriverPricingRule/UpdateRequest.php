<?php

namespace App\Http\Requests\Admin\Driver\DriverPricingRule;

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
        $rules = [
            'time_slot' => 'required|string|max:255',
            'time_icon' => 'required|string|max:255',
            'time_color' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];

        // Add dynamic price rules for each distance tier
        $distanceTiers = \App\Models\DriverDistanceTier::all();
        foreach ($distanceTiers as $tier) {
            $rules["price_{$tier->id}"] = 'nullable|string|max:255';
        }

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'time_slot.required' => 'Khung giờ là bắt buộc.',
            'time_slot.max' => 'Khung giờ không được vượt quá 255 ký tự.',
            'time_icon.required' => 'Icon thời gian là bắt buộc.',
            'time_icon.max' => 'Icon thời gian không được vượt quá 255 ký tự.',
            'time_color.required' => 'Màu sắc thời gian là bắt buộc.',
            'time_color.max' => 'Màu sắc thời gian không được vượt quá 255 ký tự.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0.',
        ];
    }
}
