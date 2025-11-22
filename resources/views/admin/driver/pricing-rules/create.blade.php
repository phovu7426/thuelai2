@extends('admin.index')

@section('page_title', 'Thêm quy tắc giá mới')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.pricing-rules.index') }}">Quy tắc giá</a>
    </li>
    <li class="breadcrumb-item active">Thêm mới</li>
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
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Thêm quy tắc giá mới</h3>
                                <a href="{{ route('admin.driver.pricing-rules.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Alert messages -->
                            <div id="alert-container"></div>

                            <form id="create-pricing-rule-form" action="{{ route('admin.driver.pricing-rules.store') }}"
                                method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="time_slot">Thời gian <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="time_slot" name="time_slot"
                                                value="{{ old('time_slot') }}"
                                                placeholder="Ví dụ: Trước 22h, 22h - 24h, Sau 24h" required>
                                            <div class="invalid-feedback" id="time_slot-error"></div>
                                            <small class="form-text text-muted">Nhập thời gian tùy ý</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="time_icon">Icon <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="time_icon" name="time_icon"
                                                value="{{ old('time_icon') }}"
                                                placeholder="Ví dụ: fas fa-sun, fas fa-moon, fas fa-star" required>
                                            <div class="invalid-feedback" id="time_icon-error"></div>
                                            <small class="form-text text-muted">Sử dụng FontAwesome icons</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="time_color">Màu sắc <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="time_color" name="time_color"
                                                value="{{ old('time_color') }}"
                                                placeholder="Ví dụ: #ffc107, #17a2b8, #dc3545" required>
                                            <div class="invalid-feedback" id="time_color-error"></div>
                                            <small class="form-text text-muted">Hex code hoặc tên màu CSS</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    @foreach ($distanceTiers as $tier)
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="price_{{ $tier->id }}">Giá {{ $tier->display_text }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="price_{{ $tier->id }}"
                                                    name="price_{{ $tier->id }}"
                                                    value="{{ old('price_' . $tier->id, $tier->to_distance === null ? 'Thỏa thuận' : '') }}"
                                                    placeholder="{{ $tier->to_distance === null ? 'Thỏa thuận' : 'Nhập giá (số hoặc text)' }}"
                                                    required>
                                                <div class="invalid-feedback" id="price_{{ $tier->id }}-error"></div>
                                                <small class="form-text text-muted">
                                                    @if ($tier->to_distance === null)
                                                        Có thể nhập "Thỏa thuận" hoặc giá cụ thể (số hoặc text)
                                                    @else
                                                        Có thể nhập số (VD: 50000) hoặc text (VD: "50k", "Thỏa thuận")
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="sort_order">Thứ tự sắp xếp</label>
                                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                                value="{{ old('sort_order', 0) }}" min="0" step="1">
                                            <div class="invalid-feedback" id="sort_order-error"></div>
                                            <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="is_active">Trạng thái</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Kích hoạt quy tắc này
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                        <i class="fas fa-save"></i> Tạo quy tắc
                                    </button>
                                    <a href="{{ route('admin.driver.pricing-rules.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Hủy
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Form submission - now using normal form submit instead of AJAX
            $('#create-pricing-rule-form').on('submit', function(e) {
                // Clear previous errors
                clearErrors();

                // Show loading state
                const submitBtn = $('#submit-btn');
                const spinner = submitBtn.find('.spinner-border');
                const icon = submitBtn.find('.fas');

                submitBtn.prop('disabled', true);
                spinner.removeClass('d-none');
                icon.addClass('d-none');

                // Let the form submit normally - controller will handle redirect
                return true;
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
