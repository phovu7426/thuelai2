@extends('admin.index')

@section('page_title', 'Thêm vai trò')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Thêm vai trò</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-shield-plus"></i> Thêm mới vai trò
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="create-role-form">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-tag"></i> Tên vai trò <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="name" id="name" class="form-control"
                                            placeholder="🏷️ Nhập tên vai trò..." value="{{ old('name') }}" required>
                                        <div class="invalid-feedback" id="name-error"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">
                                            <i class="bi bi-info-circle"></i> Mô tả <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            placeholder="ℹ️ Nhập mô tả..." value="{{ old('title') }}" required>
                                        <div class="invalid-feedback" id="title-error"></div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="btn-submit">
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
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Form submission
    $('#create-role-form').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validation
        resetValidation();
        
        // Show loading
        const btn = $('#btn-submit');
        const spinner = btn.find('.spinner-border');
        const icon = btn.find('.bi-check-circle');
        
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        icon.addClass('d-none');
        
        // Submit form
        $.ajax({
            url: '{{ route("admin.roles.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.roles.index") }}';
                    }, 2000);
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(function(field) {
                        const input = $(`#${field}`);
                        const errorDiv = $(`#${field}-error`);
                        
                        input.addClass('is-invalid');
                        errorDiv.text(errors[field][0]);
                    });
                    showAlert('danger', 'Vui lòng kiểm tra lại thông tin nhập vào');
                } else {
                    showAlert('danger', 'Có lỗi xảy ra khi tạo vai trò');
                }
            },
            complete: function() {
                // Hide loading
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                icon.removeClass('d-none');
            }
        });
    });
});

function resetValidation() {
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').text('');
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
