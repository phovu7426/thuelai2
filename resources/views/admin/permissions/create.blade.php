@extends('admin.index')

@section('page_title', 'Thêm quyền')

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">Thêm quyền</li>
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
                            <i class="bi bi-key-plus"></i> Thêm mới quyền
                        </h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.permissions.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">
                                            <i class="bi bi-key"></i> Tên quyền
                                        </label>
                                        <input type="text" name="name" class="form-control"
                                            placeholder="🔑 Nhập tên quyền..." value="{{ old('name') }}" required>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">
                                            <i class="bi bi-info-circle"></i> Mô tả
                                        </label>
                                        <input type="text" name="title" class="form-control"
                                            placeholder="ℹ️ Nhập mô tả..." value="{{ old('title') }}" required>
                                        @error('title')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left"></i> Hủy
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check-circle"></i> Thêm mới
                                        </button>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </form>
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
