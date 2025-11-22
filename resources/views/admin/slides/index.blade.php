@extends('admin.index')

@section('page_title', 'Quản lý Slides')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Quản lý Slides</li>
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
                                <form action="{{ route('admin.slides.index') }}" method="GET" class="mb-0">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <input type="text" name="title" class="form-control" placeholder="🔍 Nhập tiêu đề slide"
                                                   value="{{ request('title') }}">
                                        </div>
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-search"></i> Lọc
                                            </button>
                                            <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-3 d-flex justify-content-end">
                                @can('access_users')
                                    <button type="button" class="btn btn-primary" onclick="openCreateSlideModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm Slide
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        @if(isset($slides) && $slides->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tiêu đề</th>
                                            <th>Mô tả</th>
                                            <th>Hình ảnh</th>
                                            <th>Trạng thái</th>
                                            <th>Nổi bật</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($slides as $index => $slide)
                                            <tr>
                                                <td>{{ $slides->firstItem() + $index }}</td>
                                                <td>
                                                    <strong>{{ $slide->title }}</strong>
                                                </td>
                                                <td>{{ Str::limit($slide->description, 100) }}</td>
                                                <td>
                                                    @if ($slide->image)
                                                        <img src="{{ asset('storage/' . $slide->image) }}"
                                                            style="max-width: 120px; max-height: 60px;" 
                                                            class="img-thumbnail rounded">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                             style="width: 120px; height: 60px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm status-select" 
                                                            data-slide-id="{{ $slide->id }}" 
                                                            data-current-status="{{ $slide->status }}"
                                                            data-status-type="slides">
                                                        <option value="0" {{ !$slide->status ? 'selected' : '' }}>
                                                            Ẩn
                                                        </option>
                                                        <option value="1" {{ $slide->status ? 'selected' : '' }}>
                                                            Hiển thị
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-select form-select-sm featured-select" 
                                                            data-slide-id="{{ $slide->id }}" 
                                                            data-current-featured="{{ $slide->is_featured ? '1' : '0' }}"
                                                            data-featured-type="slides">
                                                        <option value="0" {{ !$slide->is_featured ? 'selected' : '' }}>
                                                            Không nổi bật
                                                        </option>
                                                        <option value="1" {{ $slide->is_featured ? 'selected' : '' }}>
                                                            Nổi bật
                                                        </option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="action-buttons">
                                                        @can('access_users')
                                                            <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                                                                    onclick="openEditSlideModal({{ $slide->id }})">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button type="button" class="btn-action btn-delete" title="Xóa" 
                                                                    onclick="deleteData('/admin/slides/delete/{{ $slide->id }}')">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        @endcan
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            
                            <!-- Phân trang -->
                            @if($slides->hasPages())
                                <div class="d-flex justify-content-center mt-3">
                                    {{ $slides->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-images display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">Chưa có slide nào</h4>
                                <p class="text-muted">Hãy thêm slide đầu tiên để bắt đầu!</p>
                                <a href="{{ route('admin.slides.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Thêm Slide
                                </a>
                            </div>
                        @endif
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
// Khởi tạo Universal Modal cho Slides
if (!window.slidesModal) {
    window.slidesModal = new UniversalModal({
        modalId: 'slidesModal',
        modalTitle: 'Slide',
        formId: 'slidesForm',
        submitBtnId: 'slidesSubmitBtn',
        createRoute: '{{ route("admin.slides.store") }}',
        updateRoute: '{{ route("admin.slides.update", ":id") }}',
        getDataRoute: '{{ route("admin.slides.show", ":id") }}',
        successMessage: 'Thao tác slide thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý slide',
        viewPath: 'admin.slides.form',
        viewData: {},
        onSuccess: function(response, isEdit, id) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    });
}

// Global functions để gọi từ HTML
function openCreateSlideModal() {
    window.slidesModal.openCreateModal();
}

function openEditSlideModal(slideId) {
    window.slidesModal.openEditModal(slideId);
}
</script>
@endsection
