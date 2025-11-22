<?php

namespace App\Services\Admin\Products;

use App\Repositories\Admin\Products\ProductRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class ProductService extends BaseService
{
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    protected function getRepository(): ProductRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo sản phẩm
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới sản phẩm thất bại'
        ];
        
        $keys = ['name', 'description', 'price', 'category_id'];
        if (($insertData = DataTable::getChangeData($data, $keys))
            && $this->getRepository()->create($insertData)
        ) {
            $return['success'] = true;
            $return['message'] = 'Thêm mới sản phẩm thành công';
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật sản phẩm
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật sản phẩm thất bại'
        ];
        
        $keys = ['name', 'description', 'price', 'category_id'];
        $updateData = DataTable::getChangeData($data, $keys);
        
        if (!empty($updateData)
            && ($product = $this->getRepository()->findById($id))
            && $this->getRepository()->update($product, $updateData)
        ) {
            $return['success'] = true;
            $return['message'] = 'Cập nhật sản phẩm thành công';
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái sản phẩm
     * @param int $id
     * @param int $status
     * @return array
     */
    public function changeStatus(int $id, int $status = 0): array
    {
        $return = [
            'success' => false,
            'message' => 'Thay đổi trạng thái sản phẩm thất bại'
        ];
        
        $status = !empty($status) ? 1 : 0;
        
        if ($product = $this->getRepository()->findById($id)) {
            if ((!empty($product->status) && !empty($status))
                || (empty($product->status) && empty($status))
            ) {
                $return['message'] = 'Trạng thái cần thay đổi không đúng';
            } elseif ($this->getRepository()->update($product, ['status' => $status])) {
                $return['success'] = true;
                $return['message'] = 'Thay đổi trạng thái sản phẩm thành công';
            }
        } else {
            $return['message'] = 'Sản phẩm không hợp lệ';
        }
        
        return $return;
    }

    /**
     * Hàm xóa sản phẩm
     * @param int $id
     * @return array
     */
    public function delete(int $id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa sản phẩm thất bại'
        ];
        
        $product = $this->getRepository()->findById($id);
        
        if ($product && $this->getRepository()->delete($product)) {
            $return['success'] = true;
            $return['message'] = 'Xóa sản phẩm thành công';
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách sản phẩm theo từ khóa
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


