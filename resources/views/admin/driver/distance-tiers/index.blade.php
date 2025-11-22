@extends('admin.index')

@section('page_title', 'Quản lý khoảng cách')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Khoảng cách</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="pricing-admin-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Quản lý khoảng cách</h3>
                            <a href="{{ route('admin.driver.distance-tiers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm khoảng cách mới
                            </a>
                        </div>
                    </div>

                    <div class="pricing-table-admin">
                        <div class="card-body">
                            <!-- Alert messages -->
                            <div id="alert-container"></div>

                            @if ($distanceTiers->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="20%">Tên khoảng cách</th>
                                                <th width="15%">Khoảng cách</th>
                                                <th width="15%">Text hiển thị</th>
                                                <th width="25%">Mô tả</th>
                                                <th width="10%">Trạng thái</th>
                                                <th width="10%">Nổi bật</th>
                                                <th width="10%">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="distance-tiers-table-body">
                                            @foreach ($distanceTiers as $index => $tier)
                                                <tr data-id="{{ $tier->id }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <strong>{{ $tier->name }}</strong>
                                                    </td>
                                                    <td>
                                                        <span class="text-info">
                                                            {{ $tier->distance_range }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-primary">
                                                            {{ $tier->display_text }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        {{ $tier->description ?: 'Không có mô tả' }}
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm status-select"
                                                            data-tier-id="{{ $tier->id }}"
                                                            data-current-status="{{ $tier->is_active ? '1' : '0' }}"
                                                            data-status-type="distance-tiers">
                                                            <option value="0"
                                                                {{ !$tier->is_active ? 'selected' : '' }}>
                                                                Tạm dừng
                                                            </option>
                                                            <option value="1"
                                                                {{ $tier->is_active ? 'selected' : '' }}>
                                                                Hoạt động
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm featured-select"
                                                            data-tier-id="{{ $tier->id }}"
                                                            data-current-featured="{{ $tier->is_highlighted ? '1' : '0' }}"
                                                            data-featured-type="distance-tiers">
                                                            <option value="0"
                                                                {{ !$tier->is_highlighted ? 'selected' : '' }}>
                                                                Không nổi bật
                                                            </option>
                                                            <option value="1"
                                                                {{ $tier->is_highlighted ? 'selected' : '' }}>
                                                                Nổi bật
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons">
                                                            <button type="button" class="btn-action btn-edit"
                                                                title="Chỉnh sửa"
                                                                onclick="openEditDistanceTierModal({{ $tier->id }})">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn-action btn-delete"
                                                                title="Xóa"
                                                                onclick="deleteDistanceTier({{ $tier->id }})">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="empty-state-modern">
                                    <div class="empty-icon">
                                        <i class="fas fa-route"></i>
                                    </div>
                                    <h3>Chưa có khoảng cách nào</h3>
                                    <p>Vui lòng thêm các khoảng cách để sử dụng trong quy tắc giá.</p>
                                    <a href="{{ route('admin.driver.distance-tiers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Thêm khoảng cách đầu tiên
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
@endsection

@section('scripts')
    <script src="{{ asset('js/admin/universal-modal.js') }}"></script>
    <script>
        // Khởi tạo Universal Modal cho Distance Tiers
        if (!window.distanceTiersModal) {
            window.distanceTiersModal = new UniversalModal({
                modalId: 'distanceTiersModal',
                modalTitle: 'Khoảng cách',
                formId: 'distanceTiersForm',
                submitBtnId: 'distanceTiersSubmitBtn',
                createRoute: '{{ route('admin.driver.distance-tiers.store') }}',
                updateRoute: '{{ route('admin.driver.distance-tiers.update', ':id') }}',
                getDataRoute: '{{ route('admin.driver.distance-tiers.show', ':id') }}',
                successMessage: 'Thao tác khoảng cách thành công',
                errorMessage: 'Có lỗi xảy ra khi xử lý khoảng cách',
                viewPath: 'admin.driver.distance-tiers.form',
                viewData: {},
                onSuccess: function(response, isEdit, id) {
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
        }

        // Global functions để gọi từ HTML
        function openCreateDistanceTierModal() {
            window.distanceTiersModal.openCreateModal();
        }

        function openEditDistanceTierModal(tierId) {
            window.distanceTiersModal.openEditModal(tierId);
        }

        function deleteDistanceTier(tierId) {
            console.log('Delete function called with ID:', tierId);
            if (confirm('Bạn có chắc chắn muốn xóa khoảng cách này không?')) {
                console.log('User confirmed delete');
                $.ajax({
                    url: `/admin/driver/distance-tiers/${tierId}/delete`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            showAlert('success', response.message);
                            // Remove row from table
                            $(`tr[data-id="${tierId}"]`).remove();
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr, status, error);
                        console.log('Response Text:', xhr.responseText);
                        showAlert('danger', 'Có lỗi xảy ra khi xóa khoảng cách');
                    }
                });
            }
        }

        function showAlert(type, message) {
            const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;

            // Remove existing alerts
            $('.alert').remove();

            // Add new alert at the top of content
            $('.content-wrapper').prepend(alertHtml);

            // Auto hide after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut();
            }, 5000);
        }
    </script>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Status select change
                $('.status-select').change(function() {
                    const tierId = $(this).data('tier-id');
                    const newStatus = $(this).val();
                    const currentStatus = $(this).data('current-status');

                    if (newStatus !== currentStatus) {
                        updateTierStatus(tierId, newStatus);
                    }
                });

                // Featured select change
                $('.featured-select').change(function() {
                    const tierId = $(this).data('tier-id');
                    const newFeatured = $(this).val();
                    const currentFeatured = $(this).data('current-featured');

                    if (newFeatured !== currentFeatured) {
                        updateTierFeatured(tierId, newFeatured);
                    }
                });
            });

            function updateTierStatus(tierId, status) {
                $.ajax({
                    url: `/admin/driver/distance-tiers/${tierId}/toggle-status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', response.message);
                            // Update current status
                            $(`select[data-tier-id="${tierId}"]`).data('current-status', status);
                        } else {
                            showAlert('danger', response.message);
                            // Revert select
                            const select = $(`select[data-tier-id="${tierId}"]`);
                            select.val(select.data('current-status'));
                        }
                    },
                    error: function() {
                        showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                        // Revert select
                        const select = $(`select[data-tier-id="${tierId}"]`);
                        select.val(select.data('current-status'));
                    }
                });
            }

            function updateTierFeatured(tierId, featured) {
                $.ajax({
                    url: `/admin/driver/distance-tiers/${tierId}/toggle-featured`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        is_highlighted: featured
                    },
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', response.message);
                            // Update current featured
                            $(`select[data-tier-id="${tierId}"]`).data('current-featured', featured);
                        } else {
                            showAlert('danger', response.message);
                            // Revert select
                            const select = $(`select[data-tier-id="${tierId}"]`);
                            select.val(select.data('current-featured'));
                        }
                    },
                    error: function() {
                        showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
                        // Revert select
                        const select = $(`select[data-tier-id="${tierId}"]`);
                        select.val(select.data('current-featured'));
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
        </script>
    @endpush
