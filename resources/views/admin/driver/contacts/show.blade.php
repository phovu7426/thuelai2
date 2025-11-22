@extends('admin.index')

@section('page_title', 'Chi tiết liên hệ lái xe')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.dashboard') }}">Dịch vụ lái xe</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.driver.contacts.index') }}">Liên hệ lái xe</a></li>
    <li class="breadcrumb-item active" aria-current="page">Chi tiết liên hệ</li>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Chi tiết liên hệ từ: {{ $contact['name'] ?? 'N/A' }}</h3>
                            <div>
                                @can('access_users')
                                    <button type="button" class="btn btn-primary" onclick="openEditContactModal({{ $contact['id'] }})">
                                        <i class="bi bi-pencil"></i> Chỉnh sửa
                                    </button>
                                @endcan
                                <a href="{{ route('admin.driver.contacts.index') }}" class="btn btn-secondary">
                                    <i class="bi bi-arrow-left"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-4">
                                    <h5>Thông tin liên hệ</h5>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Họ tên:</strong> {{ $contact['name'] ?? 'N/A' }}</p>
                                            <p><strong>Email:</strong> 
                                                @if($contact['email'] ?? false)
                                                    <a href="mailto:{{ $contact['email'] }}" class="text-decoration-none">
                                                        <i class="bi bi-envelope"></i> {{ $contact['email'] }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                            <p><strong>Số điện thoại:</strong> 
                                                @if($contact['phone'] ?? false)
                                                    <a href="tel:{{ $contact['phone'] }}" class="text-decoration-none">
                                                        <i class="bi bi-telephone"></i> {{ $contact['phone'] }}
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Chủ đề:</strong> 
                                                @if(isset($contact['topic']))
                                                    <span class="badge {{ $contact['topic'] == 'khiếu nại' ? 'bg-danger' : ($contact['topic'] == 'tư vấn dịch vụ' ? 'bg-info' : ($contact['topic'] == 'phản hồi' ? 'bg-success' : 'bg-secondary')) }}">
                                                        {{ $contact['topic'] }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Khác</span>
                                                @endif
                                            </p>
                                            <p><strong>Tiêu đề:</strong> {{ $contact['subject'] ?? 'Không có tiêu đề' }}</p>
                                            <p><strong>Trạng thái:</strong> 
                                                <span class="badge {{ $contact['status'] == 'unread' ? 'bg-warning' : ($contact['status'] == 'read' ? 'bg-info' : ($contact['status'] == 'replied' ? 'bg-success' : 'bg-secondary')) }}">
                                                    @switch($contact['status'] ?? 'unread')
                                                        @case('unread')
                                                            Chưa đọc
                                                            @break
                                                        @case('read')
                                                            Đã đọc
                                                            @break
                                                        @case('replied')
                                                            Đã trả lời
                                                            @break
                                                        @case('closed')
                                                            Đã đóng
                                                            @break
                                                        @default
                                                            Chưa đọc
                                                    @endswitch
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <h5>Nội dung tin nhắn</h5>
                                    <hr>
                                    <div class="p-3 bg-light rounded">
                                        @if($contact['message'] ?? false)
                                            {!! nl2br(e($contact['message'])) !!}
                                        @else
                                            <em class="text-muted">Không có nội dung tin nhắn</em>
                                        @endif
                                    </div>
                                </div>

                                @if($contact['admin_notes'] ?? false)
                                <div class="mb-4">
                                    <h5>Ghi chú của admin</h5>
                                    <hr>
                                    <div class="p-3 bg-warning bg-opacity-10 border border-warning rounded">
                                        {!! nl2br(e($contact['admin_notes'])) !!}
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <div class="mb-4">
                                    <h5>Thông tin thời gian</h5>
                                    <hr>
                                    <p><strong>Ngày gửi:</strong><br>
                                        {{ isset($contact['created_at']) ? \Carbon\Carbon::parse($contact['created_at'])->format('d/m/Y H:i:s') : 'N/A' }}
                                    </p>
                                    <p><strong>Cập nhật lần cuối:</strong><br>
                                        {{ isset($contact['updated_at']) ? \Carbon\Carbon::parse($contact['updated_at'])->format('d/m/Y H:i:s') : 'N/A' }}
                                    </p>
                                </div>

                                <div class="mb-4">
                                    <h5>Thao tác nhanh</h5>
                                    <hr>
                                    @can('access_users')
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary" onclick="updateContactStatus({{ $contact['id'] }}, 'read')">
                                                <i class="bi bi-eye"></i> Đánh dấu đã đọc
                                            </button>
                                            <button type="button" class="btn btn-outline-success" onclick="updateContactStatus({{ $contact['id'] }}, 'replied')">
                                                <i class="bi bi-reply"></i> Đánh dấu đã trả lời
                                            </button>
                                            <button type="button" class="btn btn-outline-secondary" onclick="updateContactStatus({{ $contact['id'] }}, 'closed')">
                                                <i class="bi bi-x-circle"></i> Đóng liên hệ
                                            </button>
                                            <hr>
                                            <button type="button" class="btn btn-outline-info" 
                                                    data-name="{{ $contact['name'] }}"
                                                    data-email="{{ $contact['email'] }}"
                                                    data-phone="{{ $contact['phone'] ?? '' }}"
                                                    onclick="sendReviewEmail(this)">
                                                <i class="bi bi-star-half"></i> Gửi link đánh giá
                                            </button>
                                            <button type="button" class="btn btn-outline-danger" onclick="deleteContact({{ $contact['id'] }})">
                                                <i class="bi bi-trash"></i> Xóa liên hệ
                                            </button>
                                        </div>
                                    @endcan
                                </div>

                                @if($contact['is_featured'] ?? false)
                                <div class="mb-4">
                                    <div class="alert alert-warning">
                                        <i class="bi bi-star-fill"></i> <strong>Liên hệ nổi bật</strong>
                                        <p class="mb-0 small">Liên hệ này được đánh dấu là nổi bật</p>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for adding admin notes -->
    <div class="modal fade" id="adminNotesModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm ghi chú admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="adminNotesForm">
                        <div class="mb-3">
                            <label for="adminNotes" class="form-label">Ghi chú</label>
                            <textarea class="form-control" id="adminNotes" name="admin_notes" rows="4" placeholder="Nhập ghi chú của admin...">{{ $contact['admin_notes'] ?? '' }}</textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" onclick="saveAdminNotes()">Lưu ghi chú</button>
                </div>
            </div>
        </div>
    </div>
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

function openEditContactModal(contactId) {
    window.contactsModal.openEditModal(contactId);
}

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
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi cập nhật trạng thái');
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
                    setTimeout(() => {
                        window.location.href = '{{ route("admin.driver.contacts.index") }}';
                    }, 1500);
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

function saveAdminNotes() {
    const notes = $('#adminNotes').val();
    const contactId = {{ $contact['id'] }};
    
    $.ajax({
        url: `/admin/driver/contacts/${contactId}/status`,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: '{{ $contact['status'] }}',
            admin_notes: notes
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', 'Ghi chú đã được lưu thành công');
                $('#adminNotesModal').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function() {
            showAlert('danger', 'Có lỗi xảy ra khi lưu ghi chú');
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
    
    // Insert at top of card body
    $('.card-body').prepend(alertHtml);
    
    // Auto hide after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut();
    }, 5000);
}
</script>
@endsection
