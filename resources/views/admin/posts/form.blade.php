{{-- Form cho Posts Modal --}}
@csrf

@php
    $statusValue = $status ?? old('status', 'draft');
    $featuredValue = $featured ?? old('featured', 0);
    // Chuẩn hóa category thành object để truy cập đồng nhất
    $categoryObj = isset($category)
        ? (is_array($category) ? (object) $category : $category)
        : null;
    $categoryIdValue = $category_id ?? ($categoryObj->id ?? old('category_id'));
    $categoryText = $categoryObj ? ($categoryObj->name ?? null) : null;
@endphp

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="title" class="form-label">
                <i class="bi bi-file-text"></i> Tiêu đề bài viết <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control"
                   placeholder="Nhập tiêu đề bài viết..."
                   value="{{ $title ?? old('title') }}"
                   required>
            <div class="invalid-feedback" id="titleError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="category_id" class="form-label">
                <i class="bi bi-folder"></i> Danh mục
            </label>
            <select name="category_id" id="category_id" class="form-control select2"
                    data-url="{{ route('admin.post-categories.autocomplete') }}"
                    data-field="id"
                    data-display-field="name"
                    data-selected='@json($categoryIdValue)'
                    data-fetch-url="{{ url('/admin/post-categories/:id') }}">
                <option value="">Chọn danh mục</option>
            </select>
            <div class="invalid-feedback" id="category_idError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="status" id="status" class="form-control">
                <option value="draft" {{ ($statusValue ?? '') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                <option value="published" {{ ($statusValue ?? '') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Ảnh đại diện" :value="$image ?? old('image')" />
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="excerpt" class="form-label">
                <i class="bi bi-text-paragraph"></i> Tóm tắt
            </label>
            <textarea name="excerpt" id="excerpt" class="form-control" rows="3"
                      placeholder="Nhập tóm tắt bài viết...">{{ $excerpt ?? old('excerpt') }}</textarea>
            <div class="invalid-feedback" id="excerptError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">
                <i class="bi bi-file-earmark-text"></i> Nội dung <span class="text-danger">*</span>
            </label>
            <textarea name="content" id="content" class="form-control" rows="8" placeholder="Nhập nội dung bài viết..." required>{{ $content ?? old('content') }}</textarea>
            <div class="invalid-feedback" id="contentError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_title" class="form-label">
                <i class="bi bi-tag"></i> Meta Title
            </label>
            <input type="text" name="meta_title" id="meta_title" class="form-control"
                   placeholder="Meta title cho SEO..."
                   value="{{ $meta_title ?? old('meta_title') }}">
            <div class="invalid-feedback" id="meta_titleError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_keywords" class="form-label">
                <i class="bi bi-tags"></i> Meta Keywords
            </label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                   placeholder="Từ khóa SEO, phân cách bằng dấu phẩy..."
                   value="{{ $meta_keywords ?? old('meta_keywords') }}">
            <div class="invalid-feedback" id="meta_keywordsError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="meta_description" class="form-label">
                <i class="bi bi-card-text"></i> Meta Description
            </label>
            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"
                      placeholder="Mô tả meta cho SEO...">{{ $meta_description ?? old('meta_description') }}</textarea>
            <div class="invalid-feedback" id="meta_descriptionError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Auto-generate meta title from title if empty
    $('#title').on('input', function() {
        const title = $(this).val();
        if (title && !$('#meta_title').val()) {
            $('#meta_title').val(title);
        }
    });
    
    // Auto-generate excerpt from content if empty
    $('#content').on('input', function() {
        const content = $(this).val();
        if (content && !$('#excerpt').val()) {
            const excerpt = content.substring(0, 200).trim();
            $('#excerpt').val(excerpt);
        }
    });
    
    // Đảm bảo Select2 được khởi tạo với delay
    setTimeout(function() {
        if (typeof initializeSelect2 === 'function') {
            initializeSelect2();
        }
    }, 100);
});
</script>
<script>
    // Khởi tạo qua shim CKEditor 5 (đã load ở layout)
    CKEDITOR.replace('content', {
        language: 'vi',
        height: 400,
        uploadUrl: '{{ url('/upload') }}?_token={{ csrf_token() }}',
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}'
    });
</script>
