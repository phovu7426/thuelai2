<?php

namespace App\Http\Controllers\Admin\Permissions;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Permissions\StoreRequest;
use App\Http\Requests\Admin\Permissions\UpdateRequest;
use App\Models\Permission;
use App\Services\Admin\Permissions\PermissionService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use lib\DataTable;

class PermissionController extends BaseController
{
    public function __construct(PermissionService $permissionService)
    {
        $this->service = $permissionService;
    }

    public function getService(): PermissionService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách quyền
     * @param Request $request
     * @return Factory|Application|View
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $permissions = $this->getService()->getList($filters, $options);
        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Hiển thị form tạo quyền
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        $permissions = $this->getService()->getAll();
        return view('admin.permissions.create', compact('permissions'));
    }

    /**
     * Xử lý tạo quyền
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->all());
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? ($result['messages'] ?? 'Tạo quyền thất bại.'),
            'data' => $result['data'] ?? null,
        ]);
    }

    /**
     * Hiển thị chi tiết quyền
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $permission = $this->getService()->findById($id, ['relations' => ['parent']]);
        
        if (!$permission) {
            return response()->json([
                'success' => false,
                'message' => 'Quyền không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin quyền thành công.',
            'data' => $permission
        ]);
    }

    /**
     * Hiển thị form sửa quyền
     * @param $id
     * @return View|Application|Factory
     */
    public function edit($id): View|Application|Factory
    {
        $permission = $this->getService()->findById($id);
        $permissions = $this->getService()->getAll();
        return view('admin.permissions.edit', compact('permission', 'permissions'));
    }

    /**
     * Xử lý cập nhật quyền
     * @param UpdateRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->all());
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? ($result['messages'] ?? 'Cập nhật quyền thất bại.'),
            'data' => $result['data'] ?? null,
        ]);
    }

    /**
     * Xóa quyền
     * @param $id
     * @return RedirectResponse
     */
    public function delete($id): JsonResponse
    {
        $return = $this->getService()->delete($id);
        return response()->json([
            'success' => $return['success'] ?? false,
            'message' => $return['success'] ? 'Xóa thành công' : 'Xóa thất bại.',
            'data' => $return['data'] ?? null
        ]);
    }

    /**
     * Autocomplete for select2 – returns [{id, text}] or {data: [...]}
     */
    public function autocomplete(Request $request): JsonResponse
    {
        // Hỗ trợ lấy theo id/ids để preselect (không ảnh hưởng tới hành vi cũ)
        $id = $request->input('id');
        $ids = $request->input('ids');
        if ($id || (is_array($ids) && count($ids) > 0)) {
            $items = Permission::query()
                ->when($id, fn($q) => $q->where('id', $id))
                ->when(is_array($ids) && count($ids) > 0, fn($q) => $q->orWhereIn('id', $ids))
                ->select(['id', 'name', 'title'])
                ->get()
                ->toArray();
            $results = array_map(function ($item) {
                return [
                    'id' => $item['id'] ?? null,
                    'name' => $item['name'] ?? ($item['id'] ?? ''),
                    'title' => $item['title'] ?? ($item['name'] ?? ''),
                ];
            }, $items);
            return response()->json($results);
        }

        $term = $request->input('term', '');
        // Lấy danh sách theo BaseService::autocomplete (trả về JsonResponse)
        $raw = $this->service->autocomplete($term, 'name');
        $data = $raw->getData(true);
        $list = is_array($data) && isset($data[0]) ? $data : ($data['data'] ?? []);
        // Trả về id, name, title để giữ tương thích và hỗ trợ select2 giá trị id
        $results = array_map(function ($item) {
            return [
                'id' => $item['id'] ?? null,
                'name' => $item['name'] ?? ($item['id'] ?? ''),
                'title' => $item['title'] ?? ($item['name'] ?? ''),
            ];
        }, $list);
        return response()->json($results);
    }

    /**
     * Thay đổi trạng thái quyền
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


}
