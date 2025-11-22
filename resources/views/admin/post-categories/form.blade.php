{{-- Form cho Post Categories Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-folder"></i> Tên danh mục <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Nhập tên danh mục tin tức..."
                   value="{{ $name ?? $data['name'] ?? old('name') }}"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
            <div class="form-text">
                <small><i class="bi bi-info-circle"></i> Slug sẽ được tự động tạo từ tên danh mục</small>
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
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập mô tả danh mục...">{{ $description ?? $data['description'] ?? old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="parent_id" class="form-label">
                <i class="bi bi-diagram-3"></i> Danh mục cha
            </label>
            <select name="parent_id" id="parent_id" class="form-control">
                <option value="">Không có danh mục cha</option>
                @if(isset($categories) && is_iterable($categories))
                    @foreach($categories as $category)
                        @if(is_object($category) && isset($category->id) && $category->id != ($id ?? $data['id'] ?? 0))
                            <option value="{{ $category->id }}" 
                                    {{ ($parent_id ?? $data['parent_id'] ?? old('parent_id')) == $category->id ? 'selected' : '' }}>
                                {{ $category->name ?? 'Unnamed Category' }}
                            </option>
                        @endif
                    @endforeach
                @endif
            </select>
            <div class="invalid-feedback" id="parent_idError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                   placeholder="Nhập thứ tự sắp xếp..."
                   value="{{ $sort_order ?? $data['sort_order'] ?? old('sort_order', 0) }}"
                   min="0">
            <div class="invalid-feedback" id="sort_orderError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Hình ảnh" :value="$image ?? old('image')" />
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="color" class="form-label">
                <i class="bi bi-palette"></i> Màu sắc
            </label>
            <input type="color" name="color" id="color" class="form-control form-control-color"
                   value="{{ $color ?? $data['color'] ?? '#007bff' }}">
            <div class="invalid-feedback" id="colorError"></div>
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
                <option value="0" {{ ($is_active ?? $data['is_active'] ?? old('is_active', 1)) == '0' ? 'selected' : '' }}>Vô hiệu</option>
                <option value="1" {{ ($is_active ?? $data['is_active'] ?? old('is_active', 1)) == '1' ? 'selected' : '' }}>Kích hoạt</option>
            </select>
            <div class="invalid-feedback" id="is_activeError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                       {{ ($is_featured ?? $data['is_featured'] ?? old('is_featured')) ? 'checked' : '' }}>
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
                   value="{{ $meta_title ?? $data['meta_title'] ?? old('meta_title') }}">
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
                   value="{{ $meta_description ?? $data['meta_description'] ?? old('meta_description') }}">
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
                   value="{{ $meta_keywords ?? $data['meta_keywords'] ?? old('meta_keywords') }}">
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
