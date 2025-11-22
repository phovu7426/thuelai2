@extends('admin.layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h3>Banner trang chủ</h3>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.home-banner.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Tiêu đề</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title', $banner->title) }}">
                        @error('title')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả ngắn</label>
                        <input type="text" name="subtitle" class="form-control" value="{{ old('subtitle', $banner->subtitle) }}">
                        @error('subtitle')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh banner</label>
                        @if($banner->image_url)
                            <div class="mb-2">
                                <img src="{{ $banner->image_url }}" alt="banner" style="max-height: 120px;border-radius:8px;">
                            </div>
                        @endif
                        <input type="file" name="image" class="form-control">
                        @error('image')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Liên kết (khi bấm)</label>
                        <input type="url" name="link" class="form-control" value="{{ old('link', $banner->link) }}">
                        @error('link')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nút bấm</label>
                        <input type="text" name="button_text" class="form-control" value="{{ old('button_text', $banner->button_text) }}">
                        @error('button_text')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" {{ old('status', $banner->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Kích hoạt hiển thị</label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_announcement" name="is_announcement" value="1" {{ old('is_announcement', $banner->is_announcement) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_announcement">Hiển thị dạng thanh thông báo (trên Hero)</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Lưu</button>
                </form>
            </div>
        </div>
    </div>
@endsection


