/**
 * Universal Modal Management
 * Modal component tổng quát có thể tái sử dụng cho tất cả các menu
 */

// Sử dụng IIFE để tránh global scope pollution và khai báo trùng lặp
(function() {
    'use strict';
    
    // Kiểm tra xem class đã được khai báo chưa
    if (typeof window.UniversalModal !== 'undefined') {
        return; // Nếu đã có thì thoát
    }
    
    class UniversalModal {
        constructor(config = {}) {
            this.config = {
                modalId: 'universalModal',
                modalTitle: 'Modal',
                formId: 'universalForm',
                submitBtnId: 'submitBtn',
                createRoute: '',
                updateRoute: '',
                getDataRoute: '',
                successMessage: 'Thao tác thành công',
                errorMessage: 'Có lỗi xảy ra',
                // Load giao diện từ view
                viewPath: '', // Đường dẫn đến file view (ví dụ: 'admin.users.form')
                viewData: {}, // Dữ liệu truyền vào view
                ...config
            };
            
            this.isEditMode = false;
            this.currentId = null;
            
            // Chờ jQuery sẵn sàng trước khi khởi tạo
            this.waitForJQuery();
        }

        // Chờ jQuery sẵn sàng
        waitForJQuery() {
            if (typeof $ !== 'undefined') {
                this.init();
            } else {
                // Nếu jQuery chưa sẵn sàng, chờ DOM ready
                document.addEventListener('DOMContentLoaded', () => {
                    if (typeof $ !== 'undefined') {
                        this.init();
                    } else {
                        // Nếu vẫn chưa có jQuery, chờ thêm một chút
                        setTimeout(() => {
                            if (typeof $ !== 'undefined') {
                                this.init();
                            } else {
                                console.error('jQuery is not loaded after waiting');
                            }
                        }, 100);
                    }
                });
            }
        }

        init() {
            this.bindEvents();
            this.createModal();
        }

        bindEvents() {
            // Đảm bảo jQuery đã sẵn sàng
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded');
                return;
            }
            
            // Xử lý submit form
            $(document).on('submit', `#${this.config.formId}`, (e) => this.handleSubmit(e));
            
            // Xử lý khi modal đóng
            $(document).on('hidden.bs.modal', `#${this.config.modalId}`, () => this.resetForm());
        }

        // Tạo modal HTML
        createModal() {
            // Xóa modal cũ nếu có
            $(`#${this.config.modalId}`).remove();
            
            const modalHtml = `
                <div class="modal fade" id="${this.config.modalId}" tabindex="-1" aria-labelledby="${this.config.modalId}Label" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="${this.config.modalId}Label">
                                    ${this.config.modalTitle}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                            </div>
                            <form id="${this.config.formId}" method="POST">
                                <div class="modal-body" id="${this.config.modalId}Body" style="max-height:70vh; overflow-y:auto;">
                                    <div class="text-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="bi bi-x-circle"></i> Hủy
                                    </button>
                                    <button type="submit" class="btn btn-primary" id="${this.config.submitBtnId}">
                                        <i class="bi bi-check-circle"></i> Lưu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
            
            // Thêm modal vào body
            $('body').append(modalHtml);
        }

        // Load giao diện từ view
        loadView(viewPath, data = {}) {
            const modalBody = $(`#${this.config.modalId}Body`);
            
            // Hiển thị loading
            modalBody.html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>');
            
            $.ajax({
                url: '/admin/load-view',
                type: 'POST',
                data: {
                    view: viewPath,
                    data: JSON.stringify(data),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    if (response.success) {
                        modalBody.html(response.html);
                        // Re-init common UI initializers for dynamically injected content
                        if (typeof window.initializeSelect2 === 'function') {
                            window.initializeSelect2();
                        }
                    } else {
                        modalBody.html('<div class="alert alert-danger">Không thể tải giao diện</div>');
                    }
                },
                error: () => {
                    modalBody.html('<div class="alert alert-danger">Có lỗi xảy ra khi tải giao diện</div>');
                }
            });
        }

        // Mở modal thêm mới
        openCreateModal() {
            this.isEditMode = false;
            this.currentId = null;
            this.resetForm();
            
            // Cập nhật modal title và button
            $(`#${this.config.modalId}Label`).html(`<i class="bi bi-plus-circle"></i> Thêm mới ${this.config.modalTitle}`);
            $(`#${this.config.submitBtnId}`).html('<i class="bi bi-check-circle"></i> Thêm mới');
            
            // Cập nhật form action
            $(`#${this.config.formId}`).attr('action', this.config.createRoute);
            $(`#${this.config.formId}`).attr('method', 'POST');
            
            // Xóa method PUT nếu có
            $(`#${this.config.formId} input[name="_method"]`).remove();
            
            // Load giao diện từ view
            this.loadView(this.config.viewPath, {
                ...this.config.viewData,
                mode: 'create',
                isEdit: false
            });
            
            // Hiển thị modal
            $(`#${this.config.modalId}`).modal('show');
        }

        // Mở modal chỉnh sửa
        openEditModal(id, customData = null) {
            this.isEditMode = true;
            this.currentId = id;
            this.resetForm();
            
            // Cập nhật modal title và button
            $(`#${this.config.modalId}Label`).html(`<i class="bi bi-pencil-square"></i> Chỉnh sửa ${this.config.modalTitle}`);
            $(`#${this.config.submitBtnId}`).html('<i class="bi bi-check-circle"></i> Cập nhật');
            
            // Cập nhật form action
            const updateRoute = this.config.updateRoute.replace(':id', id);
            $(`#${this.config.formId}`).attr('action', updateRoute);
            $(`#${this.config.formId}`).attr('method', 'POST');
            
            // Thêm method PUT bằng _method parameter để khớp route update
            $(`#${this.config.formId} input[name="_method"]`).remove(); // Xóa nếu có
            $(`#${this.config.formId}`).append('<input type="hidden" name="_method" value="POST">');
            
            // Load dữ liệu và giao diện
            if (customData) {
                this.loadView(this.config.viewPath, {
                    ...this.config.viewData,
                    data: customData,
                    mode: 'edit',
                    isEdit: true,
                    id: id
                });
                $(`#${this.config.modalId}`).modal('show');
            } else if (this.config.getDataRoute) {
                this.loadData(id);
            } else {
                this.loadView(this.config.viewPath, {
                    ...this.config.viewData,
                    mode: 'edit',
                    isEdit: true,
                    id: id
                });
                $(`#${this.config.modalId}`).modal('show');
            }
        }

        // Load dữ liệu từ server
        loadData(id) {
            const url = this.config.getDataRoute.replace(':id', id);
            
            $.ajax({
                url: url,
                type: 'GET',
                success: (response) => {
                    if (response.success) {
                        // Load giao diện với data
                        this.loadView(this.config.viewPath, {
                            ...this.config.viewData,
                            data: response.data,
                            mode: 'edit',
                            isEdit: true,
                            id: id
                        });
                        
                        $(`#${this.config.modalId}`).modal('show');
                    } else {
                        this.showAlert('error', 'Không thể tải dữ liệu');
                    }
                },
                error: () => {
                    this.showAlert('error', 'Có lỗi xảy ra khi tải dữ liệu');
                }
            });
        }

        // Reset form
        resetForm() {
            $(`#${this.config.formId}`)[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        }

        // Xử lý submit form
        handleSubmit(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const url = $(e.target).attr('action');
            const submitBtn = $(`#${this.config.submitBtnId}`);
            
            // Reset validation
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
            
            // Disable button và hiển thị loading
            submitBtn.addClass('btn-loading').prop('disabled', true);
            
            $.ajax({
                url: url,
                type: 'POST', // Luôn sử dụng POST, Laravel sẽ xử lý _method parameter
                data: formData,
                processData: false,
                contentType: false,
                success: (response) => {
                    if (response.success) {
                        this.showAlert('success', response.message || this.config.successMessage);
                        $(`#${this.config.modalId}`).modal('hide');
                        
                        // Callback sau khi thành công
                        if (this.config.onSuccess) {
                            this.config.onSuccess(response, this.isEditMode, this.currentId);
                        } else {
                            // Reload trang mặc định
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        }
                    } else {
                        this.showAlert('error', response.message || this.config.errorMessage);
                    }
                },
                error: (xhr) => {
                    if (xhr.status === 422) {
                        // Validation errors
                        const errors = xhr.responseJSON.errors;
                        Object.keys(errors).forEach((key) => {
                            const input = $(`#${key}`);
                            input.addClass('is-invalid');
                            $(`#${key}Error`).text(errors[key][0]);
                        });
                    } else {
                        this.showAlert('error', this.config.errorMessage);
                    }
                },
                complete: () => {
                    // Enable button và ẩn loading
                    submitBtn.removeClass('btn-loading').prop('disabled', false);
                }
            });
        }

        // Hiển thị thông báo
        showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 'bi-check-circle' : 'bi-exclamation-triangle';
            
            const alertHtml = `
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="bi ${icon}"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
            
            // Thêm alert vào đầu card-body hoặc container
            const container = $('.card-body').length ? $('.card-body') : $('.container-fluid');
            container.prepend(alertHtml);
            
            // Tự động ẩn sau 5 giây
            setTimeout(() => {
                $('.alert').fadeOut();
            }, 5000);
        }

        // Cập nhật config
        updateConfig(newConfig) {
            this.config = { ...this.config, ...newConfig };
            this.createModal();
        }

        // Xóa modal
        destroy() {
            $(`#${this.config.modalId}`).remove();
        }
    }

    // Export class ra global scope
    window.UniversalModal = UniversalModal;
    
    // Helper function để tạo modal nhanh
    window.createUniversalModal = function(config) {
        return new UniversalModal(config);
    };
    
})();
