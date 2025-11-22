<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ViewController extends BaseController
{
    /**
     * Load view cho modal
     * @param Request $request
     * @return JsonResponse
     */
    public function loadView(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'view' => 'required|string',
                'data' => 'nullable|string'
            ]);

            $viewPath = $request->input('view');
            $data = json_decode($request->input('data', '{}'), true) ?? [];
            
            // Log để debug
            Log::info('Loading view', [
                'view' => $viewPath,
                'data' => $data,
                'user_id' => Auth::check() ? Auth::id() : null
            ]);

            // Kiểm tra view có tồn tại không
            if (!View::exists($viewPath)) {
                Log::warning('View not found', ['view' => $viewPath]);
                return response()->json([
                    'success' => false,
                    'message' => 'View không tồn tại: ' . $viewPath
                ], 404);
            }

            // Kiểm tra dữ liệu trước khi render
            if (isset($data['permissions']) && is_array($data['permissions'])) {
                // Đảm bảo permissions là collection hoặc array
                if (is_object($data['permissions']) && method_exists($data['permissions'], 'toArray')) {
                    $data['permissions'] = $data['permissions']->toArray();
                }
            }
            
            // Đảm bảo $data luôn là array
            if (!is_array($data)) {
                $data = [];
            }
            
            // Nếu có key 'data' (ví dụ dữ liệu bản ghi), làm phẳng để Blade dùng biến 1 cấp
            if (isset($data['data']) && is_array($data['data'])) {
                $record = $data['data'];
                unset($data['data']);

                // Nếu có profile lồng bên trong thì merge lên 1 cấp
                if (isset($record['profile']) && is_array($record['profile'])) {
                    $record = array_merge($record, $record['profile']);
                    unset($record['profile']);
                }

                // Nếu có permissions (quan hệ) thì trích danh sách tên để dùng cho select2
                if (isset($record['permissions']) && is_array($record['permissions'])) {
                    $selectedPermissionNames = [];
                    foreach ($record['permissions'] as $perm) {
                        if (is_array($perm) && isset($perm['name'])) {
                            $selectedPermissionNames[] = $perm['name'];
                        } elseif (is_object($perm) && isset($perm->name)) {
                            $selectedPermissionNames[] = $perm->name;
                        }
                    }
                    $data['permissions_selected'] = $selectedPermissionNames;
                    unset($record['permissions']);
                }

                // Merge các field của record lên $data để Blade nhận biến 1 cấp
                $data = array_merge($data, $record);
            }

            // Render view với data
            $html = view($viewPath, $data)->render();

            Log::info('View loaded successfully', ['view' => $viewPath]);

            return response()->json([
                'success' => true,
                'html' => $html,
                'message' => 'Load view thành công'
            ]);

        } catch (\Exception $e) {
            Log::error('Error loading view', [
                'view' => $request->input('view'),
                'data' => $request->input('data'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }
}
