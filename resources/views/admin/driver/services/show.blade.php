@extends('admin.index')

@section('page_title', 'Chi tiết dịch vụ lái xe')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.services.index') }}">Quản lý dịch vụ lái xe</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết dịch vụ</li>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Chi tiết dịch vụ: {{ $service->name ?? 'N/A' }}</h3>
                            <div>
                                <a href="{{ route('admin.driver.services.edit', $service->id ?? '') }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Chỉnh sửa
                                </a>
                                <a href="{{ route('admin.driver.services.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h5>Thông tin cơ bản</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Tên dịch vụ:</strong> {{ $service->name ?? 'N/A' }}</p>
                                            <p><strong>Mô tả:</strong> {{ $service->description ?? 'Chưa có mô tả' }}</p>
                                            <p><strong>Trạng thái:</strong> 
                                                @if($service->status ?? false)
                                                    <span class="badge bg-success">Kích hoạt</span>
                                                @else
                                                    <span class="badge bg-danger">Vô hiệu hóa</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Nổi bật:</strong> 
                                                @if($service->is_featured ?? false)
                                                    <span class="badge bg-warning">Có</span>
                                                @else
                                                    <span class="badge bg-secondary">Không</span>
                                                @endif
                                            </p>
                                            <p><strong>Thứ tự hiển thị:</strong> {{ $service->sort_order ?? 0 }}</p>
                                            <p><strong>Ngày tạo:</strong> {{ $service->created_at ? $service->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($service->content ?? false)
                                <div class="mb-4">
                                    <h5>Nội dung chi tiết</h5>
                                    <hr>
                                    <div class="content-detail">
                                        {!! $service->content !!}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Hình ảnh</h5>
                                    <hr>
                                    @if($service->image ?? false)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $service->image) }}" 
                                                 alt="{{ $service->name ?? 'Dịch vụ' }}" 
                                                 class="img-fluid rounded" style="max-width: 100%;">
                                        </div>
                                    @else
                                        <p class="text-muted text-center">Chưa có hình ảnh</p>
                                    @endif
                                </div>

                                @if($service->icon ?? false)
                                <div class="mb-4">
                                    <h5>Icon</h5>
                                    <hr>
                                    <div class="text-center">
                                        <i class="{{ $service->icon }}" style="font-size: 3rem;"></i>
                                        <p class="mt-2 text-muted">{{ $service->icon }}</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
