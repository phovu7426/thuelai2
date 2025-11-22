{{-- Form cho Testimonials Modal --}}
@csrf

@php
    $statusValue = $status ?? old('status', true);
    $featuredValue = $featured ?? old('featured', false);
    $ratingValue = $rating ?? old('rating', 5);
@endphp

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="customer_name" class="form-label">
                <i class="bi bi-person"></i> Tên khách hàng <span class="text-danger">*</span>
            </label>
            <input type="text" name="customer_name" id="customer_name" class="form-control"
                   placeholder="👤 Nhập tên khách hàng..." 
                   value="{{ $customer_name ?? old('customer_name') }}" 
                   required>
            <div class="invalid-feedback" id="customer_nameError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="customer_position" class="form-label">
                <i class="bi bi-briefcase"></i> Chức vụ
            </label>
            <input type="text" name="customer_position" id="customer_position" class="form-control"
                   placeholder="💼 Nhập chức vụ..." 
                   value="{{ $customer_position ?? old('customer_position') }}">
            <div class="invalid-feedback" id="customer_positionError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="rating" class="form-label">
                <i class="bi bi-star"></i> Đánh giá <span class="text-danger">*</span>
            </label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">⭐ Chọn số sao</option>
                <option value="1" {{ ($ratingValue ?? '') == '1' ? 'selected' : '' }}>1 sao</option>
                <option value="2" {{ ($ratingValue ?? '') == '2' ? 'selected' : '' }}>2 sao</option>
                <option value="3" {{ ($ratingValue ?? '') == '3' ? 'selected' : '' }}>3 sao</option>
                <option value="4" {{ ($ratingValue ?? '') == '4' ? 'selected' : '' }}>4 sao</option>
                <option value="5" {{ ($ratingValue ?? '') == '5' ? 'selected' : '' }}>5 sao</option>
            </select>
            <div class="invalid-feedback" id="ratingError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Hình ảnh" :value="$image ?? old('image')" />
            <small class="text-muted">Hỗ trợ: JPG, PNG, GIF (tối đa 2MB)</small>
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>

    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">
                <i class="bi bi-chat-text"></i> Nội dung đánh giá <span class="text-danger">*</span>
            </label>
            <textarea name="content" id="content" class="form-control" rows="5"
                      placeholder="💬 Nhập nội dung đánh giá..." 
                      required>{{ $content ?? old('content') }}</textarea>
            <div class="invalid-feedback" id="contentError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="status" id="status" class="form-check-input" 
                       value="1" {{ ($statusValue ?? true) ? 'checked' : '' }}>
                <label for="status" class="form-check-label">
                    <i class="bi bi-check-circle"></i> Kích hoạt
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="featured" id="featured" class="form-check-input" 
                       value="1" {{ ($featuredValue ?? false) ? 'checked' : '' }}>
                <label for="featured" class="form-check-label">
                    <i class="bi bi-star"></i> Nổi bật
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Character counter for content
    $('#content').on('input', function() {
        const maxLength = 500;
        const currentLength = $(this).val().length;
        const remaining = maxLength - currentLength;
        
        if (!$(this).next('.char-counter').length) {
            $(this).after('<small class="form-text text-muted char-counter"></small>');
        }
        
        $(this).next('.char-counter').text(`${currentLength}/${maxLength} ký tự`);
        
        if (remaining < 0) {
            $(this).next('.char-counter').addClass('text-danger');
        } else {
            $(this).next('.char-counter').removeClass('text-danger');
        }
    });

    // Rating preview
    $('#rating').on('change', function() {
        const rating = parseInt($(this).val());
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="bi bi-star-fill text-warning"></i>';
            } else {
                stars += '<i class="bi bi-star text-muted"></i>';
            }
        }
        
        if (!$(this).next('.rating-preview').length) {
            $(this).after('<div class="rating-preview mt-1"></div>');
        }
        $(this).next('.rating-preview').html(stars);
    });

    // Trigger rating preview on load if value exists
    if ($('#rating').val()) {
        $('#rating').trigger('change');
    }
});
</script>

<style>
.char-counter {
    font-size: 12px;
}

.rating-preview {
    font-size: 14px;
}

.text-danger {
    color: #dc3545 !important;
}
</style>
