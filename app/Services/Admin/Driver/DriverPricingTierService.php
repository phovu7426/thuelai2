<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\DriverPricingTierRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class DriverPricingTierService extends BaseService
{
    public function __construct(DriverPricingTierRepository $driverPricingTierRepository)
    {
        $this->repository = $driverPricingTierRepository;
    }

    protected function getRepository(): DriverPricingTierRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo mức giá
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới mức giá thất bại'
        ];

        try {
            $keys = ['time_slot', 'time_icon', 'time_color', 'from_distance', 'to_distance', 'price', 'price_type', 'description', 'sort_order'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($pricingTier = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới mức giá thành công';
                $return['data'] = $pricingTier;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật mức giá
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật mức giá thất bại'
        ];

        try {
            $pricingTier = $this->getRepository()->findById($id);
            
            if (!$pricingTier) {
                $return['message'] = 'Mức giá không tồn tại';
                return $return;
            }
            
            $keys = ['time_slot', 'time_icon', 'time_color', 'from_distance', 'to_distance', 'price', 'price_type', 'description', 'sort_order'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($pricingTier, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật mức giá thành công';
                $return['data'] = $pricingTier->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa mức giá
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa mức giá thất bại'
        ];

        try {
            $pricingTier = $this->getRepository()->findById($id);
            
            if (!$pricingTier) {
                $return['message'] = 'Mức giá không tồn tại';
                return $return;
            }
            
            if ($this->getRepository()->delete($pricingTier)) {
                $return['success'] = true;
                $return['message'] = 'Xóa mức giá thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái mức giá
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
            $pricingTier = $this->getRepository()->findById($id);
            
            if (!$pricingTier) {
                $return['message'] = 'Mức giá không tồn tại';
                return $return;
            }

            $pricingTier->update(['is_active' => !$pricingTier->is_active]);
            
            $status = $pricingTier->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Mức giá đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $pricingTier->is_active];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách mức giá theo từ khóa
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'time_slot', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, $column, $limit);
    }
}


