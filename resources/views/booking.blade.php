@extends('driver.layouts.main')

@section('page_title', 'Đặt Tài Xế - Dịch Vụ Lái Xe Thuê')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <!-- Page Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-primary mb-3">Đặt Tài Xế</h1>
                <p class="lead text-muted">Đặt xe nhanh chóng, an toàn và tiện lợi với dịch vụ lái xe thuê chuyên nghiệp</p>
            </div>

            <div class="card shadow-lg border-0" style="border-radius: 20px; background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);">
                <div class="card-body p-4 p-md-5">
                    <!-- Header Buttons -->
                    <div class="row mb-4">
                        <div class="col-6">
                            <button class="btn btn-warning w-100 fw-semibold" style="border-radius: 25px; padding: 12px 24px; transition: all 0.3s ease;">
                                <i class="fas fa-car me-2"></i>Di chuyển ngay
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-primary w-100 fw-semibold" style="border-radius: 25px; padding: 12px 24px; transition: all 0.3s ease;">
                                <i class="fas fa-map-marked-alt me-2"></i>Đặt đi tỉnh
                            </button>
                        </div>
                    </div>

                    <!-- Chọn vị trí -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fw-semibold text-dark fs-6">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Chọn vị trí
                            </span>
                            <span class="badge bg-primary rounded-pill">0 km</span>
                        </div>
                        <div class="position-relative">
                            <div class="position-absolute" style="left: 20px; top: 50px; width: 3px; height: 40px; background: linear-gradient(to bottom, #007bff, #0056b3); border-radius: 2px;"></div>
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="text" class="form-control border-2" id="from-location" placeholder="Bạn sẽ đi từ đâu?" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                                    <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                    </span>
                                </div>
                                <div class="error-message text-danger small mt-1" id="from-location-error" style="display: none;">Vui lòng nhập điểm đi</div>
                            </div>
                            <div class="position-relative">
                                <div class="input-group">
                                    <input type="text" class="form-control border-2" id="to-location" placeholder="Bạn sẽ đi đâu?" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                                    <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                                        <i class="fas fa-map-marker-alt text-danger"></i>
                                    </span>
                                    <button class="btn btn-success position-absolute end-0" style="width: 35px; height: 35px; border-radius: 50%; z-index: 20; top: 50%; transform: translateY(-50%); margin-right: 15px; transition: all 0.3s ease;">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <div class="error-message text-danger small mt-1" id="to-location-error" style="display: none;">Vui lòng nhập điểm đến</div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin khách hàng -->
                    <div class="mb-4">
                        <div class="fw-semibold text-dark fs-6 mb-3">
                            <i class="fas fa-user text-primary me-2"></i>Thông tin khách hàng
                        </div>
                        <div class="mb-3">
                            <div class="input-group">
                                <input type="text" class="form-control border-2" id="customer-name" placeholder="Tên Quý khách" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                                <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                                    <span style="font-size: 20px;">👋</span>
                                </span>
                            </div>
                            <div class="error-message text-danger small mt-1" id="customer-name-error" style="display: none;">Vui lòng nhập tên khách hàng</div>
                        </div>
                        <div>
                            <div class="input-group">
                                <input type="tel" class="form-control border-2" id="customer-phone" placeholder="Số điện thoại" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                                <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                                    <i class="fas fa-phone text-muted"></i>
                                </span>
                            </div>
                            <div class="error-message text-danger small mt-1" id="customer-phone-error" style="display: none;">Vui lòng nhập số điện thoại hợp lệ</div>
                        </div>
                    </div>

                    <!-- Chọn thời gian -->
                    <div class="mb-4">
                        <div class="fw-semibold text-dark fs-6 mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>Chọn thời gian bạn cần đón (tùy chọn)
                        </div>
                        <input type="datetime-local" class="form-control border-2" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                    </div>

                    <!-- Cước phí -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-semibold text-dark fs-6">
                                <i class="fas fa-money-bill-wave text-primary me-2"></i>Cước phí (tạm tính)
                            </span>
                            <span class="badge bg-success fs-6" id="fare-display">0 đ</span>
                        </div>
                    </div>

                    <!-- Nút đặt xe -->
                    <button class="btn btn-warning w-100 fw-bold" id="booking-btn" style="border-radius: 30px; padding: 18px 32px; font-size: 18px; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);">
                        <i class="fas fa-car me-2"></i>ĐẶT TÀI XẾ NGAY
                    </button>

                    <!-- Thông tin tài xế -->
                    <div class="text-center mt-3">
                        <small class="text-danger">
                            <i class="fas fa-clock me-2"></i>Tài xế sẽ qua trong khoảng 10p
                        </small>
                    </div>
                </div>
            </div>

            <!-- Thông tin bổ sung -->
            <div class="row mt-5">
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <i class="fas fa-shield-alt text-primary fa-2x"></i>
                    </div>
                    <h5 class="fw-semibold">An Toàn Tuyệt Đối</h5>
                    <p class="text-muted small">Tài xế được kiểm duyệt kỹ lưỡng, xe đời mới, bảo hiểm đầy đủ</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);">
                        <i class="fas fa-clock text-primary fa-2x"></i>
                    </div>
                    <h5 class="fw-semibold">Nhanh Chóng 24/7</h5>
                    <p class="text-muted small">Đặt xe trong 30 giây, tài xế đến trong 10 phút, phục vụ mọi lúc</p>
                </div>
                <div class="col-md-4 text-center mb-4">
                    <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #fff3e0 0%, #ffcc02 100%);">
                        <i class="fas fa-dollar-sign text-primary fa-2x"></i>
                    </div>
                    <h5 class="fw-semibold">Giá Cả Minh Bạch</h5>
                    <p class="text-muted small">Không phụ phí, giá cố định, báo giá trước khi đi</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Validation functions
    function validateField(field, errorElement, validationRule) {
        const value = field.value.trim();
        let isValid = true;
        let errorMessage = '';
        
        // Remove previous error state
        field.classList.remove('border-danger');
        errorElement.style.display = 'none';
        
        // Check if empty
        if (!value) {
            isValid = false;
            errorMessage = errorElement.textContent;
        } else {
            // Specific validation rules
            switch(validationRule) {
                case 'phone':
                    const phoneRegex = /^(0|\+84)[3|5|7|8|9][0-9]{8}$/;
                    if (!phoneRegex.test(value)) {
                        isValid = false;
                        errorMessage = 'Số điện thoại không hợp lệ (VD: 0987654321)';
                    }
                    break;
                case 'name':
                    if (value.length < 2) {
                        isValid = false;
                        errorMessage = 'Tên phải có ít nhất 2 ký tự';
                    }
                    break;
                case 'location':
                    if (value.length < 5) {
                        isValid = false;
                        errorMessage = 'Địa chỉ phải có ít nhất 5 ký tự';
                    }
                    break;
            }
        }
        
        // Show error if invalid
        if (!isValid) {
            field.classList.add('border-danger');
            errorElement.textContent = errorMessage;
            errorElement.style.display = 'block';
        }
        
        return isValid;
    }
    
    function validateForm() {
        const fromLocation = document.getElementById('from-location');
        const toLocation = document.getElementById('to-location');
        const customerName = document.getElementById('customer-name');
        const customerPhone = document.getElementById('customer-phone');
        
        const fromLocationError = document.getElementById('from-location-error');
        const toLocationError = document.getElementById('to-location-error');
        const customerNameError = document.getElementById('customer-name-error');
        const customerPhoneError = document.getElementById('customer-phone-error');
        
        const isFromLocationValid = validateField(fromLocation, fromLocationError, 'location');
        const isToLocationValid = validateField(toLocation, toLocationError, 'location');
        const isCustomerNameValid = validateField(customerName, customerNameError, 'name');
        const isCustomerPhoneValid = validateField(customerPhone, customerPhoneError, 'phone');
        
        return isFromLocationValid && isToLocationValid && isCustomerNameValid && isCustomerPhoneValid;
    }
    
    // Xử lý thay đổi loại dịch vụ
    document.querySelectorAll('.btn-warning, .btn-primary').forEach(btn => {
        btn.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.btn-warning, .btn-primary').forEach(b => {
                b.classList.remove('active');
            });
            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Xử lý thêm điểm dừng
    document.querySelector('.btn-success').addEventListener('click', function() {
        const locationInputs = document.querySelector('.position-relative');
        const newInput = document.createElement('div');
        newInput.className = 'mb-3';
        newInput.innerHTML = `
            <div class="input-group">
                <input type="text" class="form-control border-2" placeholder="Điểm dừng thêm" style="border-radius: 15px; padding: 15px 20px; font-size: 16px; border-color: #e9ecef;">
                <span class="input-group-text border-0 bg-transparent position-absolute end-0" style="z-index: 10;">
                    <i class="fas fa-map-marker-alt text-danger"></i>
                </span>
            </div>
        `;
        
        // Insert before the last input
        const lastInput = locationInputs.querySelector('.position-relative:last-child');
        locationInputs.insertBefore(newInput, lastInput);
    });

    // Xử lý tính toán cước phí (demo)
    function calculateFare() {
        const fromLocation = document.getElementById('from-location').value;
        const toLocation = document.getElementById('to-location').value;
        
        if (fromLocation && toLocation) {
            // Demo calculation - random fare between 50,000 - 200,000 VND
            const randomFare = Math.floor(Math.random() * 150000) + 50000;
            document.getElementById('fare-display').textContent = randomFare.toLocaleString('vi-VN') + ' đ';
        }
    }

    // Add event listeners for fare calculation
    document.getElementById('from-location').addEventListener('input', calculateFare);
    document.getElementById('to-location').addEventListener('input', calculateFare);
    
    // Function to show all validation errors
    function showAllErrors() {
        const fromLocation = document.getElementById('from-location');
        const toLocation = document.getElementById('to-location');
        const customerName = document.getElementById('customer-name');
        const customerPhone = document.getElementById('customer-phone');
        
        const fromLocationError = document.getElementById('from-location-error');
        const toLocationError = document.getElementById('to-location-error');
        const customerNameError = document.getElementById('customer-name-error');
        const customerPhoneError = document.getElementById('customer-phone-error');
        
        // Force validation display for all fields
        validateField(fromLocation, fromLocationError, 'location');
        validateField(toLocation, toLocationError, 'location');
        validateField(customerName, customerNameError, 'name');
        validateField(customerPhone, customerPhoneError, 'phone');
    }
    
    // Handle booking submission
    document.getElementById('booking-btn').addEventListener('click', function() {
        // Show all errors first
        showAllErrors();
        
        if (validateForm()) {
            // Show success message
            alert('Đặt xe thành công! Tài xế sẽ liên hệ với bạn trong thời gian sớm nhất.');
            
            // Reset form
            document.getElementById('from-location').value = '';
            document.getElementById('to-location').value = '';
            document.getElementById('customer-name').value = '';
            document.getElementById('customer-phone').value = '';
            document.getElementById('fare-display').textContent = '0 đ';
            
            // Hide all error messages
            document.querySelectorAll('.error-message').forEach(error => {
                error.style.display = 'none';
            });
            
            // Remove error styling
            document.querySelectorAll('.border-danger').forEach(input => {
                input.classList.remove('border-danger');
            });
        }
    });

    // Add hover effects for buttons
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
</script>
@endsection
