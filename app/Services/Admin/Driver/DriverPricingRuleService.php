<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\DriverPricingRuleRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class DriverPricingRuleService extends BaseService
{
    public function __construct(DriverPricingRuleRepository $driverPricingRuleRepository)
    {
        $this->repository = $driverPricingRuleRepository;
    }

    protected function getRepository(): DriverPricingRuleRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo quy tắc giá
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới quy tắc giá thất bại'
        ];

        try {
            $data['is_active'] = isset($data['is_active']);
            
            $keys = ['time_slot', 'time_icon', 'time_color', 'sort_order', 'is_active'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($pricingRule = $this->getRepository()->create($insertData)) {
                // Lưu giá cho từng khoảng cách
                $this->savePricingDistances($pricingRule, $data);
                
                $return['success'] = true;
                $return['message'] = 'Thêm mới quy tắc giá thành công';
                $return['data'] = $pricingRule;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật quy tắc giá
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật quy tắc giá thất bại'
        ];

        try {
            $pricingRule = $this->getRepository()->findById($id);
            
            if (!$pricingRule) {
                $return['message'] = 'Quy tắc giá không tồn tại';
                return $return;
            }

            $data['is_active'] = isset($data['is_active']);
            
            $keys = ['time_slot', 'time_icon', 'time_color', 'sort_order', 'is_active'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($pricingRule, $updateData)) {
                // Xóa tất cả giá cũ
                $pricingRule->pricingDistances()->delete();
                
                // Lưu giá mới cho từng khoảng cách
                $this->savePricingDistances($pricingRule, $data);
                
                $return['success'] = true;
                $return['message'] = 'Cập nhật quy tắc giá thành công';
                $return['data'] = $pricingRule->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa quy tắc giá
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa quy tắc giá thất bại'
        ];

        try {
            $pricingRule = $this->getRepository()->findById($id);
            
            if (!$pricingRule) {
                $return['message'] = 'Quy tắc giá không tồn tại';
                return $return;
            }
            
            if ($this->getRepository()->delete($pricingRule)) {
                $return['success'] = true;
                $return['message'] = 'Xóa quy tắc giá thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái quy tắc giá
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
            $pricingRule = $this->getRepository()->findById($id);
            
            if (!$pricingRule) {
                $return['message'] = 'Quy tắc giá không tồn tại';
                return $return;
            }

            $pricingRule->update(['is_active' => !$pricingRule->is_active]);
            
            $status = $pricingRule->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Quy tắc giá đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $pricingRule->is_active];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái nổi bật của quy tắc giá
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
            $pricingRule = $this->getRepository()->findById($id);
            
            if (!$pricingRule) {
                $return['message'] = 'Quy tắc giá không tồn tại';
                return $return;
            }

            $pricingRule->update(['is_highlighted' => !$pricingRule->is_highlighted]);
            
            $status = $pricingRule->is_highlighted ? 'nổi bật' : 'không nổi bật';
            $message = "Quy tắc giá đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_highlighted' => $pricingRule->is_highlighted];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Lưu giá cho từng khoảng cách
     * @param \App\Models\DriverPricingRule $pricingRule
     * @param array $data
     */
    private function savePricingDistances($pricingRule, array $data): void
    {
        $distanceTiers = \App\Models\DriverDistanceTier::active()->ordered()->get();
        
        foreach ($distanceTiers as $tier) {
            $priceField = 'price_' . $tier->id;
            if (isset($data[$priceField])) {
                $price = $data[$priceField];
                
                // Xác định loại giá (số hay text)
                if (is_numeric($price)) {
                    \App\Models\DriverPricingRuleDistance::create([
                        'pricing_rule_id' => $pricingRule->id,
                        'distance_tier_id' => $tier->id,
                        'price' => $price,
                        'price_text' => null,
                    ]);
                } else {
                    \App\Models\DriverPricingRuleDistance::create([
                        'pricing_rule_id' => $pricingRule->id,
                        'distance_tier_id' => $tier->id,
                        'price' => null,
                        'price_text' => $price,
                    ]);
                }
            }
        }
    }

    /**
     * Hàm lấy ra danh sách quy tắc giá theo từ khóa
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


