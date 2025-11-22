<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Posts\PostCategory\StoreRequest;
use App\Http\Requests\Admin\Posts\PostCategory\UpdateRequest;
use App\Services\Admin\Posts\PostCategoryService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostCategoryController extends BaseController
{
    public function __construct(PostCategoryService $postCategoryService)
    {
        $this->service = $postCategoryService;
    }

    /**
     * Lấy service instance
     * @return PostCategoryService
     */
    public function getService(): PostCategoryService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách danh mục
     * @param Request $request
     * @return View|Application|Factory|JsonResponse
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $categories = $this->getService()->getList($filters, $options);
        
        return view('admin.post-categories.index', compact('categories', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo danh mục
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.post-categories.create');
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
            'message' => $result['message'] ?? 'Tạo danh mục thất bại.',
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
     * Hiển thị form chỉnh sửa danh mục
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $category = $this->getService()->findById($id);
        
        if (!$category) {
            abort(404, 'Danh mục không tồn tại.');
        }
        
        return view('admin.post-categories.edit', compact('category'));
    }

    /**
     * Xử lý chỉnh sửa danh mục
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật danh mục thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa danh mục
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
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
     * Thay đổi trạng thái nổi bật của tag
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
     * Autocomplete cho danh mục
     * @param Request $request
     * @return JsonResponse
     */
    public function autocomplete(Request $request): JsonResponse
    {
        $term = $request->get('term', '');
        $limit = $request->get('limit', 10);
        $excludeId = $request->get('exclude_id');
        
        $categories = $this->getService()->autocomplete($term, 'name', $limit, $excludeId);
        
        return $categories;
    }

}


