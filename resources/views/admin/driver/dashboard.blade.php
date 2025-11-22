@extends('admin.index')

@section('title', 'Dashboard - Dịch vụ lái xe')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Dashboard - Dịch vụ lái xe</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Dịch vụ lái xe</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="avatar avatar-lg">
                                <i class="bi bi-gear text-primary" style="font-size: 2rem;"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">{{ $stats['total_services'] }}</h4>
                            <p class="mb-0">Tổng dịch vụ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="avatar avatar-lg">
                                <i class="bi bi-cart-check text-success" style="font-size: 2rem;"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">{{ $stats['total_orders'] }}</h4>
                            <p class="mb-0">Tổng đơn hàng</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="avatar avatar-lg">
                                <i class="bi bi-chat-quote text-warning" style="font-size: 2rem;"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">{{ $stats['total_testimonials'] }}</h4>
                            <p class="mb-0">Tổng đánh giá</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <span class="avatar avatar-lg">
                                <i class="bi bi-clock text-info" style="font-size: 2rem;"></i>
                            </span>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h4 class="mb-1">{{ $stats['pending_orders'] }}</h4>
                            <p class="mb-0">Đơn hàng chờ</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Statistics Cards -->

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Đơn hàng gần đây</h5>
                </div>
                <div class="card-body">
                    @if($recent_orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Khách hàng</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày tạo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent_orders as $order)
                                    <tr>
                                        <td>
                                            {{ $order->order_number ?? 'N/A' }}
                                        </td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'pending' ? 'warning' : ($order->status === 'completed' ? 'success' : 'info') }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @else
                        <p class="text-muted text-center">Chưa có đơn hàng nào.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Testimonials -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Đánh giá gần đây</h5>
                </div>
                <div class="card-body">
                    @if($recent_testimonials->count() > 0)
                        @foreach($recent_testimonials as $testimonial)
                        <div class="d-flex align-items-start mb-3">
                            <div class="flex-shrink-0">
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
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-1">{{ $testimonial->customer_name }}</h6>
                                <div class="mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-muted"></i>
                                        @endif
                                    @endfor
                                </div>
                                <p class="mb-0 text-muted">{{ Str::limit($testimonial->content, 100) }}</p>
                            </div>
                        </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.driver.testimonials.index') }}" class="btn btn-primary btn-sm">
                                Xem tất cả đánh giá
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center">Chưa có đánh giá nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Services -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Dịch vụ nổi bật</h5>
                </div>
                <div class="card-body">
                    @if($featured_services->count() > 0)
                        <div class="row">
                            @foreach($featured_services as $service)
                            <div class="col-md-4 mb-3">
                                <div class="d-flex align-items-center p-3 border rounded">
                                    <div class="flex-shrink-0">
                                        @if($service->icon)
                                            <img src="{{ asset('storage/' . $service->icon) }}" 
                                                 alt="{{ $service->name }}" 
                                                 class="rounded" 
                                                 width="50" height="50">
                                        @else
                                            <div class="bg-primary rounded d-flex align-items-center justify-content-center" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-gear text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="mb-1">{{ $service->name }}</h6>
                                        <p class="mb-0 text-muted">{{ Str::limit($service->short_description, 80) }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.driver.services.index') }}" class="btn btn-primary btn-sm">
                                Quản lý dịch vụ
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center">Chưa có dịch vụ nổi bật nào.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Có thể thêm JavaScript cho biểu đồ và thống kê real-time ở đây
    console.log('Driver Dashboard loaded');
});
</script>
@endsection
