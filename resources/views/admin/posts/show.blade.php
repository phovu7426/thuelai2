@extends('admin.index')

@section('page_title', 'Chi tiết bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Quản lý bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết bài viết</li>
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
                            <h3 class="card-title">Chi tiết bài viết: {{ $post->title ?? 'N/A' }}</h3>
                            <div>
                                <a href="{{ route('admin.posts.edit', $post->id ?? '') }}" class="btn btn-primary">
                                    <i class="bi bi-pencil"></i> Chỉnh sửa
                                </a>
                                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
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
                                            <p><strong>Tiêu đề:</strong> {{ $post->title ?? 'N/A' }}</p>
                                            <p><strong>Mô tả:</strong> {{ $post->excerpt ?? 'Chưa có mô tả' }}</p>
                                            <p><strong>Trạng thái:</strong> 
                                                @switch($post->status ?? '')
                                                    @case('published')
                                                        <span class="badge bg-success">Đã xuất bản</span>
                                                        @break
                                                    @case('draft')
                                                        <span class="badge bg-warning">Bản nháp</span>
                                                        @break
                                                    @case('archived')
                                                        <span class="badge bg-secondary">Đã lưu trữ</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary">{{ $post->status ?? 'N/A' }}</span>
                                                @endswitch
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Nổi bật:</strong> 
                                                @if($post->featured ?? false)
                                                    <span class="badge bg-warning">Có</span>
                                                @else
                                                    <span class="badge bg-secondary">Không</span>
                                                @endif
                                            </p>
                                            <p><strong>Danh mục:</strong> 
                                                @if($post->category)
                                                    <span class="badge bg-info">{{ $post->category->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Không có</span>
                                                @endif
                                            </p>
                                            <p><strong>Ngày tạo:</strong> {{ $post->created_at ? $post->created_at->format('d/m/Y H:i') : 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>

                                @if($post->content ?? false)
                                <div class="mb-4">
                                    <h5>Nội dung chi tiết</h5>
                                    <hr>
                                    <div class="content-detail">
                                        {!! $post->content !!}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Hình ảnh</h5>
                                    <hr>
                                    @if($post->image ?? false)
                                        <div class="text-center mb-3">
                                            <img src="{{ asset('storage/' . $post->image) }}" 
                                                 alt="{{ $post->title ?? 'Bài viết' }}" 
                                                 class="img-fluid rounded" style="max-width: 100%;">
                                        </div>
                                    @else
                                        <p class="text-muted text-center">Chưa có hình ảnh</p>
                                    @endif
                                </div>

                                @if($post->meta_title || $post->meta_description)
                                <div class="mb-4">
                                    <h5>SEO</h5>
                                    <hr>
                                    @if($post->meta_title)
                                        <p><strong>Meta Title:</strong> {{ $post->meta_title }}</p>
                                    @endif
                                    @if($post->meta_description)
                                        <p><strong>Meta Description:</strong> {{ $post->meta_description }}</p>
                                    @endif
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
