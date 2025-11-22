@extends('admin.index')

@section('page_title', 'Thêm bài viết mới')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Quản lý bài viết</a></li>
    <li class="breadcrumb-item active" aria-current="page">Thêm bài viết mới</li>
@endsection

@section('content')
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Thêm bài viết mới</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                               id="title" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="content" class="form-label">Nội dung <span class="text-danger">*</span></label>
                                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                                  id="content" name="content" rows="10" required>{{ old('content') }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="excerpt" class="form-label">Tóm tắt</label>
                                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                                  id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                                        @error('excerpt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                        <select class="form-select @error('category_id') is-invalid @enderror" 
                                                id="category_id" name="category_id" required>
                                            <option value="">Chọn danh mục</option>
                                            @foreach($categories ?? [] as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" name="status">
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Xuất bản</option>
                                            <option value="archived" {{ old('status') == 'archived' ? 'selected' : '' }}>Lưu trữ</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_featured" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">
                                                Bài viết nổi bật
                                            </label>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="featured_image" class="form-label">Ảnh đại diện</label>
                                        <x-uploads.file-upload name="featured_image" label="Ảnh đại diện" :value="old('featured_image')" />
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                               id="meta_title" name="meta_title" value="{{ old('meta_title') }}">
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                                  id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle"></i> Lưu bài viết
                                    </button>
                                    <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">
                                        <i class="bi bi-arrow-left"></i> Quay lại
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- CKEditor 5 đã được load từ layout -->
<script>
    $(function(){
      var editor = CKEDITOR.replace('content', {
        language: 'vi',
        height: 400,
        filebrowserUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserImageUploadUrl: '{{ url('/upload') }}?responseType=json&_token={{ csrf_token() }}',
        filebrowserUploadMethod: 'form',
        filebrowserUploadParams: {
          _token: '{{ csrf_token() }}'
        },
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage,image2',
        image2_altRequired: false,
        image2_disableResizer: false,
        removeDialogTabs: '',
        uploadUrl: '{{ url('/upload') }}',
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
@endpush
