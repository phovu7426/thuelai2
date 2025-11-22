<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Admin Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Test Admin Contact Form</h1>
        
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-telephone-fill"></i> Cấu hình thông tin liên hệ
                        </h3>
                    </div>
                    <div class="card-body">
                        @php
                            $service = app(\App\Services\Admin\ContactInfoService::class);
                            $contactInfo = $service->getFirstOrCreate();
                        @endphp
                        
                        <form id="contactInfoForm" method="POST" action="{{ route('admin.contact-info.store') }}">
                            @csrf
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">
                                            <i class="bi bi-geo-alt"></i> Địa chỉ
                                        </label>
                                        <input type="text" name="address" id="address" class="form-control"
                                               placeholder="Nhập địa chỉ..."
                                               value="{{ $contactInfo->address ?? old('address') }}">
                                        <div class="invalid-feedback" id="addressError"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">
                                            <i class="bi bi-telephone"></i> Số điện thoại
                                        </label>
                                        <input type="text" name="phone" id="phone" class="form-control"
                                               placeholder="Nhập số điện thoại..."
                                               value="{{ $contactInfo->phone ?? old('phone') }}">
                                        <div class="invalid-feedback" id="phoneError"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">
                                            <i class="bi bi-envelope"></i> Email
                                        </label>
                                        <input type="email" name="email" id="email" class="form-control"
                                               placeholder="Nhập email..."
                                               value="{{ $contactInfo->email ?? old('email') }}">
                                        <div class="invalid-feedback" id="emailError"></div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="working_time" class="form-label">
                                            <i class="bi bi-clock"></i> Thời gian làm việc
                                        </label>
                                        <input type="text" name="working_time" id="working_time" class="form-control"
                                               placeholder="Ví dụ: 8:00 - 17:00 (Thứ 2 - Thứ 6)"
                                               value="{{ $contactInfo->working_time ?? old('working_time') }}">
                                        <div class="invalid-feedback" id="workingTimeError"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Cập nhật thông tin
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Setup CSRF token for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Handle form submission
        $('#contactInfoForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();

            // Debug: Log form data
            console.log('Form submission started');
            console.log('Form action:', $(this).attr('action'));
            
            // Disable submit button
            submitBtn.prop('disabled', true).html(
                '<i class="spinner-border spinner-border-sm me-2"></i>Đang cập nhật...');

            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('AJAX Success:', response);
                    
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        toastr.success(response.message || 'Cập nhật thông tin liên hệ thành công');

                        // Reload trang sau 1.5 giây để hiển thị dữ liệu mới
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        // Hiển thị lỗi
                        toastr.error(response.message || 'Có lỗi xảy ra');
                    }
                },
                error: function(xhr) {
                    console.log('AJAX Error:', xhr);
                    
                    let message = 'Có lỗi xảy ra khi cập nhật thông tin liên hệ';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        message = xhr.responseJSON.message;
                    }

                    // Hiển thị lỗi
                    toastr.error(message);
                },
                complete: function() {
                    // Re-enable submit button
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        });
    });
    </script>
</body>
</html>
