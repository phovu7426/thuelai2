<?php

namespace App\Http\Controllers\Admin\Driver;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Driver\DriverDistanceTier\StoreRequest;
use App\Http\Requests\Admin\Driver\DriverDistanceTier\UpdateRequest;
use App\Services\Admin\Driver\DriverDistanceTierService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DriverDistanceTierController extends BaseController
{
    public function __construct(DriverDistanceTierService $driverDistanceTierService)
    {
        $this->service = $driverDistanceTierService;
    }

    /**
     * Lấy service instance
     * @return DriverDistanceTierService
     */
    public function getService(): DriverDistanceTierService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách khoảng cách
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $distanceTiers = $this->getService()->getList($filters, $options);

        return view('admin.driver.distance-tiers.index', compact('distanceTiers', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo khoảng cách
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.driver.distance-tiers.create');
    }

    /**
     * Xử lý tạo khoảng cách
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $result = $this->getService()->create($request->validated());

        if ($result['success'] ?? false) {
            return redirect()->route('admin.driver.distance-tiers.index')
                ->with('success', $result['message'] ?? 'Tạo khoảng cách thành công.');
        } else {
            return redirect()->back()
                ->withInput()
                ->with('error', $result['message'] ?? 'Tạo khoảng cách thất bại.');
        }
    }

    /**
     * Hiển thị chi tiết khoảng cách
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $distanceTier = $this->getService()->findById($id);

        if (!$distanceTier) {
            return response()->json([
                'success' => false,
                'message' => 'Khoảng cách không tồn tại.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin khoảng cách thành công.',
            'data' => $distanceTier
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa khoảng cách
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $distanceTier = $this->getService()->findById($id);

        if (!$distanceTier) {
            abort(404, 'Khoảng cách không tồn tại.');
        }

        return view('admin.driver.distance-tiers.edit', compact('distanceTier'));
    }

    /**
     * Xử lý chỉnh sửa khoảng cách
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());

        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật khoảng cách thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa khoảng cách
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);

        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa khoảng cách thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái khoảng cách
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
     * Thay đổi trạng thái nổi bật của khoảng cách
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
