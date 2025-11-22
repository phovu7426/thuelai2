@extends('layouts.home')

@section('page_title', 'Danh sách bài đăng')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h1 class="mb-0 fw-bold">Bài Đăng</h1>
                <p class="text-muted lead">Khám phá kiến thức và thông tin hữu ích</p>
            </div>
            <div class="col-md-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb justify-content-md-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang Chủ</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Bài Đăng</li>
                    </ol>
                </nav>
            </div>
        </div>

        @if (request()->has('search') && request('search'))
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert alert-primary d-flex align-items-center" role="alert">
                        <i class="fas fa-search me-2"></i>
                        <div>
                            Kết quả tìm kiếm cho: <strong>{{ request('search') }}</strong>
                            <a href="{{ route('home.posts.index') }}" class="ms-2 btn btn-sm btn-outline-primary">
                                <i class="fas fa-times me-1"></i> Xóa bộ lọc
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if ($posts->isEmpty())
            <div class="row mt-5">
                <div class="col-md-12 text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-search fa-4x text-muted"></i>
                    </div>
                    <h3 class="text-muted">Không tìm thấy bài đăng nào</h3>
                    <p class="lead text-muted">
                        {{ request()->has('search') ? 'Không có kết quả phù hợp với tìm kiếm của bạn.' : 'Chưa có bài đăng nào được tạo.' }}
                    </p>
                    @if (request()->has('search'))
                        <a href="{{ route('home.posts.index') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left me-2"></i> Quay lại tất cả bài đăng
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach ($posts as $post)
                    <div class="col">
                        <div class="card post-card h-100">
                            @if ($post->require_login)
                                <div class="login-required-badge">
                                    <i class="fas fa-lock me-1"></i> Yêu cầu đăng nhập
                                </div>
                            @endif

                            <div class="position-relative">
                                @if ($post->image)
                                    <img src="{{ asset($post->image) }}" class="card-img-top post-image"
                                        alt="{{ $post->name }}">
                                @else
                                    <div class="bg-light post-image d-flex align-items-center justify-content-center">
                                        <i class="fas fa-file-alt text-muted fa-3x"></i>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 start-0 p-3">
                                    <span class="badge bg-primary">
                                        <i class="far fa-calendar-alt me-1"></i> {{ $post->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('home.posts.show', $post->slug) }}"
                                        class="text-decoration-none stretched-link">
                                        {{ $post->name }}
                                    </a>
                                </h5>

                                <p class="card-text">
                                    @if ($post->description)
                                        {{ Str::limit($post->description, 120) }}
                                    @else
                                        {!! Str::limit(strip_tags($post->content), 120) !!}
                                    @endif
                                </p>
                            </div>

                            <div class="card-footer py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-user-circle me-1"></i> {{ $post->user->name }}
                                    </small>
                                    <a href="{{ route('home.posts.show', $post->slug) }}"
                                        class="btn btn-sm btn-outline-primary">
                                        Xem chi tiết <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mt-5">
                <div class="col-md-12 d-flex justify-content-center">
                    {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
    </div>
@endsection