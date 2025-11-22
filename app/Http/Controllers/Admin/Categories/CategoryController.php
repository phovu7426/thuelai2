<?php

namespace App\Http\Controllers\Admin\Categories;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Categories\StoreRequest;
use App\Http\Requests\Admin\Categories\UpdateRequest;
use App\Services\Admin\Categories\CategoryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function __construct(CategoryService $categoryService)
    {
        $this->service = $categoryService;
    }

    public function getService(): CategoryService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách danh mục
     * @param Request $request
     * @return Factory|Application|View
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $categories = $this->getService()->getList($filters, $options);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Hiển thị form tạo danh mục
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $categories = $this->getService()->getList();
        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Xử lý tạo danh mục
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thêm mới danh mục thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết danh mục
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $category = $this->getService()->findById($id);
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin danh mục thành công.',
            'data' => $category
        ]);
    }

    /**
     * Hiển thị form sửa danh mục
     * @param $id
     * @return View|Application|Factory
     */
    public function edit($id): View|Application|Factory
    {
        $category = $this->getService()->findById($id);
        $categories = $this->getService()->getAll();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    /**
     * Xử lý cập nhật danh mục
     * @param UpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật danh mục thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xóa danh mục
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa danh mục thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái danh mục
     * @param $id
     * @return JsonResponse
     */
    public function toggleStatus($id): JsonResponse
    {
        $result = $this->getService()->toggleStatus($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái nổi bật của danh mục
     * @param $id
     * @return JsonResponse
     */
    public function toggleFeatured($id): JsonResponse
    {
        $result = $this->getService()->toggleFeatured($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái nổi bật thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }
}
