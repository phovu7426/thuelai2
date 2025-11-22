<?php

namespace App\Repositories\Admin\Roles;

use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $role)
    {
        $this->model = $role;
    }

    /**
     * Tạo mới vai trò và gán quyền
     */
    public function create(array $data): Model
    {
        $role = $this->getModel()->create(['name' => $data['name'] ?? '', 'title' => $data['title'] ?? '']);
        if ($role && !empty($data['permissions'])) {
            $role->syncPermissions($data['permissions']);
        }
        return $role;
    }

    /**
     * Cập nhật thông tin vai trò
     */
    public function update(Model|Role $model, array $data): bool
    {
        $update = $model->update(['name' => $data['name'] ?? '', 'title' => $data['title'] ?? '']);
        if ($update) {
            if (!empty($data['permissions'])) {
                $model->syncPermissions($data['permissions']);
            } else {
                $model->syncPermissions([]); // Xóa hết quyền nếu không có quyền nào được chọn
            }
        }
        return $update;
    }

}
