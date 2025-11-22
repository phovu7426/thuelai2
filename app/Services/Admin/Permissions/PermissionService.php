<?php

namespace App\Services\Admin\Permissions;

use App\Repositories\Admin\Permissions\PermissionRepository;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use lib\DataTable;

class PermissionService extends BaseService
{
    public function __construct(PermissionRepository $permissionRepository) {
        $this->repository = $permissionRepository;
    }

    protected function getRepository(): PermissionRepository
    {
        return $this->repository;
    }

    /**
     * Tạo mới quyền
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Thêm mới quyền thất bại'
        ];
        $keys = ['title', 'name', 'guard_name', 'parent_id', 'status'];
        if (($insertData = DataTable::getChangeData($data, $keys))
            && $this->getRepository()->create($insertData)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Thêm mới quyền thành công';
        }
        return $return;
    }

    /**
     * Cập nhật quyền
     * @param $id
     * @param array $data
     * @return array
     */
    public function update($id, array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Cập nhật quyền thất bại'
        ];
        $keys = ['title', 'name', 'guard_name', 'parent_id', 'status'];
        $updateData = DataTable::getChangeData($data, $keys);
        if (!empty($updateData)
            && ($permission = $this->getRepository()->findById($id))
        ) {
            if (!empty($permission->is_default)) {
                $return['success'] = false;
                $return['messages'] = 'Không thể cập nhật quyền hệ thống';
            } elseif ($this->getRepository()->update($permission, $updateData)) {
                $return['success'] = true;
                $return['messages'] = 'Cập nhật quyền thành công';
            }
        }
        return $return;
    }

    /**
     * Xóa quyền
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'messages' => 'Xóa quyền thất bại'
        ];
        if ($permission = $this->getRepository()->findById($id)) {
            if (!empty($permission->is_default)) {
                $return['success'] = false;
                $return['messages'] = 'Không thể xóa quyền hệ thống';
            } elseif ($this->getRepository()->delete($permission)) {
                $return['success'] = true;
                $return['messages'] = 'Xóa quyền thành công';
            }
        }
        return $return;
    }

    /**
     * Thay đổi trạng thái quyền
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
            $permission = $this->getRepository()->findById($id);
            
            if (!$permission) {
                $return['message'] = 'Quyền không tồn tại';
                return $return;
            }

            $newStatus = $permission->status === 'active' ? 'inactive' : 'active';
            $permission->update(['status' => $newStatus]);
            
            $status = $newStatus === 'active' ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Quyền đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $newStatus];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }


}
