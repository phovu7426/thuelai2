$(document).ready(function () {
    function initializeSelect2() {
        // Kiểm tra xem Select2 đã được load chưa
        if (typeof $.fn.select2 === 'undefined') {
            console.error('Select2 is not loaded');
            return;
        }
        
        $('.select2').each(function () {
            const selectElement = $(this);
            const url = selectElement.data('url'); // Lấy URL từ data-url
            
            // Chỉ khởi tạo Select2 cho elements có data-url (autocomplete)
            if (!url) {
                console.log('Skipping select2 init - no data-url:', selectElement.attr('id'));
                return;
            }
            
            console.log('Initializing Select2 for:', selectElement.attr('id'), 'with URL:', url);
            
            const field = selectElement.data('field') || 'id'; // Trường lấy giá trị
            const displayField = selectElement.data('display-field') || 'name'; // Trường hiển thị
            const selectedData = selectElement.attr('data-selected'); // Dữ liệu đã chọn
            const isMultiple = selectElement.prop('multiple'); // Kiểm tra select multiple hay không
            let selectedValues = selectedData ? JSON.parse(selectedData) : (isMultiple ? [] : null);

            // Khởi tạo Select2
            selectElement.select2({
                ajax: {
                    url: url,
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        const data = {term: params.term || ''};
                        const excludeId = selectElement.data('exclude-id');
                        if (excludeId) {
                            data.exclude_id = excludeId;
                        }
                        return data;
                    },
                    processResults: function (data) {
                        return {
                            results: data.map(function (item) {
                                return {id: item[field], text: item[displayField]};
                            })
                        };
                    },
                    cache: true
                },
                dropdownParent: selectElement.closest('.modal').length ? selectElement.closest('.modal') : $(document.body),
                width: '100%',
                minimumInputLength: 0,
                placeholder: 'Chọn mục',
                allowClear: true
            });

            // Nếu có dữ liệu đã chọn, đảm bảo option tồn tại rồi mới set giá trị
            const hasSelected = isMultiple
                ? Array.isArray(selectedValues) && selectedValues.length > 0
                : selectedValues !== null && selectedValues !== '' && typeof selectedValues !== 'undefined';

            if (hasSelected) {
                const selectedTextAttr = selectElement.attr('data-selected-text');
                if (selectedTextAttr && !isMultiple) {
                    // Nếu đã có sẵn text của option được chọn, không cần gọi server
                    if (selectElement.find("option[value='" + selectedValues + "']").length === 0) {
                        selectElement.append(new Option(selectedTextAttr, selectedValues, true, true));
                    }
                    selectElement.val(selectedValues).trigger('change');
                    return;
                }
                // Ưu tiên yêu cầu theo id/ids để chắc chắn lấy được các item đã chọn
                const requestData = isMultiple
                    ? { ids: selectedValues }
                    : { id: selectedValues };

                $.ajax({
                    url: url,
                    data: requestData,
                    dataType: 'json',
                    success: function (data) {
                        if (isMultiple) {
                            selectedValues.forEach(function(value) {
                                if (selectElement.find("option[value='" + value + "']").length === 0) {
                                    let item = Array.isArray(data) ? data.find(item => item[field] == value) : null;
                                    let text = item ? item[displayField] : value;
                                    selectElement.append(new Option(text, value, true, true));
                                }
                            });
                            selectElement.val(selectedValues).trigger('change');
                        } else {
                            let value = selectedValues;
                            if (selectElement.find("option[value='" + value + "']").length === 0) {
                                let item = Array.isArray(data) ? data.find(item => item[field] == value) : null;
                                let text = item ? item[displayField] : value;
                                selectElement.append(new Option(text, value, true, true));
                            }
                            selectElement.val(value).trigger('change');
                        }
                    }
                });
            }
        });
    }
    // Expose for external calls (e.g., after modal loads)
    window.initializeSelect2 = initializeSelect2;

    // Khởi tạo Select2 ban đầu
    initializeSelect2();

    // Sử dụng MutationObserver để theo dõi sự thay đổi trong DOM
    const observer = new MutationObserver(function (mutations) {
        mutations.forEach(function (mutation) {
            // Kiểm tra xem có phần tử mới với class select2 được thêm vào không
            if ($(mutation.addedNodes).find('.select2').length > 0) {
                initializeSelect2(); // Khởi tạo lại select2 cho các thẻ mới thêm vào
            }
        });
    });

    // Cấu hình MutationObserver
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
    
    // Khởi tạo Select2 cho các phần tử được thêm vào sau
    $(document).on('DOMNodeInserted', function(e) {
        $(e.target).find('.select2').each(function() {
            if (!$(this).data('select2')) {
                initializeSelect2();
            }
        });
    });
});

function sendAjaxRequest(url, method, data, successCallback) {
    $.ajax({
        url: url,
        method: method,
        data: data,
        success: function (response) {
            if (response.success) {
                toastr.success(response.messages || 'Thành công');
                if (typeof successCallback === 'function') {
                    successCallback(response);
                } else {
                    location.reload(); // Tự động tải lại trang nếu không có callback
                }
            } else {
                toastr.error(response.messages || 'Có lỗi xảy ra');
            }
        },
        error: function (xhr) {
            let errorMessage = "Lỗi hệ thống!";
            if (xhr.responseJSON && xhr.responseJSON.messages) {
                errorMessage = xhr.responseJSON.messages;
            }
            toastr.error(errorMessage);
        }
    });
}

function handleFormSubmit(event) {
    event.preventDefault();

    const form = event.target;
    const url = form.action;
    const method = form.method;
    const formData = $(form).serialize();

    sendAjaxRequest(url, method, formData, function (response) {
        //form.reset(); // Reset form sau khi thêm thành công
    });
}

// Lắng nghe sự kiện submit cho tất cả các form
//$(document).on('submit', 'form', handleFormSubmit);


// Kích hoạt CKEditor cho các input có data-editor="true"
document.addEventListener("DOMContentLoaded", function () {
    // Lấy CSRF token
    var csrfToken = document.querySelector('meta[name="csrf-token"]');
    var token = csrfToken ? csrfToken.getAttribute('content') : '';
    var uploadUrl = '/upload?_token=' + token;
    
    // Khởi tạo CKEditor cho tất cả textarea có data-editor="true"
    document.querySelectorAll('[data-editor="true"]').forEach((textarea) => {
        if (typeof CKEDITOR !== "undefined") {
            var editor = CKEDITOR.replace(textarea.name, {
                extraPlugins: 'image2,uploadimage', // Bật plugin ảnh
                removePlugins: 'easyimage, cloudservices',
                uploadUrl: uploadUrl, // URL để upload ảnh (bao gồm cả chụp từ camera)
                filebrowserImageUploadUrl: uploadUrl, // URL cho upload ảnh trong dialog
                fileTools_requestHeaders: {
                    'X-CSRF-TOKEN': token
                },
                toolbar: [
                    { name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'Undo', 'Redo'] },
                    { name: 'editing', items: ['Find', 'Replace', 'SelectAll'] },
                    { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript'] },
                    { name: 'paragraph', items: ['NumberedList', 'BulletedList', 'Outdent', 'Indent', 'Blockquote'] },
                    { name: 'insert', items: ['Image', 'Table', 'HorizontalRule', 'SpecialChar'] },
                    { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                    { name: 'colors', items: ['TextColor', 'BGColor'] },
                    { name: 'tools', items: ['Maximize'] }
                ],
            });
            
            // Xử lý upload trong dialog image (bao gồm chụp từ camera)
            editor.on('dialogDefinition', function(evt) {
                var dialogName = evt.data.name;
                var dialogDefinition = evt.data.definition;
                
                if (dialogName === 'image' || dialogName === 'image2') {
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
        } else {
            console.error("CKEDITOR is not loaded!");
        }
    });

    // Xử lý upload ảnh và cập nhật URL vào input tương ứng (event delegation)
    function handleUploadChange(inputEl) {
        const file = inputEl.files && inputEl.files[0];
        if (!file) return;

        const targetId = inputEl.getAttribute('data-target');
        const targetInput = targetId ? document.getElementById(targetId) : null;
        if (!targetInput) {
            console.error('Không tìm thấy input đích để gán URL (data-target).');
            return;
        }
        const uploadUrl = inputEl.getAttribute('data-url');
        if (!uploadUrl) {
            console.error('Thiếu data-url trên input upload-field.');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);
        const csrf = document.querySelector('meta[name="csrf-token"]');
        if (csrf) formData.append('_token', csrf.content);

        fetch(uploadUrl, { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data && data.success) {
                    targetInput.value = data.url;
                    const previewId = inputEl.getAttribute('data-preview');
                    if (previewId) {
                        const img = document.getElementById(previewId);
                        if (img) { img.src = data.url; img.style.display = ''; }
                    }
                } else {
                    alert('Upload thất bại: ' + ((data && (data.message || data.messages)) || 'Không xác định'));
                }
            })
            .catch(err => {
                console.error('Upload error:', err);
                alert('Không thể tải lên. Vui lòng thử lại.');
            });
    }

    if (!window.__uploadHandlerRegistered) {
        document.addEventListener('change', function(e) {
            const target = e.target;
            if (target && target.classList && target.classList.contains('upload-field')) {
                handleUploadChange(target);
            }
        });
        window.__uploadHandlerRegistered = true;
    }
});


// tinymce.init({
//     selector: "textarea[data-editor='true']", // Hoặc "#content"
//     plugins: "lists link image table code",
//     toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | link image",
// });
//
// document.addEventListener("DOMContentLoaded", function() {
//     document.querySelectorAll('.upload-field').forEach(input => {
//         input.addEventListener('change', function(event) {
//             let file = event.target.files[0];
//             if (!file) return;
//
//             let targetInput = document.getElementById(input.dataset.target);
//             let formData = new FormData();
//             formData.append('file', file);
//
//             fetch(input.dataset.url, {
//                 method: 'POST',
//                 body: formData,
//                 headers: {
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.success) {
//                         targetInput.value = data.url; // Cập nhật đường dẫn vào input hidden
//                     } else {
//                         alert('Tải file thất bại!');
//                     }
//                 })
//                 .catch(error => {
//                     console.error('Lỗi upload:', error);
//                     alert('Lỗi khi tải file!');
//                 });
//         });
//     });
// });
