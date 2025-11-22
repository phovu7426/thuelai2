{{-- Form cho Contacts Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-person"></i> Tên khách hàng <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control"
                   placeholder="Nhập tên khách hàng..."
                   value="{{ $name ?? old('name') }}"
                   required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="email" class="form-label">
                <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
            </label>
            <input type="email" name="email" id="email" class="form-control"
                   placeholder="Nhập email..."
                   value="{{ $email ?? old('email') }}"
                   required>
            <div class="invalid-feedback" id="emailError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="phone" class="form-label">
                <i class="bi bi-telephone"></i> Số điện thoại <span class="text-danger">*</span>
            </label>
            <input type="tel" name="phone" id="phone" class="form-control"
                   placeholder="Nhập số điện thoại..."
                   value="{{ $phone ?? old('phone') }}"
                   required>
            <div class="invalid-feedback" id="phoneError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="topic" class="form-label">
                <i class="bi bi-tags"></i> Chủ đề <span class="text-danger">*</span>
            </label>
            <select name="topic" id="topic" class="form-control" required>
                <option value="">Chọn chủ đề</option>
                <option value="khiếu nại" {{ ($topic ?? old('topic')) == 'khiếu nại' ? 'selected' : '' }}>Khiếu nại</option>
                <option value="tư vấn dịch vụ" {{ ($topic ?? old('topic')) == 'tư vấn dịch vụ' ? 'selected' : '' }}>Tư vấn dịch vụ</option>
                <option value="phản hồi" {{ ($topic ?? old('topic')) == 'phản hồi' ? 'selected' : '' }}>Phản hồi</option>
                <option value="khác" {{ ($topic ?? old('topic')) == 'khác' ? 'selected' : '' }}>Khác</option>
            </select>
            <div class="invalid-feedback" id="topicError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="subject" class="form-label">
                <i class="bi bi-type"></i> Tiêu đề
            </label>
            <input type="text" name="subject" id="subject" class="form-control"
                   placeholder="Nhập tiêu đề liên hệ..."
                   value="{{ $subject ?? old('subject') }}">
            <div class="invalid-feedback" id="subjectError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="message" class="form-label">
                <i class="bi bi-chat-text"></i> Nội dung tin nhắn <span class="text-danger">*</span>
            </label>
            <textarea name="message" id="message" class="form-control" rows="5"
                      placeholder="Nhập nội dung tin nhắn...">{{ $message ?? old('message') }}</textarea>
            <div class="invalid-feedback" id="messageError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="status" id="status" class="form-control">
                <option value="unread" {{ ($status ?? old('status')) == 'unread' ? 'selected' : '' }}>Chưa đọc</option>
                <option value="read" {{ ($status ?? old('status')) == 'read' ? 'selected' : '' }}>Đã đọc</option>
                <option value="replied" {{ ($status ?? old('status')) == 'replied' ? 'selected' : '' }}>Đã trả lời</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="priority" class="form-label">
                <i class="bi bi-flag"></i> Độ ưu tiên
            </label>
            <select name="priority" id="priority" class="form-control">
                <option value="low" {{ ($priority ?? old('priority')) == 'low' ? 'selected' : '' }}>Thấp</option>
                <option value="medium" {{ ($priority ?? old('priority')) == 'medium' ? 'selected' : '' }}>Trung bình</option>
                <option value="high" {{ ($priority ?? old('priority')) == 'high' ? 'selected' : '' }}>Cao</option>
                <option value="urgent" {{ ($priority ?? old('priority')) == 'urgent' ? 'selected' : '' }}>Khẩn cấp</option>
            </select>
            <div class="invalid-feedback" id="priorityError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="pickup_location" class="form-label">
                <i class="bi bi-geo-alt"></i> Điểm đón
            </label>
            <input type="text" name="pickup_location" id="pickup_location" class="form-control"
                   placeholder="Nhập điểm đón..."
                   value="{{ $pickup_location ?? old('pickup_location') }}">
            <div class="invalid-feedback" id="pickup_locationError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="dropoff_location" class="form-label">
                <i class="bi bi-geo-alt-fill"></i> Điểm đến
            </label>
            <input type="text" name="dropoff_location" id="dropoff_location" class="form-control"
                   placeholder="Nhập điểm đến..."
                   value="{{ $dropoff_location ?? old('dropoff_location') }}">
            <div class="invalid-feedback" id="dropoff_locationError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="pickup_date" class="form-label">
                <i class="bi bi-calendar-event"></i> Ngày đón
            </label>
            <input type="datetime-local" name="pickup_date" id="pickup_date" class="form-control"
                   value="{{ $pickup_date ?? old('pickup_date') }}">
            <div class="invalid-feedback" id="pickup_dateError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="passengers" class="form-label">
                <i class="bi bi-people"></i> Số hành khách
            </label>
            <input type="number" name="passengers" id="passengers" class="form-control"
                   placeholder="Nhập số hành khách..."
                   value="{{ $passengers ?? old('passengers', 1) }}"
                   min="1" max="10">
            <div class="invalid-feedback" id="passengersError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="notes" class="form-label">
                <i class="bi bi-sticky"></i> Ghi chú
            </label>
            <textarea name="notes" id="notes" class="form-control" rows="3"
                      placeholder="Nhập ghi chú...">{{ $notes ?? old('notes') }}</textarea>
            <div class="invalid-feedback" id="notesError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Validate email format
    $('#email').on('input', function() {
        const email = $(this).val();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email && !emailRegex.test(email)) {
            $('#emailError').text('Email không hợp lệ');
            $(this).addClass('is-invalid');
        } else {
            $('#emailError').text('');
            $(this).removeClass('is-invalid');
        }
    });
    
    // Validate phone format
    $('#phone').on('input', function() {
        const phone = $(this).val();
        const phoneRegex = /^[0-9+\-\s()]+$/;
        
        if (phone && !phoneRegex.test(phone)) {
            $('#phoneError').text('Số điện thoại không hợp lệ');
            $(this).addClass('is-invalid');
        } else {
            $('#phoneError').text('');
            $(this).removeClass('is-invalid');
        }
    });
    
    // Auto-generate subject from message
    $('#message').on('input', function() {
        const message = $(this).val();
        if (message && !$('#subject').val()) {
            const subject = message.length > 50 ? message.substring(0, 47) + '...' : message;
            $('#subject').val(subject);
        }
    });
    
    // Auto-fill subject based on topic
    $('#topic').on('change', function() {
        const topic = $(this).val();
        const subject = $('#subject');
        
        if (!subject.val()) {
            switch(topic) {
                case 'khiếu nại':
                    subject.val('Khiếu nại dịch vụ');
                    break;
                case 'tư vấn dịch vụ':
                    subject.val('Yêu cầu tư vấn dịch vụ');
                    break;
                case 'phản hồi':
                    subject.val('Phản hồi dịch vụ');
                    break;
                default:
                    subject.val('Liên hệ chung');
            }
        }
    });
    
    // Validate pickup date
    $('#pickup_date').on('change', function() {
        const pickupDate = new Date($(this).val());
        const now = new Date();
        
        if (pickupDate < now) {
            $('#pickup_dateError').text('Ngày đón không được trong quá khứ');
            $(this).addClass('is-invalid');
        } else {
            $('#pickup_dateError').text('');
            $(this).removeClass('is-invalid');
        }
    });
    
    // Validate passengers
    $('#passengers').on('input', function() {
        const passengers = parseInt($(this).val()) || 0;
        if (passengers < 1 || passengers > 10) {
            $('#passengersError').text('Số hành khách phải từ 1-10');
            $(this).addClass('is-invalid');
        } else {
            $('#passengersError').text('');
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
