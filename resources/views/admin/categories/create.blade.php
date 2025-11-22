@extends('admin.index')

@section('page_title', 'Thêm Danh Mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh Mục</a></li>
    <li class="breadcrumb-item active">Thêm</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Thêm Danh Mục</h5>
            </div>
            <div class="card-body">
                <!-- Alert messages -->
                <div id="alert-container"></div>

                <form id="create-category-form">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Tên danh mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control" required>
                            <div class="invalid-feedback" id="name-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Mã danh mục <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="code" id="code" class="form-control" required>
                            <div class="invalid-feedback" id="code-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Slug <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" name="slug" id="slug" class="form-control" required>
                            <div class="invalid-feedback" id="slug-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Danh mục cha</label>
                        <div class="col-sm-10">
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">Chọn danh mục cha (nếu có)</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="parent_id-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Mô tả</label>
                        <div class="col-sm-10">
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                            <div class="invalid-feedback" id="description-error"></div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label">Trạng thái</label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-control">
                                <option value="1" selected>Hiển thị</option>
                                <option value="0">Ẩn</option>
                            </select>
                            <div class="invalid-feedback" id="status-error"></div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-success" id="btn-submit">
                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                            Thêm Danh Mục
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Hủy</a>
                    </div>
                </form>
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
            .replace(/[^a-z0-9\s-]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim();
        $('#slug').val(slug);
    });

    // Form submission
    $('#create-category-form').on('submit', function(e) {
        e.preventDefault();
        
        // Reset validation
        resetValidation();
        
        // Show loading
        const btn = $('#btn-submit');
        const spinner = btn.find('.spinner-border');
        const text = btn.contents().filter(function() {
            return this.nodeType === 3;
        });
        
        btn.prop('disabled', true);
        spinner.removeClass('d-none');
        text[0].textContent = 'Đang xử lý...';
        
        // Submit form
        $.ajax({
            url: '{{ route("admin.categories.store") }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Redirect after 2 seconds
                    setTimeout(function() {
                        window.location.href = '{{ route("admin.categories.index") }}';
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
                    showAlert('danger', 'Có lỗi xảy ra khi tạo danh mục');
                }
            },
            complete: function() {
                // Hide loading
                btn.prop('disabled', false);
                spinner.addClass('d-none');
                text[0].textContent = 'Thêm Danh Mục';
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
