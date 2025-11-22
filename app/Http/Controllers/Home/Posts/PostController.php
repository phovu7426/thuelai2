<?php

namespace App\Http\Controllers\Home\Posts;

use App\Http\Controllers\BaseController;
use App\Services\Home\Posts\PostService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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

    protected function getFilters(array $filters = [], array $allowKeys = []): array
    {
        if (!empty($filters['search'])) {
            $filters['name'] = $filters['search'];
        }
        return parent::getFilters($filters, $allowKeys);
    }
    

    /**
     * Hiển thị danh sách bài đăng
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $posts = $this->getService()->getList($filters, $options);
        return view('home.posts.index', compact('posts'));
    }
    
    /**
     * Hiển thị chi tiết bài đăng
     * @param string $slug
     * @return View|Application|Factory
     */
    public function show(string $slug): View|Application|Factory
    {
        $post = $this->getService()->showBySlug($slug);
        abort_if(!$post, 404, 'Bài đăng không tồn tại hoặc yêu cầu đăng nhập');
        $relatedPosts = $this->getService()->getRelatedPosts($post->id);
        return view('home.posts.show', compact('post', 'relatedPosts'));
    }
} 