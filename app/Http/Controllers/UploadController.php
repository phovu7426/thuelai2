<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * Upload ảnh chung cho form (Admin tạo/sửa tài khoản, v.v.).
     * - Lưu file vào disk public theo ngày
     * - Trả về JSON chứa URL để gán vào input
     */
    public function upload(Request $request): JsonResponse
    {
        // Log ngay từ đầu để đảm bảo request đến được server
        Log::info('Upload request received', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'has_files' => $request->hasFile('upload') || $request->hasFile('image') || $request->hasFile('file'),
            'all_files' => array_keys($request->allFiles()),
            'content_type' => $request->header('Content-Type'),
            'user_agent' => $request->header('User-Agent'),
        ]);
        
        try {
            // Chấp nhận ckCsrfToken như _token để tương thích các flow cũ
            if ($request->has('ckCsrfToken') && !$request->has('_token')) {
                $request->merge(['_token' => $request->input('ckCsrfToken')]);
            }

            $files = $request->allFiles();
            
            Log::info('Files found', [
                'files_count' => count($files),
                'file_keys' => array_keys($files),
            ]);
            if (empty($files)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không có file nào được tải lên!'
                ], 400);
            }

            // Ưu tiên các key thường gặp, nếu không có thì lấy file đầu tiên
            $preferredKeys = ['image', 'avatar', 'file', 'photo', 'upload'];
            $inputName = null;
            foreach ($preferredKeys as $k) {
                if ($request->hasFile($k)) { $inputName = $k; break; }
            }
            if (!$inputName) {
                $inputName = array_key_first($files);
            }

            $file = $request->file($inputName);
            
            Log::info('File object', [
                'input_name' => $inputName,
                'file_exists' => $file !== null,
                'is_valid' => $file ? $file->isValid() : false,
                'original_name' => $file ? $file->getClientOriginalName() : null,
                'size' => $file ? $file->getSize() : null,
                'mime_type' => $file ? $file->getMimeType() : null,
            ]);
            
            if (!$file || !$file->isValid()) {
                Log::warning('Invalid file', [
                    'input_name' => $inputName,
                    'file_exists' => $file !== null,
                    'is_valid' => $file ? $file->isValid() : false,
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'File không hợp lệ hoặc bị lỗi khi upload!'
                ], 400);
            }

            // Kiểm tra loại file
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $mimeType = $file->getMimeType();
            
            // Nếu không có MIME type, thử lấy từ client
            if (empty($mimeType)) {
                $clientMime = $file->getClientMimeType();
                $mimeType = $clientMime ?: 'image/jpeg'; // Mặc định là jpeg
            }
            
            if (!in_array($mimeType, $allowedTypes)) {
                Log::warning('Invalid MIME type', [
                    'mime' => $mimeType,
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'Chỉ chấp nhận file hình ảnh (JPEG, PNG, GIF, WebP)! MIME type: ' . $mimeType
                ], 400);
            }

            // Giới hạn kích thước 5MB (tùy chỉnh nếu cần)
            $maxSize = 5 * 1024 * 1024;
            if ($file->getSize() > $maxSize) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kích thước ảnh vượt quá 5MB!'
                ], 413);
            }

            $originalName = $file->getClientOriginalName();
            $originalBase = pathinfo($originalName, PATHINFO_FILENAME);
            $ext = strtolower($file->getClientOriginalExtension());
            
            // Xử lý đặc biệt cho file từ camera
            // File từ camera thường có tên như "image.jpg" nhưng extension có thể không đúng
            $isCameraFile = (
                $originalName === 'image.jpg' || 
                $originalName === 'image.jpeg' || 
                $originalName === 'image.png' ||
                $originalBase === 'image' ||
                $originalBase === 'blob' ||
                empty($originalBase) ||
                strpos($originalName, 'blob') !== false
            );
            
            // Nếu không có extension hoặc là file từ camera,
            // lấy extension từ MIME type
            if (empty($ext) || $isCameraFile) {
                $mimeToExt = [
                    'image/jpeg' => 'jpg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'image/webp' => 'webp',
                ];
                $ext = $mimeToExt[$mimeType] ?? 'jpg'; // Mặc định là jpg nếu không xác định được
                
                Log::info('Camera file detected or no extension', [
                    'original_name' => $originalName,
                    'original_base' => $originalBase,
                    'detected_ext' => $ext,
                    'mime_type' => $mimeType,
                    'is_camera_file' => $isCameraFile,
                ]);
            }
            
            // Loại bỏ ký tự đặc biệt để tránh 403/URL lỗi
            $base = preg_replace('/[^A-Za-z0-9\-_]+/', '_', $originalBase);
            $base = trim($base, '_');
            // Xử lý trường hợp tên file là "blob" hoặc "image" (thường xảy ra khi chụp từ camera)
            if ($base === '' || $base === 'blob' || $base === 'image' || empty($base)) {
                $base = 'image';
            }
            
            // Đảm bảo extension hợp lệ
            if (empty($ext) || !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $ext = 'jpg';
            }
            
            $filename = time() . '_' . $base . '.' . $ext;
            
            // Log thông tin file trước khi upload
            Log::info('Processing upload', [
                'original_name' => $originalName,
                'original_base' => $originalBase,
                'extension' => $ext,
                'mime_type' => $mimeType,
                'final_filename' => $filename,
                'size' => $file->getSize(),
            ]);
            $folder = 'uploads/' . date('Ymd');
            
            // Đảm bảo thư mục tồn tại
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            
            $path = $file->storeAs($folder, $filename, 'public');
            
            if (!$path) {
                throw new \Exception('Không thể lưu file vào storage');
            }

            $url = Storage::url($path);
            
            Log::info('Upload success', [
                'filename' => $filename,
                'path' => $path,
                'url' => $url,
                'mime' => $mimeType,
            ]);

            // Trả về format tương thích cả CKEditor 4 (filebrowser) và CKEditor 5 (ckfinder)
            // - CKEditor 5 simple upload adapter mong đợi: { uploaded: true, url }
            // - Một số nơi cũ dùng: { success: true, url, ... }
            return response()->json([
                'uploaded'  => true,
                'url'       => $url,
                'fileName'  => $filename,
                'path'      => $path,
                'success'   => true,
                'inputName' => $inputName,
            ]);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $fileName = $request->file($inputName ?? 'unknown')?->getClientOriginalName() ?? 'unknown';
            
            Log::error('Upload error', [
                'message' => $errorMessage,
                'file_name' => $fileName,
                'input_name' => $inputName ?? 'unknown',
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Trả về format tương thích với CKEditor
            // Message phải ngắn gọn và rõ ràng
            $userMessage = 'Không thể tải lên file';
            if (strpos($errorMessage, 'image') !== false || strpos($errorMessage, 'jpg') !== false) {
                $userMessage = 'Lỗi khi xử lý ảnh. Vui lòng thử lại với ảnh khác.';
            } elseif (strpos($errorMessage, 'storage') !== false || strpos($errorMessage, 'permission') !== false) {
                $userMessage = 'Lỗi hệ thống khi lưu file. Vui lòng liên hệ quản trị viên.';
            } elseif (strpos($errorMessage, 'size') !== false) {
                $userMessage = 'File quá lớn. Vui lòng chọn file nhỏ hơn 5MB.';
            }
            
            return response()->json([
                'uploaded' => 0,
                'success' => false,
                'error' => [
                    'message' => $userMessage
                ],
                'message' => $userMessage,
            ], 500);
        }
    }

    /**
     * Upload ảnh dành cho CKEditor (nếu đang sử dụng CKEditor trong dự án)
     * Trả về format: { uploaded: 1, fileName: '...', url: '...' }
     * 
     * Lưu ý: CKEditor tự động thêm &responseType=json vào URL khi upload
     * Đây là hành vi mặc định của CKEditor filebrowser plugin
     */
    public function uploadImage(Request $request): JsonResponse
    {
        // Log ngay từ đầu để đảm bảo request đến được server
        Log::info('CKEditor uploadImage request received', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'has_file' => $request->hasFile('upload'),
            'has_token' => $request->has('_token'),
            'has_cktoken' => $request->has('ckCsrfToken'),
            'all_files' => array_keys($request->allFiles()),
            'content_type' => $request->header('Content-Type'),
            'user_agent' => $request->header('User-Agent'),
        ]);
        
        try {
            
            // Nếu có ckCsrfToken nhưng không có _token, thêm _token từ ckCsrfToken
            if ($request->has('ckCsrfToken') && !$request->has('_token')) {
                $request->merge(['_token' => $request->input('ckCsrfToken')]);
            }
            
            // Chấp nhận 1 trong 2 token (_token hoặc ckCsrfToken)
            if (!$request->has('_token') && !$request->has('ckCsrfToken')) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'CSRF token không hợp lệ!'
                    ]
                ], 400);
            }

            if (!$request->hasFile('upload')) {
                Log::warning('CKEditor upload: No file uploaded', [
                    'all_files' => array_keys($request->allFiles()),
                ]);
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Không có file nào được tải lên!'
                    ]
                ], 400);
            }

            $file = $request->file('upload');
            
            Log::info('CKEditor file object', [
                'file_exists' => $file !== null,
                'is_valid' => $file ? $file->isValid() : false,
                'original_name' => $file ? $file->getClientOriginalName() : null,
                'size' => $file ? $file->getSize() : null,
                'mime_type' => $file ? $file->getMimeType() : null,
            ]);
            
            if (!$file || !$file->isValid()) {
                Log::warning('CKEditor upload: Invalid file', [
                    'file_exists' => $file !== null,
                    'is_valid' => $file ? $file->isValid() : false,
                ]);
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'File không hợp lệ hoặc bị lỗi khi upload!'
                    ]
                ], 400);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $mimeType = $file->getMimeType();
            
            // Nếu không có MIME type, thử lấy từ client
            if (empty($mimeType)) {
                $clientMime = $file->getClientMimeType();
                $mimeType = $clientMime ?: 'image/jpeg'; // Mặc định là jpeg
            }
            
            if (!in_array($mimeType, $allowedTypes)) {
                Log::warning('CKEditor upload: Invalid MIME type', [
                    'mime' => $mimeType,
                    'filename' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ]);
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Chỉ chấp nhận file hình ảnh (JPEG, PNG, GIF, WebP)! MIME type: ' . $mimeType
                    ]
                ], 400);
            }

            // Giới hạn kích thước 5MB
            $maxSize = 5 * 1024 * 1024;
            $fileSize = $file->getSize();
            if ($fileSize > $maxSize) {
                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Kích thước ảnh vượt quá 5MB!'
                    ]
                ], 413);
            }

            $originalName = $file->getClientOriginalName();
            $safeName = preg_replace('/\s+/', '_', $originalName);
            $originalBase = pathinfo($originalName, PATHINFO_FILENAME);
            
            // Xử lý đặc biệt cho file từ camera
            $isCameraFile = (
                $originalName === 'image.jpg' || 
                $originalName === 'image.jpeg' || 
                $originalName === 'image.png' ||
                $originalBase === 'image' ||
                $originalBase === 'blob' ||
                empty($originalBase) ||
                strpos($originalName, 'blob') !== false
            );
            
            // Kiểm tra xem file có extension không
            $ext = strtolower($file->getClientOriginalExtension());
            if (empty($ext) || $isCameraFile) {
                // Nếu không có extension hoặc là file từ camera,
                // lấy extension từ MIME type
                $mimeToExt = [
                    'image/jpeg' => 'jpg',
                    'image/jpg' => 'jpg',
                    'image/png' => 'png',
                    'image/gif' => 'gif',
                    'image/webp' => 'webp',
                ];
                $ext = $mimeToExt[$mimeType] ?? 'jpg'; // Mặc định là jpg nếu không xác định được
                
                Log::info('CKEditor: Camera file detected or no extension', [
                    'original_name' => $originalName,
                    'original_base' => $originalBase,
                    'detected_ext' => $ext,
                    'mime_type' => $mimeType,
                    'is_camera_file' => $isCameraFile,
                ]);
                
                // Nếu tên file không có extension hoặc là file từ camera, tạo lại tên
                if (!preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $safeName) || $isCameraFile) {
                    $baseName = pathinfo($safeName, PATHINFO_FILENAME);
                    if (empty($baseName) || $baseName === 'blob' || $baseName === 'image') {
                        $baseName = 'image';
                    }
                    $safeName = $baseName . '.' . $ext;
                }
            }
            
            // Đảm bảo extension hợp lệ
            if (empty($ext) || !in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                $ext = 'jpg';
            }
            
            $filename = time() . '_' . $safeName;
            $folder = 'uploads/' . date('Ymd');
            
            // Log thông tin file trước khi upload
            Log::info('CKEditor processing upload', [
                'original_name' => $originalName,
                'safe_name' => $safeName,
                'extension' => $ext,
                'mime_type' => $mimeType,
                'final_filename' => $filename,
                'size' => $file->getSize(),
            ]);
            
            // Đảm bảo thư mục tồn tại
            if (!Storage::disk('public')->exists($folder)) {
                Storage::disk('public')->makeDirectory($folder);
            }
            
            $path = $file->storeAs($folder, $filename, 'public');
            
            if (!$path) {
                Log::error('CKEditor upload: Cannot save file', [
                    'folder' => $folder,
                    'filename' => $filename,
                ]);
                throw new \Exception('Không thể lưu file vào storage');
            }
            
            $url = Storage::url($path);

            Log::info('CKEditor upload success', [
                'filename' => $filename,
                'path' => $path,
                'url' => $url,
                'mime' => $mimeType,
            ]);

            // Trả về format đúng theo chuẩn CKEditor
            return response()->json([
                'uploaded' => 1,
                'fileName' => $filename,
                'url' => $url,
            ]);
        } catch (\Throwable $e) {
            $errorMessage = $e->getMessage();
            $fileName = $request->file('upload')?->getClientOriginalName() ?? 'unknown';
            
            Log::error('CKEditor upload error', [
                'message' => $errorMessage,
                'file_name' => $fileName,
                'trace' => $e->getTraceAsString(),
            ]);
            
            // Message phải ngắn gọn và rõ ràng
            $userMessage = 'Không thể tải lên file';
            if (strpos($errorMessage, 'image') !== false || strpos($errorMessage, 'jpg') !== false) {
                $userMessage = 'Lỗi khi xử lý ảnh. Vui lòng thử lại với ảnh khác.';
            } elseif (strpos($errorMessage, 'storage') !== false || strpos($errorMessage, 'permission') !== false) {
                $userMessage = 'Lỗi hệ thống khi lưu file. Vui lòng liên hệ quản trị viên.';
            } elseif (strpos($errorMessage, 'size') !== false) {
                $userMessage = 'File quá lớn. Vui lòng chọn file nhỏ hơn 5MB.';
            }
            
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => $userMessage
                ],
                'message' => $userMessage,
            ], 500);
        }
    }
}
