@extends('layouts.home')

@section('page_title', $post->name)

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Trang Chủ</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('home.posts.index') }}">Bài Đăng</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ Str::limit($post->name, 40) }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <article class="bg-white p-4 shadow-sm rounded-3 mb-4">
                    <!-- Tiêu đề bài viết -->
                    <h1 class="mb-3 fw-bold">{{ $post->name }}</h1>

                    <!-- Thông tin meta -->
                    <div class="d-flex align-items-center text-muted mb-4">
                        <span class="me-3">
                            <i class="fas fa-user-circle me-2"></i> {{ $post->user->name }}
                        </span>
                        <span class="me-3">
                            <i class="far fa-calendar-alt me-2"></i> {{ $post->created_at->format('d/m/Y H:i') }}
                        </span>
                        @if ($post->require_login)
                            <span class="badge bg-secondary">
                                <i class="fas fa-lock me-1"></i> Yêu cầu đăng nhập
                            </span>
                        @endif
                    </div>

                    <!-- Mô tả ngắn -->
                    @if ($post->description)
                        <div class="mb-4 p-3 bg-light rounded-3">
                            <p class="lead mb-0">{{ $post->description }}</p>
                        </div>
                    @endif

                    <!-- Hình ảnh chính -->
                    @if ($post->image)
                        <div class="mb-4   edfdfd">
                            <img src="{{ asset($post->image) }}" alt="{{ $post->name }}" class="post-header-image">
                        </div>
                    @endif

                    <!-- Nội dung bài viết -->
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>

                    <!-- Chia sẻ và các nút chức năng -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a href="{{ route('home.posts.index') }}" class="btn btn-outline-secondary mb-2">
                                <i class="fas fa-arrow-left me-2"></i> Quay lại danh sách
                            </a>
                            <div class="d-flex flex-wrap">
                                <button class="btn btn-outline-primary me-2 mb-2" onclick="window.print()">
                                    <i class="fas fa-print me-1"></i> In
                                </button>
                                <button class="btn btn-outline-success mb-2" onclick="share()">
                                    <i class="fas fa-share-alt me-1"></i> Chia sẻ
                                </button>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Phần bình luận - có thể thêm sau -->
            </div>

            <div class="col-lg-4">
                <!-- Bài đăng liên quan -->
                <div class="bg-white p-4 shadow-sm rounded-3 mb-4">
                    <h4 class="border-bottom pb-3 mb-4 fw-bold">Bài Đăng Liên Quan</h4>

                    @if ($relatedPosts->isEmpty())
                        <p class="text-muted">Không có bài đăng liên quan.</p>
                    @else
                        @foreach ($relatedPosts as $relatedPost)
                            <div class="card related-post-card mb-3">
                                @if ($relatedPost->require_login)
                                    <div class="position-absolute top-0 end-0 p-2">
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-lock"></i>
                                        </span>
                                    </div>
                                @endif

                                @if ($relatedPost->image)
                                    <img src="{{ asset($relatedPost->image) }}" class="card-img-top related-post-image"
                                        alt="{{ $relatedPost->name }}">
                                @else
                                    <div
                                        class="bg-light related-post-image d-flex align-items-center justify-content-center">
                                        <i class="fas fa-file-alt text-muted fa-2x"></i>
                                    </div>
                                @endif
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <a href="{{ route('home.posts.show', $relatedPost->slug) }}"
                                            class="text-decoration-none text-dark stretched-link">
                                            {{ Str::limit($relatedPost->name, 50) }}
                                        </a>
                                    </h6>
                                    <p class="card-text small text-muted mb-0">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $relatedPost->created_at->format('d/m/Y') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Box tìm kiếm -->
                <div class="bg-white p-4 shadow-sm rounded-3 mb-4">
                    <h4 class="border-bottom pb-3 mb-4 fw-bold">Tìm Kiếm</h4>
                    <form action="{{ route('home.posts.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="Tìm bài đăng...">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Box đăng nhập nếu chưa đăng nhập -->
                @guest
                    <div class="bg-white p-4 shadow-sm rounded-3">
                        <h4 class="border-bottom pb-3 mb-4 fw-bold">Đăng Nhập</h4>
                        <p>Đăng nhập để xem thêm nhiều bài đăng hơn, bao gồm cả nội dung dành riêng cho thành viên.</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('login.index') }}" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-1"></i> Đăng nhập ngay
                            </a>
                            <a href="{{ route('register.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-user-plus me-1"></i> Đăng ký tài khoản
                            </a>
                        </div>
                    </div>
                @endguest
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function share() {
            if (navigator.share) {
                navigator.share({
                        title: '{{ $post->name }}',
                        url: window.location.href
                    })
                    .catch(console.error);
            } else {
                // Fallback for browsers that don't support Web Share API
                const url = window.location.href;
                const textarea = document.createElement('textarea');
                textarea.value = url;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                alert('Đã sao chép đường dẫn vào clipboard!');
            }
        }
    </script>
@endsection