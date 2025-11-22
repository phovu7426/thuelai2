<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Posts\StoreRequest;
use App\Http\Requests\Admin\Posts\UpdateRequest;
use App\Services\Admin\Posts\PostService;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    /**
     * Lấy service instance
     * @return PostService
     */
    public function getService(): PostService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách bài viết
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $posts = $this->getService()->getList($filters, $options);
        $categories = PostCategory::active()->ordered()->get();
        
        return view('admin.posts.index', compact('posts', 'filters', 'options', 'categories'));
    }

    /**
     * Hiển thị form tạo bài viết
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $categories = PostCategory::active()->ordered()->get();
        $tags = PostTag::active()->get();
        
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Xử lý tạo bài viết
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->all());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo bài viết thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa bài viết
     * @param Post $post
     * @return View|Application|Factory
     */
    public function edit(Post $post): View|Application|Factory
    {
        $categories = PostCategory::active()->ordered()->get();
        $tags = PostTag::active()->get();
        
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Hiển thị chi tiết bài viết
     * @param Post $post
     * @return JsonResponse
     */
    public function show(Post $post): JsonResponse
    {
        $post->load(['category', 'tags']);
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin bài viết thành công.',
            'data' => $post
        ]);
    }

    /**
     * Xử lý chỉnh sửa bài viết
     * @param UpdateRequest $request
     * @param Post $post
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, Post $post): JsonResponse
    {
        $result = $this->getService()->update($post->id, $request->all());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật bài viết thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa bài viết
     * @param Post $post
     * @return JsonResponse
     */
    public function destroy(Post $post): JsonResponse
    {
        $result = $this->getService()->delete($post->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa bài viết thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái bài viết
     * @param Post $post
     * @return JsonResponse
     */
    public function toggleStatus(Post $post): JsonResponse
    {
        $result = $this->getService()->toggleStatus($post->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái nổi bật
     * @param Post $post
     * @return JsonResponse
     */
    public function toggleFeatured(Post $post): JsonResponse
    {
        $result = $this->getService()->toggleFeatured($post->id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái nổi bật thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }
}


