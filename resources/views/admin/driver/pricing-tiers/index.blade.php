@extends('admin.index')

@section('page_title', 'Quản lý giá theo khoảng cách')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Giá theo khoảng cách</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="pricing-admin-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Quản lý giá theo khoảng cách linh hoạt</h3>
                            <a href="{{ route('admin.driver.pricing-tiers.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm mức giá mới
                            </a>
                        </div>
                    </div>

                    <div class="pricing-table-admin">
                        <div class="card-body">
                            <!-- Alert messages -->
                            <div id="alert-container"></div>

                            @if ($pricingTiers->count() > 0)
                                @foreach ($pricingTiers as $timeSlot => $tiers)
                                    <div class="pricing-time-slot mb-4">
                                        <h4 class="mb-3">
                                            <i class="{{ $tiers->first()->time_icon }}"
                                                style="color: {{ $tiers->first()->time_color }};"></i>
                                            {{ $timeSlot }}
                                        </h4>

                                        <div class="table-responsive">
                                            <table class="table table-bordered table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="5%">#</th>
                                                        <th width="20%">Khoảng cách</th>
                                                        <th width="15%">Loại giá</th>
                                                        <th width="20%">Giá</th>
                                                        <th width="20%">Mô tả</th>
                                                        <th width="10%">Trạng thái</th>
                                                        <th width="10%">Nổi bật</th>
                                                        <th width="10%">Thao tác</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($tiers as $index => $tier)
                                                        <tr data-id="{{ $tier->id }}">
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>
                                                                <strong>{{ $tier->distance_description }}</strong>
                                                            </td>
                                                            <td>
                                                                @if ($tier->price_type === 'fixed')
                                                                    <span class="badge bg-primary">Giá cố định</span>
                                                                @else
                                                                    <span class="badge bg-info">Giá theo km</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <span class="text-success fw-bold">
                                                                    {{ $tier->display_price }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                {{ $tier->description ?: 'Không có mô tả' }}
                                                            </td>
                                                            <td>
                                                                <select class="form-select form-select-sm status-select"
                                                                    data-tier-id="{{ $tier->id }}"
                                                                    data-current-status="{{ $tier->is_active ? '1' : '0' }}"
                                                                    data-status-type="pricing-tiers">
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
                                                                <div class="form-check form-switch">
                                                                    <input class="form-check-input toggle-highlight"
                                                                        type="checkbox" data-id="{{ $tier->id }}"
                                                                        {{ $tier->is_highlighted ? 'checked' : '' }}>
                                                                    <label
                                                                        class="form-check-label highlight-label-{{ $tier->id }}">
                                                                        {{ $tier->is_highlighted ? 'Nổi bật' : 'Không nổi bật' }}
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="action-buttons">
                                                                    <button type="button" class="btn-action btn-edit"
                                                                        title="Chỉnh sửa"
                                                                        onclick="openEditPricingTierModal({{ $tier->id }})">
                                                                        <i class="fas fa-edit"></i>
                                                                        </a>
                                                                        <button type="button" class="btn-action btn-delete"
                                                                            title="Xóa"
                                                                            onclick="deletePricingTier({{ $tier->id }})">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="empty-state text-center py-5">
                                    <div class="empty-icon">
                                        <i class="fas fa-graph-up"></i>
                                    </div>
                                    <h3>Chưa có mức giá nào</h3>
                                    <p>Vui lòng thêm các mức giá theo khoảng cách để tạo bảng giá linh hoạt.</p>
                                    <a href="{{ route('admin.driver.pricing-tiers.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Thêm mức giá đầu tiên
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
        // Khởi tạo Universal Modal cho Pricing Tiers
        if (!window.pricingTiersModal) {
            window.pricingTiersModal = new UniversalModal({
                modalId: 'pricingTiersModal',
                modalTitle: 'Mức giá',
                formId: 'pricingTiersForm',
                submitBtnId: 'pricingTiersSubmitBtn',
                createRoute: '{{ route('admin.driver.pricing-tiers.store') }}',
                updateRoute: '{{ route('admin.driver.pricing-tiers.update', ':id') }}',
                getDataRoute: '{{ route('admin.driver.pricing-tiers.show', ':id') }}',
                successMessage: 'Thao tác mức giá thành công',
                errorMessage: 'Có lỗi xảy ra khi xử lý mức giá',
                viewPath: 'admin.driver.pricing-tiers.form',
                viewData: {},
                onSuccess: function(response, isEdit, id) {
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                }
            });
        }

        // Global functions để gọi từ HTML
        function openCreatePricingTierModal() {
            window.pricingTiersModal.openCreateModal();
        }

        function openEditPricingTierModal(tierId) {
            window.pricingTiersModal.openEditModal(tierId);
        }
    </script>

    @push('scripts')
        <script>
            $(document).ready(function() {
                // Toggle status
                $('.toggle-status').change(function() {
                    const tierId = $(this).data('id');
                    const isChecked = $(this).is(':checked');

                    $.ajax({
                        url: `/admin/driver/pricing-tiers/${tierId}/toggle-status`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                                // Cập nhật label
                                $(`.status-label-${tierId}`).text(isChecked ? 'Hoạt động' :
                                    'Tạm dừng');
                            } else {
                                showAlert('danger', response.message);
                                // Revert checkbox
                                $(this).prop('checked', !isChecked);
                            }
                        },
                        error: function() {
                            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                            // Revert checkbox
                            $(this).prop('checked', !isChecked);
                        }
                    });
                });

                // Toggle highlight
                $('.toggle-highlight').change(function() {
                    const tierId = $(this).data('id');
                    const isChecked = $(this).is(':checked');

                    $.ajax({
                        url: `/admin/driver/pricing-tiers/${tierId}/toggle-highlight`,
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                                // Cập nhật label
                                $(`.highlight-label-${tierId}`).text(isChecked ? 'Nổi bật' :
                                    'Không nổi bật');
                            } else {
                                showAlert('danger', response.message);
                                // Revert checkbox
                                $(this).prop('checked', !isChecked);
                            }
                        },
                        error: function() {
                            showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
                            // Revert checkbox
                            $(this).prop('checked', !isChecked);
                        }
                    });
                });
            });

            function deletePricingTier(tierId) {
                if (confirm('Bạn có chắc chắn muốn xóa mức giá này không?')) {
                    $.ajax({
                        url: `/admin/driver/pricing-tiers/${tierId}`,
                        method: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                showAlert('success', response.message);
                                // Remove row from table
                                $(`tr[data-id="${tierId}"]`).remove();
                            } else {
                                showAlert('danger', response.message);
                            }
                        },
                        error: function() {
                            showAlert('danger', 'Có lỗi xảy ra khi xóa mức giá');
                        }
                    });
                }
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
            .pricing-time-slot {
                border: 1px solid #e3e6f0;
                border-radius: 0.35rem;
                padding: 1.5rem;
                background-color: #f8f9fc;
            }

            .pricing-time-slot h4 {
                color: #5a5c69;
                border-bottom: 2px solid #e3e6f0;
                padding-bottom: 0.5rem;
            }

            .btn-action {
                display: inline-block;
                width: 32px;
                height: 32px;
                line-height: 32px;
                text-align: center;
                border-radius: 4px;
                margin: 0 2px;
                text-decoration: none;
                transition: all 0.3s ease;
            }

            .btn-edit {
                background-color: #36b9cc;
                color: white;
            }

            .btn-edit:hover {
                background-color: #2a96a5;
                color: white;
            }

            .btn-delete {
                background-color: #e74a3b;
                color: white;
                border: none;
                cursor: pointer;
            }

            .btn-delete:hover {
                background-color: #be2617;
            }

            .empty-state {
                color: #858796;
            }

            .empty-icon {
                font-size: 4rem;
                margin-bottom: 1rem;
                color: #dddfeb;
            }
        </style>
    @endpush
