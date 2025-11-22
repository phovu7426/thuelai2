@extends('admin.index')

@section('page_title', 'Quản lý bài viết')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Quản lý bài viết</li>
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
                                <!-- Form lọc -->
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <input type="text" id="search-title" class="form-control" placeholder="🔍 Tìm kiếm theo tiêu đề...">
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filter-status" class="form-control">
                                            <option value="">Tất cả trạng thái</option>
                                            <option value="draft">Bản nháp</option>
                                            <option value="published">Đã xuất bản</option>
                                            <option value="archived">Đã lưu trữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select id="filter-category" class="form-control">
                                            <option value="">Tất cả danh mục</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" id="search-btn" class="btn btn-primary">
                                            <i class="bi bi-search"></i> Lọc
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                <button type="button" class="btn btn-primary" onclick="openCreatePostModal()">
                                    <i class="bi bi-plus-circle"></i> Thêm bài viết
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Posts Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="posts-table">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50">ID</th>
                                        <th width="100">Ảnh</th>
                                        <th>Tiêu đề</th>
                                        <th width="120">Danh mục</th>
                                        <th width="100">Trạng thái</th>
                                        <th width="100">Nổi bật</th>
                                        <th width="120">Ngày tạo</th>
                                        <th width="150">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($posts ?? [] as $index => $post)
                                        <tr>
                                            <td>{{ $posts->firstItem() + $index }}</td>
                                            <td>
                                                @if($post->image)
                                                    <img src="{{ asset($post->image) }}" 
                                                         alt="{{ $post->title }}" 
                                                         class="img-thumbnail" style="max-width: 80px;">
                                                @else
                                                    <div class="bg-secondary text-white text-center rounded" 
                                                         style="width: 80px; height: 60px; line-height: 60px;">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <strong>{{ $post->title }}</strong>
                                                @if($post->excerpt)
                                                    <br><small class="text-muted">{{ Str::limit($post->excerpt, 100) }}</small>
                                                @endif
                                            </td>
                                            <td>
                                                @if($post->category)
                                                    <span class="badge bg-info">{{ $post->category->name }}</span>
                                                @else
                                                    <span class="badge bg-secondary">Không có</span>
                                                @endif
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-post-id="{{ $post->id }}" 
                                                        data-current-status="{{ $post->status }}">
                                                    <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>
                                                        Bản nháp
                                                    </option>
                                                    <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>
                                                        Đã xuất bản
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm featured-select" 
                                                        data-post-id="{{ $post->id }}" 
                                                        data-current-featured="{{ $post->featured ? '1' : '0' }}">
                                                    <option value="0" {{ !$post->featured ? 'selected' : '' }}>
                                                        Không nổi bật
                                                    </option>
                                                    <option value="1" {{ $post->featured ? 'selected' : '' }}>
                                                        Nổi bật
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ $post->created_at ? $post->created_at->format('d/m/Y') : 'N/A' }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    <button type="button" class="btn-action btn-edit" title="Sửa"
                                                            onclick="openEditPostModal({{ $post->id }})">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn-action btn-delete" title="Xóa"
                                                            onclick="deleteData('/admin/posts/{{ $post->id }}', 'DELETE')">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted">
                                                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                                                <p class="mt-2">Chưa có bài viết nào</p>
                                                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary btn-sm">
                                                    <i class="bi bi-plus-circle"></i> Tạo bài viết đầu tiên
                                                </a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        @if($posts && $posts->hasPages())
                            <div class="d-flex justify-content-center mt-3">
                                {{ $posts->links() }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/admin/universal-modal.css') }}">
<style>
/* Đảm bảo Select2 hiển thị đúng trong modal */
.select2-container {
    z-index: 9999;
}
.select2-dropdown {
    z-index: 9999;
}
</style>
@endsection

@section('scripts')
<script src="{{ asset('js/admin/universal-modal.js') }}"></script>
<script>
// Khởi tạo Universal Modal cho Posts
if (!window.postsModal) {
    window.postsModal = new UniversalModal({
        modalId: 'postsModal',
        modalTitle: 'Bài viết',
        formId: 'postsForm',
        submitBtnId: 'postsSubmitBtn',
        createRoute: '{{ route("admin.posts.store") }}',
        updateRoute: '{{ route("admin.posts.update", ":id") }}',
        getDataRoute: '{{ route("admin.posts.show", ":id") }}',
        successMessage: 'Thao tác bài viết thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý bài viết',
        viewPath: 'admin.posts.form',
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
function openCreatePostModal() {
    window.postsModal.openCreateModal();
}

function openEditPostModal(postId) {
    window.postsModal.openEditModal(postId);
}
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Status select change
    $('.status-select').change(function() {
        const postId = $(this).data('post-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updatePostStatus(postId, newStatus);
        }
    });

    // Featured select change
    $('.featured-select').change(function() {
        const postId = $(this).data('post-id');
        const newFeatured = $(this).val();
        const currentFeatured = $(this).data('current-featured');
        
        if (newFeatured !== currentFeatured) {
            updatePostFeatured(postId, newFeatured);
        }
    });
});

function updatePostStatus(postId, status) {
    $.ajax({
        url: `/admin/posts/${postId}/toggle-status`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current status
                $(`.status-select[data-post-id="${postId}"]`).data('current-status', status);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`.status-select[data-post-id="${postId}"]`);
                select.val(select.data('current-status'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
            // Revert select
            const select = $(`.status-select[data-post-id="${postId}"]`);
            select.val(select.data('current-status'));
        }
    });
}

function updatePostFeatured(postId, featured) {
    $.ajax({
        url: `/admin/posts/${postId}/toggle-featured`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            featured: featured
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current featured
                $(`.featured-select[data-post-id="${postId}"]`).data('current-featured', featured);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`.featured-select[data-post-id="${postId}"]`);
                select.val(select.data('current-featured'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật nổi bật');
            // Revert select
            const select = $(`.featured-select[data-post-id="${postId}"]`);
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
    
    // Tạo alert container nếu chưa có
    if (!$('#alert-container').length) {
        $('.card-body').prepend('<div id="alert-container"></div>');
    }
    
    $('#alert-container').html(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('#alert-container .alert').fadeOut();
    }, 5000);
}

function deletePost(id) {
    if (confirm('Bạn có chắc chắn muốn xóa bài viết này?')) {
        fetch(`/admin/posts/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Có lỗi xảy ra: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Có lỗi xảy ra khi xóa bài viết');
        });
    }
}
</script>
@endpush
