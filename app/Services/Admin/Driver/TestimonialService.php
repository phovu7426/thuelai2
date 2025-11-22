<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\TestimonialRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use lib\DataTable;

class TestimonialService extends BaseService
{
    public function __construct(TestimonialRepository $testimonialRepository)
    {
        $this->repository = $testimonialRepository;
    }

    protected function getRepository(): TestimonialRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo đánh giá
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới đánh giá thất bại'
        ];

        try {
            $data['is_featured'] = isset($data['is_featured']);
            $data['status'] = isset($data['status']);
            
            $keys = ['customer_name', 'customer_title', 'content', 'rating', 'image', 'is_featured', 'status', 'sort_order'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($testimonial = $this->getRepository()->create($insertData)) {
                $return['success'] = true;
                $return['message'] = 'Thêm mới đánh giá thành công';
                $return['data'] = $testimonial;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật đánh giá
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật đánh giá thất bại'
        ];

        try {
            $testimonial = $this->getRepository()->findById($id);
            
            if (!$testimonial) {
                $return['message'] = 'Đánh giá không tồn tại';
                return $return;
            }

            $data['is_featured'] = isset($data['is_featured']);
            $data['status'] = isset($data['status']);
            
            $keys = ['customer_name', 'customer_title', 'content', 'rating', 'image', 'is_featured', 'status', 'sort_order'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($testimonial, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật đánh giá thành công';
                $return['data'] = $testimonial->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa đánh giá
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa đánh giá thất bại'
        ];

        try {
            $testimonial = $this->getRepository()->findById($id);
            
            if (!$testimonial) {
                $return['message'] = 'Đánh giá không tồn tại';
                return $return;
            }

            // Xóa hình ảnh nếu có
            if ($testimonial->image) {
                Storage::disk('public')->delete($testimonial->image);
            }
            
            if ($this->getRepository()->delete($testimonial)) {
                $return['success'] = true;
                $return['message'] = 'Xóa đánh giá thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái đánh giá
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
            $testimonial = $this->getRepository()->findById($id);
            
            if (!$testimonial) {
                $return['message'] = 'Đánh giá không tồn tại';
                return $return;
            }

            $testimonial->update(['status' => !$testimonial->status]);
            
            $status = $testimonial->status ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Đánh giá đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $testimonial->status];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm thay đổi trạng thái featured
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
            $testimonial = $this->getRepository()->findById($id);
            
            if (!$testimonial) {
                $return['message'] = 'Đánh giá không tồn tại';
                return $return;
            }

            $testimonial->update(['is_featured' => !$testimonial->is_featured]);
            
            $status = $testimonial->is_featured ? 'đánh dấu nổi bật' : 'bỏ đánh dấu nổi bật';
            $message = "Đánh giá đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_featured' => $testimonial->is_featured];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Cập nhật thứ tự sắp xếp
     * @param array $testimonials
     * @return array
     */
    public function updateOrder(array $testimonials): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật thứ tự thất bại'
        ];

        try {
            foreach ($testimonials as $testimonial) {
                $this->getRepository()->updateById($testimonial['id'], ['sort_order' => $testimonial['sort_order']]);
            }

            $return['success'] = true;
            $return['message'] = 'Thứ tự sắp xếp đã được cập nhật thành công!';
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Bulk actions
     * @param string $action
     * @param array $ids
     * @return array
     */
    public function bulkAction(string $action, array $ids): array
    {
        $return = [
            'success' => false,
            'message' => 'Thực hiện hành động thất bại'
        ];

        try {
            $testimonials = $this->getRepository()->findByIds($ids);
            
            if ($testimonials->isEmpty()) {
                $return['message'] = 'Không tìm thấy đánh giá nào';
                return $return;
            }

            switch ($action) {
                case 'delete':
                    foreach ($testimonials as $testimonial) {
                        if ($testimonial->image) {
                            Storage::disk('public')->delete($testimonial->image);
                        }
                    }
                    $this->getRepository()->deleteMultiple($testimonials);
                    $message = 'Đã xóa ' . count($ids) . ' đánh giá thành công!';
                    break;

                case 'activate':
                    $this->getRepository()->updateMultiple($testimonials, ['status' => true]);
                    $message = 'Đã kích hoạt ' . count($ids) . ' đánh giá thành công!';
                    break;

                case 'deactivate':
                    $this->getRepository()->updateMultiple($testimonials, ['status' => false]);
                    $message = 'Đã vô hiệu hóa ' . count($ids) . ' đánh giá thành công!';
                    break;

                case 'feature':
                    $this->getRepository()->updateMultiple($testimonials, ['is_featured' => true]);
                    $message = 'Đã đánh dấu nổi bật ' . count($ids) . ' đánh giá thành công!';
                    break;

                case 'unfeature':
                    $this->getRepository()->updateMultiple($testimonials, ['is_featured' => false]);
                    $message = 'Đã bỏ đánh dấu nổi bật ' . count($ids) . ' đánh giá thành công!';
                    break;

                default:
                    $return['message'] = 'Hành động không hợp lệ';
                    return $return;
            }

            $return['success'] = true;
            $return['message'] = $message;
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm lấy ra danh sách đánh giá theo từ khóa
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'customer_name', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, $column, $limit);
    }
}


