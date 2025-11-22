{{-- Form cho Contact Info Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="address" class="form-label">
                <i class="bi bi-geo-alt"></i> Địa chỉ
            </label>
            <input type="text" name="address" id="address" class="form-control"
                   placeholder="Nhập địa chỉ..."
                   value="{{ $address ?? old('address') }}">
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
                   value="{{ $phone ?? old('phone') }}">
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
                   value="{{ $email ?? old('email') }}">
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
                   value="{{ $working_time ?? old('working_time') }}">
            <div class="invalid-feedback" id="workingTimeError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="facebook" class="form-label">
                <i class="bi bi-facebook"></i> Facebook
            </label>
            <input type="url" name="facebook" id="facebook" class="form-control"
                   placeholder="https://facebook.com/..."
                   value="{{ $facebook ?? old('facebook') }}">
            <div class="invalid-feedback" id="facebookError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="instagram" class="form-label">
                <i class="bi bi-instagram"></i> Instagram
            </label>
            <input type="url" name="instagram" id="instagram" class="form-control"
                   placeholder="https://instagram.com/..."
                   value="{{ $instagram ?? old('instagram') }}">
            <div class="invalid-feedback" id="instagramError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="youtube" class="form-label">
                <i class="bi bi-youtube"></i> YouTube
            </label>
            <input type="url" name="youtube" id="youtube" class="form-control"
                   placeholder="https://youtube.com/..."
                   value="{{ $youtube ?? old('youtube') }}">
            <div class="invalid-feedback" id="youtubeError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="linkedin" class="form-label">
                <i class="bi bi-linkedin"></i> LinkedIn
            </label>
            <input type="url" name="linkedin" id="linkedin" class="form-control"
                   placeholder="https://linkedin.com/..."
                   value="{{ $linkedin ?? old('linkedin') }}">
            <div class="invalid-feedback" id="linkedinError"></div>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="map_embed" class="form-label">
                <i class="bi bi-map"></i> Mã nhúng bản đồ
            </label>
            <textarea name="map_embed" id="map_embed" class="form-control" rows="4"
                      placeholder="Nhập mã HTML embed từ Google Maps hoặc các dịch vụ bản đồ khác...">{{ $map_embed ?? old('map_embed') }}</textarea>
            <div class="invalid-feedback" id="mapEmbedError"></div>
            <small class="form-text text-muted">
                Bạn có thể lấy mã embed từ Google Maps: Tìm địa điểm → Chia sẻ → Nhúng bản đồ
            </small>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <x-uploads.file-upload name="pricing_background_image" label="Ảnh nền bảng giá" :value="$pricing_background_image ?? old('pricing_background_image')" />
            <div class="invalid-feedback" id="pricingBackgroundImageError"></div>
            <small class="form-text text-muted">
                Ảnh nền sẽ được hiển thị phía sau bảng giá trên trang chủ. Kích thước khuyến nghị: 1920x1080px
            </small>
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

    // Validate URL format for social media
    function validateUrl(inputId, errorId, fieldName) {
        $(`#${inputId}`).on('input', function() {
            const url = $(this).val();
            const urlRegex = /^https?:\/\/.+/;
            
            if (url && !urlRegex.test(url)) {
                $(`#${errorId}`).text(`${fieldName} phải bắt đầu bằng http:// hoặc https://`);
                $(this).addClass('is-invalid');
            } else {
                $(`#${errorId}`).text('');
                $(this).removeClass('is-invalid');
            }
        });
    }

    // Apply URL validation
    validateUrl('facebook', 'facebookError', 'Facebook URL');
    validateUrl('instagram', 'instagramError', 'Instagram URL');
    validateUrl('youtube', 'youtubeError', 'YouTube URL');
    validateUrl('linkedin', 'linkedinError', 'LinkedIn URL');

    // Preview map embed
    $('#map_embed').on('input', function() {
        const embedCode = $(this).val();
        if (embedCode.includes('<iframe') && embedCode.includes('</iframe>')) {
            // Valid iframe embed code
            $('#mapEmbedError').text('');
            $(this).removeClass('is-invalid');
        } else if (embedCode.trim() !== '') {
            $('#mapEmbedError').text('Mã nhúng không hợp lệ. Vui lòng sử dụng mã iframe từ Google Maps.');
            $(this).addClass('is-invalid');
        } else {
            $('#mapEmbedError').text('');
            $(this).removeClass('is-invalid');
        }
    });
});
</script>
