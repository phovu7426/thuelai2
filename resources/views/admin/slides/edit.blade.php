@extends('admin.index')

@section('page_title', 'Chỉnh sửa slide')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.slides.index') }}">Danh sách slides</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa slide</li>
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
                        <h3 class="card-title">
                            <i class="bi bi-image-gear"></i> Chỉnh sửa slide: {{ $slide->title }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.slides.update', $slide->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">
                                            <i class="bi bi-type-bold"></i> Tiêu đề <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                               placeholder="📝 Nhập tiêu đề slide..." value="{{ old('title', $slide->title) }}" required>
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="description" class="form-label">
                                            <i class="bi bi-text-paragraph"></i> Mô tả
                                        </label>
                                        <textarea name="description" id="description" rows="5" class="form-control @error('description') is-invalid @enderror" placeholder="📄 Nhập mô tả slide...">{{ old('description', $slide->description) }}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="link" class="form-label">
                                            <i class="bi bi-link-45deg"></i> Liên kết
                                        </label>
                                        <input type="url" name="link" id="link" class="form-control @error('link') is-invalid @enderror" 
                                               placeholder="🔗 Nhập URL liên kết..." value="{{ old('link', $slide->link) }}">
                                        @error('link')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">
                                                <i class="bi bi-gear"></i> Cài đặt
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label for="image" class="form-label">
                                                    <i class="bi bi-image"></i> Hình ảnh
                                                </label>
                                                <x-uploads.file-upload name="image" label="Hình ảnh" :value="$slide->image" :required="true" />
                                                <small class="form-text text-muted">Để trống nếu không muốn thay đổi hình ảnh</small>
                                                @error('image')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                                <div class="mt-2" id="image-preview">
                                                    @if($slide->image)
                                                        <img src="{{ asset('storage/' . $slide->image) }}" alt="{{ $slide->title }}" class="img-thumbnail" style="max-height: 200px">
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="status" class="form-label">
                                                    <i class="bi bi-toggle-on"></i> Trạng thái
                                                </label>
                                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                                    <option value="1" {{ old('status', $slide->status) == '1' ? 'selected' : '' }}>✅ Hiển thị</option>
                                                    <option value="0" {{ old('status', $slide->status) == '0' ? 'selected' : '' }}>❌ Ẩn</option>
                                                </select>
                                                @error('status')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="is_featured" name="is_featured" 
                                                           value="1" {{ old('is_featured', $slide->is_featured) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="is_featured">
                                                        <i class="bi bi-star"></i> Đánh dấu nổi bật
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Quay lại
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Cập nhật slide
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection

@section('scripts')
@parent
<script>
</script>
<!-- CKEditor 5 đã được load từ layout -->
<script>
    $(function(){
      CKEDITOR.replace('description', {
        language: 'vi',
        height: 200,
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserUploadMethod: 'form',
        filebrowserUploadParams: {
          _token: '{{ csrf_token() }}'
        },
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage,image2',
        image2_altRequired: false,
        image2_disableResizer: false,
        removeDialogTabs: '',
      });
    });
</script>
@endsection
