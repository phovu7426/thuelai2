<?php

namespace App\Services\Admin\Driver;

use App\Repositories\Admin\Driver\DriverContactRepository;
use App\Services\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\Driver\ContactNotification;
use lib\DataTable;

class DriverContactService extends BaseService
{
    public function __construct(DriverContactRepository $driverContactRepository)
    {
        $this->repository = $driverContactRepository;
    }

    protected function getRepository(): DriverContactRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo liên hệ
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới liên hệ thất bại'
        ];

        try {
            $data['status'] = 'unread';
            
            $keys = ['name', 'email', 'phone', 'subject', 'message', 'status'];
            $insertData = DataTable::getChangeData($data, $keys);
            
            if ($contact = $this->getRepository()->create($insertData)) {
                // Gửi email thông báo (nếu có cấu hình email)
                try {
                    // Mail::to('admin@thuelai.vn')->send(new ContactNotification($contact));
                } catch (\Exception $e) {
                    // Log lỗi gửi email
                    Log::error('Failed to send contact notification email: ' . $e->getMessage());
                }

                $return['success'] = true;
                $return['message'] = 'Thêm mới liên hệ thành công';
                $return['data'] = $contact;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật liên hệ
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật liên hệ thất bại'
        ];

        try {
            $contact = $this->getRepository()->findById($id);
            
            if (!$contact) {
                $return['message'] = 'Liên hệ không tồn tại';
                return $return;
            }
            
            $keys = ['name', 'email', 'phone', 'subject', 'message', 'status', 'admin_notes'];
            $updateData = DataTable::getChangeData($data, $keys);
            
            if ($this->getRepository()->update($contact, $updateData)) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật liên hệ thành công';
                $return['data'] = $contact->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm xóa liên hệ
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa liên hệ thất bại'
        ];

        try {
            $contact = $this->getRepository()->findById($id);
            
            if (!$contact) {
                $return['message'] = 'Liên hệ không tồn tại';
                return $return;
            }
            
            if ($this->getRepository()->delete($contact)) {
                $return['success'] = true;
                $return['message'] = 'Xóa liên hệ thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm cập nhật trạng thái liên hệ
     * @param int $id
     * @param string $status
     * @param string|null $adminNotes
     * @return array
     */
    public function updateStatus(int $id, string $status, ?string $adminNotes = null): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật trạng thái thất bại'
        ];

        try {
            $contact = $this->getRepository()->findById($id);
            
            if (!$contact) {
                $return['message'] = 'Liên hệ không tồn tại';
                return $return;
            }

            $updateData = ['status' => $status];
            if ($adminNotes !== null) {
                $updateData['admin_notes'] = $adminNotes;
            }

            $contact->update($updateData);
            
            $statusLabels = [
                'unread' => 'Chưa đọc',
                'read' => 'Đã đọc',
                'replied' => 'Đã trả lời',
                'closed' => 'Đã đóng'
            ];

            $message = "Liên hệ đã được cập nhật trạng thái thành: {$statusLabels[$status]}";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $status];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm đánh dấu đã đọc
     * @param int $id
     * @return array
     */
    public function markAsRead(int $id): array
    {
        return $this->updateStatus($id, 'read');
    }

    /**
     * Hàm toggle trạng thái liên hệ
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
            $contact = $this->getRepository()->findById($id);
            
            if (!$contact) {
                $return['message'] = 'Liên hệ không tồn tại';
                return $return;
            }

            // Chuyển đổi trạng thái theo thứ tự: unread -> read -> replied -> unread
            $statusMap = [
                'unread' => 'read',
                'read' => 'replied',
                'replied' => 'unread'
            ];

            $newStatus = $statusMap[$contact->status] ?? 'unread';
            
            $contact->update(['status' => $newStatus]);
            
            $statusLabels = [
                'unread' => 'Chưa đọc',
                'read' => 'Đã đọc',
                'replied' => 'Đã trả lời'
            ];

            $return['success'] = true;
            $return['message'] = 'Đã cập nhật trạng thái thành công';
            $return['data'] = [
                'new_status' => $newStatus,
                'status_text' => $statusLabels[$newStatus] ?? ucfirst($newStatus)
            ];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Hàm bulk actions
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
            $contacts = $this->getRepository()->findByIds($ids);
            
            if ($contacts->isEmpty()) {
                $return['message'] = 'Không tìm thấy liên hệ nào';
                return $return;
            }

            switch ($action) {
                case 'delete':
                    $this->getRepository()->deleteMultiple($contacts);
                    $message = 'Đã xóa ' . count($ids) . ' liên hệ thành công!';
                    break;

                case 'mark-read':
                    $this->getRepository()->updateMultiple($contacts, ['status' => 'read']);
                    $message = 'Đã đánh dấu đã đọc ' . count($ids) . ' liên hệ thành công!';
                    break;

                case 'mark-replied':
                    $this->getRepository()->updateMultiple($contacts, ['status' => 'replied']);
                    $message = 'Đã đánh dấu đã trả lời ' . count($ids) . ' liên hệ thành công!';
                    break;

                case 'mark-closed':
                    $this->getRepository()->updateMultiple($contacts, ['status' => 'closed']);
                    $message = 'Đã đánh dấu đã đóng ' . count($ids) . ' liên hệ thành công!';
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
     * Hàm lấy ra danh sách liên hệ theo từ khóa
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


