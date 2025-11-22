/**
 * Helper function để khởi tạo CKEditor với cấu hình chuẩn
 * Sửa lỗi validation "Thiếu đường dẫn hình ảnh"
 */
function initCKEditor(elementId, options) {
    // Đảm bảo basePath được set
    if (typeof window.CKEDITOR_BASEPATH === 'undefined') {
        var script = document.querySelector('script[src*="ckeditor.js"]');
        if (script) {
            var src = script.src;
            window.CKEDITOR_BASEPATH = src.substring(0, src.lastIndexOf('/') + 1);
        }
    }
    
    // Lấy CSRF token và upload URL
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var token = csrfToken ? csrfToken.getAttribute('content') : '';
    var uploadUrl = '/upload?_token=' + token;
    
    // Merge options với defaults
    var defaultOptions = {
        language: 'vi',
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage',
        uploadUrl: uploadUrl, // URL để upload ảnh (bao gồm cả chụp từ camera)
        filebrowserImageUploadUrl: uploadUrl, // URL cho upload ảnh trong dialog
        image2_altRequired: false,
        fileTools_requestHeaders: {
            'X-CSRF-TOKEN': token
        }
    };
    
    var config = Object.assign({}, defaultOptions, options || {});
    
    // Khởi tạo editor
    var editor = CKEDITOR.replace(elementId, config);
    
    // Sửa validation cho dialog image và xử lý upload
    editor.on('dialogDefinition', function(evt) {
        var dialogName = evt.data.name;
        var dialogDefinition = evt.data.definition;
        
        if (dialogName == 'image2' || dialogName == 'image') {
            var infoTab = dialogDefinition.getContents('info');
            var urlField = infoTab.get('src') || infoTab.get('txtUrl');
            
            if (urlField) {
                // Override validation để không báo lỗi
                urlField.validate = function() {
                    var value = this.getValue();
                    // Luôn pass validation (cho phép upload hoặc nhập URL sau)
                    return true;
                };
                urlField.required = false;
            }
            
            // Xử lý tab Upload - khi chụp ảnh từ camera
            var uploadTab = dialogDefinition.getContents('Upload');
            if (uploadTab) {
                var uploadField = uploadTab.get('upload');
                if (uploadField) {
                    var originalOnChange = uploadField.onChange;
                    uploadField.onChange = function() {
                        if (originalOnChange) {
                            originalOnChange.call(this);
                        }
                        
                        var fileInput = this.getInputElement().$;
                        if (fileInput && fileInput.files && fileInput.files.length > 0) {
                            var file = fileInput.files[0];
                            console.log('File selected for upload:', file.name, file.type);
                            
                            var formData = new FormData();
                            formData.append('upload', file);
                            formData.append('_token', token);
                            
                            var xhr = new XMLHttpRequest();
                            xhr.open('POST', uploadUrl.split('?')[0], true);
                            
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    try {
                                        var response = JSON.parse(xhr.responseText);
                                        console.log('Upload response:', response);
                                        if (response.url) {
                                            var currentDialog = CKEDITOR.dialog.getCurrent();
                                            if (currentDialog) {
                                                var srcField = currentDialog.getContentElement('info', 'src') || 
                                                             currentDialog.getContentElement('info', 'txtUrl');
                                                if (srcField) {
                                                    srcField.setValue(response.url);
                                                    currentDialog.selectPage('info');
                                                }
                                            }
                                        }
                                    } catch (e) {
                                        console.error('Error parsing response:', e);
                                        alert('Lỗi khi upload ảnh: ' + e.message);
                                    }
                                } else {
                                    console.error('Upload failed:', xhr.status, xhr.responseText);
                                    try {
                                        var errorResponse = JSON.parse(xhr.responseText);
                                        alert('Lỗi khi upload ảnh: ' + (errorResponse.message || errorResponse.error?.message || 'Vui lòng thử lại.'));
                                    } catch (e) {
                                        alert('Lỗi khi upload ảnh. Vui lòng thử lại.');
                                    }
                                }
                            };
                            
                            xhr.onerror = function() {
                                console.error('Upload error');
                                alert('Lỗi kết nối khi upload ảnh.');
                            };
                            
                            xhr.send(formData);
                        }
                    };
                }
            }
        }
    });
    
    // Đảm bảo gửi CSRF token khi upload (bao gồm chụp từ camera)
    editor.on('fileUploadRequest', function(evt) {
        var fileLoader = evt.data.fileLoader;
        var formData = new FormData();
        formData.append('upload', fileLoader.file);
        formData.append('_token', token);
        fileLoader.xhr.open('POST', uploadUrl.split('?')[0], true);
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
    
    return editor;
}

