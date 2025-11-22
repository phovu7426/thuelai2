@extends('admin.index')

@section('page_title', 'Danh sách danh mục tin tức')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Danh sách danh mục tin tức</li>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <div class="row align-items-center">
                            <div class="col-sm-9">
                                <!-- Form tìm kiếm -->
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" id="search-name" class="form-control" placeholder="🔍 Nhập tên danh mục">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="btn-search" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Tìm kiếm
                                        </button>
                                        <button type="button" id="btn-reset" class="btn btn-secondary">
                                            <i class="bi bi-arrow-clockwise"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                @can('access_users')
                                    <button type="button" class="btn btn-primary" onclick="openCreatePostCategoryModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm danh mục
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên danh mục</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Hành Động</th>
                            </tr>
                            </thead>
                            <tbody id="categories-table-body">
                            @foreach($categories as $index => $category)
                                <tr data-id="{{ $category->id }}">
                                    <td>{{ $categories->firstItem() + $index }}</td>
                                    <td>
                                        <strong>{{ $category->name ?? '' }}</strong>
                                        <br><small class="text-muted">Slug: {{ $category->slug ?? '' }}</small>
                                    </td>
                                    <td>{{ Str::limit($category->description ?? '', 80) }}</td>
                                    <td>
                                        <select class="form-select form-select-sm status-select" 
                                                data-category-id="{{ $category->id }}" 
                                                data-current-status="{{ $category->status == 'active' ? 'active' : 'inactive' }}"
                                                data-status-type="post-categories">
                                            <option value="inactive" {{ $category->status != 'active' ? 'selected' : '' }}>
                                                Vô hiệu
                                            </option>
                                            <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>
                                                Kích hoạt
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            @can('access_users')
                                                <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                                                        onclick="openEditPostCategoryModal({{ $category->id }})">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button type="button" class="btn-action btn-delete" title="Xóa" onclick="deleteData('/admin/post-categories/{{ $category->id }}', 'DELETE')">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        
                        <!-- Phân trang -->
                        <div id="pagination-container">
                            @if($categories->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $categories->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
@endsection

@section('scripts')
<script>
// Đợi jQuery sẵn sàng trước khi khởi tạo Universal Modal
function waitForJQuery(callback) {
    if (typeof $ !== 'undefined') {
        callback();
    } else {
        // Nếu jQuery chưa sẵn sàng, chờ DOM ready
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof $ !== 'undefined') {
                callback();
            } else {
                // Nếu vẫn chưa có jQuery, chờ thêm một chút
                setTimeout(() => {
                    if (typeof $ !== 'undefined') {
                        callback();
                    } else {
                        console.error('jQuery is not loaded after waiting');
                    }
                }, 100);
            }
        });
    }
}

// Khởi tạo Universal Modal
waitForJQuery(function() {
    // Kiểm tra jQuery đã sẵn sàng
    if (typeof $ === 'undefined') {
        console.error('jQuery is not loaded');
        return;
    }
    
    // Khởi tạo Universal Modal cho Post Categories
    if (!window.postCategoriesModal) {
        window.postCategoriesModal = new UniversalModal({
            modalId: 'postCategoriesModal',
            modalTitle: 'Danh mục tin tức',
            formId: 'postCategoriesForm',
            submitBtnId: 'postCategoriesSubmitBtn',
            createRoute: '{{ route("admin.post-categories.store") }}',
            updateRoute: '{{ route("admin.post-categories.update", ":id") }}',
            getDataRoute: '{{ route("admin.post-categories.show", ":id") }}',
            successMessage: 'Thao tác danh mục tin tức thành công',
            errorMessage: 'Có lỗi xảy ra khi xử lý danh mục tin tức',
            viewPath: 'admin.post-categories.form',
            viewData: {
                categories: @json($categories ?? [])
            },
            onSuccess: function(response, isEdit, id) {
                setTimeout(() => {
                    location.reload();
                }, 1500);
            }
        });
    }
});

// Global functions để gọi từ HTML
function openCreatePostCategoryModal() {
    if (window.postCategoriesModal) {
        window.postCategoriesModal.openCreateModal();
    } else {
        console.error('Post Categories Modal not initialized');
    }
}

function openEditPostCategoryModal(categoryId) {
    if (window.postCategoriesModal) {
        window.postCategoriesModal.openEditModal(categoryId);
    } else {
        console.error('Post Categories Modal not initialized');
    }
}
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Search functionality
    $('#btn-search').click(function() {
        searchCategories();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-name').val('');
        searchCategories();
    });

    // Enter key search
    $('#search-name').keypress(function(e) {
        if (e.which == 13) {
            searchCategories();
        }
    });

    // Status select change
    $('.status-select').change(function() {
        const categoryId = $(this).data('category-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus === currentStatus) return;
        
        $.ajax({
            url: `/admin/post-categories/${categoryId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current status
                    $(this).data('current-status', response.data.status);
                } else {
                    showAlert('danger', response.message);
                    // Revert select
                    $(this).val(currentStatus);
                }
            }.bind(this),
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                // Revert select
                $(this).val(currentStatus);
            }.bind(this)
        });
    });

    // Featured select change
    $('.featured-select').change(function() {
        const categoryId = $(this).data('category-id');
        const newFeatured = $(this).val();
        const currentFeatured = $(this).data('current-featured');
        
        if (newFeatured === currentFeatured) return;
        
        $.ajax({
            url: `/admin/post-categories/${categoryId}/toggle-featured`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_featured: newFeatured
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current featured
                    $(this).data('current-featured', newFeatured);
                } else {
                    showAlert('danger', response.message);
                    // Revert select
                    $(this).val(currentFeatured);
                }
            }.bind(this),
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
                // Revert select
                $(this).val(currentFeatured);
            }.bind(this)
        });
    });
});

// Search function
function searchCategories(page = 1) {
    const name = $('#search-name').val();
    
    $.ajax({
        url: '{{ route("admin.post-categories.index") }}',
        method: 'GET',
        data: {
            name: name,
            page: page
        },
        success: function(response) {
            $('#categories-table-body').html(response.html);
            $('#pagination-container').html(response.pagination);
            
            // Rebind events
            bindEvents();
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi tìm kiếm');
        }
    });
}

// Global functions
function deletePostCategory(categoryId) {
    if (!confirm('Bạn có chắc chắn muốn xóa danh mục này?')) {
        return;
    }
    
    $.ajax({
        url: `/admin/post-categories/${categoryId}`,
        method: 'DELETE',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                $(`tr[data-id="${categoryId}"]`).remove();
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi xóa danh mục');
        }
    });
}

function bindEvents() {
    // Rebind status select events
    $('.status-select').off('change').on('change', function() {
        const categoryId = $(this).data('category-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus === currentStatus) return;
        
        $.ajax({
            url: `/admin/post-categories/${categoryId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current status
                    $(this).data('current-status', response.data.status);
                } else {
                    showAlert('danger', response.message);
                    // Revert select
                    $(this).val(currentStatus);
                }
            }.bind(this),
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
                // Revert select
                $(this).val(currentStatus);
            }.bind(this)
        });
    });

    // Rebind featured select events
    $('.featured-select').off('change').on('change', function() {
        const categoryId = $(this).data('category-id');
        const newFeatured = $(this).val();
        const currentFeatured = $(this).data('current-featured');
        
        if (newFeatured === currentFeatured) return;
        
        $.ajax({
            url: `/admin/post-categories/${categoryId}/toggle-featured`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                is_featured: newFeatured
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current featured
                    $(this).data('current-featured', newFeatured);
                } else {
                    showAlert('danger', response.message);
                    // Revert select
                    $(this).val(currentFeatured);
                }
            }.bind(this),
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
                // Revert select
                $(this).val(currentFeatured);
            }.bind(this)
        });
    });
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('#alert-container').html(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('#alert-container .alert').fadeOut();
    }, 5000);
}
</script>
@endpush
