<?php

namespace App\Http\Controllers\Admin\Roles;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Roles\StoreRequest;
use App\Http\Requests\Admin\Roles\UpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Services\Admin\Permissions\PermissionService;
use App\Services\Admin\Roles\RoleService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use lib\DataTable;

class RoleController extends BaseController
{
    protected PermissionService $permissionService;

    public function __construct(RoleService $roleService, PermissionService $permissionService)
    {
        $this->service = $roleService;
        $this->permissionService = $permissionService;
    }

    public function getService(): RoleService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách vai trò
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $options['relations'] = ['permissions'];
        $roles = $this->getService()->getList($filters, $options);
        return view('admin.roles.index', compact('roles', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo vai trò
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $permissions = $this->permissionService->getList();
        return view('admin.roles.create', compact('permissions'));
    }

    /**
     * Xử lý tạo vai trò
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo vai trò thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết vai trò
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $role = $this->getService()->findById($id);
        
        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'Vai trò không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin vai trò thành công.',
            'data' => $role
        ]);
    }

    /**
     * Hiển thị form sửa vai trò
     * @param $id
     * @return View|Application|Factory
     */
    public function edit($id): View|Application|Factory
    {
        $role = $this->getService()->findById($id);
        $permissions = $this->permissionService->getList();
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    /**
     * Xử lý cập nhật vai trò
     * @param UpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật vai trò thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xóa vai trò
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa vai trò thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái vai trò
     * @param $id
     * @return JsonResponse
     */
    public function toggleStatus($id): JsonResponse
    {
        $result = $this->getService()->toggleStatus($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Thay đổi trạng thái nổi bật của vai trò
     * @param $id
     * @return JsonResponse
     */
    public function toggleFeatured($id): JsonResponse
    {
        $result = $this->getService()->toggleFeatured($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái nổi bật thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }
}
