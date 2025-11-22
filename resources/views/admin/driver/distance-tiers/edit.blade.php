@extends('admin.index')

@section('page_title', 'Chỉnh sửa khoảng cách')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.distance-tiers.index') }}">Danh sách khoảng cách</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa khoảng cách</li>
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
                            <i class="bi bi-route-gear"></i> Chỉnh sửa khoảng cách: {{ $distanceTier->name }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-distance-tier-form" method="POST"
                            action="{{ route('admin.driver.distance-tiers.update', $distanceTier->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    <i class="bi bi-tag"></i> Tên khoảng cách <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="📏 Nhập tên khoảng cách..."
                                                    value="{{ old('name', $distanceTier->name) }}" required>
                                                <div class="invalid-feedback" id="name-error"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="display_text" class="form-label">
                                                    <i class="bi bi-text-paragraph"></i> Text hiển thị <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="display_text"
                                                    name="display_text" placeholder="📝 Nhập text hiển thị..."
                                                    value="{{ old('display_text', $distanceTier->display_text) }}" required>
                                                <div class="invalid-feedback" id="display_text-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="from_distance" class="form-label">
                                                    <i class="bi bi-arrow-right"></i> Từ khoảng cách (km) <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="number" class="form-control" id="from_distance"
                                                    name="from_distance" placeholder="0"
                                                    value="{{ old('from_distance', $distanceTier->from_distance) }}"
                                                    data-debug="from_distance: {{ $distanceTier->from_distance }}"
                                                    min="0" step="0.1" required>
                                                <div class="invalid-feedback" id="from_distance-error"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="to_distance" class="form-label">
                                                    <i class="bi bi-arrow-left"></i> Đến khoảng cách (km)
                                                </label>
                                                <input type="number" class="form-control" id="to_distance"
                                                    name="to_distance" placeholder="0"
                                                    value="{{ old('to_distance', $distanceTier->to_distance) }}"
                                                    min="0" step="0.1">
                                                <div class="invalid-feedback" id="to_distance-error"></div>
                                                <small class="form-text text-muted">Để trống nếu không giới hạn</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô tả
                                        </label>
                                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="📄 Nhập mô tả...">{{ old('description', $distanceTier->description) }}</textarea>
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
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_active"
                                                        name="is_active" value="1"
                                                        {{ old('is_active', $distanceTier->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        <i class="bi bi-toggle-on"></i> Kích hoạt khoảng cách
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự hiển thị
                                                </label>
                                                <input type="number" class="form-control" id="sort_order"
                                                    name="sort_order" placeholder="0"
                                                    value="{{ old('sort_order', $distanceTier->sort_order) }}"
                                                    min="0">
                                                <div class="invalid-feedback" id="sort_order-error"></div>
                                                <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                            </div>

                                            <div class="mb-3">
                                                <label for="color" class="form-label">
                                                    <i class="bi bi-palette"></i> Màu sắc
                                                </label>
                                                <input type="color" class="form-control form-control-color"
                                                    id="color" name="color"
                                                    value="{{ old('color', $distanceTier->color) }}"
                                                    title="Chọn màu sắc">
                                                <div class="invalid-feedback" id="color-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="icon" class="form-label">
                                                    <i class="bi bi-emoji-smile"></i> Icon
                                                </label>
                                                <input type="text" class="form-control" id="icon" name="icon"
                                                    placeholder="🎨 Ví dụ: fas fa-route"
                                                    value="{{ old('icon', $distanceTier->icon) }}">
                                                <div class="invalid-feedback" id="icon-error"></div>
                                                <small class="form-text text-muted">Sử dụng FontAwesome icons</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.driver.distance-tiers.index') }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật khoảng cách
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
        $(document).ready(function() {
            // Form submission
            $('#edit-distance-tier-form').on('submit', function(e) {
                e.preventDefault();

                // Clear previous errors
                clearErrors();

                // Show loading state
                const submitBtn = $('#submit-btn');
                const spinner = submitBtn.find('.spinner-border');
                const icon = submitBtn.find('.bi');

                submitBtn.prop('disabled', true);
                spinner.removeClass('d-none');
                icon.addClass('d-none');

                var formData = $(this).serialize();
                console.log('Form data:', formData);

                $.ajax({
                    url: '{{ route('admin.driver.distance-tiers.update', $distanceTier->id) }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            showAlert('success', response.message);
                            // Redirect after 1 second
                            setTimeout(function() {
                                window.location.href =
                                    '{{ route('admin.driver.distance-tiers.index') }}';
                            }, 1000);
                        } else {
                            showAlert('danger', response.message);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            // Validation errors
                            const errors = xhr.responseJSON.errors;
                            displayErrors(errors);
                            showAlert('danger', 'Vui lòng kiểm tra lại thông tin nhập vào');
                        } else {
                            showAlert('danger', 'Có lỗi xảy ra khi cập nhật khoảng cách');
                        }
                    },
                    complete: function() {
                        // Reset loading state
                        submitBtn.prop('disabled', false);
                        spinner.addClass('d-none');
                        icon.removeClass('d-none');
                    }
                });
            });
        });

        function clearErrors() {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        function displayErrors(errors) {
            $.each(errors, function(field, messages) {
                const input = $(`[name="${field}"]`);
                const errorDiv = $(`#${field}-error`);

                input.addClass('is-invalid');
                errorDiv.text(messages[0]);
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
