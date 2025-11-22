@extends('admin.index')

@section('page_title', 'Cập nhật tài khoản')

@section('page_title', 'Cập nhật tài khoản')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Cập nhật tài khoản</li>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.profiles.update', request('user_id')) }}" method="POST">
                            @csrf

                            <!-- Tên đã được loại bỏ khỏi Profile -->

                            <!-- Số điện thoại -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone', $profile->phone ?? '') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Địa chỉ -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ old('address', $profile->address ?? '') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ngày sinh -->
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Ngày sinh</label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date"
                                    value="{{ old('birth_date', $profile->birth_date ?? '') }}">
                                @error('birth_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Giới tính -->
                            <div class="mb-3">
                                <label class="form-label">Giới tính</label>
                                <select class="form-control @error('gender') is-invalid @enderror" name="gender">
                                    <option value="male"
                                        {{ old('gender', $profile->gender ?? '') === 'male' ? 'selected' : '' }}>Nam
                                    </option>
                                    <option value="female"
                                        {{ old('gender', $profile->gender ?? '') === 'female' ? 'selected' : '' }}>Nữ
                                    </option>
                                    <option value="other"
                                        {{ old('gender', $profile->gender ?? '') === 'other' ? 'selected' : '' }}>Khác
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nút submit -->
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
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
