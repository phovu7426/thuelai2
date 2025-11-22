<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\DriverContact\StoreRequest;
use App\Http\Requests\Admin\Driver\DriverContact\UpdateRequest;
use App\Services\Admin\Driver\DriverContactService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverContactController extends BaseController
{
    public function __construct(DriverContactService $driverContactService)
    {
        $this->service = $driverContactService;
    }

    /**
     * Lấy service instance
     * @return DriverContactService
     */
    public function getService(): DriverContactService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách liên hệ
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $contacts = $this->getService()->getList($filters, $options);
        
        return view('admin.driver.contacts.index', compact('contacts', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo liên hệ
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.driver.contacts.create');
    }

    /**
     * Xử lý tạo liên hệ
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo liên hệ thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết liên hệ
     * @param int $id
     * @return View|Application|Factory|JsonResponse
     */
    public function show(int $id): View|Application|Factory|JsonResponse
    {
        $contact = $this->getService()->findById($id);
        
        if (!$contact) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Liên hệ không tồn tại.'
                ], 404);
            }
            abort(404, 'Liên hệ không tồn tại.');
        }
        
        // Nếu là AJAX request, trả về JSON
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $contact
            ]);
        }
        
        // Nếu không phải AJAX, trả về view
        return view('admin.driver.contacts.show', compact('contact'));
    }

    /**
     * Hiển thị form chỉnh sửa liên hệ
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $contact = $this->getService()->findById($id);
        
        if (!$contact) {
            abort(404, 'Liên hệ không tồn tại.');
        }
        
        return view('admin.driver.contacts.edit', compact('contact'));
    }

    /**
     * Xử lý chỉnh sửa liên hệ
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật liên hệ thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa liên hệ
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa liên hệ thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Cập nhật trạng thái liên hệ
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function updateStatus(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:unread,read,replied,closed',
            'admin_notes' => 'nullable|string'
        ]);

        $result = $this->getService()->updateStatus(
            $id, 
            $request->status, 
            $request->admin_notes
        );
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Đánh dấu đã đọc
     * @param int $id
     * @return JsonResponse
     */
    public function markAsRead(int $id): JsonResponse
    {
        $result = $this->getService()->markAsRead($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Đánh dấu đã đọc thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái liên hệ
     * @param int $id
     * @return JsonResponse
     */
    public function toggleStatus(int $id): JsonResponse
    {
        $result = $this->getService()->toggleStatus($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Lọc liên hệ theo trạng thái
     * @param Request $request
     * @return JsonResponse
     */
    public function filterByStatus(Request $request): JsonResponse
    {
        $status = $request->get('status');
        $filters = ['status' => $status];
        $options = $this->getOptions($request->all());
        
        $contacts = $this->getService()->getList($filters, $options);
        
        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    /**
     * Tìm kiếm liên hệ
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request): JsonResponse
    {
        $search = $request->get('search');
        $filters = ['search' => $search];
        $options = $this->getOptions($request->all());
        
        $contacts = $this->getService()->getList($filters, $options);
        
        return response()->json([
            'success' => true,
            'data' => $contacts
        ]);
    }

    /**
     * Bulk actions
     * @param Request $request
     * @return JsonResponse
     */
    public function bulkAction(Request $request): JsonResponse
    {
        $request->validate([
            'action' => 'required|in:delete,mark-read,mark-replied,mark-closed',
            'ids' => 'required|array'
        ]);

        $result = $this->getService()->bulkAction($request->action, $request->ids);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thực hiện hành động thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xuất dữ liệu liên hệ
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(Request $request)
    {
        $status = $request->get('status');
        $filters = ['status' => $status];
        $options = ['per_page' => 1000]; // Lấy tất cả để export
        
        $contacts = $this->getService()->getList($filters, $options);
        
        // Tạo file CSV
        $filename = 'driver_contacts_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($contacts) {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, [
                'Tên',
                'Email',
                'Số điện thoại',
                'Chủ đề',
                'Nội dung',
                'Trạng thái',
                'Ghi chú admin',
                'Ngày tạo'
            ]);

            // Data
            foreach ($contacts as $contact) {
                fputcsv($file, [
                    $contact->name,
                    $contact->email,
                    $contact->phone,
                    $contact->subject,
                    $contact->message,
                    $contact->status_text,
                    $contact->admin_notes,
                    $contact->created_at->format('d/m/Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
