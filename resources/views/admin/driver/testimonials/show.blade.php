@extends('admin.index')

@section('title', 'Chi tiết đánh giá khách hàng')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chi tiết đánh giá khách hàng</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.driver.testimonials.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <!-- <a href="{{ route('admin.driver.testimonials.edit', $testimonial) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Chỉnh sửa
                        </a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Tên khách hàng:</strong></label>
                                        <p class="form-control-static">{{ $testimonial->customer_name }}</p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Đánh giá:</strong></label>
                                        <div class="rating-display">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                            @endfor
                                            <span class="ml-2">({{ $testimonial->rating }}/5)</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Loại dịch vụ:</strong></label>
                                        <p class="form-control-static">
                                            @switch($testimonial->service_type)
                                                @case('hourly')
                                                    Lái xe theo giờ
                                                    @break
                                                @case('trip')
                                                    Lái xe theo chuyến
                                                    @break
                                                @case('custom')
                                                    Lái xe theo yêu cầu
                                                    @break
                                                @case('business')
                                                    Lái xe cho doanh nghiệp
                                                    @break
                                                @case('event')
                                                    Lái xe cho sự kiện
                                                    @break
                                                @default
                                                    {{ $testimonial->service_type }}
                                            @endswitch
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Trạng thái:</strong></label>
                                        <span class="badge badge-{{ $testimonial->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ $testimonial->status == 'active' ? 'Hiển thị' : 'Ẩn' }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Nổi bật:</strong></label>
                                        <span class="badge badge-{{ $testimonial->is_featured ? 'warning' : 'secondary' }}">
                                            {{ $testimonial->is_featured ? 'Có' : 'Không' }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Thứ tự hiển thị:</strong></label>
                                        <p class="form-control-static">{{ $testimonial->display_order }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Nội dung đánh giá:</strong></label>
                                <div class="testimonial-content p-3 bg-light rounded">
                                    <p class="mb-0">{{ $testimonial->content }}</p>
                                </div>
                            </div>

                            @if($testimonial->notes)
                            <div class="form-group">
                                <label><strong>Ghi chú:</strong></label>
                                <div class="notes-content p-3 bg-light rounded">
                                    <p class="mb-0">{{ $testimonial->notes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            @if($testimonial->image)
                            <div class="form-group">
                                <label><strong>Ảnh khách hàng:</strong></label>
                                <div class="testimonial-image">
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" 
                                         alt="Ảnh {{ $testimonial->customer_name }}" 
                                         class="img-fluid rounded" style="max-width: 100%;">
                                </div>
                            </div>
                            @endif

                            <div class="form-group">
                                <label><strong>Thông tin khác:</strong></label>
                                <div class="info-list">
                                    <div class="info-item">
                                        <strong>Ngày tạo:</strong>
                                        <span>{{ $testimonial->created_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <strong>Cập nhật lần cuối:</strong>
                                        <span>{{ $testimonial->updated_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label><strong>Thao tác nhanh:</strong></label>
                                <div class="btn-group-vertical w-100">
                                    <button type="button" class="btn btn-sm btn-{{ $testimonial->status == 'active' ? 'warning' : 'success' }} toggle-status" 
                                            data-id="{{ $testimonial->id }}" data-status="{{ $testimonial->status }}">
                                        <i class="fas fa-{{ $testimonial->status == 'active' ? 'eye-slash' : 'eye' }}"></i>
                                        {{ $testimonial->status == 'active' ? 'Ẩn' : 'Hiển thị' }}
                                    </button>
                                    
                                    <button type="button" class="btn btn-sm btn-{{ $testimonial->is_featured ? 'secondary' : 'warning' }} toggle-featured" 
                                            data-id="{{ $testimonial->id }}" data-featured="{{ $testimonial->is_featured }}">
                                        <i class="fas fa-star"></i>
                                        {{ $testimonial->is_featured ? 'Bỏ nổi bật' : 'Đánh dấu nổi bật' }}
                                    </button>
                                    
                                    <form action="{{ route('admin.driver.testimonials.destroy', $testimonial) }}" 
                                          method="POST" class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger w-100" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa đánh giá này?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Toggle status
    $('.toggle-status').on('click', function() {
        const id = $(this).data('id');
        const currentStatus = $(this).data('status');
        const newStatus = currentStatus === 'active' ? 'inactive' : 'active';
        
        $.ajax({
            url: `/admin/driver/testimonials/${id}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra!');
            }
        });
    });

    // Toggle featured
    $('.toggle-featured').on('click', function() {
        const id = $(this).data('id');
        const currentFeatured = $(this).data('featured');
        const newFeatured = !currentFeatured;
        
        $.ajax({
            url: `/admin/driver/testimonials/${id}/toggle-featured`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_featured: newFeatured
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra!');
            }
        });
    });
});
</script>

<style>
.rating-display .fas.fa-star {
    font-size: 18px;
}

.testimonial-content, .notes-content {
    border-left: 4px solid #007bff;
}

.info-list .info-item {
    padding: 8px 0;
    border-bottom: 1px solid #eee;
}

.info-list .info-item:last-child {
    border-bottom: none;
}

.info-list .info-item strong {
    display: inline-block;
    width: 120px;
    color: #666;
}

.testimonial-image img {
    border: 1px solid #ddd;
    padding: 5px;
}
</style>
@endsection
