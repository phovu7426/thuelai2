<?php

namespace App\Http\Requests\Admin\Posts;

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
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category_id' => 'required|exists:post_categories,id',
            'featured_image' => 'nullable|string|max:500',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string',
            'featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:post_tags,id'
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
            'title.required' => 'Tiêu đề bài viết là bắt buộc.',
            'title.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung bài viết là bắt buộc.',
            'category_id.required' => 'Danh mục bài viết là bắt buộc.',
            'category_id.exists' => 'Danh mục bài viết không tồn tại.',
            'featured_image.string' => 'Đường dẫn ảnh phải là chuỗi.',
            'featured_image.max' => 'Đường dẫn ảnh không được vượt quá 500 ký tự.',
            'status.required' => 'Trạng thái bài viết là bắt buộc.',
            'status.in' => 'Trạng thái bài viết không hợp lệ.',
            'published_at.date' => 'Ngày xuất bản không đúng định dạng.',
            'meta_title.max' => 'Meta title không được vượt quá 255 ký tự.',
            'meta_description.max' => 'Meta description không được vượt quá 500 ký tự.',
            'tags.array' => 'Tags phải là một mảng.',
            'tags.*.exists' => 'Tag không tồn tại.',
        ];
    }
}
