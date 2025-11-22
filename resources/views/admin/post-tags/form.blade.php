{{-- Form cho Post Tags Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-tag"></i> Tên tag <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Nhập tên tag..."
                   value="{{ $name ?? old('name') }}"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
            <div class="form-text">
                <small><i class="bi bi-info-circle"></i> Slug sẽ được tự động tạo từ tên tag</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Mô tả
            </label>
            <textarea name="description" id="description" class="form-control" rows="3"
                      placeholder="Nhập mô tả tag...">{{ $description ?? old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="color" class="form-label">
                <i class="bi bi-palette"></i> Màu sắc
            </label>
            <input type="color" name="color" id="color" class="form-control form-control-color"
                   value="{{ $color ?? old('color', '#007bff') }}"
                   title="Chọn màu sắc cho tag">
            <div class="invalid-feedback" id="colorError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="icon" class="form-label">
                <i class="bi bi-emoji-smile"></i> Icon
            </label>
            <input type="text" name="icon" id="icon" class="form-control"
                   placeholder="Nhập tên icon (ví dụ: bi-tag)..."
                   value="{{ $icon ?? old('icon') }}">
            <div class="invalid-feedback" id="iconError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="is_active" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="0" {{ ($is_active ?? old('is_active', 1)) == '0' ? 'selected' : '' }}>Vô hiệu</option>
                <option value="1" {{ ($is_active ?? old('is_active', 1)) == '1' ? 'selected' : '' }}>Kích hoạt</option>
            </select>
            <div class="invalid-feedback" id="is_activeError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                       {{ ($is_featured ?? old('is_featured')) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">
                    <i class="bi bi-star"></i> Nổi bật
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_title" class="form-label">
                <i class="bi bi-type-bold"></i> Meta Title
            </label>
            <input type="text" name="meta_title" id="meta_title" class="form-control"
                   placeholder="Nhập meta title..."
                   value="{{ $meta_title ?? old('meta_title') }}">
            <div class="invalid-feedback" id="meta_titleError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Meta Description
            </label>
            <input type="text" name="meta_description" id="meta_description" class="form-control"
                   placeholder="Nhập meta description..."
                   value="{{ $meta_description ?? old('meta_description') }}">
            <div class="invalid-feedback" id="meta_descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="meta_keywords" class="form-label">
                <i class="bi bi-tags"></i> Meta Keywords
            </label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                   placeholder="Nhập meta keywords (phân cách bằng dấu phẩy)..."
                   value="{{ $meta_keywords ?? old('meta_keywords') }}">
            <div class="invalid-feedback" id="meta_keywordsError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Auto-generate meta title from name
    $('#name').on('input', function() {
        const name = $(this).val();
        if (name && !$('#meta_title').val()) {
            $('#meta_title').val(name);
        }
    });
    
    // Auto-generate meta description from description
    $('#description').on('input', function() {
        const description = $(this).val();
        if (description && !$('#meta_description').val()) {
            const metaDesc = description.length > 160 ? description.substring(0, 157) + '...' : description;
            $('#meta_description').val(metaDesc);
        }
    });
});
</script>
