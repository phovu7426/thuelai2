<?php

namespace App\Services\Admin\Roles;

use App\Repositories\Admin\Roles\RoleRepository;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use lib\DataTable;

class RoleService extends BaseService
{
    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }

    protected function getRepository(): RoleRepository
    {
        return $this->repository;
    }

    /**
     * Lấy thông tin vai trò theo ID
     * @param $id
     * @param array $options
     * @return Model|null
     */
    public function findById($id, array $options = []): ?Model
    {
        $options['relations'] = ['permissions'];
        return $this->getRepository()->findById($id, $options);
    }

    /**
     * Xử lý tạo vai trò
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Thêm mới quyền thất bại'
        ];
        $keys = ['title', 'name', 'permissions'];
        if (($insertData = DataTable::getChangeData($data, $keys))
            && $this->getRepository()->create($insertData)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Thêm mới quyền thành công';
        }
        return $return;
    }

    /**
     * Xử lý cập nhật vai trò
     * @param $id
     * @param array $data
     * @return array
     */
    public function update($id, array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Cập nhật vai trò thất bại'
        ];
        $keys = ['title', 'name', 'permissions'];
        $updateData = DataTable::getChangeData($data, $keys);
        if (!empty($updateData)
            && ($role = $this->getRepository()->findById($id))
            && $this->getRepository()->update($role, $data)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Cập nhật vai trò thành công';
        }
        return $return;
    }

    /**
     * Thay đổi trạng thái vai trò
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
            $role = $this->getRepository()->findById($id);
            
            if (!$role) {
                $return['message'] = 'Vai trò không tồn tại';
                return $return;
            }

            $newStatus = $role->status === 'active' ? 'inactive' : 'active';
            $role->update(['status' => $newStatus]);
            
            $status = $newStatus === 'active' ? 'kích hoạt' : 'vô hiệu hóa';
            $message = "Vai trò đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['status' => $newStatus];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }

    /**
     * Thay đổi trạng thái nổi bật của vai trò
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
            $role = $this->getRepository()->findById($id);
            
            if (!$role) {
                $return['message'] = 'Vai trò không tồn tại';
                return $return;
            }

            $role->update(['is_featured' => !$role->is_featured]);
            
            $status = $role->is_featured ? 'nổi bật' : 'không nổi bật';
            $message = "Vai trò đã được {$status} thành công!";
            
            $return['success'] = true;
            $return['message'] = $message;
            $return['data'] = ['is_featured' => $role->is_featured];
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }
        
        return $return;
    }
}
