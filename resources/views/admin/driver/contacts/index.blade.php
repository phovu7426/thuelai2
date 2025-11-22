@extends('admin.index')

@section('page_title', 'Quản lý liên hệ lái xe')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.dashboard') }}">Dịch vụ lái xe</a></li>
    <li class="breadcrumb-item active" aria-current="page">Liên hệ lái xe</li>
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
                                        <input type="text" id="search-name" class="form-control" placeholder="🔍 Nhập tên khách hàng">
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
                                    <button type="button" class="btn btn-primary" onclick="openCreateContactModal()">
                                        <i class="bi bi-plus-circle"></i> Thêm liên hệ mới
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Alert messages -->
                        <div id="alert-container"></div>

                        @if($contacts->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên</th>
                                            <th>Email</th>
                                            <th>Số điện thoại</th>
                                            <th>Chủ đề</th>
                                            <th>Tiêu đề</th>
                                            <th>Trạng thái</th>
                                            <th>Nổi bật</th>
                                            <th>Ngày gửi</th>
                                            <th>Thao tác</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contacts-table-body">
                                        @foreach($contacts as $index => $contact)
                                        <tr data-id="{{ $contact['id'] }}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                <strong>{{ $contact['name'] }}</strong>
                                            </td>
                                            <td>
                                                <a href="mailto:{{ $contact['email'] }}" class="text-decoration-none">
                                                    <i class="bi bi-envelope"></i> {{ $contact['email'] }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="tel:{{ $contact['phone'] }}" class="text-decoration-none">
                                                    <i class="bi bi-telephone"></i> {{ $contact['phone'] }}
                                                </a>
                                            </td>
                                            <td>
                                                @if(isset($contact['topic']))
                                                    <span class="badge {{ $contact['topic'] == 'khiếu nại' ? 'badge-danger' : ($contact['topic'] == 'tư vấn dịch vụ' ? 'badge-info' : ($contact['topic'] == 'phản hồi' ? 'badge-success' : 'badge-secondary')) }}">
                                                        {{ $contact['topic'] }}
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">Khác</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $contact['subject'] ?? 'Không có tiêu đề' }}
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm status-select" 
                                                        data-contact-id="{{ $contact['id'] }}" 
                                                        data-current-status="{{ $contact['status'] }}">
                                                    <option value="unread" {{ $contact['status'] == 'unread' ? 'selected' : '' }}>
                                                        Chưa đọc
                                                    </option>
                                                    <option value="read" {{ $contact['status'] == 'read' ? 'selected' : '' }}>
                                                        Đã đọc
                                                    </option>
                                                    <option value="replied" {{ $contact['status'] == 'replied' ? 'selected' : '' }}>
                                                        Đã trả lời
                                                    </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-select form-select-sm featured-select" 
                                                        data-contact-id="{{ $contact['id'] }}" 
                                                        data-current-featured="{{ $contact['is_featured'] ? '1' : '0' }}"
                                                        data-featured-type="contacts">
                                                    <option value="0" {{ !$contact['is_featured'] ? 'selected' : '' }}>
                                                        Không nổi bật
                                                    </option>
                                                    <option value="1" {{ $contact['is_featured'] ? 'selected' : '' }}>
                                                        Nổi bật
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($contact['created_at'])->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="action-buttons">
                                                    @can('access_users')
                                                        <a href="{{ route('admin.driver.contacts.show', $contact['id']) }}" 
                                                           class="btn-action btn-view" title="Xem chi tiết">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <button type="button" class="btn-action btn-edit" title="Chỉnh sửa"
                                                                onclick="openEditContactModal({{ $contact['id'] }})">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button type="button" class="btn-action btn-review" title="Gửi đánh giá"
                                                                data-name="{{ $contact['name'] }}"
                                                                data-email="{{ $contact['email'] }}"
                                                                onclick="sendReviewEmail(this)">
                                                            <i class="bi bi-star-half"></i>
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
                            <div id="pagination-container">
                                @if($contacts->hasPages())
                                    <div class="d-flex justify-content-center mt-3">
                                        {{ $contacts->links() }}
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-envelope-open display-1 text-muted"></i>
                                <h4 class="mt-3 text-muted">Chưa có liên hệ nào</h4>
                                <p class="text-muted">Hãy thêm liên hệ đầu tiên để bắt đầu!</p>
                                <a href="{{ route('admin.driver.contacts.create') }}" class="btn btn-primary">
                                    <i class="bi bi-plus-circle"></i> Thêm liên hệ mới
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
// Khởi tạo Universal Modal cho Contacts
if (!window.contactsModal) {
    window.contactsModal = new UniversalModal({
        modalId: 'contactsModal',
        modalTitle: 'Liên hệ',
        formId: 'contactsForm',
        submitBtnId: 'contactsSubmitBtn',
        createRoute: '{{ route("admin.driver.contacts.store") }}',
        updateRoute: '{{ route("admin.driver.contacts.update", ":id") }}',
        getDataRoute: '{{ route("admin.driver.contacts.show", ":id") }}',
        successMessage: 'Thao tác liên hệ thành công',
        errorMessage: 'Có lỗi xảy ra khi xử lý liên hệ',
        viewPath: 'admin.driver.contacts.form',
        viewData: {},
        onSuccess: function(response, isEdit, id) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    });
}

// Global functions để gọi từ HTML
function openCreateContactModal() {
    window.contactsModal.openCreateModal();
}

function openEditContactModal(contactId) {
    window.contactsModal.openEditModal(contactId);
}

// Global function to send review email (ensure it's available for inline onclick)
window.sendReviewEmail = function(button) {
    const name = $(button).data('name');
    const email = $(button).data('email');
    const phone = $(button).data('phone') || '';

    if (!email) {
        showAlert('danger', 'Liên hệ không có email hợp lệ.');
        return;
    }

    if (confirm(`Tạo link mời đánh giá cho ${name || '(khách không tên)'} (${email})?`)) {
        $.ajax({
            url: '{{ route('review.send-email') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: name || 'Khách hàng',
                email: email,
                phone: phone
            },
            success: function(response) {
                if (response.success) {
                    let msg = response.message;
                    if (response.review_url) {
                        msg += ` — Link trực tiếp: <a href="${response.review_url}" target="_blank">${response.review_url}</a>`;
                    }
                    showAlert('success', msg);
                } else {
                    showAlert('danger', response.message || 'Gửi email thất bại.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const errs = xhr.responseJSON.errors;
                    const flat = Object.values(errs).flat().join('<br/>');
                    showAlert('danger', flat);
                } else {
                    showAlert('danger', 'Có lỗi xảy ra khi gửi email đánh giá');
                }
            }
        });
    }
}
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Status change
    $('.status-select').change(function() {
        const contactId = $(this).data('contact-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updateContactStatus(contactId, newStatus);
        }
    });

    // Search
    $('#btn-search').click(function() {
        searchContacts();
    });

    // Reset search
    $('#btn-reset').click(function() {
        $('#search-name').val('');
        searchContacts();
    });

    // Enter key search
    $('#search-name').keypress(function(e) {
        if (e.which == 13) {
            searchContacts();
        }
    });
});

function updateContactStatus(contactId, status) {
    $.ajax({
        url: `/admin/driver/contacts/${contactId}/status`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: status
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                // Update current status
                $(`select[data-contact-id="${contactId}"]`).data('current-status', status);
            } else {
                showAlert('danger', response.message);
                // Revert select
                const select = $(`select[data-contact-id="${contactId}"]`);
                select.val(select.data('current-status'));
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
            // Revert select
            const select = $(`select[data-contact-id="${contactId}"]`);
            select.val(select.data('current-status'));
        }
    });
}

function searchContacts(page = 1) {
    const name = $('#search-name').val();
    
    $.ajax({
        url: '{{ route("admin.driver.contacts.index") }}',
        method: 'GET',
        data: {
            name: name,
            page: page
        },
        success: function(response) {
            $('#contacts-table-body').html(response.html);
            $('#pagination-container').html(response.pagination);
            
            // Rebind events
            bindEvents();
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi tìm kiếm');
        }
    });
}

function deleteContact(contactId) {
    if (confirm('Bạn có chắc chắn muốn xóa liên hệ này không?')) {
        $.ajax({
            url: `/admin/driver/contacts/${contactId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    showAlert('success', response.message);
                    // Remove row from table
                    $(`tr[data-id="${contactId}"]`).remove();
                } else {
                    showAlert('danger', response.message);
                }
            },
            error: function() {
                showAlert('danger', 'Có lỗi xảy ra khi xóa liên hệ');
            }
        });
    }
}

function bindEvents() {
    // Rebind status change events
    $('.status-select').off('change').on('change', function() {
        const contactId = $(this).data('contact-id');
        const newStatus = $(this).val();
        const currentStatus = $(this).data('current-status');
        
        if (newStatus !== currentStatus) {
            updateContactStatus(contactId, newStatus);
        }
    });
}

function sendReviewEmail(button) {
    const name = $(button).data('name');
    const email = $(button).data('email');
    const phone = $(button).data('phone') || '';

    if (!email) {
        showAlert('danger', 'Liên hệ không có email hợp lệ.');
        return;
    }

    if (confirm(`Tạo link mời đánh giá cho ${name || '(khách không tên)'} (${email})?`)) {
        $.ajax({
            url: '{{ route('review.send-email') }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                name: name || 'Khách hàng',
                email: email,
                phone: phone
            },
            success: function(response) {
                if (response.success) {
                    let msg = response.message;
                    if (response.review_url) {
                        msg += ` — Link trực tiếp: <a href="${response.review_url}" target="_blank">${response.review_url}</a>`;
                    }
                    showAlert('success', msg);
                } else {
                    showAlert('danger', response.message || 'Gửi email thất bại.');
                }
            },
            error: function(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    const errs = xhr.responseJSON.errors;
                    const flat = Object.values(errs).flat().join('<br/>');
                    showAlert('danger', flat);
                } else {
                    showAlert('danger', 'Có lỗi xảy ra khi gửi email đánh giá');
                }
            }
        });
    }
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
