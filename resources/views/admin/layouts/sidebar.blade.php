<!--begin::Sidebar Wrapper-->
<div class="sidebar-wrapper">
    <nav class="mt-2">
        <!--begin::Sidebar Menu-->
        <ul class="nav sidebar-menu flex-column" role="menu">
            <style>
                /* CSS cho menu */
                .sidebar-menu .nav-item {
                    margin-bottom: 5px;
                }

                .sidebar-menu .nav-link {
                    border-radius: 8px;
                    transition: all 0.3s ease;
                    padding: 0.8rem 1rem;
                }

                .sidebar-menu .nav-link:hover {
                    background-color: rgba(255, 255, 255, 0.1);
                }

                .sidebar-menu .nav-link.active {
                    background-color: rgba(255, 255, 255, 0.2);
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                }

                .sidebar-menu .nav-icon {
                    margin-right: 10px;
                }

                .nav-badge {
                    float: right;
                    margin-top: 3px;
                }
            </style>

            {{-- Tổng quan --}}
            @can('access_dashboard')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ isActive('admin.dashboard') }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Tổng quan</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý tài khoản --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ isActive('admin.users.*') }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Quản lý tài khoản</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý vai trò --}}
            @can('access_roles')
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}" class="nav-link {{ isActive('admin.roles.*') }}">
                        <i class="nav-icon bi bi-person-badge-fill"></i>
                        <p>Quản lý vai trò</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý quyền --}}
            @can('access_permissions')
                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}" class="nav-link {{ isActive('admin.permissions.*') }}">
                        <i class="nav-icon bi bi-shield-lock-fill"></i>
                        <p>Quản lý quyền</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý slide --}}
            @can('access_slides')
                <li class="nav-item">
                    <a href="{{ route('admin.slides.index') }}" class="nav-link {{ isActive('admin.slides.*') }}">
                        <i class="nav-icon bi bi-sliders"></i>
                        <p>Quản lý slide</p>
                    </a>
                </li>
            @endcan

            {{-- Cấu hình banner trang chủ --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.home-banner.edit') }}" class="nav-link {{ isActive('admin.home-banner.*') }}">
                        <i class="nav-icon bi bi-image"></i>
                        <p>Banner trang chủ</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý danh mục tin tức --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.post-categories.index') }}"
                        class="nav-link {{ isActive('admin.post-categories.*') }}">
                        <i class="nav-icon bi bi-folder"></i>
                        <p>Danh mục tin tức</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý tin tức --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.posts.index') }}" class="nav-link {{ isActive('admin.posts.*') }}">
                        <i class="nav-icon bi bi-newspaper"></i>
                        <p>Quản lý tin tức</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý tags --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.post-tags.index') }}" class="nav-link {{ isActive('admin.post-tags.*') }}">
                        <i class="nav-icon bi bi-tags"></i>
                        <p>Quản lý tags</p>
                    </a>
                </li>
            @endcan

            {{-- ===== DRIVER SERVICES SECTION ===== --}}
            {{-- Quản lý dịch vụ lái xe --}}
            @can('access_driver_services')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.services.index') }}"
                        class="nav-link {{ isActive('admin.driver.services.*') }}">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>Quản lý dịch vụ</p>
                    </a>
                </li>
            @endcan




            {{-- Quản lý quy tắc giá --}}
            @can('access_driver_services')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.pricing-rules.index') }}"
                        class="nav-link {{ isActive('admin.driver.pricing-rules.*') }}">
                        <i class="nav-icon bi bi-calculator"></i>
                        <p>Quy tắc giá</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý khoảng cách --}}
            @can('access_driver_services')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.distance-tiers.index') }}"
                        class="nav-link {{ isActive('admin.driver.distance-tiers.*') }}">
                        <i class="nav-icon fa fa-route"></i>
                        <p>Khoảng cách</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý giá theo khoảng cách --}}
            @can('access_driver_services')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.pricing-tiers.index') }}"
                        class="nav-link {{ isActive('admin.driver.pricing-tiers.*') }}">
                        <i class="nav-icon bi bi-graph-up"></i>
                        <p>Giá theo khoảng cách</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý testimonials --}}
            @can('access_driver_testimonials')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.testimonials.index') }}"
                        class="nav-link {{ isActive('admin.driver.testimonials.*') }}">
                        <i class="nav-icon bi bi-chat-quote"></i>
                        <p>Đánh giá khách hàng</p>
                    </a>
                </li>
            @endcan

            {{-- Quản lý liên hệ lái xe --}}
            @can('access_driver_contacts')
                <li class="nav-item">
                    <a href="{{ route('admin.driver.contacts.index') }}"
                        class="nav-link {{ isActive('admin.driver.contacts.*') }}">
                        <i class="nav-icon bi bi-envelope"></i>
                        <p>Liên hệ lái xe</p>
                    </a>
                </li>
            @endcan

            {{-- ===== END DRIVER SERVICES SECTION ===== --}}

            {{-- Quản lý thông tin liên hệ --}}
            @can('access_users')
                <li class="nav-item">
                    <a href="{{ route('admin.contact-info.index') }}"
                        class="nav-link {{ isActive('admin.contact-info.*') }}">
                        <i class="nav-icon bi bi-telephone-fill"></i>
                        <p>Thông tin liên hệ</p>
                    </a>
                </li>
            @endcan

        </ul>
        <!--end::Sidebar Menu-->
    </nav>
</div>
<!--end::Sidebar Wrapper-->

<script>
    // Script khẩn cấp để sửa menu
    document.addEventListener('DOMContentLoaded', function() {
        // Xử lý menu đã mở
        var openMenuItems = document.querySelectorAll('.sidebar-menu .nav-item.menu-open');
        openMenuItems.forEach(function(item) {
            var treeview = item.querySelector('.nav-treeview');
            if (treeview) {
                treeview.style.display = 'block';
            }
        });

        // Xử lý sự kiện click trên menu
        document.querySelectorAll('.sidebar-menu .nav-item > a').forEach(function(menuLink) {
            if (menuLink.nextElementSibling && menuLink.nextElementSibling.classList.contains(
                    'nav-treeview')) {
                menuLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var navItem = this.parentNode;
                    var treeview = this.nextElementSibling;

                    if (navItem.classList.contains('menu-open')) {
                        navItem.classList.remove('menu-open');
                        treeview.style.display = 'none';
                    } else {
                        navItem.classList.add('menu-open');
                        treeview.style.display = 'block';
                    }

                    return false;
                });
            }
        });
    });
</script>
