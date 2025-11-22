@extends('admin.index')

@section('page_title', 'Thêm mới đánh giá khách hàng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.dashboard') }}">Dịch vụ lái xe</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.testimonials.index') }}">Đánh giá khách hàng</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm mới</li>
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
                            <i class="bi bi-chat-quote"></i> Thêm mới đánh giá khách hàng
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="create-testimonial-form" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_name" class="form-label">
                                            <i class="bi bi-person"></i> Tên khách hàng
                                        </label>
                                        <input type="text" name="customer_name" id="customer_name" class="form-control"
                                               placeholder="👤 Nhập tên khách hàng..." value="{{ old('customer_name') }}" required>
                                        <div class="invalid-feedback" id="customer_name-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="customer_position" class="form-label">
                                            <i class="bi bi-briefcase"></i> Chức vụ
                                        </label>
                                        <input type="text" name="customer_position" id="customer_position" class="form-control"
                                               placeholder="💼 Nhập chức vụ..." value="{{ old('customer_position') }}">
                                        <div class="invalid-feedback" id="customer_position-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="rating" class="form-label">
                                            <i class="bi bi-star"></i> Đánh giá
                                        </label>
                                        <select name="rating" id="rating" class="form-control" required>
                                            <option value="">⭐ Chọn số sao</option>
                                            <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 sao</option>
                                            <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 sao</option>
                                            <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 sao</option>
                                            <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 sao</option>
                                            <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 sao</option>
                                        </select>
                                        <div class="invalid-feedback" id="rating-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="image" class="form-label">
                                            <i class="bi bi-image"></i> Hình ảnh
                                        </label>
                                        <x-uploads.file-upload name="image" label="Hình ảnh" :value="old('image')" />
                                        <small class="text-muted">Hỗ trợ: JPG, PNG, GIF (tối đa 2MB)</small>
                                        <div class="invalid-feedback" id="image-error"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">
                                            <i class="bi bi-chat-text"></i> Nội dung đánh giá
                                        </label>
                                        <textarea name="content" id="content" class="form-control" rows="5"
                                                  placeholder="💬 Nhập nội dung đánh giá..." required>{{ old('content') }}</textarea>
                                        <div class="invalid-feedback" id="content-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="status" id="status" class="form-check-input" value="1" {{ old('status') ? 'checked' : '' }}>
                                            <label for="status" class="form-check-label">
                                                <i class="bi bi-check-circle"></i> Kích hoạt
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input type="checkbox" name="featured" id="featured" class="form-check-input" value="1" {{ old('featured') ? 'checked' : '' }}>
                                            <label for="featured" class="form-check-label">
                                                <i class="bi bi-star"></i> Nổi bật
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('admin.driver.testimonials.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Thêm mới
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Character counter for content
    $('#content').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$(this).next('.char-counter').length) {
            $(this).after('<small class="form-text text-muted char-counter"></small>');
        }
        
        $(this).next('.char-counter').text(`${currentLength}/${maxLength} ký tự`);
        
        if (remaining < 0) {
            $(this).next('.char-counter').addClass('text-danger');
        } else {
            $(this).next('.char-counter').removeClass('text-danger');
        }
    });

    // Form submission
    $('#create-testimonial-form').on('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearErrors();
        
        // Show loading state
        const submitBtn = $('#submit-btn');
        const spinner = submitBtn.find('.spinner-border');
        const icon = submitBtn.find('.bi');
        
        submitBtn.prop('disabled', true);
        spinner.removeClass('d-none');
        icon.addClass('d-none');
        
        // Create FormData for file upload
        const formData = new FormData(this);
        
        $.ajax({
            url: '{{ route("admin.driver.testimonials.store") }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.driver.testimonials.index") }}';
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
                    showAlert('danger', 'Có lỗi xảy ra khi tạo đánh giá');
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

<style>
.char-counter {
    font-size: 12px;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush
