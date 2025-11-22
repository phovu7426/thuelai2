/**
 * Custom JavaScript để ghi đè chức năng AdminLTE liên quan đến menu
 */
$(document).ready(function() {
    // Xử lý menu sidebar
    function initSidebar() {
        // Vô hiệu hóa chức năng Treeview mặc định của AdminLTE
        if (typeof window.adminlte !== 'undefined' && typeof window.adminlte.Treeview !== 'undefined') {
            // Ghi đè phương thức toggle của AdminLTE Treeview
            const originalTreeviewToggle = window.adminlte.Treeview.prototype.toggle;
            window.adminlte.Treeview.prototype.toggle = function() {
                // Không làm gì để vô hiệu hóa chức năng mặc định
                console.log('AdminLTE Treeview toggle đã bị vô hiệu hóa');
                return;
            };
        }

        // Ngăn chặn AdminLTE tự động đóng/mở menu
        $(document).off('click', '.sidebar-menu .nav-item > a').on('click', '.sidebar-menu .nav-item > a', function(e) {
            if ($(this).next('ul.nav-treeview').length > 0) {
                e.preventDefault();
                e.stopPropagation();
                
                const navItem = $(this).parent('.nav-item');
                const treeview = $(this).next('ul.nav-treeview');
                
                // Toggle menu open class
                navItem.toggleClass('menu-open');
                
                // Hiển thị/ẩn submenu với animation
                if (navItem.hasClass('menu-open')) {
                    treeview.show();
                } else {
                    treeview.hide();
                }
                
                return false;
            }
        });
        
        // Đảm bảo menu được mở đúng vị trí hiện tại
        const activeLink = $('.sidebar-menu .nav-link.active');
        activeLink.parents('.nav-item').addClass('menu-open');
        activeLink.parents('ul.nav-treeview').show();
    }
    
    // Khởi tạo sidebar ngay lập tức
    initSidebar();
    
    // Và chạy lại sau khi trang đã tải hoàn toàn để ghi đè mọi khởi tạo từ AdminLTE
    $(window).on('load', function() {
        setTimeout(function() {
            initSidebar();
        }, 100);
    });
}); 