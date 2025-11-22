<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trang Chủ') - laixeho.net.vn</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam. Cam kết mang đến trải nghiệm dịch vụ tốt nhất cho khách hàng."/>
    <meta name="keywords" content="lái xe thuê, dịch vụ lái xe, laixeho, lái xe theo giờ, lái xe theo chuyến, lái xe doanh nghiệp, lái xe sự kiện, lái xe du lịch"/>
    <meta name="robots" content="index, follow"/>
    <meta name="language" content="Vietnamese"/>
    <meta name="revisit-after" content="7 days"/>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('title', 'Trang Chủ') - laixeho.net.vn"/>
    <meta property="og:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam. Cam kết mang đến trải nghiệm dịch vụ tốt nhất cho khách hàng."/>
    <meta property="og:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="laixeho.net.vn"/>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('title', 'Trang Chủ') - laixeho.net.vn"/>
    <meta name="twitter:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam."/>
    <meta name="twitter:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #3f51b5;
            --secondary-color: #f50057;
            --light-bg: #f8f9ff;
            --dark-text: #2c3e50;
            --light-text: #7b8898;
        }

        body {
            font-family: 'Figtree', sans-serif;
            padding-top: 80px;
            background-color: var(--light-bg);
            color: var(--dark-text);
            line-height: 1.6;
        }

        .navbar {
            box-shadow: 0 4px 12px rgba(0, 0, 0, .1);
            background-color: white;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
            letter-spacing: 0.5px;
        }

        .nav-link {
            font-weight: 500;
            position: relative;
        }

        .nav-link.active:after {
            content: '';
            position: absolute;
            width: 80%;
            height: 2px;
            background: var(--primary-color);
            bottom: 0;
            left: 10%;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #303f9f;
            border-color: #303f9f;
        }

        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .post-card {
            height: 100%;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            background-color: white;
        }

        .post-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .post-image {
            height: 220px;
            object-fit: cover;
        }

        .post-card .card-title {
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--dark-text);
        }

        .post-card .card-text {
            color: var(--light-text);
        }

        .post-card .card-footer {
            background-color: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
        }

        .login-required-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            z-index: 10;
            background-color: var(--secondary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .footer {
            background-color: white;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            padding: 3rem 0;
            margin-top: 5rem;
        }

        .footer h5 {
            font-weight: 600;
            margin-bottom: 1.2rem;
            color: var(--primary-color);
        }

        .breadcrumb-item a {
            color: var(--primary-color);
            text-decoration: none;
        }

        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .page-link {
            color: var(--primary-color);
        }

        /* Post content styles */
        .post-content {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .post-content img {
            max-width: 100%;
            height: auto;
            margin: 1.5rem 0;
            border-radius: 8px;
        }

        .post-header-image {
            height: 400px;
            object-fit: cover;
            border-radius: 12px;
            width: 100%;
        }

        .related-post-card {
            border: none;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .related-post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        .related-post-image {
            height: 160px;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .post-header-image {
                height: 250px;
            }
        }
    </style>

    @yield('styles')
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Trang
                            Chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('home/posts*') ? 'active' : '' }}"
                            href="{{ route('home.posts.index') }}">Bài Đăng</a>
                    </li>
                </ul>

                <!-- Tìm kiếm -->
                <form class="d-flex me-3" action="{{ route('home.posts.index') }}" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="search" placeholder="Tìm bài đăng..."
                            aria-label="Search" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>

                <!-- User menu -->
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login.index') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Đăng Nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register.index') }}">
                                <i class="fas fa-user-plus me-1"></i> Đăng Ký
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-1"></i> Bảng Điều Khiển
                                    </a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-1"></i> Đăng Xuất
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h5>{{ config('app.name', 'Laravel') }}</h5>
                    <p class="text-muted">Trang web chia sẻ thông tin và kiến thức hữu ích cho cộng đồng. Mang đến những
                        bài viết chất lượng và đáng tin cậy.</p>
                    <p class="text-muted">© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
                </div>
                <div class="col-md-3">
                    <h5>Liên Kết</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ url('/') }}" class="text-decoration-none text-muted">Trang
                                Chủ</a></li>
                        <li class="mb-2"><a href="{{ route('home.posts.index') }}"
                                class="text-decoration-none text-muted">Bài Đăng</a></li>
                        <li class="mb-2"><a href="{{ route('login.index') }}"
                                class="text-decoration-none text-muted">Đăng Nhập</a></li>
                        <li class="mb-2"><a href="{{ route('register.index') }}"
                                class="text-decoration-none text-muted">Đăng Ký</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Liên Hệ</h5>
                    <ul class="list-unstyled">
                        @if ($contactEmail)
                            <li class="mb-2"><i class="fas fa-envelope me-2"></i> {{ $contactEmail }}</li>
                        @endif
                        @if ($contactPhone)
                            <li class="mb-2"><i class="fas fa-phone me-2"></i> {{ $contactPhone }}</li>
                        @endif
                        @if ($contactAddress)
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $contactAddress }}</li>
                        @endif
                    </ul>
                    @if (!empty($globalSocialLinks))
                        <div class="mt-3">
                            @foreach ($globalSocialLinks as $key => $social)
                                <a href="{{ $social['url'] }}" target="_blank" class="text-decoration-none me-2"
                                    title="{{ $social['name'] }}">
                                    @if ($key == 'facebook')
                                        <i class="fab fa-facebook fa-lg"></i>
                                    @elseif($key == 'instagram')
                                        <i class="fab fa-instagram fa-lg"></i>
                                    @elseif($key == 'youtube')
                                        <i class="fab fa-youtube fa-lg"></i>
                                    @elseif($key == 'linkedin')
                                        <i class="fab fa-linkedin fa-lg"></i>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>
