@extends('admin.index')

@section('page_title', 'Quản lý đánh giá khách hàng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.dashboard') }}">Dịch vụ lái xe</a></li>
    <li class="breadcrumb-item active" aria-current="page">Đánh giá khách hàng</li>
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
                                        <input type="text" id="search-customer-name" class="form-control" placeholder="🔍 Nhập tên khách hàng">
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
                            <!-- <div class="col-sm-3 d-flex justify-content-end">
                                @can('access_driver_testimonials')
                                    <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm đánh giá mới
                                    </button>
                                @endcan
                            </div> -->
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        @if($testimonials->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Hình ảnh</th>
                                            <th>Khách hàng</th>
                                            <th>Đánh giá</th>
                                            <th>Nội dung</th>
                                            <th>Trạng thái</th>
                                            <th>Nổi bật</th>
                                            <th>Ngày tạo</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="testimonials-table-body">
                                        @foreach($testimonials as $index => $testimonial)
                                        <tr data-id="{{ $testimonial->id }}">
                                            <td>{{ $testimonials->firstItem() + $index }}</td>
                                            <td>
                                                @if($testimonial->image)
                                                    <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                                         alt="{{ $testimonial->customer_name }}" 
                                                         class="rounded-circle" 
                                                         width="40" height="40">
                                                @else
                                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="bi bi-person text-white"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $testimonial->customer_name }}</strong><br>
                                                <small class="text-muted">{{ $testimonial->customer_position ?? 'Khách hàng' }}</small>
                                            </td>
                                            <td>
                                                <div class="mb-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $testimonial->rating)
                                                            <i class="bi bi-star-fill text-warning"></i>
                                                        @else
                                                            <i class="bi bi-star text-muted"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <small class="text-muted">{{ $testimonial->rating }}/5 sao</small>
                                            </td>
                                            <td>{{ Str::limit($testimonial->content, 100) }}</td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-testimonial-id="{{ $testimonial->id }}" 
                                                        data-current-status="{{ $testimonial->status ? '1' : '0' }}"
                                                        data-status-type="testimonials">
                                                    <option value="0" {{ !$testimonial->status ? 'selected' : '' }}>
                                                        Vô hiệu
                                                    </option>
                                                    <option value="1" {{ $testimonial->status ? 'selected' : '' }}>
                                                        Kích hoạt
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm featured-select" 
                                                        data-testimonial-id="{{ $testimonial->id }}" 
                                                        data-current-featured="{{ $testimonial->featured ? '1' : '0' }}"
                                                        data-featured-type="testimonials">
                                                    <option value="0" {{ !$testimonial->featured ? 'selected' : '' }}>
                                                        Bình thường
                                                    </option>
                                                    <option value="1" {{ $testimonial->featured ? 'selected' : '' }}>
                                                        Nổi bật
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ $testimonial->created_at ? $testimonial->created_at->format('d/m/Y') : 'N/A' }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    @can('access_driver_testimonials')
                                                        <a href="{{ route('admin.driver.testimonials.show', $testimonial->id) }}"
                                                           class="btn-action btn-view" title="Xem chi tiết">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <!-- <button type="button" class="btn-action btn-edit" title="Chỉnh sửa" 
                                                                onclick="openEditModal({{ $testimonial->id }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button> -->
                                                    @endcan
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Phân trang -->
                            <div id="pagination-container">
                                @if($testimonials->hasPages())
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $testimonials->links() }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-chat-quote display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">Chưa có đánh giá nào</h4>
                                <p class="text-muted">Hãy thêm đánh giá đầu tiên để bắt đầu!</p>
                                <button type="button" class="btn btn-primary" onclick="openCreateModal()">
                                    <i class="bi bi-plus-circle"></i> Thêm đánh giá mới
                                </button>
                            </div>
                        @endif
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/universal-modal.js') }}"></script>
<script>
// Khởi tạo Universal Modal cho Testimonials (chỉ khởi tạo một lần)
if (!window.testimonialsModal) {
    window.testimonialsModal = new UniversalModal({
        modalId: 'testimonialsModal',
        modalTitle: 'Đánh giá khách hàng',
        formId: 'testimonialsForm',
        submitBtnId: 'testimonialsSubmitBtn',
        createRoute: '{{ route("admin.driver.testimonials.store") }}',
        updateRoute: '{{ route("admin.driver.testimonials.update", ":id") }}',
        getDataRoute: '{{ route("admin.driver.testimonials.getTestimonialInfo", ":id") }}',
        successMessage: 'Thao tác đánh giá khách hàng thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý đánh giá khách hàng',
        viewPath: 'admin.driver.testimonials.form',
        viewData: {},
        onSuccess: function(response, isEdit, id) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    });
}

// Global functions để gọi từ HTML
function openCreateModal() {
    window.testimonialsModal.openCreateModal();
}

function openEditModal(testimonialId) {
    window.testimonialsModal.openEditModal(testimonialId);
}

$(document).ready(function() {
    // Toggle status
    $('.toggle-status').change(function() {
        const testimonialId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/driver/testimonials/${testimonialId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật label
                    $(`.status-label-${testimonialId}`).text(isChecked ? 'Kích hoạt' : 'Vô hiệu');
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

    // Toggle featured
    $('.toggle-featured').change(function() {
        const testimonialId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/driver/testimonials/${testimonialId}/toggle-featured`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật label
                    $(`.featured-label-${testimonialId}`).text(isChecked ? 'Nổi bật' : 'Bình thường');
                } else {
                    showAlert('danger', response.message);
                    // Revert checkbox
                    $(this).prop('checked', !isChecked);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái nổi bật');
                // Revert checkbox
                $(this).prop('checked', !isChecked);
            }
        });
    });

    // Search
    $('#btn-search').click(function() {
        searchTestimonials();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-customer-name').val('');
        searchTestimonials();
    });

    // Enter key search
    $('#search-customer-name').keypress(function(e) {
        if (e.which == 13) {
            searchTestimonials();
        }
    });
});

function searchTestimonials(page = 1) {
    const customerName = $('#search-customer-name').val();
    
    $.ajax({
        url: '{{ route("admin.driver.testimonials.index") }}',
        method: 'GET',
        data: {
            customer_name: customerName,
            page: page
        },
        success: function(response) {
            $('#testimonials-table-body').html(response.html);
            $('#pagination-container').html(response.pagination);
            
            // Rebind events
            bindEvents();
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi tìm kiếm');
        }
    });
}

function deleteTestimonial(testimonialId) {
    if (confirm('Bạn có chắc chắn muốn xóa đánh giá này không?')) {
        $.ajax({
            url: `/admin/driver/testimonials/${testimonialId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Remove row from table
                    $(`tr[data-id="${testimonialId}"]`).remove();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi xóa đánh giá');
            }
        });
    }
}

function bindEvents() {
    // Rebind toggle status events
    $('.toggle-status').off('change').on('change', function() {
        const testimonialId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/driver/testimonials/${testimonialId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    $(`.status-label-${testimonialId}`).text(isChecked ? 'Kích hoạt' : 'Vô hiệu');
                } else {
                    showAlert('danger', response.message);
                    $(this).prop('checked', !isChecked);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                $(this).prop('checked', !isChecked);
            }
        });
    });

    // Rebind toggle featured events
    $('.toggle-featured').off('change').on('change', function() {
        const testimonialId = $(this).data('id');
        const isChecked = $(this).is(':checked');
        
        $.ajax({
            url: `/admin/driver/testimonials/${testimonialId}/toggle-featured`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    $(`.featured-label-${testimonialId}`).text(isChecked ? 'Nổi bật' : 'Bình thường');
                } else {
                    showAlert('danger', response.message);
                    $(this).prop('checked', !isChecked);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái nổi bật');
                $(this).prop('checked', !isChecked);
            }
        });
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
@endsection
