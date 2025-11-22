<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\DriverServiceRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use lib\DataTable;

class DriverServiceService extends BaseService
{
    public function __construct(DriverServiceRepository $driverServiceRepository)
    {
        $this->repository = $driverServiceRepository;
    }

    protected function getRepository(): DriverServiceRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo dịch vụ lái xe
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới dịch vụ lái xe thất bại'
        ];

        try {
            $data['slug'] = Str::slug($data['name']);
            $data['is_featured'] = isset($data['is_featured']);
            $data['status'] = isset($data['status']);
            
            // Xử lý upload hình ảnh
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                $data['image'] = $data['image']->store('driver-services', 'public');
            }

            if (isset($data['icon']) && $data['icon'] instanceof \Illuminate\Http\UploadedFile) {
                $data['icon'] = $data['icon']->store('driver-services/icons', 'public');
            }

            $keys = ['name', 'description', 'short_description', 'is_featured', 'status', 'sort_order', 'image', 'icon', 'slug'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($service = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới dịch vụ lái xe thành công';
                $return['data'] = $service;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật dịch vụ lái xe
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật dịch vụ lái xe thất bại'
        ];

        try {
            $service = $this->getRepository()->findById($id);
            
            if (!$service) {
                $return['message'] = 'Dịch vụ lái xe không tồn tại';
                return $return;
            }

            $data['slug'] = Str::slug($data['name']);
            $data['is_featured'] = isset($data['is_featured']);
            $data['status'] = isset($data['status']);
            
            // Xử lý upload hình ảnh
            if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
                // Xóa ảnh cũ
                if ($service->image) {
                    Storage::disk('public')->delete($service->image);
                }
                $data['image'] = $data['image']->store('driver-services', 'public');
            }

            if (isset($data['icon']) && $data['icon'] instanceof \Illuminate\Http\UploadedFile) {
                // Xóa icon cũ
                if ($service->icon) {
                    Storage::disk('public')->delete($service->icon);
                }
                $data['icon'] = $data['icon']->store('driver-services/icons', 'public');
            }

            $keys = ['name', 'description', 'short_description', 'is_featured', 'status', 'sort_order', 'image', 'icon', 'slug'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($service, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật dịch vụ lái xe thành công';
                $return['data'] = $service->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa dịch vụ lái xe
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa dịch vụ lái xe thất bại'
        ];

        try {
            $service = $this->getRepository()->findById($id);
            
            if (!$service) {
                $return['message'] = 'Dịch vụ lái xe không tồn tại';
                return $return;
            }

            // Xóa ảnh
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            
            if ($this->getRepository()->delete($service)) {
                $return['success'] = true;
                $return['message'] = 'Xóa dịch vụ lái xe thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái dịch vụ lái xe
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
            $service = $this->getRepository()->findById($id);
            
            if (!$service) {
                $return['message'] = 'Dịch vụ lái xe không tồn tại';
                return $return;
            }

            $service->update(['status' => !$service->status]);
            
            $message = $service->status ? 'Dịch vụ đã được kích hoạt!' : 'Dịch vụ đã được vô hiệu hóa!';
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $service->status];
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
            $service = $this->getRepository()->findById($id);
            
            if (!$service) {
                $return['message'] = 'Dịch vụ lái xe không tồn tại';
                return $return;
            }

            $service->update(['is_featured' => !$service->is_featured]);
            
            $message = $service->is_featured ? 'Dịch vụ đã được đánh dấu nổi bật!' : 'Dịch vụ đã bỏ đánh dấu nổi bật!';
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_featured' => $service->is_featured];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách dịch vụ theo từ khóa
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'name', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, $column, $limit);
    }

    /**
     * Cập nhật thứ tự dịch vụ
     * @param array $data
     * @return array
     */
    public function updateOrder(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật thứ tự thất bại'
        ];

        try {
            if (isset($data['orders']) && is_array($data['orders'])) {
                foreach ($data['orders'] as $order) {
                    if (isset($order['id']) && isset($order['sort_order'])) {
                        $service = $this->getRepository()->findById($order['id']);
                        if ($service) {
                            $service->update(['sort_order' => $order['sort_order']]);
                        }
                    }
                }
                
                $return['success'] = true;
                $return['message'] = 'Cập nhật thứ tự thành công';
            } else {
                $return['message'] = 'Dữ liệu không hợp lệ';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }
}
