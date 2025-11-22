<!doctype html>
<html lang="en">
<!--begin::Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
   <title>Cơ sở sản xuất đá ốp lát DN - @yield('title', 'Đá tự nhiên cao cấp')</title>
    <!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="title" content="Quản trị hệ thống - laixeho.net.vn"/>
    <meta name="author" content="laixeho.net.vn"/>
    
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
    <meta property="og:title" content="Dịch vụ lái xe thuê chuyên nghiệp - laixeho.net.vn"/>
    <meta property="og:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam. Cam kết mang đến trải nghiệm dịch vụ tốt nhất cho khách hàng."/>
    <meta property="og:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>
    <meta property="og:url" content="{{ url()->current() }}"/>
    <meta property="og:type" content="website"/>
    <meta property="og:site_name" content="laixeho.net.vn"/>
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:title" content="Dịch vụ lái xe thuê chuyên nghiệp - laixeho.net.vn"/>
    <meta name="twitter:description" content="Dịch vụ lái xe thuê chuyên nghiệp, an toàn và uy tín hàng đầu Việt Nam."/>
    <meta name="twitter:image" content="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- jQuery -->
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>

    <!--end::Primary Meta Tags-->
    <!--begin::Fonts-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
        crossorigin="anonymous"
    />
    <!--end::Fonts-->
    <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(OverlayScrollbars)-->
    <!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        crossorigin="anonymous"
    />
    <!--end::Third Party Plugin(Bootstrap Icons)-->
    <!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="{{ asset('adminlte/css/adminlte.css') }}"/>
    <!--end::Required Plugin(AdminLTE)-->
    <!-- apexcharts -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css"
        crossorigin="anonymous"
    />
    <!-- jsvectormap -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css"
        crossorigin="anonymous"
    />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
    <!-- Thêm CSS cho Select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
    <!-- CKEditor 5 super-build (free, nhiều tính năng) -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/super-build/ckeditor.js"></script>
    <style>
        .ck-editor__editable { min-height: 200px; }
    </style>
    <script>
        // Shim CKEditor 4 -> 5 (super-build) để không cần sửa từng view
        (function() {
            var CK5 = (window.CKEDITOR && window.CKEDITOR.ClassicEditor) ? window.CKEDITOR.ClassicEditor : (window.ClassicEditor || null);
            if (!CK5) return;
            window.CKEDITOR = window.CKEDITOR || {};
            window.CKEDITOR.replace = function(elementId, cfg) {
                var el = document.getElementById(elementId);
                if (!el) return;
                var uploadUrl = (cfg && (cfg.uploadUrl || cfg.filebrowserUploadUrl)) || ('/upload?_token=' + (document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''));
                var language = (cfg && cfg.language) || 'vi';
                CK5.create(el, {
                    language: language,
                    licenseKey: 'GPL',
                    toolbar: {
                        items: [
                            'heading','|','bold','italic','underline','strikethrough','subscript','superscript',
                            'fontSize','fontFamily','fontColor','fontBackgroundColor','highlight','|',
                            'alignment','bulletedList','numberedList','todoList','outdent','indent','|',
                            'link','blockQuote','code','codeBlock','insertTable','mediaEmbed','horizontalLine','specialCharacters','|',
                            'findAndReplace','selectAll','undo','redo','removeFormat','|','imageUpload'
                        ]
                    },
                    ckfinder: { uploadUrl: uploadUrl },
                    image: {
                        toolbar: ['imageStyle:inline','imageStyle:block','imageStyle:side','|','resizeImage','toggleImageCaption','imageTextAlternative','linkImage'],
                        styles: ['inline','block','side']
                    },
                    table: { contentToolbar: ['tableColumn','tableRow','mergeTableCells','tableProperties','tableCellProperties'] },
                    removePlugins: [
                        // Premium/collaboration & cloud
                        'ExportPdf','ExportWord','RealTimeCollaborativeComments','RealTimeCollaborativeTrackChanges',
                        'RealTimeCollaborativeRevisionHistory','PresenceList','Comments','TrackChanges','TrackChangesData',
                        'RevisionHistory','Pagination','WProofreader','CKBox','CKFinder','EasyImage',
                        // Additional premium features
                        'MathType','TextPartLanguage','SlashCommand','Template','DocumentOutline','FormatPainter',
                        'TableOfContents','PasteFromOfficeEnhanced','CaseChange','MultiLevelList',
                        // AI variants
                        'AiAssistant','AIAssistant','AI','Ai','ai'
                    ]
                }).then(function(editor){
                    (window._ck5Editors = window._ck5Editors || {})[elementId] = editor;
                }).catch(function(e){ console.error('CKEditor5 init error:', e); });
            };
        })();
        // Bảo đảm mọi form upload (kể cả luồng cũ) luôn gửi _token thay vì ckCsrfToken
        (function(){
            document.addEventListener('submit', function(ev){
                var form = ev.target;
                try {
                    if (!form || form.tagName !== 'FORM') return;
                    if (form.enctype !== 'multipart/form-data') return;
                    if (!form.querySelector('input[type="file"][name="upload"]')) return;
                    var csrf = document.querySelector('meta[name="csrf-token"]');
                    if (csrf) {
                        var tokenInput = form.querySelector('input[name="_token"]');
                        if (!tokenInput) {
                            tokenInput = document.createElement('input');
                            tokenInput.type = 'hidden';
                            tokenInput.name = '_token';
                            form.appendChild(tokenInput);
                        }
                        tokenInput.value = csrf.getAttribute('content');
                    }
                    var ck = form.querySelector('input[name="ckCsrfToken"]');
                    if (ck) ck.remove();
                } catch(e) {}
            }, true);
        })();
    </script>
    
    <style>
        /* CSS để sửa hiển thị menu sidebar */
        .sidebar-menu .nav-item > ul.nav-treeview {
            display: none; /* Ẩn tất cả submenu mặc định */
            height: auto !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
        
        .sidebar-menu .nav-item.menu-open > ul.nav-treeview {
            display: block !important; /* Hiển thị submenu khi có class menu-open */
        }
        
        .sidebar-menu .nav-arrow {
            transition: transform 0.3s;
        }
        
        .sidebar-menu .nav-item.menu-open > a .nav-arrow {
            transform: rotate(90deg); /* Xoay mũi tên khi menu được mở */
        }

        /* CSS cho brand logo admin */
        .brand-link {
            display: flex !important;
            align-items: center !important;
            gap: 0.75rem !important;
            padding: 0.75rem 1rem !important;
            text-decoration: none !important;
            transition: all 0.3s ease !important;
        }

        .brand-link:hover {
            background: rgba(99, 102, 241, 0.1) !important;
            border-radius: 8px !important;
            transform: translateX(2px) !important;
        }

        .brand-image {
            width: 40px !important;
            height: 40px !important;
            object-fit: contain !important;
            border-radius: 0 !important;
            transition: all 0.3s ease !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .brand-link:hover .brand-image {
            transform: scale(1.05) !important;
            background: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }

        .brand-link span {
            font-size: 1.1rem !important;
            font-weight: 700 !important;
            color: #6366f1 !important;
            letter-spacing: 0.5px !important;
            transition: all 0.3s ease !important;
        }

        .brand-link:hover span {
            color: #4f46e5 !important;
            transform: translateX(2px) !important;
        }

        /* Responsive cho mobile */
        @media (max-width: 768px) {
            .brand-image {
                width: 35px !important;
                height: 35px !important;
            }
            
            .brand-link span {
                font-size: 1rem !important;
            }
        }
    </style>
    
    @yield('styles')
</head>
<!--end::Head-->
<!--begin::Body-->
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
<!--begin::App Wrapper-->
<div class="app-wrapper">
    @include('admin.layouts.header')
    <!--begin::Sidebar-->
    <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="light">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
            <!--begin::Brand Link-->
            <a href="{{ route('admin.index') }}" class="brand-link">
                <!--begin::Brand Image-->
                <img
                    src="{{ asset('images/z6992695110735_2867de0ed574f13edb943a926dfd9159.jpg') }}"
                    class="brand-image"
                />
                <span>laixeho.net.vn</span>
            </a>
            <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        @include('admin.layouts.sidebar')
    </aside>
    <!--end::Sidebar-->
    <!--begin::App Main-->
    <main class="app-main">
        @include('admin.layouts.pathway')
        <!--begin::App Content-->
        @yield('content')
        <!--end::App Content-->
    </main>
    <!--end::App Main-->
    @include('admin.layouts.footer')
</div>
<!--end::App Wrapper-->

<!--begin::Script-->
<!--begin::Third Party Plugin(OverlayScrollbars)-->
<script src="{{ asset('js/toastr.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/browser/overlayscrollbars.browser.es6.min.js"
    crossorigin="anonymous"
></script>
<!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
    crossorigin="anonymous"
></script>
<!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
<script src="{{ asset('adminlte/js/adminlte.js') }}"></script>
<!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
<script>
    if (typeof SELECTOR_SIDEBAR_WRAPPER === 'undefined') {
        var SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
    }
    if (typeof SidebarScrollDefault === 'undefined') {
        var SidebarScrollDefault = {
            scrollbarTheme: 'os-theme-light',
            scrollbarAutoHide: 'leave',
            scrollbarClickScroll: true,
        };
    }
    document.addEventListener('DOMContentLoaded', function () {
        const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
        if (sidebarWrapper && typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== 'undefined') {
            OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                scrollbars: {
                    theme: SidebarScrollDefault.scrollbarTheme,
                    autoHide: SidebarScrollDefault.scrollbarAutoHide,
                    clickScroll: SidebarScrollDefault.scrollbarClickScroll,
                },
            });
        }
    });
</script>
<!--end::OverlayScrollbars Configure-->

<script>
    $(document).ready(function() {
        @if(session('error'))
            toastr.error("{{ session('error') }}");
        @endif

        @if(session('success'))
            toastr.success("{{ session('success') }}");
        @endif
    });
</script>


<script src="{{ asset('js/admin-custom.js') }}"></script>

<script>
/**
 * Hàm delete - gọi API để xóa dữ liệu
 * @param {string} apiUrl - URL của API endpoint
 * @param {function} successCallback - Callback khi thành công (optional)
 * @param {function} errorCallback - Callback khi có lỗi (optional)
 */
function deleteData(apiUrl, method = 'POST', successCallback = null, errorCallback = null) {
    // Hiển thị confirm dialog
    if (!confirm('Bạn có chắc chắn muốn xóa không?')) {
        return;
    }

    // Hiển thị loading
    toastr.info('Đang xử lý...', '', {timeOut: 0, extendedTimeOut: 0});

    $.ajax({
        url: apiUrl,
        type: method,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        success: function(response) {
            // Ẩn loading
            toastr.clear();
            
            // Hiển thị thông báo thành công
            toastr.success(response.message || 'Xóa thành công!');
            
            // Gọi callback nếu có
            if (successCallback && typeof successCallback === 'function') {
                successCallback(response);
            }
            setTimeout(function() {
                location.reload();
            }, 1000);
        },
        error: function(xhr, status, error) {
            // Ẩn loading
            toastr.clear();
            
            let errorMessage = 'Có lỗi xảy ra khi xóa!';
            
            // Xử lý error message từ server
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseText) {
                try {
                    const errorData = JSON.parse(xhr.responseText);
                    errorMessage = errorData.message || errorMessage;
                } catch (e) {
                    errorMessage = xhr.responseText;
                }
            }
            
            // Hiển thị thông báo lỗi
            toastr.error(errorMessage);
            
            // Gọi callback nếu có
            if (errorCallback && typeof errorCallback === 'function') {
                errorCallback(xhr, status, error);
            }
        }
    });
}
</script>

@yield('scripts')
<!--end::Script-->
</body>
<!--end::Body-->
</html>
