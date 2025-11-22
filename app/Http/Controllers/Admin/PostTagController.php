<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Posts\PostTag\StoreRequest;
use App\Http\Requests\Admin\Posts\PostTag\UpdateRequest;
use App\Services\Admin\Posts\PostTagService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostTagController extends BaseController
{
    public function __construct(PostTagService $postTagService)
    {
        $this->service = $postTagService;
    }

    /**
     * Lấy service instance
     * @return PostTagService
     */
    public function getService(): PostTagService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách tags
     * @param Request $request
     * @return View|Application|Factory|JsonResponse
     */
    public function index(Request $request): View|Application|Factory|JsonResponse
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $tags = $this->getService()->getList($filters, $options);
        
        // Nếu là AJAX request, trả về JSON
        if ($request->ajax()) {
            $html = view('admin.post-tags.partials.table', compact('tags'))->render();
            $pagination = view('admin.post-tags.partials.pagination', compact('tags'))->render();
            
            return response()->json([
                'html' => $html,
                'pagination' => $pagination
            ]);
        }
        
        return view('admin.post-tags.index', compact('tags', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo tag
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.post-tags.create');
    }

    /**
     * Xử lý tạo tag
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo tag thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết tag
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $tag = $this->getService()->findById($id);
        
        if (!$tag) {
            return response()->json([
                'success' => false,
                'message' => 'Tag không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin tag thành công.',
            'data' => $tag
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa tag
     * @param int $id
     * @return View|Application|Factory
     */
    public function edit(int $id): View|Application|Factory
    {
        $tag = $this->getService()->findById($id);
        
        if (!$tag) {
            abort(404, 'Tag không tồn tại.');
        }
        
        return view('admin.post-tags.edit', compact('tag'));
    }

    /**
     * Xử lý chỉnh sửa tag
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật tag thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa tag
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa tag thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái tag
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
}


