/**
 * Ví dụ sử dụng Universal Modal với View cho menu Categories
 */

// Khởi tạo modal cho categories
const categoriesModal = new UniversalModal({
    modalId: 'categoriesModal',
    modalTitle: 'Danh mục',
    formId: 'categoriesForm',
    submitBtnId: 'categoriesSubmitBtn',
    createRoute: '/admin/categories/store',
    updateRoute: '/admin/categories/update/:id',
    getDataRoute: '/admin/categories/get-category-info/:id',
    successMessage: 'Thao tác danh mục thành công',
    errorMessage: 'Có lỗi xảy ra khi xử lý danh mục',
    viewPath: 'admin.categories.form',
    viewData: {
        // Truyền thêm data vào view
        categories: [], // Sẽ được load động
        parentCategories: [] // Danh sách categories cha
    },
    onSuccess: function(response, isEdit, id) {
        console.log('Thao tác danh mục thành công:', { response, isEdit, id });
        
        // Có thể thêm logic custom ở đây
        // Ví dụ: refresh danh sách categories, update tree view, etc.
        
        setTimeout(() => {
            location.reload();
        }, 1500);
    }
});

// Global functions để gọi từ HTML
function openCreateCategoryModal() {
    categoriesModal.openCreateModal();
}

function openEditCategoryModal(categoryId) {
    categoriesModal.openEditModal(categoryId);
}

// Hàm helper để load danh sách categories cho select parent
function loadCategoriesForSelect() {
    $.ajax({
        url: '/admin/categories/get-all-categories',
        type: 'GET',
        success: function(response) {
            if (response.success) {
                // Cập nhật viewData với categories mới
                categoriesModal.updateConfig({
                    viewData: {
                        ...categoriesModal.config.viewData,
                        categories: response.data
                    }
                });
                
                // Reload view nếu modal đang mở
                if ($('#categoriesModal').hasClass('show')) {
                    categoriesModal.loadView('admin.categories.form', {
                        ...categoriesModal.config.viewData,
                        categories: response.data
                    });
                }
            }
        }
    });
}

// Load categories khi trang load
$(document).ready(function() {
    loadCategoriesForSelect();
});
