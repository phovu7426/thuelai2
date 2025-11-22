<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Posts\StoreRequest;
use App\Http\Requests\Admin\Posts\UpdateRequest;
use App\Services\Admin\Posts\PostService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends BaseController
{
    public function __construct(PostService $postService)
    {
        $this->service = $postService;
    }

    public function getService(): PostService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách bài đăng
     * @param Request $request
     * @return Factory|Application|View
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $posts = $this->getService()->getList($filters, $options);
        
        // Lấy danh sách categories để hiển thị trong filter
        $categories = \App\Models\PostCategory::all();
        
        return view('admin.posts.index', compact('posts', 'categories'));
    }

    /**
     * Hiển thị form tạo bài đăng
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $categories = \App\Models\PostCategory::all();
        return view('admin.posts.create', compact('categories'));
    }

    /**
     * Xử lý tạo bài đăng
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $return = $this->getService()->create($request->all());
        if (!empty($return['success'])) {
            return redirect()->route('admin.posts.index')
                ->with('success', $return['message'] ?? 'Thêm mới bài đăng thành công.');
        }
        return redirect()->route('admin.posts.index')
            ->with('fail', $return['message'] ?? 'Thêm mới bài đăng thất bại.');
    }

    /**
     * Hiển thị form sửa bài đăng
     * @param $id
     * @return View|Application|Factory
     */
    public function edit($id): View|Application|Factory
    {
        $post = $this->getService()->findById($id);
        $categories = \App\Models\PostCategory::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    /**
     * Hiển thị chi tiết bài đăng
     * @param $id
     * @return View|Application|Factory
     */
    public function show($id): View|Application|Factory
    {
        $post = $this->getService()->findById($id);
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Xử lý cập nhật bài đăng
     * @param UpdateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, $id): RedirectResponse
    {
        $return = $this->getService()->update($id, $request->all());
        if (!empty($return['success'])) {
            return redirect()->route('admin.posts.index')
                ->with('success', $return['message'] ?? 'Cập nhật bài đăng thành công.');
        }
        return redirect()->route('admin.posts.index')
            ->with('fail', $return['message'] ?? 'Cập nhật bài đăng thất bại.');
    }

    /**
     * Xóa bài đăng
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): RedirectResponse
    {
        $return = $this->getService()->delete($id);
        if (!empty($return['success'])) {
            return redirect()->route('admin.posts.index')
                ->with('success', $return['message'] ?? 'Xóa bài đăng thành công.');
        }
        return redirect()->route('admin.posts.index')
            ->with('fail', $return['message'] ?? 'Xóa bài đăng thất bại.');
    }
}
