<?php

namespace App\Services\Admin\Posts;

use App\Repositories\Admin\Posts\PostRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use lib\DataTable;

class PostService extends BaseService
{
    public function __construct(PostRepository $postRepository)
    {
        $this->repository = $postRepository;
    }

    protected function getRepository(): PostRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo bài viết
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới bài viết thất bại'
        ];

        try {
            $data['author_id'] = Auth::id();
            $data['featured'] = isset($data['featured']);
            $data['slug'] = Str::slug($data['title']);
            
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $data['image']->store('posts', 'public');
            }

            if (isset($data['status']) && $data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $keys = ['title', 'excerpt', 'content', 'category_id', 'image', 'status', 'published_at', 
                    'meta_title', 'meta_description', 'meta_keywords', 'featured', 'author_id', 'slug'];
            
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($post = $this->getRepository()->create($insertData)) {
                // Xử lý tags
                if (isset($data['tags']) && is_array($data['tags'])) {
                    $post->tags()->attach($data['tags']);
                }
                
                $return['success'] = true;
                $return['message'] = 'Thêm mới bài viết thành công';
                $return['data'] = $post;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật bài viết
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật bài viết thất bại'
        ];

        try {
            $post = $this->getRepository()->findById($id);
            if (!$post) {
                $return['message'] = 'Bài viết không tồn tại';
                return $return;
            }

            $data['featured'] = isset($data['featured']);
            $data['slug'] = Str::slug($data['title']);
            
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                // Xóa ảnh cũ
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $data['image']->store('posts', 'public');
            }

            if (isset($data['status']) && $data['status'] === 'published' && empty($data['published_at'])) {
                $data['published_at'] = now();
            }

            $keys = ['title', 'excerpt', 'content', 'category_id', 'image', 'status', 'published_at', 
                    'meta_title', 'meta_description', 'meta_keywords', 'featured', 'slug'];
            
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($post, $updateData)) {
                // Xử lý tags
                if (isset($data['tags'])) {
                    $post->tags()->sync($data['tags'] ?? []);
                }
                
                $return['success'] = true;
                $return['message'] = 'Cập nhật bài viết thành công';
                $return['data'] = $post->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa bài viết
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa bài viết thất bại'
        ];

        try {
            $post = $this->getRepository()->findById($id);
            
            if (!$post) {
                $return['message'] = 'Bài viết không tồn tại';
                return $return;
            }

            // Xóa ảnh
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            if ($this->getRepository()->delete($post)) {
                $return['success'] = true;
                $return['message'] = 'Xóa bài viết thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái bài viết
     * @param int $id
     * @return array
     */
    public function toggleStatus(int $id): array
    {
        $return = [
            'success' => false,
            'message' => 'Thay đổi trạng thái thất bại'
        ];

        try {
            $post = $this->getRepository()->findById($id);
            
            if (!$post) {
                $return['message'] = 'Bài viết không tồn tại';
                return $return;
            }

            if ($post->status === 'published') {
                $post->update(['status' => 'draft']);
                $status = 'draft';
                $message = 'Bài viết đã được chuyển về bản nháp!';
            } else {
                $post->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $status = 'published';
                $message = 'Bài viết đã được xuất bản!';
            }

            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $status];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái nổi bật
     * @param int $id
     * @return array
     */
    public function toggleFeatured(int $id): array
    {
        $return = [
            'success' => false,
            'message' => 'Thay đổi trạng thái nổi bật thất bại'
        ];

        try {
            $post = $this->getRepository()->findById($id);
            
            if (!$post) {
                $return['message'] = 'Bài viết không tồn tại';
                return $return;
            }

            $post->update(['featured' => !$post->featured]);
            
            $message = $post->featured ? 'Bài viết đã được đánh dấu nổi bật!' : 'Bài viết đã bỏ đánh dấu nổi bật!';
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['featured' => $post->featured];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách bài viết theo từ khóa
     * @param string|null $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'title', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, $column, $limit);
    }
}
