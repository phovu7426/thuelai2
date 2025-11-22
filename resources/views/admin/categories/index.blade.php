@extends('admin.index')

@section('page_title', 'Danh sách Danh Mục')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Danh sách Danh Mục</li>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('js/admin/universal-modal.js') }}"></script>
<script>
// Khởi tạo Universal Modal cho Categories
if (!window.categoriesModal) {
    window.categoriesModal = new UniversalModal({
        modalId: 'categoriesModal',
        modalTitle: 'Danh mục',
        formId: 'categoriesForm',
        submitBtnId: 'categoriesSubmitBtn',
        createRoute: '{{ route("admin.categories.store") }}',
        updateRoute: '{{ route("admin.categories.update", ":id") }}',
        getDataRoute: '{{ route("admin.categories.show", ":id") }}',
        successMessage: 'Thao tác danh mục thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý danh mục',
        viewPath: 'admin.categories.form',
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

// Global functions để gọi từ HTML
function openCreateCategoryModal() {
    window.categoriesModal.openCreateModal();
}

function openEditCategoryModal(categoryId) {
    window.categoriesModal.openEditModal(categoryId);
}
</script>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" id="search-name" class="form-control" placeholder="Nhập tên danh mục">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" id="search-code" class="form-control" placeholder="Nhập mã danh mục">
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="btn-search" class="btn btn-primary">Tìm kiếm</button>
                                        <button type="button" id="btn-reset" class="btn btn-secondary">Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 d-flex">
                                <button type="button" class="btn btn-primary ms-auto" onclick="openCreateCategoryModal()">
                                    <i class="bi bi-plus-circle"></i> Thêm Danh Mục
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Tên Danh Mục</th>
                                    <th>Mã</th>
                                    <th>Slug</th>
                                    <th>Danh Mục Cha</th>
                                    <th>Trạng Thái</th>
                                    <th>Nổi Bật</th>
                                    <th>Hành Động</th>
                                </tr>
                                </thead>
                                <tbody id="categories-table-body">
                                    @foreach($categories as $index => $category)
                                        <tr data-id="{{ $category->id }}">
                                            <td>{{ $categories->firstItem() + $index }}</td>
                                            <td>{{ $category->name ?? '' }}</td>
                                            <td>{{ $category->code ?? '' }}</td>
                                            <td>{{ $category->slug ?? '' }}</td>
                                            <td>{{ $category->parent->name ?? 'N/A' }}</td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-category-id="{{ $category->id }}" 
                                                        data-current-status="{{ $category->status ? '1' : '0' }}"
                                                        data-status-type="categories">
                                                    <option value="0" {{ !$category->status ? 'selected' : '' }}>
                                                        Ẩn
                                                    </option>
                                                    <option value="1" {{ $category->status ? 'selected' : '' }}>
                                                        Hiển thị
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm featured-select" 
                                                        data-category-id="{{ $category->id }}" 
                                                        data-current-featured="{{ $category->is_featured ? '1' : '0' }}"
                                                        data-featured-type="categories">
                                                    <option value="0" {{ !$category->is_featured ? 'selected' : '' }}>
                                                        Không nổi bật
                                                    </option>
                                                    <option value="1" {{ $category->is_featured ? 'selected' : '' }}>
                                                        Nổi bật
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-edit" title="Sửa"
                                                            onclick="openEditCategoryModal({{ $category->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn-action btn-delete" title="Xóa"
                                                            onclick="deleteCategory({{ $category->id }})">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Hiển thị phân trang -->
                        <div id="pagination-container">
                            @include('vendor.pagination.pagination', ['paginator' => $categories])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Status select change
    $('.status-select').change(function() {
        const categoryId = $(this).data('category-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus === currentStatus) return;
        
        $.ajax({
            url: `/admin/categories/${categoryId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current status
                    $(this).data('current-status', newStatus);
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
            url: `/admin/categories/${categoryId}/toggle-featured`,
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

    // Search
    $('#btn-search').click(function() {
        searchCategories();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-name').val('');
        $('#search-code').val('');
        searchCategories();
    });

    // Enter key search
    $('#search-name, #search-code').keypress(function(e) {
        if (e.which == 13) {
            searchCategories();
        }
    });
});

function searchCategories(page = 1) {
    const name = $('#search-name').val();
    const code = $('#search-code').val();
    
    $.ajax({
        url: '{{ route("admin.categories.index") }}',
        method: 'GET',
        data: {
            name: name,
            code: code,
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

function deleteCategory(categoryId) {
    if (confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) {
        $.ajax({
            url: `/admin/categories/${categoryId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Remove row from table
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
}

function bindEvents() {
    // Rebind status select events
    $('.status-select').off('change').on('change', function() {
        const categoryId = $(this).data('category-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus === currentStatus) return;
        
        $.ajax({
            url: `/admin/categories/${categoryId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Cập nhật current status
                    $(this).data('current-status', newStatus);
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
            url: `/admin/categories/${categoryId}/toggle-featured`,
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
