@extends('admin.index')

@section('page_title', 'Chỉnh sửa quy tắc giá')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.pricing-rules.index') }}">Danh sách quy tắc giá</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa quy tắc giá</li>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
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

            <!--begin::Row-->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-currency-exchange"></i> Chỉnh sửa quy tắc giá: {{ $pricingRule->time_slot }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <form id="edit-pricing-rule-form"
                            action="{{ route('admin.driver.pricing-rules.update', $pricingRule->id) }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="time_slot" class="form-label">
                                                    <i class="bi bi-clock"></i> Thời gian <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="time_slot" name="time_slot"
                                                    value="{{ old('time_slot', $pricingRule->time_slot) }}"
                                                    placeholder="⏰ Ví dụ: Trước 22h, 22h - 24h, Sau 24h" required>
                                                <div class="invalid-feedback" id="time_slot-error"></div>
                                                <small class="form-text text-muted">Nhập thời gian tùy ý</small>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="time_icon" class="form-label">
                                                    <i class="bi bi-emoji-smile"></i> Icon <span
                                                        class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="time_icon" name="time_icon"
                                                    value="{{ old('time_icon', $pricingRule->time_icon) }}"
                                                    placeholder="🎨 Ví dụ: fas fa-sun, fas fa-moon, fas fa-star" required>
                                                <div class="invalid-feedback" id="time_icon-error"></div>
                                                <small class="form-text text-muted">Sử dụng FontAwesome icons</small>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="time_color" class="form-label">
                                                    <i class="bi bi-palette"></i> Màu sắc <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control" id="time_color" name="time_color"
                                                    value="{{ old('time_color', $pricingRule->time_color) }}"
                                                    placeholder="🎨 Ví dụ: #ffc107, #17a2b8, #dc3545" required>
                                                <div class="invalid-feedback" id="time_color-error"></div>
                                                <small class="form-text text-muted">Hex code hoặc tên màu CSS</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-12">
                                            <h5 class="mb-3">
                                                <i class="bi bi-currency-dollar"></i> Cấu hình giá theo khoảng cách
                                            </h5>
                                        </div>
                                    </div>

                                    <div class="row g-3">
                                        @foreach ($distanceTiers as $tier)
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    @php
                                                        $currentPrice = $pricingRule->pricingDistances
                                                            ->where('distance_tier_id', $tier->id)
                                                            ->first();
                                                        $priceValue = $currentPrice
                                                            ? ($currentPrice->price_text ?:
                                                            $currentPrice->price)
                                                            : '';
                                                    @endphp
                                                    <label for="price_{{ $tier->id }}" class="form-label">
                                                        <i class="bi bi-graph-up"></i> Giá {{ $tier->display_text }} <span
                                                            class="text-danger">*</span>
                                                    </label>
                                                    <input type="text" class="form-control"
                                                        id="price_{{ $tier->id }}" name="price_{{ $tier->id }}"
                                                        value="{{ old('price_' . $tier->id, $priceValue) }}"
                                                        placeholder="💰 Nhập giá (số hoặc text)..." required>
                                                    <div class="invalid-feedback" id="price_{{ $tier->id }}-error">
                                                    </div>
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
                                                <label for="description" class="form-label">
                                                    <i class="bi bi-text-paragraph"></i> Mô tả
                                                </label>
                                                <textarea class="form-control" id="description" name="description" rows="3" placeholder="📝 Nhập mô tả...">{{ old('description', $pricingRule->description) }}</textarea>
                                                <div class="invalid-feedback" id="description-error"></div>
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_active"
                                                        name="is_active" value="1"
                                                        {{ old('is_active', $pricingRule->is_active) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_active">
                                                        <i class="bi bi-toggle-on"></i> Kích hoạt quy tắc
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="sort_order" class="form-label">
                                                    <i class="bi bi-sort-numeric-down"></i> Thứ tự ưu tiên
                                                </label>
                                                <input type="number" class="form-control" id="sort_order"
                                                    name="sort_order" placeholder="0"
                                                    value="{{ old('sort_order', $pricingRule->sort_order) }}"
                                                    min="0">
                                                <div class="invalid-feedback" id="sort_order-error"></div>
                                                <small class="form-text text-muted">Số càng nhỏ càng ưu tiên cao</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.driver.pricing-rules.index') }}"
                                            class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary" id="submit-btn">
                                            <span class="spinner-border spinner-border-sm d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i class="bi bi-check-circle"></i> Cập nhật quy tắc giá
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
            // Form submission - now using normal form submit instead of AJAX
            $('#edit-pricing-rule-form').on('submit', function(e) {
                // Clear previous errors
                clearErrors();

                // Show loading state
                const submitBtn = $('#submit-btn');
                const spinner = submitBtn.find('.spinner-border');
                const icon = submitBtn.find('.bi');

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
