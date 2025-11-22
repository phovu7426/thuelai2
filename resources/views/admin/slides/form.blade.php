{{-- Form cho Slides Modal --}}
@csrf

<div class="row g-3">
    <div class="col-md-8">
        <div class="mb-3">
            <label for="title" class="form-label">
                <i class="bi bi-type"></i> Tiêu đề <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control"
                   placeholder="Nhập tiêu đề slide..."
                   value="{{ $data['title'] ?? old('title') }}"
                   required>
            <div class="invalid-feedback" id="titleError"></div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="mb-3">
            <label for="sort_order" class="form-label">
                <i class="bi bi-sort-numeric-down"></i> Thứ tự
            </label>
            <input type="number" name="sort_order" id="sort_order" class="form-control"
                   placeholder="Nhập thứ tự..."
                   value="{{ $data['sort_order'] ?? old('sort_order', 0) }}"
                   min="0">
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
            <textarea name="description" id="description" class="form-control" rows="3" placeholder="Nhập mô tả slide...">{{ $data['description'] ?? old('description') }}</textarea>
            <div class="invalid-feedback" id="descriptionError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Hình ảnh" :value="isset($data['image']) && $data['image'] ? asset('storage/' . $data['image']) : old('image')" :required="true" />
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="link" class="form-label">
                <i class="bi bi-link-45deg"></i> Liên kết
            </label>
            <input type="url" name="link" id="link" class="form-control"
                   placeholder="Nhập liên kết (tùy chọn)..."
                   value="{{ $data['link'] ?? old('link') }}">
            <div class="invalid-feedback" id="linkError"></div>
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
                <option value="0" {{ ($data['status'] ?? old('status')) == '0' ? 'selected' : '' }}>Ẩn</option>
                <option value="1" {{ ($data['status'] ?? old('status')) == '1' ? 'selected' : '' }}>Hiển thị</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <div class="form-check">
                <input type="checkbox" name="is_featured" id="is_featured" class="form-check-input" value="1"
                       {{ ($data['is_featured'] ?? old('is_featured')) ? 'checked' : '' }}>
                <label class="form-check-label" for="is_featured">
                    <i class="bi bi-star"></i> Nổi bật
                </label>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="start_date" class="form-label">
                <i class="bi bi-calendar-event"></i> Ngày bắt đầu
            </label>
            <input type="datetime-local" name="start_date" id="start_date" class="form-control"
                   value="{{ $data['start_date'] ?? old('start_date') }}">
            <div class="invalid-feedback" id="start_dateError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="end_date" class="form-label">
                <i class="bi bi-calendar-x"></i> Ngày kết thúc
            </label>
            <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                   value="{{ $data['end_date'] ?? old('end_date') }}">
            <div class="invalid-feedback" id="end_dateError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Image preview
    $('#image').on('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = $('<div class="mt-2"><img src="' + e.target.result + '" class="img-thumbnail" style="max-width: 200px;"></div>');
                $('#image').next('.mt-2').remove();
                $('#image').after(preview);
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Validate dates
    $('#start_date, #end_date').on('change', function() {
        const startDate = new Date($('#start_date').val());
        const endDate = new Date($('#end_date').val());
        
        if (startDate && endDate && startDate > endDate) {
            $('#end_dateError').text('Ngày kết thúc phải sau ngày bắt đầu');
            $('#end_date').addClass('is-invalid');
        } else {
            $('#end_dateError').text('');
            $('#end_date').removeClass('is-invalid');
        }
    });
});
</script>
<!-- CKEditor 5 đã được load từ layout -->
<script>
    $(function(){
      CKEDITOR.replace('description', {
        language: 'vi',
        height: 200,
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserUploadMethod: 'form',
        filebrowserUploadParams: {
          _token: '{{ csrf_token() }}'
        },
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage,image2',
        image2_altRequired: false,
        image2_disableResizer: false,
        removeDialogTabs: '',
      });
    });
</script>
