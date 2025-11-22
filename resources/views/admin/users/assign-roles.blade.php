@extends('admin.index')

@section('page_title', 'Gán Vai Trò')

@section('page_title', 'Gán Vai Trò Cho Người Dùng')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Tài khoản</a></li>
    <li class="breadcrumb-item active" aria-current="page">Gán vai trò</li>
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
                        <form method="POST" action="{{ route('admin.users.assignRoles', $user->id) }}">
                            @csrf

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label"><strong>Email:</strong></label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label"><strong>Vai trò:</strong></label>
                                <select class="form-control select2" name="roles[]" multiple data-field="name"
                                    data-display-field="title" data-selected='@json($userRoles ?? [])'
                                    data-url="{{ route('admin.roles.autocomplete') }}">
                                    <option value="">Chọn vai trò</option>
                                </select>
                                @error('roles')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Lưu</button>
                                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
@endsection
