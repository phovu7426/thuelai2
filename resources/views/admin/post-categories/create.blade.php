@extends('admin.index')

@section('title', 'Thêm danh mục mới')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.post-categories.index') }}">Danh mục tin tức</a></li>
                        <li class="breadcrumb-item active">Thêm mới</li>
                    </ol>
                </div>
                <h4 class="page-title">Thêm danh mục mới</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <!-- Alert messages -->
                    <div id="alert-container"></div>

                    <form id="create-category-form" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên danh mục <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" 
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    <div class="invalid-feedback" id="name-error"></div>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" 
                                           id="slug" name="slug" value="{{ old('slug') }}" required>
                                    <div class="invalid-feedback" id="slug-error"></div>
                                    <small class="form-text text-muted">Slug sẽ được tạo tự động từ tên danh mục</small>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả</label>
                                    <textarea class="form-control" 
                                              id="description" name="description" rows="4">{{ old('description') }}</textarea>
                                    <div class="invalid-feedback" id="description-error"></div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Cài đặt</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="color" class="form-label">Màu sắc</label>
                                            <input type="color" class="form-control form-control-color" 
                                                   id="color" name="color" value="{{ old('color', '#007bff') }}" title="Chọn màu sắc">
                                            <div class="invalid-feedback" id="color-error"></div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="sort_order" class="form-label">Thứ tự</label>
                                            <input type="number" class="form-control" 
                                                   id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                                            <div class="invalid-feedback" id="sort_order-error"></div>
                                            <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                                       value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Kích hoạt danh mục
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                                       value="1" {{ old('is_featured', false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Nổi bật danh mục
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <x-uploads.file-upload name="image" label="Hình ảnh" :value="old('image')" />
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
                                        <i class="mdi mdi-arrow-left"></i> Quay lại
                                    </a>
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                        <i class="mdi mdi-content-save"></i> Lưu danh mục
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
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
    $('#create-category-form').on('submit', function(e) {
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
            url: '{{ route("admin.post-categories.store") }}',
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
                    showAlert('danger', 'Có lỗi xảy ra khi lưu danh mục');
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




