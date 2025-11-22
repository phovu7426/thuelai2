@extends('admin.index')

@section('page_title', 'Danh sách tags')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Danh sách tags</li>
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
                                        <input type="text" id="search-name" class="form-control" placeholder="🔍 Nhập tên tag">
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
                                    <button type="button" class="btn btn-primary" onclick="openCreateTagModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm tag
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
                                <th>Tên tag</th>
                                <th>Mô tả</th>
                                <th>Trạng thái</th>
                                <th>Nổi bật</th>
                                <th>Hành Động</th>
                            </tr>
                            </thead>
                            <tbody id="tags-table-body">
                            @include('admin.post-tags.partials.table')
                            </tbody>
                        </table>
                        
                        <!-- Phân trang -->
                        <div id="pagination-container">
                            @include('admin.post-tags.partials.pagination')
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
<script src="{{ asset('js/admin/universal-modal.js') }}"></script>
<script>
// Khởi tạo Universal Modal cho Post Tags
if (!window.postTagsModal) {
    window.postTagsModal = new UniversalModal({
        modalId: 'postTagsModal',
        modalTitle: 'Tag',
        formId: 'postTagsForm',
        submitBtnId: 'postTagsSubmitBtn',
        createRoute: '{{ route("admin.post-tags.store") }}',
        updateRoute: '{{ route("admin.post-tags.update", ":id") }}',
        getDataRoute: '{{ route("admin.post-tags.show", ":id") }}',
        successMessage: 'Thao tác tag thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý tag',
        viewPath: 'admin.post-tags.form',
        viewData: {},
        onSuccess: function(response, isEdit, id) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    });
}

// Global functions để gọi từ HTML
function openCreateTagModal() {
    window.postTagsModal.openCreateModal();
}

function openEditTagModal(tagId) {
    window.postTagsModal.openEditModal(tagId);
}
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Status select change
    $('.status-select').change(function() {
        const tagId = $(this).data('tag-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updateTagStatus(tagId, newStatus);
        }
    });

    // Featured select change
    $('.featured-select').change(function() {
        const tagId = $(this).data('tag-id');
        const newFeatured = $(this).val();
        const currentFeatured = $(this).data('current-featured');
        
        if (newFeatured !== currentFeatured) {
            updateTagFeatured(tagId, newFeatured);
        }
    });

    // Search
    $('#btn-search').click(function() {
        searchTags();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-name').val('');
        searchTags();
    });

    // Enter key search
    $('#search-name').keypress(function(e) {
        if (e.which == 13) {
            searchTags();
        }
    });
});

function searchTags(page = 1) {
    const name = $('#search-name').val();
    
    $.ajax({
        url: '{{ route("admin.post-tags.index") }}',
        method: 'GET',
        data: {
            name: name,
            page: page
        },
        success: function(response) {
            $('#tags-table-body').html(response.html);
            $('#pagination-container').html(response.pagination);
            
            // Rebind events
            bindEvents();
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi tìm kiếm');
        }
    });
}

function deleteTag(tagId) {
    if (confirm('Bạn có chắc chắn muốn xóa tag này không?')) {
        $.ajax({
            url: `/admin/post-tags/${tagId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Remove row from table
                    $(`tr[data-id="${tagId}"]`).remove();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi xóa tag');
            }
        });
    }
}

function bindEvents() {
    // Rebind status select events
    $('.status-select').off('change').on('change', function() {
        const tagId = $(this).data('tag-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updateTagStatus(tagId, newStatus);
        }
    });

    // Rebind featured select events
    $('.featured-select').off('change').on('change', function() {
        const tagId = $(this).data('tag-id');
        const newFeatured = $(this).val();
        const currentFeatured = $(this).data('current-featured');
        
        if (newFeatured !== currentFeatured) {
            updateTagFeatured(tagId, newFeatured);
        }
    });
}

function updateTagStatus(tagId, status) {
    $.ajax({
        url: `/admin/post-tags/${tagId}/toggle-status`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current status
                $(`select[data-tag-id="${tagId}"]`).data('current-status', status);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`select[data-tag-id="${tagId}"]`);
                select.val(select.data('current-status'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
            // Revert select
            const select = $(`select[data-tag-id="${tagId}"]`);
            select.val(select.data('current-status'));
        }
    });
}

function updateTagFeatured(tagId, featured) {
    $.ajax({
        url: `/admin/post-tags/${tagId}/toggle-featured`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            is_featured: featured
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current featured
                $(`select[data-tag-id="${tagId}"]`).data('current-featured', featured);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`select[data-tag-id="${tagId}"]`);
                select.val(select.data('current-featured'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
            // Revert select
            const select = $(`select[data-tag-id="${tagId}"]`);
            select.val(select.data('current-featured'));
        }
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


