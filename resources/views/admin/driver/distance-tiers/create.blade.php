@extends('admin.index')

@section('page_title', 'Thêm khoảng cách mới')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.driver.distance-tiers.index') }}">Khoảng cách</a>
    </li>
    <li class="breadcrumb-item active">Thêm mới</li>
@endsection

@section('content')
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="card-title">Thêm khoảng cách mới</h3>
                                <a href="{{ route('admin.driver.distance-tiers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Alert messages -->
                            <div id="alert-container"></div>

                            <form id="create-distance-tier-form" method="POST"
                                action="{{ route('admin.driver.distance-tiers.store') }}">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Tên khoảng cách <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                value="{{ old('name') }}" placeholder="Ví dụ: 5km đầu, 6-10km, >10km"
                                                required>
                                            <div class="invalid-feedback" id="name-error"></div>
                                            <small class="form-text text-muted">Tên để quản lý khoảng cách</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="display_text">Text hiển thị <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="display_text" name="display_text"
                                                value="{{ old('display_text') }}"
                                                placeholder="Ví dụ: 5km đầu, 6-10km, >10km, >30km" required>
                                            <div class="invalid-feedback" id="display_text-error"></div>
                                            <small class="form-text text-muted">Text hiển thị trong bảng giá</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="from_distance">Từ km <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="from_distance"
                                                name="from_distance" value="{{ old('from_distance', 0) }}" min="0"
                                                step="0.1" placeholder="0" required>
                                            <div class="invalid-feedback" id="from_distance-error"></div>
                                            <small class="form-text text-muted">Khoảng cách bắt đầu</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="to_distance">Đến km</label>
                                            <input type="number" class="form-control" id="to_distance" name="to_distance"
                                                value="{{ old('to_distance') }}" min="0" step="0.1"
                                                placeholder="Để trống = không giới hạn">
                                            <div class="invalid-feedback" id="to_distance-error"></div>
                                            <small class="form-text text-muted">Để trống = từ km đó trở lên</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="sort_order">Thứ tự sắp xếp</label>
                                            <input type="number" class="form-control" id="sort_order" name="sort_order"
                                                value="{{ old('sort_order', 0) }}" min="0" step="1">
                                            <div class="invalid-feedback" id="sort_order-error"></div>
                                            <small class="form-text text-muted">Số càng nhỏ càng hiển thị trước</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="description">Mô tả</label>
                                            <textarea class="form-control" id="description" name="description" rows="3"
                                                placeholder="Mô tả chi tiết về khoảng cách này">{{ old('description') }}</textarea>
                                            <div class="invalid-feedback" id="description-error"></div>
                                            <small class="form-text text-muted">Mô tả để dễ hiểu hơn</small>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="is_active">Trạng thái</label>
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="is_active"
                                                    name="is_active" value="1"
                                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Kích hoạt khoảng cách này
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">
                                        <span class="spinner-border spinner-border-sm d-none" role="status"
                                            aria-hidden="true"></span>
                                        <i class="fas fa-save"></i> Tạo khoảng cách
                                    </button>
                                    <a href="{{ route('admin.driver.distance-tiers.index') }}" class="btn btn-secondary">
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
            // Form sẽ submit bình thường, không cần AJAX
            // Chỉ giữ lại auto-generate functions

            // Auto-generate display text from name
            $('#name').on('input', function() {
                const name = $(this).val();
                if (name && !$('#display_text').val()) {
                    $('#display_text').val(name);
                }
            });

            // Auto-generate distance range from min/max
            $('#min_distance, #max_distance').on('input', function() {
                const minDistance = $('#min_distance').val();
                const maxDistance = $('#max_distance').val();

                if (minDistance && maxDistance) {
                    const range = `${minDistance}-${maxDistance}km`;
                    $('#distance_range').val(range);
                }
            });
        });
    </script>
@endpush
