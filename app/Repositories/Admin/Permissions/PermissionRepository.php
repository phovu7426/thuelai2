<?php

namespace App\Repositories\Admin\Permissions;

use App\Repositories\BaseRepository;
use App\Models\Permission;

class PermissionRepository extends BaseRepository
{
    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

}
