{{-- Form cho Driver Services Modal --}}
@csrf

@php
    // Chuẩn hóa data thành object để truy cập đồng nhất (hỗ trợ cả array/object)
    $dataObj = isset($data) ? (is_array($data) ? (object) $data : $data) : null;
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-tag"></i> Tên dịch vụ <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Nhập tên dịch vụ..."
                   value="{{ $name ?? ($dataObj->name ?? old('name')) }}"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="short_description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Mô tả ngắn
            </label>
            <input type="text" name="short_description" id="short_description" class="form-control"
                   placeholder="Nhập mô tả ngắn..."
                   value="{{ $short_description ?? ($dataObj->short_description ?? old('short_description')) }}">
            <div class="invalid-feedback" id="short_descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Mô tả chi tiết
            </label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Nhập mô tả chi tiết...">{{ $description ?? ($dataObj->description ?? old('description')) }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Ảnh dịch vụ" :value="$image ?? $dataObj->image ?? old('image')" />
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="icon" label="Icon dịch vụ" :value="$icon ?? $dataObj->icon ?? old('icon')" />
            <div class="invalid-feedback" id="iconError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="status" id="status" class="form-check-input" value="1"
                       {{ ($status ?? ($dataObj->status ?? old('status', true))) ? 'checked' : '' }}>
                <label class="form-check-label" for="status">
                    <i class="bi bi-toggle-on"></i> Kích hoạt
                </label>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                       {{ ($is_featured ?? ($dataObj->is_featured ?? old('is_featured'))) ? 'checked' : '' }}>
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
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                   placeholder="Nhập thứ tự sắp xếp..."
                   value="{{ $sort_order ?? ($dataObj->sort_order ?? old('sort_order', 0)) }}" min="0">
            <div class="invalid-feedback" id="sort_orderError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Preview image khi chọn file
    $('#image').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = $('<div class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" width="100"></div>');
                $('#image').next('.mt-2').remove();
                $('#image').after(preview);
            }
            reader.readAsDataURL(file);
        }
    });
    
    // Preview icon khi chọn file
    $('#icon').change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = $('<div class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" width="60"></div>');
                $('#icon').next('.mt-2').remove();
                $('#icon').after(preview);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
<script>
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
