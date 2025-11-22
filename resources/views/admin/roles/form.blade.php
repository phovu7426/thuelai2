{{-- Form cho Roles Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="title" class="form-label">
                <i class="bi bi-person-badge"></i> Ý nghĩa vai trò <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control"
                   placeholder="Nhập ý nghĩa vai trò..."
                   value="{{ $title ?? old('title') }}"
                   required>
            <div class="invalid-feedback" id="titleError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-code-slash"></i> Tên vai trò <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Nhập tên vai trò (ví dụ: admin, user)..."
                   value="{{ $name ?? old('name') }}"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-shield-check"></i> Quyền hạn
            </label>
            <select class="form-control select2" name="permissions[]" multiple data-field="name" data-display-field="title"
                    data-selected='@json($permissions_selected ?? [])'
                    data-url="{{ route('admin.permissions.autocomplete') }}">
                <option value="">🔐 Chọn quyền</option>
            </select>
            <small class="form-text text-muted">Có thể chọn nhiều quyền</small>
            <div class="invalid-feedback" id="permissionsError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="status" id="status" class="form-control">
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="inactive" {{ $status === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Dùng init Select2 chung từ public/js/main.js (class .select2 với data-* đã đủ)
    // Auto-generate name from title
    $('#title').on('input', function() {
        const title = $(this).val();
        if (title && !$('#name').val()) {
            const name = title.toLowerCase()
                .replace(/[^a-z0-9\s]/g, '')
                .replace(/\s+/g, '_');
            $('#name').val(name);
        }
    });
});
</script>
