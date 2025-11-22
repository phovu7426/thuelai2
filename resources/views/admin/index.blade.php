<!doctype html>
<html lang="en">
<!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>AdminLTE v4 | Dashboard</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta name="description" content="Cơ sở sản xuất đá ốp lát DN">
    <meta name="keywords"
        content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    
    <!-- Đảm bảo jQuery đã sẵn sàng -->
    <script>
        // Kiểm tra jQuery đã load
        if (typeof jQuery === 'undefined') {
            console.error('jQuery failed to load');
        } else {
            console.log('jQuery loaded successfully, version:', jQuery.fn.jquery);
            // Đặt biến global để các script khác có thể sử dụng
            window.jQuery = jQuery;
            window.$ = jQuery;
        }
    </script>

    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="{{ asset('vendor/overlayscrollbars/overlayscrollbars.min.css') }}">
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.min.css') }}">
    <!-- Fallback: Sử dụng Font Awesome nếu Bootstrap Icons không load được -->
    <script>
        // Kiểm tra nếu Bootstrap Icons không load được thì sử dụng Font Awesome
        document.addEventListener('DOMContentLoaded', function() {
            const testIcon = document.createElement('i');
            testIcon.className = 'bi bi-check';
            testIcon.style.display = 'none';
            document.body.appendChild(testIcon);
            
            const computedStyle = window.getComputedStyle(testIcon, '::before');
            if (!computedStyle.content || computedStyle.content === 'none') {
                // Bootstrap Icons không load được, thay thế bằng Font Awesome
                const style = document.createElement('style');
                style.textContent = `
                    .bi::before { font-family: "Font Awesome 6 Free"; font-weight: 900; }
                    .bi-check::before { content: "\\f00c"; }
                    .bi-x::before { content: "\\f00d"; }
                    .bi-plus::before { content: "\\f067"; }
                    .bi-pencil::before { content: "\\f303"; }
                    .bi-trash::before { content: "\\f1f8"; }
                    .bi-eye::before { content: "\\f06e"; }
                    .bi-people-fill::before { content: "\\f0c0"; }
                    .bi-gem::before { content: "\\f3a5"; }
                    .bi-building::before { content: "\\f1ad"; }
                    .bi-file-earmark-text::before { content: "\\f35d"; }
                    .bi-search::before { content: "\\f002"; }
                    .bi-arrow-clockwise::before { content: "\\f021"; }
                    .bi-plus-circle::before { content: "\\f055"; }
                    .bi-star-fill::before { content: "\\f005"; }
                    .bi-star::before { content: "\\f006"; }
                    .bi-person::before { content: "\\f007"; }
                    .bi-image::before { content: "\\f03e"; }
                    .bi-gear::before { content: "\\f013"; }
                    .bi-chat-quote::before { content: "\\f27d"; }
                    .bi-envelope-open::before { content: "\\f2b6"; }
                `;
                document.head.appendChild(style);
            }
            document.body.removeChild(testIcon);
        });
    </script>
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}" />
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link rel="stylesheet" href="{{ asset('vendor/apexcharts/apexcharts.min.css') }}">
    <!-- jsvectormap -->
    <link rel="stylesheet" href="{{ asset('vendor/jsvectormap/jsvectormap.min.css') }}">
    <link href="{{ asset('fontawesome-free-6.5.1-web/css/all.min.css') }}" rel="stylesheet">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- Thêm CSS cho Select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <!-- CSS cho nút toggle đẹp mắt -->
    <link href="{{ asset('css/admin-toggle-buttons.css') }}" rel="stylesheet" />
    <!-- CSS hiện đại cho admin panel -->
    <link href="{{ asset('css/admin-modern.css') }}" rel="stylesheet" />
    <!-- Universal Modal CSS -->
    <link href="{{ asset('css/admin/universal-modal.css') }}" rel="stylesheet" />
    
    <!-- Admin Dropdowns Component -->
    <script src="{{ asset('js/admin-dropdowns.js') }}" defer></script>
    
    <!-- Universal Modal Component -->
    <script src="{{ asset('js/admin/universal-modal.js') }}" defer></script>
    
    <!-- CKEditor 5 đã được load từ layout -->
    @yield('styles')
</head>
<!--end::Head-->
<!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    @extends('admin.layouts.main')

    @section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Thống kê chung</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-primary">
                                            <i class="bi bi-people-fill"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Người dùng</span>
                                            <span class="info-box-number">{{ \App\Models\User::count() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-success">
                                            <i class="bi bi-gem"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Dịch vụ lái xe</span>
                                            <span class="info-box-number">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-warning">
                                            <i class="bi bi-building"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Đơn hàng lái xe</span>
                                            <span class="info-box-number">0</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 col-12">
                                    <div class="info-box">
                                        <span class="info-box-icon bg-info">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </span>
                                        <div class="info-box-content">
                                            <span class="info-box-text">Bài viết</span>
                                            <span class="info-box-number">{{ \App\Models\Post::count() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Hoạt động gần đây</h3>
                        </div>
                        <div class="card-body">
                            <div class="timeline">
                                <div class="timeline-item">
                                    <div class="timeline-time">2 phút trước</div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <strong>Admin</strong> đã thêm dịch vụ lái xe mới
                                        </div>
                                        <div class="timeline-body">
                                            Dịch vụ lái xe gia đình
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-time">1 giờ trước</div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <strong>Admin</strong> đã cập nhật thông tin đơn hàng
                                        </div>
                                        <div class="timeline-body">
                                            Đơn hàng lái xe công ty
                                        </div>
                                    </div>
                                </div>
                                <div class="timeline-item">
                                    <div class="timeline-time">Hôm qua</div>
                                    <div class="timeline-content">
                                        <div class="timeline-header">
                                            <strong>Admin</strong> đã thêm dịch vụ mới
                                        </div>
                                        <div class="timeline-body">
                                            Dịch vụ lái xe du lịch
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
    <!--begin::Script-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/overlayscrollbars/overlayscrollbars.browser.es6.min.js') }}"></script>
    <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="{{ asset('vendor/popperjs/popper.min.js') }}"></script>
    <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="{{ asset('vendor/bootstrap/bootstrap.min.js') }}"></script>
    <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
    <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script>
        const Default = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarWrapper = document.querySelector('.sidebar-wrapper');
            if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }
        });
    </script>
    {{-- @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif

    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif --}}
    @yield('scripts')
    <!--end::OverlayScrollbars Configure-->
    <!-- OPTIONAL SCRIPTS -->


    <!--end::Script-->
</body>
<!--end::Body-->

</html>
