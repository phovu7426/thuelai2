@extends('admin.index')

@section('page_title', 'Chỉnh sửa vai trò')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.roles.index') }}">Danh sách vai trò</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa vai trò</li>
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
                            <i class="bi bi-shield-gear"></i> Chỉnh sửa vai trò: {{ $role->title }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-role-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">
                                                    <i class="bi bi-person-badge"></i> Tên hiển thị <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="title" name="title"
                                                    class="form-control"
                                                    placeholder="👤 Nhập tên hiển thị..." 
                                                    value="{{ old('title', $role->title) }}" required>
                                                <div class="invalid-feedback" id="title-error"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    <i class="bi bi-code"></i> Tên hệ thống <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="name" name="name"
                                                    class="form-control"
                                                    placeholder="🔧 Nhập tên hệ thống..." 
                                                    value="{{ old('name', $role->name) }}" required>
                                                <div class="invalid-feedback" id="name-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô tả
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="📄 Nhập mô tả...">{{ old('description', $role->description) }}</textarea>
                                        <div class="invalid-feedback" id="description-error"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">
                                            <i class="bi bi-shield-check"></i> Quyền được gán
                                        </label>
                                        <select class="form-control select2"
                                            name="permissions[]" multiple data-field="name"
                                            data-selected='@json($role->permissions->pluck('name')->toArray())'
                                            data-url="{{ route('admin.permissions.autocomplete') }}">
                                            <option value="">🔐 Chọn quyền</option>
                                        </select>
                                        <div class="invalid-feedback" id="permissions-error"></div>
                                        <small class="form-text text-muted">Có thể chọn nhiều quyền</small>
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
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active" 
                                                           value="1" {{ old('is_active', $role->is_active ?? true) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        <i class="bi bi-toggle-on"></i> Kích hoạt vai trò
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự hiển thị
                                                </label>
                                                <input type="number" class="form-control" 
                                                       id="sort_order" name="sort_order" placeholder="0" 
                                                       value="{{ old('sort_order', $role->sort_order ?? 0) }}" min="0">
                                                <div class="invalid-feedback" id="sort_order-error"></div>
                                                <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="color" class="form-label">
                                                    <i class="bi bi-palette"></i> Màu sắc
                                                </label>
                                                <input type="color" class="form-control form-control-color" 
                                                       id="color" name="color" value="{{ old('color', $role->color ?? '#007bff') }}" title="Chọn màu sắc">
                                                <div class="invalid-feedback" id="color-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="btn-submit">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật vai trò
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
<!-- CKEditor 5 đã được load từ layout -->
<script>
$(document).ready(function() {
    // Initialize Select2 for permissions
    $('.select2').select2({
        placeholder: '🔐 Chọn quyền',
        allowClear: true,
        ajax: {
            url: $('.select2').data('url'),
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term,
                    page: params.page
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data,
                    pagination: {
                        more: data.next_page_url != null
                    }
                };
            },
            cache: true
        }
    });

    // Set selected permissions
    const selectedPermissions = $('.select2').data('selected');
    if (selectedPermissions && selectedPermissions.length > 0) {
        // Fetch permissions and set them
        $.ajax({
            url: $('.select2').data('url'),
            data: { term: '', limit: 100 },
            success: function(data) {
                const permissions = data.data.filter(p => selectedPermissions.includes(p.text));
                permissions.forEach(permission => {
                    const option = new Option(permission.text, permission.id, true, true);
                    $('.select2').append(option);
                });
                $('.select2').trigger('change');
            }
        });
    }

    // Form submission
    $('#edit-role-form').on('submit', function(e) {
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
            url: '{{ route("admin.roles.update", $role->id) }}',
            method: 'PUT',
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
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật vai trò');
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
@endpush
