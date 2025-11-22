{{-- Form cho Driver Pricing Rules Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="name" class="form-label">
                <i class="bi bi-tag"></i> Tên quy tắc <span class="text-danger">*</span>
            </label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Nhập tên quy tắc..."
                value="{{ isset($data['name']) ? $data['name'] : old('name') }}" required>
            <div class="invalid-feedback" id="nameError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="type" class="form-label">
                <i class="bi bi-gear"></i> Loại quy tắc <span class="text-danger">*</span>
            </label>
            <select name="type" id="type" class="form-control" required>
                <option value="">Chọn loại quy tắc</option>
                <option value="distance"
                    {{ (isset($data['type']) ? $data['type'] : old('type')) == 'distance' ? 'selected' : '' }}>Theo
                    khoảng cách</option>
                <option value="time"
                    {{ (isset($data['type']) ? $data['type'] : old('type')) == 'time' ? 'selected' : '' }}>Theo thời
                    gian</option>
                <option value="special"
                    {{ (isset($data['type']) ? $data['type'] : old('type')) == 'special' ? 'selected' : '' }}>Đặc biệt
                </option>
            </select>
            <div class="invalid-feedback" id="typeError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="base_price" class="form-label">
                <i class="bi bi-currency-dollar"></i> Giá cơ bản <span class="text-danger">*</span>
            </label>
            <input type="text" name="base_price" id="base_price" class="form-control"
                placeholder="Nhập giá cơ bản (số hoặc text)..."
                value="{{ isset($data['base_price']) ? $data['base_price'] : old('base_price') }}" required>
            <div class="invalid-feedback" id="base_priceError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="price_per_unit" class="form-label">
                <i class="bi bi-currency-dollar"></i> Giá theo đơn vị
            </label>
            <input type="text" name="price_per_unit" id="price_per_unit" class="form-control"
                placeholder="Nhập giá theo đơn vị (số hoặc text)..."
                value="{{ isset($data['price_per_unit']) ? $data['price_per_unit'] : old('price_per_unit') }}">
            <div class="invalid-feedback" id="price_per_unitError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="unit" class="form-label">
                <i class="bi bi-rulers"></i> Đơn vị
            </label>
            <select name="unit" id="unit" class="form-control">
                <option value="">Chọn đơn vị</option>
                <option value="km"
                    {{ (isset($data['unit']) ? $data['unit'] : old('unit')) == 'km' ? 'selected' : '' }}>Kilometer
                </option>
                <option value="hour"
                    {{ (isset($data['unit']) ? $data['unit'] : old('unit')) == 'hour' ? 'selected' : '' }}>Giờ</option>
                <option value="day"
                    {{ (isset($data['unit']) ? $data['unit'] : old('unit')) == 'day' ? 'selected' : '' }}>Ngày</option>
            </select>
            <div class="invalid-feedback" id="unitError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="min_value" class="form-label">
                <i class="bi bi-arrow-down"></i> Giá trị tối thiểu
            </label>
            <input type="text" name="min_value" id="min_value" class="form-control"
                placeholder="Nhập giá trị tối thiểu (số hoặc text)..."
                value="{{ isset($data['min_value']) ? $data['min_value'] : old('min_value') }}">
            <div class="invalid-feedback" id="min_valueError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="max_value" class="form-label">
                <i class="bi bi-arrow-up"></i> Giá trị tối đa
            </label>
            <input type="text" name="max_value" id="max_value" class="form-control"
                placeholder="Nhập giá trị tối đa (số hoặc text)..."
                value="{{ isset($data['max_value']) ? $data['max_value'] : old('max_value') }}">
            <div class="invalid-feedback" id="max_valueError"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự sắp xếp
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                placeholder="Nhập thứ tự sắp xếp..."
                value="{{ isset($data['sort_order']) ? $data['sort_order'] : old('sort_order', 0) }}" min="0">
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
                placeholder="Nhập mô tả quy tắc...">{{ isset($data['description']) ? $data['description'] : old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1"
                    {{ (isset($data['is_active']) ? $data['is_active'] : old('is_active', true)) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">
                    <i class="bi bi-toggle-on"></i> Kích hoạt
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_default" id="is_default" class="form-check-input" value="1"
                    {{ (isset($data['is_default']) ? $data['is_default'] : old('is_default')) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_default">
                    <i class="bi bi-star"></i> Mặc định
                </label>
            </div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
    $(document).ready(function() {
        // Auto-hide max_value khi type là special
        $('#type').change(function() {
            if ($(this).val() === 'special') {
                $('.col-md-6:has(#max_value)').hide();
                $('.col-md-6:has(#min_value)').hide();
                $('.col-md-6:has(#unit)').hide();
            } else {
                $('.col-md-6:has(#max_value)').show();
                $('.col-md-6:has(#min_value)').show();
                $('.col-md-6:has(#unit)').show();
            }
        });

        // Trigger change event on load
        $('#type').trigger('change');
    });
</script>
