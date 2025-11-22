@extends('admin.index')

@section('page_title', 'Chỉnh sửa Danh Mục')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Danh sách Danh Mục</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa Danh Mục</li>
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
                            <i class="bi bi-folder-gear"></i> Chỉnh sửa Danh Mục: {{ $category->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-category-form">
                            @csrf
                            @method('PUT')
                            
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    <i class="bi bi-folder"></i> Tên Danh Mục <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="name" id="name" class="form-control"
                                                       placeholder="📁 Nhập tên danh mục..." 
                                                       value="{{ old('name', $category->name) }}" required>
                                                <div class="invalid-feedback" id="name-error"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="code" class="form-label">
                                                    <i class="bi bi-code"></i> Mã Danh Mục <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="code" id="code" class="form-control"
                                                       placeholder="🔢 Nhập mã danh mục..." 
                                                       value="{{ old('code', $category->code) }}" required>
                                                <div class="invalid-feedback" id="code-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="slug" class="form-label">
                                                    <i class="bi bi-link"></i> Slug <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" name="slug" id="slug" class="form-control"
                                                       placeholder="🔗 Nhập slug..." 
                                                       value="{{ old('slug', $category->slug) }}" required>
                                                <div class="invalid-feedback" id="slug-error"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="parent_id" class="form-label">
                                                    <i class="bi bi-diagram-3"></i> Danh Mục Cha
                                                </label>
                                                <select name="parent_id" id="parent_id" class="form-select">
                                                    <option value="">📂 Không có</option>
                                                    @foreach($categories as $cat)
                                                        @if($cat->id != $category->id)
                                                            <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                                                {{ $cat->name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback" id="parent_id-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô Tả
                                        </label>
                                        <textarea name="description" id="description" class="form-control" rows="3" 
                                                  placeholder="📄 Nhập mô tả...">{{ old('description', $category->description) }}</textarea>
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
                                                <label for="status" class="form-label">
                                                    <i class="bi bi-toggle-on"></i> Trạng Thái
                                                </label>
                                                <select name="status" id="status" class="form-select">
                                                    <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>✅ Hiển Thị</option>
                                                    <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>❌ Ẩn</option>
                                                </select>
                                                <div class="invalid-feedback" id="status-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự hiển thị
                                                </label>
                                                <input type="number" class="form-control" 
                                                       id="sort_order" name="sort_order" placeholder="0" 
                                                       value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                                                <div class="invalid-feedback" id="sort_order-error"></div>
                                                <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="color" class="form-label">
                                                    <i class="bi bi-palette"></i> Màu sắc
                                                </label>
                                                <input type="color" class="form-control form-control-color" 
                                                       id="color" name="color" value="{{ old('color', $category->color ?? '#007bff') }}" title="Chọn màu sắc">
                                                <div class="invalid-feedback" id="color-error"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="btn-submit">
                                            <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập Nhật Danh Mục
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
    $('#edit-category-form').on('submit', function(e) {
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
            url: '{{ route("admin.categories.update", $category->id) }}',
            method: 'PUT',
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
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật danh mục');
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
