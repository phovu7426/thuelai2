@extends('admin.index')

@section('page_title', 'Thêm mức giá mới')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.pricing-tiers.index') }}">Giá theo khoảng cách</a>
    </li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">
                                <i class="bi bi-currency-dollar"></i> Thêm mức giá mới
                            </h3>
                            <a href="{{ route('admin.driver.pricing-tiers.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="create-pricing-tier-form">
                            @csrf
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="time_slot" class="form-label">
                                            <i class="bi bi-clock"></i> Thời gian <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" 
                                                id="time_slot" 
                                                name="time_slot" 
                                                required>
                                            <option value="">🕐 Chọn thời gian</option>
                                            <option value="Trước 22h" {{ old('time_slot') == 'Trước 22h' ? 'selected' : '' }}>🌅 Trước 22h</option>
                                            <option value="22h - 24h" {{ old('time_slot') == '22h - 24h' ? 'selected' : '' }}>🌙 22h - 24h</option>
                                            <option value="Sau 24h" {{ old('time_slot') == 'Sau 24h' ? 'selected' : '' }}>⭐ Sau 24h</option>
                                        </select>
                                        <div class="invalid-feedback" id="time_slot-error"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="time_icon" class="form-label">
                                            <i class="bi bi-palette"></i> Icon <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="time_icon" 
                                               name="time_icon" 
                                               value="{{ old('time_icon') }}" 
                                               placeholder="Ví dụ: fas fa-sun, fas fa-moon, fas fa-star"
                                               required>
                                        <div class="invalid-feedback" id="time_icon-error"></div>
                                        <small class="form-text text-muted">Sử dụng FontAwesome icons</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <label for="time_color" class="form-label">
                                            <i class="bi bi-palette-fill"></i> Màu sắc <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="time_color" 
                                               name="time_color" 
                                               value="{{ old('time_color') }}" 
                                               placeholder="Ví dụ: #ffc107, #17a2b8, #dc3545"
                                               required>
                                        <div class="invalid-feedback" id="time_color-error"></div>
                                        <small class="form-text text-muted">Hex code hoặc tên màu CSS</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="from_distance" class="form-label">
                                            <i class="bi bi-arrow-right"></i> Từ km <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="from_distance" 
                                               name="from_distance" 
                                               value="{{ old('from_distance') }}" 
                                               min="0" 
                                               step="0.1"
                                               placeholder="0"
                                               required>
                                        <div class="invalid-feedback" id="from_distance-error"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="to_distance" class="form-label">
                                            <i class="bi bi-arrow-left"></i> Đến km
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="to_distance" 
                                               name="to_distance" 
                                               value="{{ old('to_distance') }}" 
                                               min="0" 
                                               step="0.1"
                                               placeholder="Để trống = không giới hạn">
                                        <div class="invalid-feedback" id="to_distance-error"></div>
                                        <small class="form-text text-muted">Để trống = từ km đó trở lên</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="price" class="form-label">
                                            <i class="bi bi-currency-dollar"></i> Giá <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price') }}" 
                                               min="0" 
                                               step="1000"
                                               placeholder="245000"
                                               required>
                                        <div class="invalid-feedback" id="price-error"></div>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="price_type" class="form-label">
                                            <i class="bi bi-tag"></i> Loại giá <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-control" 
                                                id="price_type" 
                                                name="price_type" 
                                                required>
                                            <option value="">🏷️ Chọn loại giá</option>
                                            <option value="fixed" {{ old('price_type') == 'fixed' ? 'selected' : '' }}>💰 Giá cố định</option>
                                            <option value="per_km" {{ old('price_type') == 'per_km' ? 'selected' : '' }}>📏 Giá theo km</option>
                                        </select>
                                        <div class="invalid-feedback" id="price_type-error"></div>
                                        <small class="form-text text-muted">Giá cố định hoặc giá/km</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô tả
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Mô tả chi tiết về mức giá này">{{ old('description') }}</textarea>
                                        <div class="invalid-feedback" id="description-error"></div>
                                        <small class="form-text text-muted">Mô tả để dễ hiểu hơn</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="sort_order" class="form-label">
                                            <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
                                        </label>
                                        <input type="number" 
                                               class="form-control" 
                                               id="sort_order" 
                                               name="sort_order" 
                                               value="{{ old('sort_order', 0) }}" 
                                               min="0"
                                               step="1">
                                        <div class="invalid-feedback" id="sort_order-error"></div>
                                        <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group mb-3">
                                        <label for="is_active" class="form-label">
                                            <i class="bi bi-toggle-on"></i> Trạng thái
                                        </label>
                                        <div class="form-check">
                                            <input type="checkbox" 
                                                   class="form-check-input" 
                                                   id="is_active" 
                                                   name="is_active" 
                                                   value="1" 
                                                   {{ old('is_active', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_active">
                                                ✅ Kích hoạt mức giá này
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary" id="submit-btn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                    <i class="bi bi-check-circle"></i> Tạo mức giá
                                </button>
                                <a href="{{ route('admin.driver.pricing-tiers.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-times"></i> Hủy
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- CKEditor 5 đã được load từ layout -->
<script>
$(document).ready(function() {
    // Auto-fill icon và color khi chọn time slot
    const timeSlotSelect = document.getElementById('time_slot');
    const timeIconInput = document.getElementById('time_icon');
    const timeColorInput = document.getElementById('time_color');
    
    const timeSlotData = {
        'Trước 22h': { icon: 'fas fa-sun', color: '#ffc107' },
        '22h - 24h': { icon: 'fas fa-moon', color: '#17a2b8' },
        'Sau 24h': { icon: 'fas fa-star', color: '#dc3545' }
    };
    
    timeSlotSelect.addEventListener('change', function() {
        const selectedValue = this.value;
        if (timeSlotData[selectedValue]) {
            timeIconInput.value = timeSlotData[selectedValue].icon;
            timeColorInput.value = timeSlotData[selectedValue].color;
        }
    });

    // Form submission
    $('#create-pricing-tier-form').on('submit', function(e) {
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
        
        $.ajax({
            url: '{{ route("admin.driver.pricing-tiers.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.driver.pricing-tiers.index") }}';
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
                    showAlert('danger', 'Có lỗi xảy ra khi tạo mức giá');
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
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush

