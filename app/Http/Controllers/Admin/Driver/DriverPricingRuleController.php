<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\DriverPricingRule\StoreRequest;
use App\Http\Requests\Admin\Driver\DriverPricingRule\UpdateRequest;
use App\Services\Admin\Driver\DriverPricingRuleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverPricingRuleController extends BaseController
{
    public function __construct(DriverPricingRuleService $driverPricingRuleService)
    {
        $this->service = $driverPricingRuleService;
    }

    /**
     * Lấy service instance
     * @return DriverPricingRuleService
     */
    public function getService(): DriverPricingRuleService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách quy tắc giá
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());

        // Load pricing rules with relationships
        $pricingRules = \App\Models\DriverPricingRule::with(['pricingDistances.distanceTier'])
            ->orderBy('sort_order')
            ->paginate($options['perPage'] ?? 10);

        $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();

        return view('admin.driver.pricing-rules.index', compact('pricingRules', 'distanceTiers', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo quy tắc giá
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();
        return view('admin.driver.pricing-rules.create', compact('distanceTiers'));
    }

    /**
     * Xử lý tạo quy tắc giá
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request): \Illuminate\Http\RedirectResponse
    {
        $result = $this->getService()->create($request->validated());

        if ($result['success']) {
            return redirect()->route('admin.driver.pricing-rules.index')
                ->with('success', $result['message'] ?? 'Tạo quy tắc giá thành công.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $result['message'] ?? 'Tạo quy tắc giá thất bại.');
        }
    }

    /**
     * Hiển thị chi tiết quy tắc giá
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $pricingRule = $this->getService()->findById($id);

        if (!$pricingRule) {
            return response()->json([
                'success' => false,
                'message' => 'Quy tắc giá không tồn tại.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin quy tắc giá thành công.',
            'data' => $pricingRule
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa quy tắc giá
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $pricingRule = $this->getService()->findById($id);

        if (!$pricingRule) {
            abort(404, 'Quy tắc giá không tồn tại.');
        }

        $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();
        return view('admin.driver.pricing-rules.edit', compact('pricingRule', 'distanceTiers'));
    }

    /**
     * Xử lý chỉnh sửa quy tắc giá
     * @param UpdateRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $result = $this->getService()->update($id, $request->validated());

        if ($result['success']) {
            return redirect()->route('admin.driver.pricing-rules.index')
                ->with('success', $result['message'] ?? 'Cập nhật quy tắc giá thành công.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $result['message'] ?? 'Cập nhật quy tắc giá thất bại.');
        }
    }

    /**
     * Xử lý xóa quy tắc giá
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $result = $this->getService()->delete($id);

        if ($result['success']) {
            return redirect()->route('admin.driver.pricing-rules.index')
                ->with('success', $result['message'] ?? 'Xóa quy tắc giá thành công.');
        } else {
            return redirect()->back()
                ->with('error', $result['message'] ?? 'Xóa quy tắc giá thất bại.');
        }
    }

    /**
     * Thay đổi trạng thái quy tắc giá
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
     * Thay đổi trạng thái nổi bật của quy tắc giá
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
}
