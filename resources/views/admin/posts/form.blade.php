{{-- Form cho Posts Modal --}}
@csrf

@php
    $statusValue = $status ?? old('status', 'draft');
    $featuredValue = $featured ?? old('featured', 0);
    // Chuẩn hóa category thành object để truy cập đồng nhất
    $categoryObj = isset($category)
        ? (is_array($category) ? (object) $category : $category)
        : null;
    $categoryIdValue = $category_id ?? ($categoryObj->id ?? old('category_id'));
    $categoryText = $categoryObj ? ($categoryObj->name ?? null) : null;
@endphp

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="title" class="form-label">
                <i class="bi bi-file-text"></i> Tiêu đề bài viết <span class="text-danger">*</span>
            </label>
            <input type="text" name="title" id="title" class="form-control"
                   placeholder="Nhập tiêu đề bài viết..."
                   value="{{ $title ?? old('title') }}"
                   required>
            <div class="invalid-feedback" id="titleError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="category_id" class="form-label">
                <i class="bi bi-folder"></i> Danh mục
            </label>
            <select name="category_id" id="category_id" class="form-control select2"
                    data-url="{{ route('admin.post-categories.autocomplete') }}"
                    data-field="id"
                    data-display-field="name"
                    data-selected='@json($categoryIdValue)'
                    data-fetch-url="{{ url('/admin/post-categories/:id') }}">
                <option value="">Chọn danh mục</option>
            </select>
            <div class="invalid-feedback" id="category_idError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="status" class="form-label">
                <i class="bi bi-toggle-on"></i> Trạng thái
            </label>
            <select name="status" id="status" class="form-control">
                <option value="draft" {{ ($statusValue ?? '') === 'draft' ? 'selected' : '' }}>Bản nháp</option>
                <option value="published" {{ ($statusValue ?? '') === 'published' ? 'selected' : '' }}>Đã xuất bản</option>
            </select>
            <div class="invalid-feedback" id="statusError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <x-uploads.file-upload name="image" label="Ảnh đại diện" :value="$image ?? old('image')" />
            <div class="invalid-feedback" id="imageError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="excerpt" class="form-label">
                <i class="bi bi-text-paragraph"></i> Tóm tắt
            </label>
            <textarea name="excerpt" id="excerpt" class="form-control" rows="3"
                      placeholder="Nhập tóm tắt bài viết...">{{ $excerpt ?? old('excerpt') }}</textarea>
            <div class="invalid-feedback" id="excerptError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="content" class="form-label">
                <i class="bi bi-file-earmark-text"></i> Nội dung <span class="text-danger">*</span>
            </label>
            <textarea name="content" id="content" class="form-control" rows="8" placeholder="Nhập nội dung bài viết..." required>{{ $content ?? old('content') }}</textarea>
            <div class="invalid-feedback" id="contentError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_title" class="form-label">
                <i class="bi bi-tag"></i> Meta Title
            </label>
            <input type="text" name="meta_title" id="meta_title" class="form-control"
                   placeholder="Meta title cho SEO..."
                   value="{{ $meta_title ?? old('meta_title') }}">
            <div class="invalid-feedback" id="meta_titleError"></div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="mb-3">
            <label for="meta_keywords" class="form-label">
                <i class="bi bi-tags"></i> Meta Keywords
            </label>
            <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                   placeholder="Từ khóa SEO, phân cách bằng dấu phẩy..."
                   value="{{ $meta_keywords ?? old('meta_keywords') }}">
            <div class="invalid-feedback" id="meta_keywordsError"></div>
        </div>
    </div>
</div>

<div class="row g-3">
    <div class="col-12">
        <div class="mb-3">
            <label for="meta_description" class="form-label">
                <i class="bi bi-card-text"></i> Meta Description
            </label>
            <textarea name="meta_description" id="meta_description" class="form-control" rows="3"
                      placeholder="Mô tả meta cho SEO...">{{ $meta_description ?? old('meta_description') }}</textarea>
            <div class="invalid-feedback" id="meta_descriptionError"></div>
        </div>
    </div>
</div>

{{-- Script để xử lý form --}}
<script>
$(document).ready(function() {
    // Auto-generate meta title from title if empty
    $('#title').on('input', function() {
        const title = $(this).val();
        if (title && !$('#meta_title').val()) {
            $('#meta_title').val(title);
        }
    });
    
    // Auto-generate excerpt from content if empty
    $('#content').on('input', function() {
        const content = $(this).val();
        if (content && !$('#excerpt').val()) {
            const excerpt = content.substring(0, 200).trim();
            $('#excerpt').val(excerpt);
        }
    });
    
    // Đảm bảo Select2 được khởi tạo với delay
    setTimeout(function() {
        if (typeof initializeSelect2 === 'function') {
            initializeSelect2();
        }
    }, 100);
});
</script>
<script>
    // Khởi tạo qua shim CKEditor 5 (đã load ở layout)
    $(function(){
      var editor = CKEDITOR.replace('content', {
        language: 'vi',
        height: 400,
        uploadUrl: '{{ url('/upload') }}?_token={{ csrf_token() }}',
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserImageUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage,image2',
        image2_altRequired: false,
      });
      
      // Xử lý khi dialog image được mở
      editor.on('dialogDefinition', function(evt) {
        var dialogName = evt.data.name;
        var dialogDefinition = evt.data.definition;
        
        if (dialogName == 'image2' || dialogName == 'image') {
          var infoTab = dialogDefinition.getContents('info');
          var urlField = infoTab.get('src') || infoTab.get('txtUrl');
          
          if (urlField) {
            urlField.validate = function() {
              return true;
            };
            urlField.required = false;
          }
        }
      });
      
      // Lắng nghe khi dialog được mở và attach event listener vào input file
      editor.on('dialogShow', function(evt) {
        var dialog = evt.data;
        var dialogName = dialog.getName();
        
        if (dialogName == 'image2' || dialogName == 'image') {
          // Hàm để attach event listener
          function attachFileListener() {
            try {
              // Tìm input file trong dialog - thử nhiều cách
              var dialogElement = dialog.getElement();
              var dialogDom = dialogElement ? dialogElement.$ : null;
              
              // Nếu không tìm thấy, thử tìm trong document
              if (!dialogDom) {
                var dialogIframe = dialog.getElement().getFrameDocument();
                if (dialogIframe) {
                  dialogDom = dialogIframe.$;
                }
              }
              
              // Nếu vẫn không có, tìm trong body
              if (!dialogDom) {
                dialogDom = document.body;
              }
              
              var fileInputs = dialogDom.querySelectorAll('input[type="file"]');
              
              if (fileInputs.length === 0) {
                // Thử tìm trong iframe của dialog
                var iframes = document.querySelectorAll('iframe');
                for (var i = 0; i < iframes.length; i++) {
                  try {
                    var iframeDoc = iframes[i].contentDocument || iframes[i].contentWindow.document;
                    fileInputs = iframeDoc.querySelectorAll('input[type="file"]');
                    if (fileInputs.length > 0) {
                      dialogDom = iframeDoc;
                      break;
                    }
                  } catch (e) {
                    // Cross-origin, bỏ qua
                  }
                }
              }
              
              if (fileInputs.length > 0) {
                fileInputs.forEach(function(fileInput) {
                  // Kiểm tra xem đã có listener chưa
                  if (!fileInput.hasAttribute('data-upload-listener')) {
                    fileInput.setAttribute('data-upload-listener', 'true');
                    
                    fileInput.addEventListener('change', function(e) {
                var file = e.target.files && e.target.files[0];
                if (file) {
                  // Hiển thị thông báo đang upload
                  var uploadMsg = 'Đang tải lên ảnh: ' + (file.name || 'ảnh từ camera') + '...';
                  alert(uploadMsg);
                  
                  var formData = new FormData();
                  formData.append('upload', file);
                  formData.append('_token', '{{ csrf_token() }}');
                  
                  var xhr = new XMLHttpRequest();
                  xhr.open('POST', '{{ url('/upload') }}', true);
                  
                  xhr.onload = function() {
                    if (xhr.status === 200) {
                      try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.url) {
                          var currentDialog = CKEDITOR.dialog.getCurrent();
                          if (currentDialog) {
                            var srcField = currentDialog.getContentElement('info', 'src') || 
                                         currentDialog.getContentElement('info', 'txtUrl');
                            if (srcField) {
                              srcField.setValue(response.url);
                              currentDialog.selectPage('info');
                              alert('Tải lên thành công! Ảnh đã được chèn vào editor.');
                            } else {
                              alert('Tải lên thành công nhưng không tìm thấy field để chèn ảnh.');
                            }
                          } else {
                            alert('Tải lên thành công nhưng không tìm thấy dialog.');
                          }
                        } else {
                          alert('Tải lên thành công nhưng không có URL ảnh. Vui lòng thử lại.');
                        }
                      } catch (e) {
                        alert('Lỗi khi xử lý phản hồi từ server. Vui lòng thử lại.');
                      }
                    } else {
                      try {
                        var errorResponse = JSON.parse(xhr.responseText);
                        var errorMsg = errorResponse.message || errorResponse.error?.message || 'Lỗi không xác định';
                        alert('Lỗi khi tải lên ảnh: ' + errorMsg);
                      } catch (e) {
                        alert('Lỗi khi tải lên ảnh (Mã lỗi: ' + xhr.status + '). Vui lòng thử lại.');
                      }
                    }
                  };
                  
                  xhr.onerror = function() {
                    alert('Lỗi kết nối khi tải lên ảnh. Vui lòng kiểm tra kết nối mạng và thử lại.');
                  };
                  
                  xhr.upload.onprogress = function(e) {
                    // Có thể hiển thị progress nếu cần
                    if (e.lengthComputable) {
                      var percentComplete = (e.loaded / e.total) * 100;
                      // Progress được xử lý ở đây nếu cần UI
                    }
                  };
                  
                  xhr.send(formData);
                }
              }, false);
                  }
                });
              } else {
                // Nếu chưa tìm thấy, thử lại sau
                setTimeout(attachFileListener, 200);
              }
            } catch (e) {
              alert('Lỗi khi xử lý upload: ' + e.message);
            }
          }
          
          // Thử attach ngay và sau đó thử lại
          setTimeout(attachFileListener, 100);
          setTimeout(attachFileListener, 500);
          setTimeout(attachFileListener, 1000);
        }
      });

      // Đảm bảo gửi CSRF token khi dùng uploadimage (XHR)
      editor.on('fileUploadRequest', function(evt) {
        var fileLoader = evt.data.fileLoader;
        var formData = new FormData();
        formData.append('upload', fileLoader.file);
        formData.append('_token', '{{ csrf_token() }}');
        fileLoader.xhr.open('POST', editor.config.uploadUrl || '{{ url('/upload') }}', true);
        fileLoader.xhr.send(formData);
        evt.stop();
      });

      // Parse response và gán URL để CKEditor chèn ảnh
      editor.on('fileUploadResponse', function(evt) {
        var data = evt.data;
        try {
          var json = JSON.parse(data.fileLoader.xhr.responseText || '{}');
          if (json && json.url) {
            data.url = json.url;
          } else if (json && json.uploaded && json.fileName && json.url) {
            data.url = json.url;
          } else if (json && json.success && json.url) {
            data.url = json.url;
          }
        } catch (e) {
          console.error('Error parsing upload response:', e);
        }
        evt.stop();
      });
    });
</script>
