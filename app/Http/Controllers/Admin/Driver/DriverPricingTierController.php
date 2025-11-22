<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\DriverPricingTier\StoreRequest;
use App\Http\Requests\Admin\Driver\DriverPricingTier\UpdateRequest;
use App\Services\Admin\Driver\DriverPricingTierService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverPricingTierController extends BaseController
{
    public function __construct(DriverPricingTierService $driverPricingTierService)
    {
        $this->service = $driverPricingTierService;
    }

    /**
     * Lấy service instance
     * @return DriverPricingTierService
     */
    public function getService(): DriverPricingTierService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách mức giá
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $pricingTiers = $this->getService()->getList($filters, $options);
        $pricingTiers = $pricingTiers->groupBy('time_slot');
        
        return view('admin.driver.pricing-tiers.index', compact('pricingTiers', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo mức giá
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.driver.pricing-tiers.create');
    }

    /**
     * Xử lý tạo mức giá
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo mức giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết mức giá
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $pricingTier = $this->getService()->findById($id);
        
        if (!$pricingTier) {
            return response()->json([
                'success' => false,
                'message' => 'Mức giá không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin mức giá thành công.',
            'data' => $pricingTier
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa mức giá
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $pricingTier = $this->getService()->findById($id);
        
        if (!$pricingTier) {
            abort(404, 'Mức giá không tồn tại.');
        }
        
        return view('admin.driver.pricing-tiers.edit', compact('pricingTier'));
    }

    /**
     * Xử lý chỉnh sửa mức giá
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật mức giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa mức giá
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa mức giá thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái mức giá
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
}
