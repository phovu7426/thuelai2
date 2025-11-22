@props(['name', 'label' => null, 'required' => false, 'value' => null, 'preview' => true])

<div class="image-uploader">
    @if($label)
        <label class="form-label">{{ $label }} @if($required)<span class="text-danger">*</span>@endif</label>
    @endif

    <div class="d-flex align-items-center gap-3">
        <input type="file"
               class="upload-field form-control"
               accept="image/*"
               data-target="{{ $name }}_input"
               data-preview="{{ $name }}_preview"
               data-url="{{ route('upload') }}"
               {{ $required ? 'required' : '' }}>

        <div class="image-preview" style="min-width: 100px;">
            @if(!empty($value))
                @if(str_starts_with($value, 'storage/'))
                    <img id="{{ $name }}_preview" src="{{ asset($value) }}"
                         alt="preview" style="max-height: 80px;">
                @elseif(str_starts_with($value, 'http') || str_starts_with($value, '/'))
                    <img id="{{ $name }}_preview" src="{{ $value }}"
                         alt="preview" style="max-height: 80px;">
                @else
                    <img id="{{ $name }}_preview" src="{{ asset('storage/' . $value) }}"
                         alt="preview" style="max-height: 80px;">
                @endif
            @else
                <img id="{{ $name }}_preview" src="" alt="preview" style="max-height: 80px; display:none;">
            @endif
        </div>
    </div>

    <input type="hidden" id="{{ $name }}_input" name="{{ $name }}" value="{{ $value ?? '' }}" {{ $required ? 'required' : '' }}>

    <small class="text-muted d-block mt-1">Chọn ảnh, hệ thống sẽ tải lên và tự điền URL vào input ẩn.</small>
</div>
