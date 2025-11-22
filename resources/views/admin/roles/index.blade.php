@extends('admin.index')

@section('page_title', 'Danh sách vai trò')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Danh sách vai trò</li>
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
                        <div class="row align-items-center">
                            <div class="col-sm-9">
                                <!-- Form tìm kiếm -->
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" id="search-name" class="form-control" placeholder="🔍 Nhập tên vai trò">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="btn-search" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tìm kiếm
                                        </button>
                                        <button type="button" id="btn-reset" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                @can('access_users')
                                    <button type="button" class="btn btn-primary" onclick="openCreateRoleModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm Vai trò
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ý nghĩa vai trò</th>
                                <th>Tên vai trò</th>
                                <th>Quyền</th>
                                <th>Trạng thái</th>
                                <th>Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="roles-table-body">
                            @foreach($roles as $index => $role)
                                <tr data-id="{{ $role->id }}">
                                    <td>{{ $roles->firstItem() + $index }}</td>
                                    <td>{{ $role->title ?? '' }}</td>
                                    <td>{{ $role->name ?? '' }}</td>
                                    <td>
                                        @php
                                            $permissionCount = count($role->permissions ?? []);
                                        @endphp

                                        @if ($permissionCount > 0)
                                            <button type="button"
                                                    class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#permissionsModal_{{ $role->id }}">
                                                {{ $permissionCount }} quyền
                                            </button>
                                        @else
                                            <span class="badge bg-secondary">0 quyền</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php $isInactive = ($role->status ?? 'active') === 'inactive'; @endphp
                                        <select class="form-select form-select-sm status-select" 
                                                data-role-id="{{ $role->id }}" 
                                                data-current-status="{{ $isInactive ? '1' : '0' }}"
                                                data-status-type="roles">
                                            <option value="0" {{ !$isInactive ? 'selected' : '' }}>
                                                Hoạt động
                                            </option>
                                            <option value="1" {{ $isInactive ? 'selected' : '' }}>
                                                Không hoạt động
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            @can('access_roles')
                                                <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                                                        onclick="openEditRoleModal({{ $role->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn-action btn-delete" title="Xóa" 
                                                        onclick="deleteData('/admin/roles/delete/{{ $role->id }}', 'DELETE')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Hiển thị phân trang -->
                    <div id="pagination-container">
                        @include('vendor.pagination.pagination', ['paginator' => $roles])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal hiển thị danh sách quyền -->
    @foreach($roles as $role)
        <div class="modal fade" id="permissionsModal_{{ $role->id }}" tabindex="-1" aria-labelledby="permissionsModalLabel_{{ $role->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="permissionsModalLabel_{{ $role->id }}">
                            Danh sách quyền của vai trò: <strong>{{ $role->title }}</strong>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        @if (count($role->permissions ?? []))
                            <ul class="list-group">
                                @foreach ($role->permissions as $permission)
                                    <li class="list-group-item">{{ $permission->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Không có quyền nào được gán.</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
@endsection

@section('scripts')
<script>
// Đợi jQuery sẵn sàng trước khi khởi tạo Universal Modal
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        callback();
    } else {
        // Nếu jQuery chưa sẵn sàng, chờ DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof $ !== 'undefined') {
                callback();
            } else {
                // Nếu vẫn chưa có jQuery, chờ thêm một chút
                setTimeout(() => {
                    if (typeof $ !== 'undefined') {
                        callback();
                    } else {
                        console.error('jQuery is not loaded after waiting');
                    }
                }, 100);
            }
        });
    }
}

// Khởi tạo Universal Modal
waitForJQuery(function() {
    // Kiểm tra jQuery đã sẵn sàng
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }
    
    // Khởi tạo Universal Modal cho Roles
    if (!window.rolesModal) {
        window.rolesModal = new UniversalModal({
            modalId: 'rolesModal',
            modalTitle: 'Vai trò',
            formId: 'rolesForm',
            submitBtnId: 'rolesSubmitBtn',
            createRoute: '{{ route("admin.roles.store") }}',
            updateRoute: '{{ route("admin.roles.update", ":id") }}',
            getDataRoute: '{{ route("admin.roles.show", ":id") }}',
            successMessage: 'Thao tác vai trò thành công',
            errorMessage: 'Có lỗi xảy ra khi xử lý vai trò',
            viewPath: 'admin.roles.form',
            viewData: {
                permissions: @json($permissions ?? [])
            },
            onSuccess: function(response, isEdit, id) {
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        });
    }
});

// Global functions để gọi từ HTML
function openCreateRoleModal() {
    if (window.rolesModal) {
        window.rolesModal.openCreateModal();
    } else {
        console.error('Roles modal not initialized');
    }
}

function openEditRoleModal(roleId) {
    if (window.rolesModal) {
        window.rolesModal.openEditModal(roleId);
    } else {
        console.error('Roles modal not initialized');
    }
}
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Search
    $('#btn-search').click(function() {
        searchRoles();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-name').val('');
        searchRoles();
    });

    // Enter key search
    $('#search-name').keypress(function(e) {
        if (e.which == 13) {
            searchRoles();
        }
    });
    
    // Bind initial events
    bindEvents();
});

function searchRoles(page = 1) {
    const name = $('#search-name').val();
    
    $.ajax({
        url: '{{ route("admin.roles.index") }}',
        method: 'GET',
        data: {
            name: name,
            page: page
        },
        success: function(response) {
            if (response.html) {
                $('#roles-table-body').html(response.html);
            }
            if (response.pagination) {
                $('#pagination-container').html(response.pagination);
            }
            
            // Rebind events
            bindEvents();
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi tìm kiếm');
        }
    });
}

function deleteRole(roleId) {
    if (confirm('Bạn có chắc chắn muốn xóa vai trò này không?')) {
        $.ajax({
            url: `/admin/roles/${roleId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Remove row from table
                    $(`tr[data-id="${roleId}"]`).remove();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi xóa vai trò');
            }
        });
    }
}

function bindEvents() {
    // Rebind delete events
    $('.btn-delete').off('click').on('click', function() {
        const roleId = $(this).closest('tr').data('id');
        deleteRole(roleId);
    });
    
    // Bind status change events
    $('.status-select').off('change').on('change', function() {
        const roleId = $(this).data('role-id');
        const status = $(this).val();
        const statusType = $(this).data('status-type');
        
        if (statusType === 'roles') {
            updateRoleStatus(roleId);
        }
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

function updateRoleStatus(roleId, status) {
    $.ajax({
        url: `{{ route('admin.roles.toggle-status', ':id') }}`.replace(':id', roleId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current status
                const select = $(`select[data-role-id="${roleId}"]`);
                const newStatus = response.data.status === 'active' ? '0' : '1';
                select.val(newStatus);
                select.data('current-status', newStatus);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`select[data-role-id="${roleId}"]`);
                select.val(select.data('current-status'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
            // Revert select
            const select = $(`select[data-role-id="${roleId}"]`);
            select.val(select.data('current-status'));
        }
    });
}

function updateRoleFeatured(roleId, featured) {
    $.ajax({
        url: `/admin/roles/${roleId}/toggle-featured`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            is_featured: featured
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current featured
                $(`select[data-role-id="${roleId}"]`).data('current-featured', featured);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`select[data-role-id="${roleId}"]`);
                select.val(select.data('current-featured'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
            // Revert select
            const select = $(`select[data-role-id="${roleId}"]`);
            select.val(select.data('current-featured'));
        }
    });
}
</script>
@endpush
