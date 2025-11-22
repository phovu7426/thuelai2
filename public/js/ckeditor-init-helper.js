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
    
    // Merge options với defaults
    var defaultOptions = {
        language: 'vi',
        removePlugins: 'easyimage,cloudservices',
        extraPlugins: 'uploadimage',
        image2_altRequired: false
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
    
    return editor;
}

