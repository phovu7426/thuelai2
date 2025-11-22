@extends('admin.index')

@section('page_title', 'Chỉnh sửa đánh giá khách hàng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.testimonials.index') }}">Danh sách đánh giá</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa đánh giá</li>
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
                            <i class="bi bi-chat-quote-gear"></i> Chỉnh sửa đánh giá khách hàng: {{ $testimonial->customer_name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-testimonial-form" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="customer_name" class="form-label">
                                                    <i class="bi bi-person"></i> Tên khách hàng <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" 
                                                       id="customer_name" name="customer_name" 
                                                       placeholder="👤 Nhập tên khách hàng..." 
                                                       value="{{ old('customer_name', $testimonial->customer_name) }}" required>
                                                <div class="invalid-feedback" id="customer_name-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="service_type" class="form-label">
                                                    <i class="bi bi-gear"></i> Loại dịch vụ
                                                </label>
                                                <select class="form-select" 
                                                        id="service_type" name="service_type">
                                                    <option value="">🚗 Chọn loại dịch vụ</option>
                                                    <option value="hourly" {{ old('service_type', $testimonial->service_type) == 'hourly' ? 'selected' : '' }}>⏰ Lái xe theo giờ</option>
                                                    <option value="trip" {{ old('service_type', $testimonial->service_type) == 'trip' ? 'selected' : '' }}>🚙 Lái xe theo chuyến</option>
                                                    <option value="custom" {{ old('service_type', $testimonial->service_type) == 'custom' ? 'selected' : '' }}>🎯 Lái xe theo yêu cầu</option>
                                                    <option value="business" {{ old('service_type', $testimonial->service_type) == 'business' ? 'selected' : '' }}>🏢 Lái xe cho doanh nghiệp</option>
                                                    <option value="event" {{ old('service_type', $testimonial->service_type) == 'event' ? 'selected' : '' }}>🎉 Lái xe cho sự kiện</option>
                                                </select>
                                                <div class="invalid-feedback" id="service_type-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="rating" class="form-label">
                                                    <i class="bi bi-star"></i> Đánh giá <span class="text-danger">*</span>
                                                </label>
                                                <div class="rating-input">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                                               {{ old('rating', $testimonial->rating) == $i ? 'checked' : '' }} required>
                                                        <label for="star{{ $i }}" class="star-label">
                                                            <i class="fas fa-star"></i>
                                                        </label>
                                                    @endfor
                                                    <span class="rating-text ml-2">({{ old('rating', $testimonial->rating) }}/5)</span>
                                                </div>
                                                <div class="invalid-feedback" id="rating-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="display_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự hiển thị
                                                </label>
                                                <input type="number" class="form-control" 
                                                       id="display_order" name="display_order" 
                                                       placeholder="1" 
                                                       value="{{ old('display_order', $testimonial->display_order) }}" min="1">
                                                <div class="invalid-feedback" id="display_order-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">
                                            <i class="bi bi-chat-quote"></i> Nội dung đánh giá <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" 
                                                  id="content" name="content" rows="5" 
                                                  placeholder="💬 Nhập nội dung đánh giá..." required>{{ old('content', $testimonial->content) }}</textarea>
                                        <div class="invalid-feedback" id="content-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">
                                            <i class="bi bi-sticky"></i> Ghi chú
                                        </label>
                                        <textarea class="form-control" 
                                                  id="notes" name="notes" rows="3" 
                                                  placeholder="📝 Nhập ghi chú...">{{ old('notes', $testimonial->notes) }}</textarea>
                                        <div class="invalid-feedback" id="notes-error"></div>
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
                                                <label for="status" class="form-label">
                                                    <i class="bi bi-toggle-on"></i> Trạng thái
                                                </label>
                                                <select class="form-select" 
                                                        id="status" name="status">
                                                    <option value="active" {{ old('status', $testimonial->status) == 'active' ? 'selected' : '' }}>✅ Hoạt động</option>
                                                    <option value="inactive" {{ old('status', $testimonial->status) == 'inactive' ? 'selected' : '' }}>❌ Không hoạt động</option>
                                                    <option value="pending" {{ old('status', $testimonial->status) == 'pending' ? 'selected' : '' }}>⏳ Chờ duyệt</option>
                                                </select>
                                                <div class="invalid-feedback" id="status-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                                           value="1" {{ old('is_featured', $testimonial->is_featured) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        <i class="bi bi-star"></i> Đánh dấu nổi bật
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="customer_avatar" class="form-label">
                                                    <i class="bi bi-person-circle"></i> Ảnh đại diện
                                                </label>
                                                <x-uploads.file-upload name="customer_avatar" label="Ảnh đại diện" :value="$testimonial->customer_avatar" />
                                                <div class="invalid-feedback" id="customer_avatar-error"></div>
                                                <small class="form-text text-muted">Để trống nếu không muốn thay đổi ảnh</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.driver.testimonials.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật đánh giá
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
$(document).ready(function() {
    // Rating stars interaction
    $('.star-label').on('click', function() {
        const rating = $(this).prev('input[type="radio"]').val();
        $('.rating-text').text(`(${rating}/5)`);
    });

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
    $('#edit-testimonial-form').on('submit', function(e) {
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
            url: '{{ route("admin.driver.testimonials.update", $testimonial) }}',
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
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật đánh giá');
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
.rating-input {
    display: flex;
    align-items: center;
    gap: 5px;
}

.rating-input input[type="radio"] {
    display: none;
}

.star-label {
    cursor: pointer;
    font-size: 24px;
    color: #ddd;
    transition: color 0.2s;
}

.star-label:hover,
.star-label:hover ~ .star-label,
.rating-input input[type="radio"]:checked ~ .star-label {
    color: #ffc107;
}

.rating-text {
    font-weight: bold;
    color: #666;
}

.char-counter {
    font-size: 12px;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush
