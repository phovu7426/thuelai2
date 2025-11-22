<?php

namespace App\Services\Admin\Posts;

use App\Repositories\Admin\Posts\PostTagRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class PostTagService extends BaseService
{
    public function __construct(PostTagRepository $postTagRepository)
    {
        $this->repository = $postTagRepository;
    }

    protected function getRepository(): PostTagRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo tag
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới tag thất bại'
        ];

        try {
            $data['is_active'] = isset($data['is_active']);
            $data['is_featured'] = isset($data['is_featured']);
            
            // Tự động sinh slug từ name
            if (!empty($data['name'])) {
                $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            }
            
            $keys = ['name', 'description', 'color', 'icon', 'is_active', 'is_featured', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($tag = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới tag thành công';
                $return['data'] = $tag;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật tag
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật tag thất bại'
        ];

        try {
            $tag = $this->getRepository()->findById($id);
            
            if (!$tag) {
                $return['message'] = 'Tag không tồn tại';
                return $return;
            }

            $data['is_active'] = isset($data['is_active']);
            $data['is_featured'] = isset($data['is_featured']);
            
            // Tự động sinh slug từ name
            if (!empty($data['name'])) {
                $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            }
            
            $keys = ['name', 'description', 'color', 'icon', 'is_active', 'is_featured', 'slug', 'meta_title', 'meta_description', 'meta_keywords'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($tag, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật tag thành công';
                $return['data'] = $tag->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa tag
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa tag thất bại'
        ];

        try {
            $tag = $this->getRepository()->findById($id);
            
            if (!$tag) {
                $return['message'] = 'Tag không tồn tại';
                return $return;
            }

            // Kiểm tra xem tag có bài viết nào không
            if ($tag->posts()->count() > 0) {
                $return['message'] = 'Không thể xóa tag có bài viết!';
                return $return;
            }
            
            if ($this->getRepository()->delete($tag)) {
                $return['success'] = true;
                $return['message'] = 'Xóa tag thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái tag
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
            $tag = $this->getRepository()->findById($id);
            
            if (!$tag) {
                $return['message'] = 'Tag không tồn tại';
                return $return;
            }

            $tag->update(['is_active' => !$tag->is_active]);
            
            $status = $tag->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Tag đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $tag->is_active];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái nổi bật của tag
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
            $tag = $this->getRepository()->findById($id);
            
            if (!$tag) {
                $return['message'] = 'Tag không tồn tại';
                return $return;
            }

            $tag->update(['is_featured' => !$tag->is_featured]);
            
            $status = $tag->is_featured ? 'nổi bật' : 'không nổi bật';
            $message = "Tag đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_featured' => $tag->is_featured];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách tag theo từ khóa
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'name', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, $column, $limit);
    }
}


