{{-- Form cho Categories Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-tag"></i> Tên danh mục <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control" 
                   placeholder="Nhập tên danh mục..." 
                   value="{{ $data['name'] ?? old('name') }}" 
                   required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="mb-3">
            <label for="slug" class="form-label">
                <i class="bi bi-link-45deg"></i> Slug <span class="text-danger">*</span>
            </label>
            <input type="text" name="slug" id="slug" class="form-control" 
                   placeholder="ten-danh-muc" 
                   value="{{ $data['slug'] ?? old('slug') }}" 
                   required>
            <small class="form-text text-muted">URL friendly (không dấu, cách bằng gạch ngang)</small>
            <div class="invalid-feedback" id="slugError"></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">
                <i class="bi bi-card-text"></i> Mô tả
            </label>
            <textarea name="description" id="description" class="form-control" placeholder="Nhập mô tả danh mục..." rows="3">{{ $data['description'] ?? old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="parent_id" class="form-label">
                <i class="bi bi-diagram-3"></i> Danh mục cha
            </label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Không có</option>
                @if(isset($categories) && is_array($categories))
                    @foreach($categories as $category)
                        <option value="{{ $category['id'] }}" 
                                {{ ($data['parent_id'] ?? '') == $category['id'] ? 'selected' : '' }}>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback" id="parent_idError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái <span class="text-danger">*</span>
            </label>
            <select name="status" id="status" class="form-control" required>
                <option value="1" {{ ($data['status'] ?? 1) == 1 ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ ($data['status'] ?? 1) == 0 ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control" 
                   placeholder="0" 
                   value="{{ $data['sort_order'] ?? 0 }}" 
                   min="0">
            <div class="invalid-feedback" id="sort_orderError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="icon" class="form-label">
                <i class="bi bi-emoji-smile"></i> Icon
            </label>
            <input type="text" name="icon" id="icon" class="form-control" 
                   placeholder="bi-house" 
                   value="{{ $data['icon'] ?? old('icon') }}">
            <small class="form-text text-muted">Bootstrap Icons class (ví dụ: bi-house, bi-person)</small>
            <div class="invalid-feedback" id="iconError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" 
                       value="1" {{ ($data['is_featured'] ?? 0) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">
                    <i class="bi bi-star"></i> Danh mục nổi bật
                </label>
            </div>
            <div class="invalid-feedback" id="is_featuredError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="show_in_menu" id="show_in_menu" class="form-check-input" 
                       value="1" {{ ($data['show_in_menu'] ?? 1) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="show_in_menu">
                    <i class="bi bi-list"></i> Hiển thị trong menu
                </label>
            </div>
            <div class="invalid-feedback" id="show_in_menuError"></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="meta_title" class="form-label">
                <i class="bi bi-tag"></i> Meta Title
            </label>
            <input type="text" name="meta_title" id="meta_title" class="form-control" 
                   placeholder="Meta title cho SEO..." 
                   value="{{ $data['meta_title'] ?? old('meta_title') }}">
            <div class="invalid-feedback" id="meta_titleError"></div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="mb-3">
            <label for="meta_description" class="form-label">
                <i class="bi bi-card-text"></i> Meta Description
            </label>
            <textarea name="meta_description" id="meta_description" class="form-control" 
                      placeholder="Meta description cho SEO..." 
                      rows="2">{{ $data['meta_description'] ?? old('meta_description') }}</textarea>
            <div class="invalid-feedback" id="meta_descriptionError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Auto-generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const slug = name.toLowerCase()
            .replace(/đ/g, 'd')
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');
        
        if (slug && !$('#slug').val()) {
            $('#slug').val(slug);
        }
    });

    // Icon preview
    $('#icon').on('input', function() {
        const iconClass = $(this).val();
        if (iconClass) {
            // Có thể thêm preview icon ở đây
            console.log('Icon class:', iconClass);
        }
    });

    // Load categories for parent select if needed
    if ($('#parent_id option').length <= 1) {
        loadCategoriesForSelect();
    }
});

// Function to load categories for parent select
function loadCategoriesForSelect() {
    $.ajax({
        url: '/admin/categories/get-all-categories',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                const select = $('#parent_id');
                select.find('option:not(:first)').remove();
                
                response.data.forEach(category => {
                    select.append(`<option value="${category.id}">${category.name}</option>`);
                });
            }
        }
    });
}
</script>
<!-- CKEditor 5 đã được load từ layout -->
<script>
    $(function(){
      CKEDITOR.replace('description', {
        language: 'vi',
        height: 200,
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserUploadMethod: 'form',
        filebrowserUploadParams: {
          _token: '{{ csrf_token() }}'
        },
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage,image2',
        image2_altRequired: false,
        image2_disableResizer: false,
        removeDialogTabs: '',
      });
    });
</script>
