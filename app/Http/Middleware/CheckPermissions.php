<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $user = auth()->user();

        if (!$user) {
            abort(403, 'Bạn chưa đăng nhập.');
        }

        // Lấy tất cả quyền của user, bao gồm cả quyền cha
        $userPermissions = $this->getAllUserPermissions($user);

        // Kiểm tra xem user có ít nhất một trong các quyền yêu cầu không
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return $next($request);
            }
        }

        abort(403, 'Bạn không có quyền truy cập.');
    }

    private function getAllUserPermissions($user): array
    {
        // Lấy danh sách tất cả quyền trực tiếp của user
        $permissions = $user->getPermissionNames()->toArray();
        // Lấy thêm các quyền cha dựa trên parent_id
        $allPermissions = [];
        foreach ($permissions as $permission) {
            $this->collectParentPermissions($permission, $allPermissions);
        }
        return array_unique(array_merge($permissions, $allPermissions));
    }

    private function collectParentPermissions($permissionName, &$collected): void
    {
        $permission = Permission::where('name', $permissionName)->first();
        if ($permission && $permission->parent_id) {
            $parent = Permission::find($permission->parent_id);
            if ($parent && !in_array($parent->name, $collected)) {
                $collected[] = $parent->name;
                $this->collectParentPermissions($parent->name, $collected);
            }
        }
    }
}
