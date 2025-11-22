@extends('admin.index')

@section('page_title', 'Chỉnh sửa danh mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.post-categories.index') }}">Danh sách danh mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa danh mục</li>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-folder-gear"></i> Chỉnh sửa danh mục: {{ $category->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-category-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-folder"></i> Tên danh mục <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" 
                                               id="name" name="name" placeholder="📁 Nhập tên danh mục..." 
                                               value="{{ old('name', $category->name) }}" required>
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">
                                            <i class="bi bi-link"></i> Slug <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" 
                                               id="slug" name="slug" placeholder="slug-danh-muc" 
                                               value="{{ old('slug', $category->slug) }}" required>
                                        <div class="invalid-feedback" id="slug-error"></div>
                                        <small class="form-text text-muted">Slug sẽ được tạo tự động từ tên danh mục</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô tả
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="📄 Nhập mô tả danh mục...">{{ old('description', $category->description) }}</textarea>
                                        <div class="invalid-feedback" id="description-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="bi bi-gear"></i> Cài đặt
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="color" class="form-label">
                                                    <i class="bi bi-palette"></i> Màu sắc
                                                </label>
                                                <input type="color" class="form-control form-control-color" 
                                                       id="color" name="color" value="{{ old('color', $category->color) }}" title="Chọn màu sắc">
                                                <div class="invalid-feedback" id="color-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự
                                                </label>
                                                <input type="number" class="form-control" 
                                                       id="sort_order" name="sort_order" placeholder="0" 
                                                       value="{{ old('sort_order', $category->sort_order) }}" min="0">
                                                <div class="invalid-feedback" id="sort_order-error"></div>
                                                <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                                           value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        <i class="bi bi-toggle-on"></i> Kích hoạt danh mục
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                                           value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        <i class="bi bi-star"></i> Nổi bật danh mục
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="image" class="form-label">
                                                    <i class="bi bi-image"></i> Hình ảnh
                                                </label>
                                                @if($category->image)
                                                    <div class="mb-2">
                                                        <img src="{{ $category->image_url }}" alt="{{ $category->name }}" 
                                                             class="img-thumbnail" style="max-width: 200px;">
                                                    </div>
                                                @endif
                                                <x-uploads.file-upload name="image" label="Hình ảnh" :value="$category->image" />
                                                <div class="invalid-feedback" id="image-error"></div>
                                                <small class="form-text text-muted">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.post-categories.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật danh mục
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@push('scripts')
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
<script>
$(document).ready(function() {
    // Auto generate slug from name
    $('#name').on('input', function() {
        const name = $(this).val();
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
            .replace(/\s+/g, '-') // Replace spaces with hyphens
            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
            .trim('-'); // Remove leading/trailing hyphens
        $('#slug').val(slug);
    });

    // Form submission
    $('#edit-category-form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Show loading state
        const submitBtn = $('#submit-btn');
        const spinner = submitBtn.find('.spinner-border');
        const icon = submitBtn.find('.mdi');
        
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        icon.addClass('d-none');
        
        // Create FormData for file upload
        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.post-categories.update", $category->id) }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.post-categories.index") }}';
                    }, 1000);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    displayErrors(errors);
                    showAlert('danger', 'Vui lòng kiểm tra lại thông tin nhập vào');
                } else {
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật danh mục');
                }
            },
            complete: function() {
                // Reset loading state
                submitBtn.prop('disabled', false);
                spinner.addClass('d-none');
                icon.removeClass('d-none');
            }
        });
    });
});

function clearErrors() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
}

function displayErrors(errors) {
    $.each(errors, function(field, messages) {
        const input = $(`[name="${field}"]`);
        const errorDiv = $(`#${field}-error`);
        
        input.addClass('is-invalid');
        errorDiv.text(messages[0]);
    });
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#alert-container').html(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('#alert-container .alert').fadeOut();
    }, 5000);
}
</script>
@endpush


