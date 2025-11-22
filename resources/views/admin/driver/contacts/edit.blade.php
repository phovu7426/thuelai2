@extends('admin.index')

@section('page_title', 'Chỉnh sửa liên hệ')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.contacts.index') }}">Danh sách liên hệ</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa liên hệ</li>
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
                            <i class="bi bi-envelope-gear"></i> Chỉnh sửa liên hệ: {{ $contact['name'] ?? 'Không có tên' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-contact-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    <i class="bi bi-person"></i> Tên <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" 
                                                       id="name" name="name" 
                                                       placeholder="👤 Nhập tên..." 
                                                       value="{{ old('name', $contact['name'] ?? '') }}" required>
                                                <div class="invalid-feedback" id="name-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">
                                                    <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" class="form-control" 
                                                       id="email" name="email" 
                                                       placeholder="📧 Nhập email..." 
                                                       value="{{ old('email', $contact['email'] ?? '') }}" required>
                                                <div class="invalid-feedback" id="email-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">
                                                    <i class="bi bi-telephone"></i> Số điện thoại
                                                </label>
                                                <input type="tel" class="form-control" 
                                                       id="phone" name="phone" 
                                                       placeholder="📞 Nhập số điện thoại..." 
                                                       value="{{ old('phone', $contact['phone'] ?? '') }}">
                                                <div class="invalid-feedback" id="phone-error"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="subject" class="form-label">
                                                    <i class="bi bi-chat-text"></i> Tiêu đề
                                                </label>
                                                <input type="text" class="form-control" 
                                                       id="subject" name="subject" 
                                                       placeholder="📝 Nhập tiêu đề..." 
                                                       value="{{ old('subject', $contact['subject'] ?? '') }}">
                                                <div class="invalid-feedback" id="subject-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="message" class="form-label">
                                            <i class="bi bi-chat-dots"></i> Nội dung tin nhắn <span class="text-danger">*</span>
                                        </label>
                                        <textarea class="form-control" 
                                                  id="message" name="message" rows="6" 
                                                  placeholder="💬 Nhập nội dung tin nhắn..." required>{{ old('message', $contact['message'] ?? '') }}</textarea>
                                        <div class="invalid-feedback" id="message-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="admin_notes" class="form-label">
                                            <i class="bi bi-sticky"></i> Ghi chú admin
                                        </label>
                                        <textarea class="form-control" 
                                                  id="admin_notes" name="admin_notes" rows="3" 
                                                  placeholder="📝 Nhập ghi chú...">{{ old('admin_notes', $contact['admin_notes'] ?? '') }}</textarea>
                                        <div class="invalid-feedback" id="admin_notes-error"></div>
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
                                                    <option value="unread" {{ old('status', $contact['status'] ?? '') == 'unread' ? 'selected' : '' }}>📧 Chưa đọc</option>
                                                    <option value="read" {{ old('status', $contact['status'] ?? '') == 'read' ? 'selected' : '' }}>✅ Đã đọc</option>
                                                    <option value="replied" {{ old('status', $contact['status'] ?? '') == 'replied' ? 'selected' : '' }}>💬 Đã trả lời</option>
                                                </select>
                                                <div class="invalid-feedback" id="status-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="topic" class="form-label">
                                                    <i class="bi bi-tags"></i> Chủ đề <span class="text-danger">*</span>
                                                </label>
                                                <select class="form-select" 
                                                        id="topic" name="topic" required>
                                                    <option value="">🏷️ Chọn chủ đề</option>
                                                    <option value="khiếu nại" {{ old('topic', $contact['topic'] ?? '') == 'khiếu nại' ? 'selected' : '' }}>Khiếu nại</option>
                                                    <option value="tư vấn dịch vụ" {{ old('topic', $contact['topic'] ?? '') == 'tư vấn dịch vụ' ? 'selected' : '' }}>Tư vấn dịch vụ</option>
                                                    <option value="phản hồi" {{ old('topic', $contact['topic'] ?? '') == 'phản hồi' ? 'selected' : '' }}>Phản hồi</option>
                                                    <option value="khác" {{ old('topic', $contact['topic'] ?? '') == 'khác' ? 'selected' : '' }}>Khác</option>
                                                </select>
                                                <div class="invalid-feedback" id="topic-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="priority" class="form-label">
                                                    <i class="bi bi-flag"></i> Độ ưu tiên
                                                </label>
                                                <select class="form-select" 
                                                        id="priority" name="priority">
                                                    <option value="low" {{ old('priority', $contact['priority'] ?? '') == 'low' ? 'selected' : '' }}>🟢 Thấp</option>
                                                    <option value="medium" {{ old('priority', $contact['priority'] ?? '') == 'medium' ? 'selected' : '' }}>🟡 Trung bình</option>
                                                    <option value="high" {{ old('priority', $contact['priority'] ?? '') == 'high' ? 'selected' : '' }}>🔴 Cao</option>
                                                </select>
                                                <div class="invalid-feedback" id="priority-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="assigned_to" class="form-label">
                                                    <i class="bi bi-person-check"></i> Giao cho
                                                </label>
                                                <select class="form-select" 
                                                        id="assigned_to" name="assigned_to">
                                                    <option value="">👤 Chọn người xử lý</option>
                                                    @foreach($users ?? [] as $user)
                                                        <option value="{{ $user->id }}" 
                                                                {{ old('assigned_to', $contact['assigned_to'] ?? '') == $user->id ? 'selected' : '' }}>
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback" id="assigned_to-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="contact_date" class="form-label">
                                                    <i class="bi bi-calendar"></i> Ngày liên hệ
                                                </label>
                                                <input type="datetime-local" class="form-control" 
                                                       id="contact_date" name="contact_date" 
                                                       value="{{ old('contact_date', $contact['contact_date'] ?? '') }}">
                                                <div class="invalid-feedback" id="contact_date-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.driver.contacts.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật liên hệ
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
    // Phone number formatting
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 0) {
            if (value.startsWith('84')) {
                value = value.replace(/^84/, '0');
            }
            if (value.length > 10) {
                value = value.substring(0, 10);
            }
        }
        $(this).val(value);
    });

    // Character counter for message
    $('#message').on('input', function() {
        const maxLength = 1000;
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
    $('#edit-contact-form').on('submit', function(e) {
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
            url: '{{ route("admin.driver.contacts.update", $contact["id"]) }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.driver.contacts.index") }}';
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
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật liên hệ');
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
.form-group label {
    font-weight: 600;
    color: #333;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.char-counter {
    font-size: 12px;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
@endpush
