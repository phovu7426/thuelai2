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
        image2_altRequired: false,
        fileTools_requestHeaders: {
            'X-CSRF-TOKEN': token
        }
    };
    
    var config = Object.assign({}, defaultOptions, options || {});
    
    // Khởi tạo editor
    var editor = CKEDITOR.replace(elementId, config);
    
    // Sửa validation cho dialog image
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

