<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\DriverDistanceTierRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class DriverDistanceTierService extends BaseService
{
    public function __construct(DriverDistanceTierRepository $driverDistanceTierRepository)
    {
        $this->repository = $driverDistanceTierRepository;
    }

    protected function getRepository(): DriverDistanceTierRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo khoảng cách
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới khoảng cách thất bại'
        ];

        try {
            $data['is_active'] = isset($data['is_active']);

            $keys = ['name', 'description', 'from_distance', 'to_distance', 'display_text', 'sort_order', 'is_active', 'color', 'icon'];
            $insertData = DataTable::getChangeData($data, $keys);

            if ($distanceTier = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới khoảng cách thành công';
                $return['data'] = $distanceTier;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm cập nhật khoảng cách
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật khoảng cách thất bại'
        ];

        try {
            $distanceTier = $this->getRepository()->findById($id);

            if (!$distanceTier) {
                $return['message'] = 'Khoảng cách không tồn tại';
                return $return;
            }

            $data['is_active'] = isset($data['is_active']);

            $keys = ['name', 'description', 'from_distance', 'to_distance', 'display_text', 'sort_order', 'is_active', 'color', 'icon'];
            $updateData = DataTable::getChangeData($data, $keys);

            if ($this->getRepository()->update($distanceTier, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật khoảng cách thành công';
                $return['data'] = $distanceTier->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm xóa khoảng cách
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa khoảng cách thất bại'
        ];

        try {
            $distanceTier = $this->getRepository()->findById($id);

            if (!$distanceTier) {
                $return['message'] = 'Khoảng cách không tồn tại';
                return $return;
            }

            if ($this->getRepository()->delete($distanceTier)) {
                $return['success'] = true;
                $return['message'] = 'Xóa khoảng cách thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm thay đổi trạng thái khoảng cách
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
            $distanceTier = $this->getRepository()->findById($id);

            if (!$distanceTier) {
                $return['message'] = 'Khoảng cách không tồn tại';
                return $return;
            }

            $distanceTier->update(['is_active' => !$distanceTier->is_active]);

            $status = $distanceTier->is_active ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Khoảng cách đã được {$status} thành công!";

            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $distanceTier->is_active];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm thay đổi trạng thái nổi bật của khoảng cách
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
            $distanceTier = $this->getRepository()->findById($id);

            if (!$distanceTier) {
                $return['message'] = 'Khoảng cách không tồn tại';
                return $return;
            }

            $distanceTier->update(['is_highlighted' => !$distanceTier->is_highlighted]);

            $status = $distanceTier->is_highlighted ? 'nổi bật' : 'không nổi bật';
            $message = "Khoảng cách đã được {$status} thành công!";

            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_highlighted' => $distanceTier->is_highlighted];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm lấy ra danh sách khoảng cách theo từ khóa
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
