@extends('admin.index')

@section('page_title', 'Chỉnh sửa tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Danh sách tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chỉnh sửa tài khoản</li>
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
                            <i class="bi bi-person-gear"></i> Chỉnh sửa tài khoản
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-person"></i> Tên
                                        </label>
                                        <input type="text" name="name" class="form-control" 
                                               placeholder="👤 Nhập tên..." value="{{ $user->name }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope"></i> Email
                                        </label>
                                        <input type="email" name="email" class="form-control" 
                                               placeholder="📧 Nhập email..." value="{{ $user->email }}" required>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">
                                            <i class="bi bi-toggle-on"></i> Trạng thái
                                        </label>
                                        <select name="status" class="form-control">
                                            <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Hoạt động</option>
                                            <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>Không hoạt động</option>
                                        </select>
                                    </div>
                                </div>

                                

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone"></i> Số điện thoại
                                        </label>
                                        <input type="tel" name="phone" class="form-control" 
                                               placeholder="Nhập số điện thoại..." value="{{ optional($user->profile)->phone }}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="birth_date" class="form-label">
                                            <i class="bi bi-calendar"></i> Ngày sinh
                                        </label>
                                        <input type="date" name="birth_date" class="form-control" 
                                               value="{{ optional($user->profile)->birth_date }}">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">
                                            <i class="bi bi-geo-alt"></i> Địa chỉ
                                        </label>
                                        <textarea name="address" class="form-control" rows="3" placeholder="Nhập địa chỉ...">{{ optional($user->profile)->address }}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="gender" class="form-label">
                                            <i class="bi bi-gender-ambiguous"></i> Giới tính
                                        </label>
                                        @php $g = optional($user->profile)->gender; @endphp
                                        <select name="gender" class="form-control">
                                            <option value="">-- Chọn --</option>
                                            <option value="male" {{ $g === 'male' ? 'selected' : '' }}>Nam</option>
                                            <option value="female" {{ $g === 'female' ? 'selected' : '' }}>Nữ</option>
                                            <option value="other" {{ $g === 'other' ? 'selected' : '' }}>Khác</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Cập nhật
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <x-uploads.file-upload name="image" label="Ảnh đại diện" :value="$user->image" />
                                    </div>
                                </div>
                            </div> <!-- row -->
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
