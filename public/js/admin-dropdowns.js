/**
 * Admin Dropdowns Component
 * Xử lý dropdown select cho trạng thái và nổi bật
 */
class AdminDropdowns {
    constructor() {
        this.init();
    }

    init() {
        this.initStatusDropdowns();
        this.initFeaturedDropdowns();
    }

    /**
     * Khởi tạo dropdown trạng thái
     */
    initStatusDropdowns() {
        const statusSelects = document.querySelectorAll('.status-select');
        
        statusSelects.forEach(select => {
            select.addEventListener('change', (e) => this.handleStatusChange(e));
        });
    }

    /**
     * Khởi tạo dropdown nổi bật
     */
    initFeaturedDropdowns() {
        const featuredSelects = document.querySelectorAll('.featured-select');
        
        featuredSelects.forEach(select => {
            select.addEventListener('change', (e) => this.handleFeaturedChange(e));
        });
    }

    /**
     * Xử lý thay đổi trạng thái
     */
    handleStatusChange(event) {
        const select = event.target;
        
        const itemId = select.dataset.itemId || select.dataset.userId || select.dataset.postId || 
                       select.dataset.categoryId || select.dataset.tagId || select.dataset.slideId || 
                       select.dataset.testimonialId || select.dataset.contactId || select.dataset.serviceId;
        const newStatus = select.value;
        const currentStatus = select.dataset.currentStatus;
        const apiEndpoint = select.dataset.statusApi || this.getDefaultStatusApi(select);
        const statusLabels = this.getStatusLabels(select);

        // Nếu trạng thái không thay đổi thì không làm gì
        if (newStatus === currentStatus) {
            return;
        }

        this.updateStatus(select, itemId, newStatus, currentStatus, apiEndpoint, statusLabels);
    }

    /**
     * Xử lý thay đổi nổi bật
     */
    handleFeaturedChange(event) {
        const select = event.target;
        const itemId = select.dataset.itemId || select.dataset.userId || select.dataset.postId || 
                       select.dataset.categoryId || select.dataset.tagId || select.dataset.slideId || 
                       select.dataset.testimonialId || select.dataset.contactId || select.dataset.serviceId;
        const newFeatured = select.value;
        const currentFeatured = select.dataset.currentFeatured;
        const apiEndpoint = select.dataset.featuredApi || this.getDefaultFeaturedApi(select);
        const featuredLabels = this.getFeaturedLabels(select);

        // Nếu trạng thái không thay đổi thì không làm gì
        if (newFeatured === currentFeatured) {
            return;
        }

        this.updateFeatured(select, itemId, newFeatured, currentFeatured, apiEndpoint, featuredLabels);
    }

    /**
     * Cập nhật trạng thái
     */
    updateStatus(select, itemId, newStatus, currentStatus, apiEndpoint, statusLabels) {
        // Disable select để tránh thay đổi nhiều lần
        select.disabled = true;

        // Tạo form data
        const formData = new FormData();
        formData.append('_token', this.getCsrfToken());
        formData.append('_method', 'POST');
        formData.append('status', newStatus);

        // Gọi API để cập nhật trạng thái
        fetch(apiEndpoint, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Cập nhật current status
                select.dataset.currentStatus = newStatus;
                
                // Hiển thị thông báo thành công
                const statusText = statusLabels[newStatus] || newStatus;
                this.showNotification('success', `Đã cập nhật trạng thái thành: ${statusText}`);
            } else {
                this.showNotification('error', data.message || 'Có lỗi xảy ra');
                // Khôi phục giá trị cũ
                select.value = currentStatus;
            }
        })
        .catch(error => {
            this.showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái');
            // Khôi phục giá trị cũ
            select.value = currentStatus;
        })
        .finally(() => {
            // Khôi phục select
            select.disabled = false;
        });
    }

    /**
     * Cập nhật nổi bật
     */
    updateFeatured(select, itemId, newFeatured, currentFeatured, apiEndpoint, featuredLabels) {
        // Disable select để tránh thay đổi nhiều lần
        select.disabled = true;

        // Tạo form data
        const formData = new FormData();
        formData.append('_token', this.getCsrfToken());
        formData.append('_method', 'POST');

        // Gọi API để cập nhật trạng thái nổi bật
        fetch(apiEndpoint, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật current featured
                select.dataset.currentFeatured = newFeatured;
                
                // Hiển thị thông báo thành công
                const featuredText = featuredLabels[newFeatured] || newFeatured;
                this.showNotification('success', `Đã cập nhật trạng thái nổi bật thành: ${featuredText}`);
            } else {
                this.showNotification('error', data.message || 'Có lỗi xảy ra');
                // Khôi phục giá trị cũ
                select.value = currentFeatured;
            }
        })
        .catch(error => {
            this.showNotification('error', 'Có lỗi xảy ra khi cập nhật trạng thái nổi bật');
            // Khôi phục giá trị cũ
            select.value = currentFeatured;
        })
        .finally(() => {
            // Khôi phục select
            select.disabled = false;
        });
    }

    /**
     * Lấy API endpoint mặc định cho status
     */
    getDefaultStatusApi(select) {
        const itemId = select.dataset.itemId || select.dataset.userId || select.dataset.postId || 
                       select.dataset.categoryId || select.dataset.tagId || select.dataset.slideId || 
                       select.dataset.testimonialId || select.dataset.contactId || select.dataset.serviceId ||
                       select.dataset.roleId || select.dataset.permissionId || select.dataset.seriesId ||
                       select.dataset.ruleId || select.dataset.tierId;
        
        // Xác định loại item dựa trên dataset
        if (select.dataset.userId) return `/admin/users/${itemId}/toggle-block`;
        if (select.dataset.postId) return `/admin/posts/${itemId}/toggle-status`;
        if (select.dataset.categoryId) return `/admin/post-categories/${itemId}/toggle-status`;
        if (select.dataset.tagId) return `/admin/post-tags/${itemId}/toggle-status`;
        if (select.dataset.slideId) return `/admin/slides/${itemId}/toggle-status`;
        if (select.dataset.testimonialId) return `/admin/driver/testimonials/${itemId}/toggle-status`;
        if (select.dataset.contactId) return `/admin/driver/contacts/${itemId}/toggle-status`;
        if (select.dataset.serviceId) return `/admin/driver/services/${itemId}/toggle-status`;
        if (select.dataset.roleId) return `/admin/roles/${itemId}/toggle-status`;
        if (select.dataset.permissionId) return `/admin/permissions/${itemId}/toggle-status`;
        if (select.dataset.seriesId) return `/admin/series/${itemId}/toggle-status`;
        if (select.dataset.ruleId) return `/admin/driver/pricing-rules/${itemId}/toggle-status`;
        if (select.dataset.tierId) return `/admin/driver/pricing-tiers/${itemId}/toggle-status`;
        
        return `/admin/items/${itemId}/toggle-status`;
    }

    /**
     * Lấy API endpoint mặc định cho featured
     */
    getDefaultFeaturedApi(select) {
        const itemId = select.dataset.itemId || select.dataset.userId || select.dataset.postId || 
                       select.dataset.categoryId || select.dataset.tagId || select.dataset.slideId || 
                       select.dataset.testimonialId || select.dataset.contactId || select.dataset.serviceId ||
                       select.dataset.roleId || select.dataset.permissionId || select.dataset.seriesId ||
                       select.dataset.ruleId || select.dataset.tierId;
        
        // Xác định loại item dựa trên dataset
        if (select.dataset.postId) return `/admin/posts/${itemId}/toggle-featured`;
        if (select.dataset.categoryId) return `/admin/post-categories/${itemId}/toggle-featured`;
        if (select.dataset.tagId) return `/admin/post-tags/${itemId}/toggle-featured`;
        if (select.dataset.slideId) return `/admin/slides/${itemId}/toggle-featured`;
        if (select.dataset.testimonialId) return `/admin/driver/testimonials/${itemId}/toggle-featured`;
        if (select.dataset.serviceId) return `/admin/driver/services/${itemId}/toggle-featured`;
        if (select.dataset.roleId) return `/admin/roles/${itemId}/toggle-featured`;
        if (select.dataset.permissionId) return `/admin/permissions/${itemId}/toggle-featured`;
        if (select.dataset.seriesId) return `/admin/series/${itemId}/toggle-featured`;
        if (select.dataset.ruleId) return `/admin/driver/pricing-rules/${itemId}/toggle-featured`;
        if (select.dataset.tierId) return `/admin/driver/pricing-tiers/${itemId}/toggle-featured`;
        if (select.dataset.contactId) return `/admin/driver/contacts/${itemId}/toggle-featured`;
        
        return `/admin/items/${itemId}/toggle-featured`;
    }

    /**
     * Lấy labels cho status
     */
    getStatusLabels(select) {
        const statusType = select.dataset.statusType || 'default';
        
        const labels = {
            'default': { '0': 'Vô hiệu', '1': 'Kích hoạt' },
            'users': { '0': 'Hoạt động', '1': 'Khóa' },
            'posts': { 'draft': 'Nháp', 'published': 'Xuất bản' },
            'slides': { '0': 'Ẩn', '1': 'Hiển thị' },
            'contacts': { 'unread': 'Chưa đọc', 'read': 'Đã đọc', 'replied': 'Đã trả lời' },
            'services': { 'inactive': 'Không hoạt động', 'active': 'Hoạt động' }
        };

        return labels[statusType] || labels.default;
    }

    /**
     * Lấy labels cho featured
     */
    getFeaturedLabels(select) {
        const featuredType = select.dataset.featuredType || 'default';
        
        const labels = {
            'default': { '0': 'Bình thường', '1': 'Nổi bật' },
            'posts': { '0': 'Bình thường', '1': 'Nổi bật' },
            'slides': { '0': 'Không nổi bật', '1': 'Nổi bật' },
            'testimonials': { '0': 'Bình thường', '1': 'Nổi bật' },
            'services': { 'inactive': 'Không nổi bật', 'active': 'Nổi bật' }
        };

        return labels[featuredType] || labels.default;
    }

    /**
     * Lấy CSRF token
     */
    getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    /**
     * Hiển thị thông báo
     */
    showNotification(type, message) {
        // Tạo toast notification
        const toast = document.createElement('div');
        toast.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        toast.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(toast);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 3000);
    }
}

// Khởi tạo component khi DOM ready
document.addEventListener('DOMContentLoaded', function() {
    window.adminDropdowns = new AdminDropdowns();
});
