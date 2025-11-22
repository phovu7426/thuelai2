<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title', 'Dịch vụ lái xe thuê') - Phục vụ 24/7</title>
    
    <!-- Force favicon refresh -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    
    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/favicon-48x48.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/apple-touch-icon.png') }}">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="Bạn uống tôi lái - Dịch vụ lái xe hộ khi say rượu bia 24/7 tại Hà Nội. Tài xế chuyên nghiệp, có mặt trong 15 phút, an toàn tuyệt đối. Hotline: 0398982112"/>
    <meta name="keywords" content="bạn uống tôi lái, lái xe hộ hà nội, dịch vụ lái xe khi say, tài xế hộ uy tín, lái xe thuê, dịch vụ lái xe, laixeho, lái xe theo giờ, lái xe theo chuyến, lái xe doanh nghiệp, lái xe sự kiện, lái xe du lịch"/>
    <meta name="robots" content="index, follow"/>
    <meta name="language" content="Vietnamese"/>
    <meta name="revisit-after" content="7 days"/>
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="@yield('page_title', 'Dịch vụ lái xe thuê') - Phục vụ 24/7"/>
    <meta property="og:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam. Cam kết mang đến trải nghiệm dịch vụ tốt nhất cho khách hàng."/>
    <meta property="og:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="laixeho.net.vn"/>
    
    <!-- Google Site Verification -->
    <meta name="google-site-verification" content="your-google-verification-code">
    
    <!-- Additional Favicon Meta Tags -->
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('images/favicon-32x32.png') }}">
    <meta name="theme-color" content="#ffffff">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="@yield('page_title', 'Dịch vụ lái xe thuê') - Phục vụ 24/7"/>
    <meta name="twitter:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam."/>
    <meta name="twitter:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('fontawesome-free-6.5.1-web/css/all.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('css/driver.css') }}" rel="stylesheet">

    @stack('styles')
    
    <!-- FAQ Schema Markup -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "FAQPage",
        "mainEntity": [
            {
                "@type": "Question",
                "name": "Bạn uống tôi lái",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Nhậu xong không phải lo về nhà! Chúng tôi có dịch vụ lái xe hộ khi say rượu bia 24/7. Tài xế chuyên nghiệp sẽ đến đón bạn trong vòng 15 phút, đảm bảo an toàn tuyệt đối. Gọi ngay: 0398982112"
                }
            },
            {
                "@type": "Question",
                "name": "Lái xe hộ Hà Nội",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Dịch vụ lái xe hộ uy tín số 1 Hà Nội! Đội ngũ tài xế giàu kinh nghiệm, phương tiện hiện đại, phục vụ tận tâm. Cam kết giá cả hợp lý và an toàn tuyệt đối. Hotline: 0398982112"
                }
            },
            {
                "@type": "Question",
                "name": "Dịch vụ lái xe khi say",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Say rồi đừng tự lái! Chúng tôi đến trong 15 phút, lái xe hộ an toàn tận nơi. Dịch vụ 24/7, giá cả phải chăng, tài xế chuyên nghiệp. Liên hệ: 0398982112"
                }
            },
            {
                "@type": "Question",
                "name": "Gọi 0398982112",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Hotline 24/7: 0398982112. Đặt xe ngay lập tức, Tài xế chuyên nghiệp, Có mặt trong 15 phút, Giá cả hợp lý, An toàn tuyệt đối"
                }
            }
        ]
    }
    </script>
</head>

<body>
    <!-- Modern Header -->
    <header class="modern-header">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand" href="{{ route('driver.home') }}">
                    <div class="brand-logo">
                        <img src="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}" alt="Logo" class="logo-image">
                        <span>laixeho.net.vn</span>
                    </div>
                </a>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.home') }}">
                                <i class="fas fa-home"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.services') }}">
                                <i class="fas fa-cogs"></i>
                                <span>Dịch vụ</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.pricing') }}">
                                <i class="fas fa-tags"></i>
                                <span>Bảng giá</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.news') }}">
                                <i class="fas fa-newspaper"></i>
                                <span>Tin tức</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.about') }}">
                                <i class="fas fa-info-circle"></i>
                                <span>Giới thiệu</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('driver.contact') }}">
                                <i class="fas fa-phone"></i>
                                <span>Liên hệ</span>
                            </a>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle user-menu" href="#" role="button"
                                    data-bs-toggle="dropdown">
                                    <div class="user-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span>{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu modern-dropdown">

                                    <li>
                                        <a class="dropdown-item" href="{{ route('dashboard') }}">
                                            <i class="fas fa-tachometer-alt"></i>
                                            <span>Quản lý</span>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i>
                                                <span>Đăng xuất</span>
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link login-btn" href="{{ route('login.index') }}">
                                    <i class="fas fa-sign-in-alt"></i>
                                    <span>Đăng nhập</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Floating Social Icons -->
    <div class="floating-social-container">
        {{-- Zalo --}}
        @if ($contactPhone)
            <div class="floating-social-item" id="zaloBtn">
                <div class="social-icon zalo">
                    <i class="fas fa-comments"></i>
                </div>
                <span class="social-label">Zalo</span>
            </div>
        @endif

        {{-- Facebook --}}
        @if (!empty($globalSocialLinks['facebook'] ?? ''))
            <div class="floating-social-item" id="facebookBtn">
                <div class="social-icon facebook">
                    <i class="fab fa-facebook-f"></i>
                </div>
                <span class="social-label">Facebook</span>
            </div>
        @endif

        {{-- Hotline --}}
        @if ($contactPhone)
            <div class="floating-social-item" id="phoneBtn">
                <div class="social-icon phone">
                    <i class="fas fa-phone-alt"></i>
                </div>
                <span class="social-label">Hotline</span>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Modern Footer -->
    <footer class="modern-footer">
        <div class="footer-waves">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="currentColor" fill-opacity="1"
                    d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <div class="footer-content">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-section">
                        <div class="footer-brand">
                            <div class="brand-logo">
                                <img src="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}" alt="Logo" class="logo-image">
                                <span>laixeho.net.vn</span>
                            </div>
                            <p>Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam. Cam kết mang đến
                                trải nghiệm dịch vụ tốt nhất cho khách hàng.</p>
                            @if (!empty($globalSocialLinks))
                                <div class="social-links">
                                    @foreach ($globalSocialLinks as $key => $social)
                                        <a href="{{ $social['url'] }}" target="_blank" class="social-link"
                                            title="{{ $social['name'] }}">
                                            @if ($key == 'facebook')
                                                <i class="fab fa-facebook-f"></i>
                                            @elseif($key == 'youtube')
                                                <i class="fab fa-youtube"></i>
                                            @elseif($key == 'instagram')
                                                <i class="fab fa-instagram"></i>
                                            @elseif($key == 'linkedin')
                                                <i class="fab fa-linkedin"></i>
                                            @endif
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="footer-section">
                        <h4>Dịch vụ</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('driver.services') }}">Lái xe theo giờ</a></li>
                            <li><a href="{{ route('driver.services') }}">Lái xe theo chuyến</a></li>
                            <li><a href="{{ route('driver.services') }}">Lái xe doanh nghiệp</a></li>
                            <li><a href="{{ route('driver.services') }}">Lái xe sự kiện</a></li>
                            <li><a href="{{ route('driver.services') }}">Lái xe du lịch</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Hỗ trợ</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('driver.contact') }}">Liên hệ</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Hướng dẫn</a></li>
                            <li><a href="#">Chính sách</a></li>
                            <li><a href="#">Điều khoản</a></li>
                        </ul>
                    </div>

                    <div class="footer-section">
                        <h4>Liên hệ</h4>
                        <div class="contact-info">
                            @if ($contactPhone)
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">Hotline</span>
                                        <span class="contact-value">{{ $contactPhone }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($contactEmail)
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">Email</span>
                                        <span class="contact-value">{{ $contactEmail }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($contactAddress)
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">Địa chỉ</span>
                                        <span class="contact-value">{{ $contactAddress }}</span>
                                    </div>
                                </div>
                            @endif

                            @if ($contactWorkingTime)
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div class="contact-details">
                                        <span class="contact-label">Thời gian</span>
                                        <span class="contact-value">{{ $contactWorkingTime }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="footer-bottom">
                    <div class="footer-bottom-content">
                        <div class="copyright">
                            <p>&copy; {{ date('Y') }} <strong>laixeho.net.vn</strong>. Tất cả quyền được bảo lưu.</p>
                        </div>
                        <div class="footer-actions">
                            <a href="#" class="footer-action-link">Chính sách bảo mật</a>
                            <a href="#" class="footer-action-link">Điều khoản sử dụng</a>
                            <a href="#" class="footer-action-link">Sitemap</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

    <!-- Contact Data for JavaScript -->
    <script>
        window.contactData = {
            phone: @json($contactPhone ?? ''),
            email: @json($contactEmail ?? ''),
            socialLinks: @json($globalSocialLinks ?? [])
        };
    </script>

    <!-- Custom JS -->
    <script src="{{ asset('js/driver.js') }}"></script>

    <!-- Social Media Functions -->
    <script>
        // Function to open phone call
        function openPhone() {
            const phoneNumber = window.contactData?.phone || "{{ $contactPhone ?? '' }}";
            if (phoneNumber) {
                const cleanPhone = phoneNumber.replace(/[^0-9]/g, '');
                window.location.href = `tel:${cleanPhone}`;
            }
        }

        // Function to open Zalo
        function openZalo() {
            const phoneNumber = window.contactData?.phone || "{{ $contactPhone ?? '' }}";
            if (phoneNumber) {
                const cleanPhone = phoneNumber.replace(/[^0-9]/g, '');
                // Try to open Zalo app first, fallback to web
                const zaloUrl = `https://zalo.me/${cleanPhone}`;
                window.open(zaloUrl, '_blank');
            }
        }

        // Function to open Facebook
        function openFacebook() {
            const facebookUrl = window.contactData?.socialLinks?.facebook || {!! json_encode($globalSocialLinks['facebook'] ?? '') !!};

            if (facebookUrl && facebookUrl !== '#') {
                // Try to open Facebook app first, fallback to web
                const appUrl = facebookUrl.replace('https://www.facebook.com/', 'fb://profile/');
                const webUrl = facebookUrl;
                
                // Try app first, then web
                window.location.href = appUrl;
                setTimeout(() => {
                    window.location.href = webUrl;
                }, 1000);
            }
        }
    </script>

    <!-- Zalo SDK -->
    <script>
        // Zalo SDK Configuration
        window.ZaloSocialSDK = window.ZaloSocialSDK || {};
        window.ZaloSocialSDK.config = {
            appId: "your-zalo-app-id", // Thay bằng App ID thực tế từ Zalo Developer
            version: "v2.0"
        };

        // Load Zalo SDK
        (function(d, s, id) {
            var js, zjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "https://sp.zalo.me/plugins/sdk.js";
            zjs.parentNode.insertBefore(js, zjs);
        }(document, 'script', 'zalo-jssdk'));
    </script>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-17536899209">
    </script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-17536899209');
    </script>

    @yield('scripts')
    @stack('scripts')
</body>

</html>
