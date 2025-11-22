@extends('admin.index')

@section('page_title', 'Quản lý quy tắc giá')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Quy tắc giá</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="pricing-admin-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>Quản lý quy tắc giá cố định</h3>
                            <a href="{{ route('admin.driver.pricing-rules.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Thêm quy tắc mới
                            </a>
                        </div>
                    </div>

                    <div class="pricing-table-admin">
                        <div class="card-body">
                            <!-- Alert messages -->
                            <div id="alert-container"></div>

                            @if ($pricingRules->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="5%">#</th>
                                                <th width="15%">Thời gian</th>
                                                @foreach ($distanceTiers as $tier)
                                                    <th width="15%">{{ $tier->display_text }}</th>
                                                @endforeach
                                                <th width="10%">Trạng thái</th>
                                                <th width="10%">Nổi bật</th>
                                                <th width="10%">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pricing-rules-table-body">
                                            @foreach ($pricingRules as $index => $rule)
                                                <tr data-id="{{ $rule->id }}">
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <div class="time-slot-admin">
                                                            <i class="{{ $rule->time_icon }}"></i>
                                                            <span>{{ $rule->time_slot }}</span>
                                                        </div>
                                                    </td>
                                                    @foreach ($distanceTiers as $tier)
                                                        <td class="price-display">
                                                            @php
                                                                $pricingDistance = $rule->pricingDistances
                                                                    ->where('distance_tier_id', $tier->id)
                                                                    ->first();
                                                            @endphp
                                                            @if ($pricingDistance)
                                                                @if ($pricingDistance->price_text)
                                                                    <span
                                                                        class="price-value">{{ $pricingDistance->price_text }}</span>
                                                                @else
                                                                    <span class="price-value">
                                                                        {{ number_format($pricingDistance->price / 1000, 0) }}k
                                                                    </span>
                                                                    <small class="price-unit">
                                                                        @if ($tier->from_distance == 0 && $tier->to_distance)
                                                                            /chuyến
                                                                        @else
                                                                            /km
                                                                        @endif
                                                                    </small>
                                                                @endif
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    @endforeach
                                                    <td>
                                                        <select class="form-select form-select-sm status-select"
                                                            data-rule-id="{{ $rule->id }}"
                                                            data-current-status="{{ $rule->is_active ? '1' : '0' }}"
                                                            data-status-type="pricing-rules">
                                                            <option value="0"
                                                                {{ !$rule->is_active ? 'selected' : '' }}>
                                                                Tạm dừng
                                                            </option>
                                                            <option value="1"
                                                                {{ $rule->is_active ? 'selected' : '' }}>
                                                                Hoạt động
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select form-select-sm featured-select"
                                                            data-rule-id="{{ $rule->id }}"
                                                            data-current-featured="{{ $rule->is_highlighted ? '1' : '0' }}"
                                                            data-featured-type="pricing-rules">
                                                            <option value="0"
                                                                {{ !$rule->is_highlighted ? 'selected' : '' }}>
                                                                Không nổi bật
                                                            </option>
                                                            <option value="1"
                                                                {{ $rule->is_highlighted ? 'selected' : '' }}>
                                                                Nổi bật
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <div class="action-buttons-modern">
                                                            <a href="{{ route('admin.driver.pricing-rules.edit', $rule->id) }}"
                                                                class="btn-action-modern btn-edit-modern" title="Chỉnh sửa">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <button type="button"
                                                                class="btn-action-modern btn-delete-modern" title="Xóa"
                                                                onclick="deletePricingRule({{ $rule->id }})">
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
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                    <h3>Chưa có quy tắc giá nào</h3>
                                    <p>Vui lòng thêm các quy tắc giá để tạo bảng giá cố định.</p>
                                    <a href="{{ route('admin.driver.pricing-rules.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Thêm quy tắc đầu tiên
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

@section('scripts')
    <script>
        // Global functions
        window.deletePricingRule = function(ruleId) {
            console.log('Delete pricing rule called with ID:', ruleId);
            if (confirm('Bạn có chắc chắn muốn xóa quy tắc này không?')) {
                console.log('User confirmed delete');
                $.ajax({
                    url: `/admin/driver/pricing-rules/${ruleId}/delete`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log('AJAX Success:', response);
                        if (response.success) {
                            // Remove row from table first
                            $(`tr[data-id="${ruleId}"]`).remove();

                            // Show success message
                            try {
                                showAlert('success', response.message);
                            } catch (e) {
                                console.log('ShowAlert error:', e);
                                alert('Xóa quy tắc thành công!');
                            }
                        } else {
                            try {
                                showAlert('danger', response.message);
                            } catch (e) {
                                console.log('ShowAlert error:', e);
                                alert('Lỗi: ' + response.message);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX Error:', xhr, status, error);
                        console.log('Response Text:', xhr.responseText);
                        try {
                            showAlert('danger', 'Có lỗi xảy ra khi xóa quy tắc');
                        } catch (e) {
                            console.log('ShowAlert error:', e);
                            alert('Có lỗi xảy ra khi xóa quy tắc');
                        }
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

        $(document).ready(function() {
            // Status select change
            $('.status-select').change(function() {
                const ruleId = $(this).data('rule-id');
                const newStatus = $(this).val();
                const currentStatus = $(this).data('current-status');

                if (newStatus !== currentStatus) {
                    updateRuleStatus(ruleId, newStatus);
                }
            });

            // Featured select change
            $('.featured-select').change(function() {
                const ruleId = $(this).data('rule-id');
                const newFeatured = $(this).val();
                const currentFeatured = $(this).data('current-featured');

                if (newFeatured !== currentFeatured) {
                    updateRuleFeatured(ruleId, newFeatured);
                }
            });
        });

        function updateRuleStatus(ruleId, status) {
            $.ajax({
                url: `/admin/driver/pricing-rules/${ruleId}/toggle-status`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        // Update current status
                        $(`select[data-rule-id="${ruleId}"]`).data('current-status', status);
                    } else {
                        showAlert('danger', response.message);
                        // Revert select
                        const select = $(`select[data-rule-id="${ruleId}"]`);
                        select.val(select.data('current-status'));
                    }
                },
                error: function() {
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                    // Revert select
                    const select = $(`select[data-rule-id="${ruleId}"]`);
                    select.val(select.data('current-status'));
                }
            });
        }

        function updateRuleFeatured(ruleId, featured) {
            $.ajax({
                url: `/admin/driver/pricing-rules/${ruleId}/toggle-featured`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    is_highlighted: featured
                },
                success: function(response) {
                    if (response.success) {
                        showAlert('success', response.message);
                        // Update current featured
                        $(`select[data-rule-id="${ruleId}"]`).data('current-featured', featured);
                    } else {
                        showAlert('danger', response.message);
                        // Revert select
                        const select = $(`select[data-rule-id="${ruleId}"]`);
                        select.val(select.data('current-featured'));
                    }
                },
                error: function() {
                    showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
                    // Revert select
                    const select = $(`select[data-rule-id="${ruleId}"]`);
                    select.val(select.data('current-featured'));
                }
            });
        }
    </script>
@endsection
