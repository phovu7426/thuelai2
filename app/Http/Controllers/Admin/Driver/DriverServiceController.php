<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\DriverService\StoreRequest;
use App\Http\Requests\Admin\Driver\DriverService\UpdateRequest;
use App\Services\Admin\Driver\DriverServiceService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverServiceController extends BaseController
{
    public function __construct(DriverServiceService $driverServiceService)
    {
        $this->service = $driverServiceService;
    }

    /**
     * Lấy service instance
     * @return DriverServiceService
     */
    public function getService(): DriverServiceService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách dịch vụ lái xe
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $services = $this->getService()->getList($filters, $options);
        
        return view('admin.driver.services.index', compact('services', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo dịch vụ lái xe
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.driver.services.create');
    }

    /**
     * Xử lý tạo dịch vụ lái xe
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo dịch vụ lái xe thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa dịch vụ lái xe
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $service = $this->getService()->findById($id);
        
        if (!$service) {
            abort(404, 'Dịch vụ lái xe không tồn tại.');
        }
        
        return view('admin.driver.services.edit', compact('service'));
    }

    /**
     * Hiển thị chi tiết dịch vụ lái xe (HTML view)
     * @param int $id
     * @return View|Application|Factory
     */
    public function view(int $id): View|Application|Factory
    {
        $service = $this->getService()->findById($id);
        
        if (!$service) {
            abort(404, 'Dịch vụ lái xe không tồn tại.');
        }
        
        return view('admin.driver.services.show', compact('service'));
    }

    /**
     * Hiển thị chi tiết dịch vụ lái xe (JSON data cho modal)
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $service = $this->getService()->findById($id);
        
        if (!$service) {
            return response()->json([
                'success' => false,
                'message' => 'Dịch vụ lái xe không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin dịch vụ lái xe thành công.',
            'data' => $service
        ]);
    }

    /**
     * Xử lý chỉnh sửa dịch vụ lái xe
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật dịch vụ lái xe thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa dịch vụ lái xe
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa dịch vụ lái xe thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái dịch vụ lái xe
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
     * Thay đổi trạng thái nổi bật
     * @param int $id
     * @return JsonResponse
     */
    public function toggleFeatured(int $id): JsonResponse
    {
        $result = $this->getService()->toggleFeatured($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái nổi bật thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Cập nhật thứ tự dịch vụ
     * @param Request $request
     * @return JsonResponse
     */
    public function updateOrder(Request $request): JsonResponse
    {
        $result = $this->getService()->updateOrder($request->all());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['success'] ? 'Cập nhật thứ tự thành công' : 'Cập nhật thứ tự thất bại',
            'data' => $result['data'] ?? null
        ]);
    }
}
