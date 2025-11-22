{{-- Form cho Pricing Tiers Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="distance_tier_id" class="form-label">
                <i class="bi bi-arrows-move"></i> Khoảng cách <span class="text-danger">*</span>
            </label>
            <select name="distance_tier_id" id="distance_tier_id" class="form-control" required>
                <option value="">Chọn khoảng cách</option>
                @foreach ($distanceTiers ?? [] as $tier)
                    <option value="{{ $tier->id }}"
                        {{ ($data['distance_tier_id'] ?? old('distance_tier_id')) == $tier->id ? 'selected' : '' }}>
                        {{ $tier->name }} ({{ $tier->distance_range }})
                    </option>
                @endforeach
            </select>
            <div class="invalid-feedback" id="distance_tier_idError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="time_slot" class="form-label">
                <i class="bi bi-clock"></i> Khung giờ <span class="text-danger">*</span>
            </label>
            <select name="time_slot" id="time_slot" class="form-control" required>
                <option value="">Chọn khung giờ</option>
                <option value="morning" {{ ($data['time_slot'] ?? old('time_slot')) == 'morning' ? 'selected' : '' }}>
                    Sáng (6:00 - 12:00)</option>
                <option value="afternoon"
                    {{ ($data['time_slot'] ?? old('time_slot')) == 'afternoon' ? 'selected' : '' }}>Chiều (12:00 -
                    18:00)</option>
                <option value="evening" {{ ($data['time_slot'] ?? old('time_slot')) == 'evening' ? 'selected' : '' }}>
                    Tối (18:00 - 22:00)</option>
                <option value="night" {{ ($data['time_slot'] ?? old('time_slot')) == 'night' ? 'selected' : '' }}>Đêm
                    (22:00 - 6:00)</option>
            </select>
            <div class="invalid-feedback" id="time_slotError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="price_type" class="form-label">
                <i class="bi bi-currency-dollar"></i> Loại giá <span class="text-danger">*</span>
            </label>
            <select name="price_type" id="price_type" class="form-control" required>
                <option value="">Chọn loại giá</option>
                <option value="fixed" {{ ($data['price_type'] ?? old('price_type')) == 'fixed' ? 'selected' : '' }}>Giá
                    cố định</option>
                <option value="per_km" {{ ($data['price_type'] ?? old('price_type')) == 'per_km' ? 'selected' : '' }}>
                    Giá theo km</option>
            </select>
            <div class="invalid-feedback" id="price_typeError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="price" class="form-label">
                <i class="bi bi-cash"></i> Giá <span class="text-danger">*</span>
            </label>
            <div class="input-group">
                <input type="text" name="price" id="price" class="form-control"
                    placeholder="Nhập giá (số hoặc text)..." value="{{ $data['price'] ?? old('price') }}" required>
                <span class="input-group-text" id="price_unit">VNĐ</span>
            </div>
            <div class="invalid-feedback" id="priceError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Mô tả
            </label>
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập mô tả mức giá...">{{ $data['description'] ?? old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="is_active" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="is_active" id="is_active" class="form-control">
                <option value="0" {{ ($data['is_active'] ?? old('is_active', 1)) == '0' ? 'selected' : '' }}>Tạm
                    dừng</option>
                <option value="1" {{ ($data['is_active'] ?? old('is_active', 1)) == '1' ? 'selected' : '' }}>Hoạt
                    động</option>
            </select>
            <div class="invalid-feedback" id="is_activeError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_highlighted" id="is_highlighted" class="form-check-input" value="1"
                    {{ $data['is_highlighted'] ?? old('is_highlighted') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_highlighted">
                    <i class="bi bi-star"></i> Nổi bật
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="min_distance" class="form-label">
                <i class="bi bi-arrow-down"></i> Khoảng cách tối thiểu (km)
            </label>
            <input type="number" name="min_distance" id="min_distance" class="form-control"
                placeholder="Nhập khoảng cách tối thiểu..."
                value="{{ $data['min_distance'] ?? old('min_distance', 0) }}" min="0" step="0.1">
            <div class="invalid-feedback" id="min_distanceError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="max_distance" class="form-label">
                <i class="bi bi-arrow-up"></i> Khoảng cách tối đa (km)
            </label>
            <input type="number" name="max_distance" id="max_distance" class="form-control"
                placeholder="Nhập khoảng cách tối đa..." value="{{ $data['max_distance'] ?? old('max_distance') }}"
                min="0" step="0.1">
            <div class="invalid-feedback" id="max_distanceError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="time_icon" class="form-label">
                <i class="bi bi-emoji-smile"></i> Icon khung giờ
            </label>
            <input type="text" name="time_icon" id="time_icon" class="form-control"
                placeholder="Ví dụ: bi-sun, bi-moon..." value="{{ $data['time_icon'] ?? old('time_icon') }}">
            <div class="invalid-feedback" id="time_iconError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="time_color" class="form-label">
                <i class="bi bi-palette"></i> Màu khung giờ
            </label>
            <input type="color" name="time_color" id="time_color" class="form-control form-control-color"
                value="{{ $data['time_color'] ?? old('time_color', '#007bff') }}" title="Chọn màu cho khung giờ">
            <div class="invalid-feedback" id="time_colorError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
    $(document).ready(function() {
        // Update price unit based on price type
        $('#price_type').on('change', function() {
            const priceType = $(this).val();
            const priceUnit = $('#price_unit');

            if (priceType === 'fixed') {
                priceUnit.text('VNĐ');
            } else if (priceType === 'per_km') {
                priceUnit.text('VNĐ/km');
            }
        });

        // Auto-generate time icon based on time slot
        $('#time_slot').on('change', function() {
            const timeSlot = $(this).val();
            const timeIcon = $('#time_icon');
            const timeColor = $('#time_color');

            if (timeSlot === 'morning') {
                timeIcon.val('bi-sun');
                timeColor.val('#ffc107');
            } else if (timeSlot === 'afternoon') {
                timeIcon.val('bi-sun-fill');
                timeColor.val('#fd7e14');
            } else if (timeSlot === 'evening') {
                timeIcon.val('bi-moon');
                timeColor.val('#6f42c1');
            } else if (timeSlot === 'night') {
                timeIcon.val('bi-moon-fill');
                timeColor.val('#343a40');
            }
        });

        // Validate max distance > min distance
        $('#max_distance').on('input', function() {
            const minDistance = parseFloat($('#min_distance').val()) || 0;
            const maxDistance = parseFloat($(this).val()) || 0;

            if (maxDistance <= minDistance) {
                $('#max_distanceError').text('Khoảng cách tối đa phải lớn hơn tối thiểu');
                $(this).addClass('is-invalid');
            } else {
                $('#max_distanceError').text('');
                $(this).removeClass('is-invalid');
            }
        });

        // Validate price - now accepts both text and numbers
        $('#price').on('input', function() {
            const priceValue = $(this).val().trim();
            if (priceValue === '') {
                $('#priceError').text('Vui lòng nhập giá');
                $(this).addClass('is-invalid');
            } else {
                // If it's a number, check if it's negative
                if (!isNaN(priceValue) && parseFloat(priceValue) < 0) {
                    $('#priceError').text('Giá không được âm');
                    $(this).addClass('is-invalid');
                } else {
                    $('#priceError').text('');
                    $(this).removeClass('is-invalid');
                }
            }
        });
    });
</script>
