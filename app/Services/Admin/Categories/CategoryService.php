<?php

namespace App\Services\Admin\Categories;

use App\Repositories\Admin\Categories\CategoryRepository;
use App\Services\BaseService;
use lib\DataTable;

class CategoryService extends BaseService
{
    public function __construct(CategoryRepository $categoryRepository) {
        $this->repository = $categoryRepository;
    }

    protected function getRepository(): CategoryRepository
    {
        return $this->repository;
    }

    /**
     * Tạo mới danh mục
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Thêm mới danh mục thất bại'
        ];
        $keys = ['name', 'code', 'description', 'slug', 'parent_id', 'status'];
        if (($insertData = DataTable::getChangeData($data, $keys))
            && $this->getRepository()->create($insertData)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Thêm mới danh mục thành công';
        }
        return $return;
    }

    /**
     * Cập nhật danh mục
     * @param $id
     * @param array $data
     * @return array
     */
    public function update($id, array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Cập nhật danh mục thất bại'
        ];
        $keys = ['name', 'code', 'description', 'slug', 'parent_id', 'status'];
        $updateData = DataTable::getChangeData($data, $keys);
        if (!empty($updateData)
            && ($role = $this->getRepository()->findById($id))
            && $this->getRepository()->update($role, $data)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Cập nhật danh mục thành công';
        }
        return $return;
    }

    /**
     * Thay đổi trạng thái danh mục
     * @param $id
     * @return array
     */
    public function toggleStatus($id): array
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

            $category->update(['status' => !$category->status]);
            
            $status = $category->status ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Danh mục đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $category->status];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Thay đổi trạng thái nổi bật của danh mục
     * @param $id
     * @return array
     */
    public function toggleFeatured($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Thay đổi trạng thái nổi bật thất bại'
        ];

        try {
            $category = $this->getRepository()->findById($id);
            
            if (!$category) {
                $return['message'] = 'Danh mục không tồn tại';
                return $return;
            }

            $newFeaturedState = !$category->is_featured;

            if ($this->getRepository()->update($category, ['is_featured' => $newFeaturedState])) {
                $status = $newFeaturedState ? 'nổi bật' : 'không nổi bật';
                $message = "Danh mục đã được {$status} thành công!";
                
                $return['success'] = true;
                $return['message'] = $message;
                $return['data'] = ['is_featured' => $newFeaturedState];
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }
}
