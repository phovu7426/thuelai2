@extends('admin.index')

@section('page_title', 'Danh sách tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Danh sách tài khoản</li>
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
                                <!-- Form lọc -->
                                <form action="{{ route('admin.users.index') }}" method="GET" class="mb-0">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <input type="email" name="email" class="form-control" placeholder="🔍 Nhập email"
                                                   value="{{ request('email') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Lọc
                                            </button>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                @can('access_users')
                                    <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm Tài khoản
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>Vai Trò</th>
                                <th>Hành Động</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $index => $user)
                                <tr>
                                    <td>{{ $users->firstItem() + $index }}</td>
                                    <td>{{ $user->name ?? '' }}</td>
                                    <td>{{ $user->email ?? '' }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        @php $isBlocked = ($user->status ?? 'active') === 'inactive'; @endphp
                                        <select class="form-select form-select-sm status-select" 
                                                data-user-id="{{ $user->id }}" 
                                                data-current-status="{{ $isBlocked ? '1' : '0' }}"
                                                data-status-type="users">
                                            <option value="0" {{ !$isBlocked ? 'selected' : '' }}>
                                                Hoạt động
                                            </option>
                                            <option value="1" {{ $isBlocked ? 'selected' : '' }}>
                                                Khóa
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        @php
                                            $roleCount = $user->roles->count();
                                        @endphp

                                        @if ($roleCount > 0)
                                            <button type="button"
                                                    class="btn btn-sm btn-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#rolesModal_{{ $user->id }}">
                                                {{ $roleCount }} vai trò
                                            </button>
                                        @else
                                            <span class="badge bg-secondary">0 vai trò</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            @can('access_users')
                                                <a href="{{ route('admin.users.showAssignRolesForm', $user->id ?? '') }}" title="Gán vai trò"
                                                   class="btn-action btn-view"><i class="fas fa-user-tag"></i></a>
                                            @endcan
                                            @can('access_users')
                                                <button type="button" class="btn-action btn-edit" title="Chỉnh sửa" 
                                                        onclick="openEditModal({{ $user->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            @endcan
                                            @can('access_users')
                                                <button type="button" class="btn-action btn-delete" title="Xóa" 
                                                        onclick="deleteData('/admin/users/delete/{{ $user->id }}')">
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
                    <!-- /.card-body -->

                    <!-- Hiển thị phân trang -->
                    @include('vendor.pagination.pagination', ['paginator' => $users])
                </div>
                <!-- /.card -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->



    <!-- Modals hiển thị danh sách vai trò của từng tài khoản -->
    @foreach($users as $user)
        <div class="modal fade" id="rolesModal_{{ $user->id }}" tabindex="-1"
             aria-labelledby="rolesModalLabel_{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rolesModalLabel_{{ $user->id }}">
                            Vai trò của: <strong>{{ $user->email }}</strong>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        @if ($user->roles->count())
                            <ul class="list-group">
                                @foreach ($user->roles as $role)
                                    <li class="list-group-item">{{ $role->title ?? $role->name }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>Người dùng này chưa có vai trò nào.</p>
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
<script src="{{ asset('js/admin/universal-modal.js') }}"></script>
<script>
// Khởi tạo Universal Modal cho Users (chỉ khởi tạo một lần)
if (!window.usersModal) {
    window.usersModal = new UniversalModal({
    modalId: 'usersModal',
    modalTitle: 'Tài khoản',
    formId: 'usersForm',
    submitBtnId: 'usersSubmitBtn',
    createRoute: '{{ route("admin.users.store") }}',
    updateRoute: '{{ route("admin.users.update", ":id") }}',
    getDataRoute: '{{ route("admin.users.getUserInfo", ":id") }}',
    successMessage: 'Thao tác tài khoản thành công',
    errorMessage: 'Có lỗi xảy ra khi xử lý tài khoản',
    viewPath: 'admin.users.form',
    viewData: {
        roles: @json($roles ?? []),
        permissions: @json($permissions ?? [])
    },
    onSuccess: function(response, isEdit, id) {
        setTimeout(() => {
            location.reload();
        }, 1500);
    }
});
}

// Global functions để gọi từ HTML
function openCreateModal() {
    window.usersModal.openCreateModal();
}

function openEditModal(userId) {
    window.usersModal.openEditModal(userId);
}
</script>
@endsection
