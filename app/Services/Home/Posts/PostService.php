<?php

namespace App\Services\Home\Posts;

use App\Repositories\Home\Posts\PostRepository;
use App\Services\BaseService;
use App\Enums\BasicStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PostService extends BaseService
{
    public function __construct(PostRepository $postRepository) {
        $this->repository = $postRepository;
    }

    protected function getRepository(): PostRepository
    {
        return $this->repository;
    }
    
    /**
     * Lấy chi tiết bài đăng
     * @param int $id
     * @return Model|null
     */
    public function show(int $id): ?Model
    {
        $post = $this->getRepository()->findById($id, [
            'relations' => ['user']
        ]);
        if (!$post || $post->status !== BasicStatus::ACTIVE->value) {
            return null;
        }
        // Kiểm tra quyền xem bài đăng yêu cầu đăng nhập
        if (!Auth::check() && !empty($post->require_login)) {
            return null;
        }
        return $post;
    }
    
    /**
     * Lấy bài đăng liên quan
     * @param int $postId
     * @param int $limit
     * @return mixed
     */
    public function getRelatedPosts(int $postId, int $limit = 4)
    {
        $filters = ['status' => BasicStatus::ACTIVE->value];
        // Kiểm tra người dùng đăng nhập để lọc bài đăng
        if (!Auth::check()) {
            $filters['require_login'] = false;
        }
        return $this->getRepository()->getModel()
            ->where('status', BasicStatus::ACTIVE->value)
            ->where('id', '!=', $postId)
            ->when(!Auth::check(), function($query) {
                return $query->where('require_login', false);
            })
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
} 