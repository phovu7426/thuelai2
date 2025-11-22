{{-- Form cho Distance Tiers Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-arrows-move"></i> Tên khoảng cách <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên khoảng cách..."
                value="{{ $name ?? old('name') }}" required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="distance_range" class="form-label">
                <i class="bi bi-rulers"></i> Khoảng cách <span class="text-danger">*</span>
            </label>
            <input type="text" name="distance_range" id="distance_range" class="form-control"
                placeholder="Ví dụ: 0-5km, 5-10km..." value="{{ $display_text ?? old('distance_range') }}" required>
            <div class="invalid-feedback" id="distance_rangeError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="display_text" class="form-label">
                <i class="bi bi-type"></i> Text hiển thị <span class="text-danger">*</span>
            </label>
            <input type="text" name="display_text" id="display_text" class="form-control"
                placeholder="Ví dụ: Gần, Trung bình, Xa..." value="{{ $display_text ?? old('display_text') }}" required>
            <div class="invalid-feedback" id="display_textError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                placeholder="Nhập thứ tự sắp xếp..." value="{{ $sort_order ?? old('sort_order', 0) }}" min="0">
            <div class="invalid-feedback" id="sort_orderError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-12">
        <div class="mb-3">
            <label for="description" class="form-label">
                <i class="bi bi-text-paragraph"></i> Mô tả
            </label>
            <textarea name="description" id="description" class="form-control" rows="3"
                placeholder="Nhập mô tả khoảng cách...">{{ $description ?? old('description') }}</textarea>
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
                <option value="0" {{ ($is_active ?? old('is_active', 1)) == '0' ? 'selected' : '' }}>
                    Tạm dừng</option>
                <option value="1" {{ ($is_active ?? old('is_active', 1)) == '1' ? 'selected' : '' }}>
                    Hoạt động</option>
            </select>
            <div class="invalid-feedback" id="is_activeError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_highlighted" id="is_highlighted" class="form-check-input" value="1"
                    {{ $is_highlighted ?? old('is_highlighted') ? 'checked' : '' }}>
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
                placeholder="Nhập khoảng cách tối thiểu..." value="{{ $from_distance ?? old('min_distance', 0) }}"
                min="0" step="0.1">
            <div class="invalid-feedback" id="min_distanceError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="max_distance" class="form-label">
                <i class="bi bi-arrow-up"></i> Khoảng cách tối đa (km)
            </label>
            <input type="number" name="max_distance" id="max_distance" class="form-control"
                placeholder="Nhập khoảng cách tối đa..." value="{{ $to_distance ?? old('max_distance') }}"
                min="0" step="0.1">
            <div class="invalid-feedback" id="max_distanceError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
    $(document).ready(function() {
        // Auto-generate display text from name
        $('#name').on('input', function() {
            const name = $(this).val();
            if (name && !$('#display_text').val()) {
                $('#display_text').val(name);
            }
        });

        // Auto-generate distance range from min/max
        $('#min_distance, #max_distance').on('input', function() {
            const minDistance = $('#min_distance').val();
            const maxDistance = $('#max_distance').val();

            if (minDistance && maxDistance) {
                const range = `${minDistance}-${maxDistance}km`;
                $('#distance_range').val(range);
            }
        });

        // Validate distance range
        $('#distance_range').on('input', function() {
            const range = $(this).val();
            if (range && !/^\d+(\.\d+)?-\d+(\.\d+)?km$/.test(range)) {
                $('#distance_rangeError').text('Định dạng: số-sốkm (ví dụ: 0-5km)');
                $(this).addClass('is-invalid');
            } else {
                $('#distance_rangeError').text('');
                $(this).removeClass('is-invalid');
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
    });
</script>
