<?php

namespace App\Services\Admin\Posts;

use App\Repositories\Admin\Posts\PostCategoryRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use lib\DataTable;

class PostCategoryService extends BaseService
{
    public function __construct(PostCategoryRepository $postCategoryRepository)
    {
        $this->repository = $postCategoryRepository;
    }

    protected function getRepository(): PostCategoryRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo danh mục
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới danh mục thất bại'
        ];

        try {
            // Tự động sinh slug từ name nếu không có
            if (!empty($data['name']) && empty($data['slug'])) {
                $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            }
            
            // Xử lý parent_id
            if (empty($data['parent_id'])) {
                $data['parent_id'] = null;
            }
            
            $keys = ['name', 'slug', 'description', 'parent_id', 'status'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($category = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới danh mục thành công';
                $return['data'] = $category;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật danh mục
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật danh mục thất bại'
        ];

        try {
            $category = $this->getRepository()->findById($id);
            
            if (!$category) {
                $return['message'] = 'Danh mục không tồn tại';
                return $return;
            }

            // Tự động sinh slug từ name nếu không có
            if (!empty($data['name']) && empty($data['slug'])) {
                $data['slug'] = \Illuminate\Support\Str::slug($data['name']);
            }
            
            // Xử lý parent_id
            if (empty($data['parent_id'])) {
                $data['parent_id'] = null;
            }
            
            $keys = ['name', 'slug', 'description', 'parent_id', 'status'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($category, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật danh mục thành công';
                $return['data'] = $category->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa danh mục
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa danh mục thất bại'
        ];

        try {
            $category = $this->getRepository()->findById($id);
            
            if (!$category) {
                $return['message'] = 'Danh mục không tồn tại';
                return $return;
            }

            // Kiểm tra xem danh mục có bài viết nào không
            if ($category->posts()->count() > 0) {
                $return['message'] = 'Không thể xóa danh mục có bài viết!';
                return $return;
            }
            
            if ($this->getRepository()->delete($category)) {
                $return['success'] = true;
                $return['message'] = 'Xóa danh mục thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái danh mục
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
            $category = $this->getRepository()->findById($id);
            
            if (!$category) {
                $return['message'] = 'Danh mục không tồn tại';
                return $return;
            }

            $newStatus = $category->status === 'active' ? 'inactive' : 'active';
            
            if ($this->getRepository()->update($category, ['status' => $newStatus])) {
                $status = $newStatus === 'active' ? 'kích hoạt' : 'vô hiệu hóa';
                $message = "Danh mục đã được {$status} thành công!";
                
                $return['success'] = true;
                $return['message'] = $message;
                $return['data'] = ['status' => $newStatus];
            }
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
     * Hàm lấy ra danh sách danh mục theo từ khóa
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'name', int $limit = 10, int $excludeId = null): JsonResponse
    {
        try {
            $query = $this->getRepository()->getModel()->select('id', 'name', 'slug')
                ->where('status', 'active')
                ->orderBy('name', 'asc');
            
            if (!empty($term)) {
                $query->where('name', 'like', '%' . $term . '%');
            }
            
            // Loại trừ category hiện tại nếu đang edit
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
            
            $categories = $query->limit($limit)->get();
            
            $results = $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'text' => $category->name,
                    'name' => $category->name,
                    'slug' => $category->slug
                ];
            });
            
            return response()->json($results);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }
}


