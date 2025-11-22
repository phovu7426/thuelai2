<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Admin\Users\Users\AssignRequest;
use App\Http\Requests\Admin\Users\Users\StoreRequest;
use App\Http\Requests\Admin\Users\Users\UpdateRequest;
use App\Services\Admin\Users\UserService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserController extends BaseController
{
    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    /**
     * Lấy service instance
     * @return UserService
     */
    public function getService(): UserService
    {
        return $this->service;
    }

    /**
     * Hiển thị danh sách tài khoản
     * @param Request $request
     * @return View|Application|Factory
     */
    public function index(Request $request): View|Application|Factory
    {
        $filters = $this->getFilters($request->all());
        $options = $this->getOptions($request->all());
        $users = $this->getService()->getList($filters, $options);
        
        return view('admin.users.index', compact('users', 'filters', 'options'));
    }

    /**
     * Hiển thị form tạo tài khoản
     * @return View|Application|Factory
     */
    public function create(): View|Application|Factory
    {
        return view('admin.users.create');
    }

    /**
     * Xử lý tạo tài khoản
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $result = $this->getService()->create($request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Tạo tài khoản thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị chi tiết tài khoản
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = $this->getService()->findById($id, ['relations' => ['profile']]);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản không tồn tại.',
                'data' => null
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Lấy thông tin tài khoản thành công.',
            'data' => $user
        ]);
    }

    /**
     * Hiển thị form chỉnh sửa tài khoản
     * @param int $id
     * @return View|Application|Factory|RedirectResponse
     */
    public function edit(int $id): View|Application|Factory|RedirectResponse
    {
        $user = $this->getService()->findById($id);
        
        if (!$user) {
            return redirect()->route('admin.users.index')
                ->with('fail', 'Tài khoản không tồn tại.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Xử lý chỉnh sửa tài khoản
     * @param UpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $id): JsonResponse
    {
        $result = $this->getService()->update($id, $request->validated());
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Cập nhật tài khoản thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Xử lý xóa tài khoản
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        $result = $this->getService()->delete($id);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Xóa tài khoản thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Hiển thị form phân vai trò
     * @param int $id
     * @return View|Application|Factory|RedirectResponse
     */
    public function showAssignRolesForm(int $id): View|Application|Factory|RedirectResponse
    {
        $user = $this->getService()->findById($id);
        
        if (!$user) {
            return redirect()->route('admin.users.index')
                ->with('fail', 'Tài khoản không tồn tại.');
        }
        
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->unique()->toArray();
        
        return view('admin.users.assign-roles', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Xử lý phân vai trò
     * @param AssignRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function assignRoles(AssignRequest $request, int $id): JsonResponse
    {
        try {
            $this->getService()->assignRoles($id, $request->validated()['roles'] ?? []);
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật vai trò thành công.',
                'data' => null
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null
            ], 500);
        }
    }

    /**
     * Khóa hoặc mở khóa tài khoản
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(int $id, Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|boolean',
        ]);
        
        $result = $this->getService()->changeStatus($id, (int) $request->status);
        
        return response()->json([
            'success' => $result['success'] ?? false,
            'message' => $result['message'] ?? 'Thay đổi trạng thái tài khoản thất bại.',
            'data' => $result['data'] ?? null
        ]);
    }

    /**
     * Lấy thông tin người dùng cho AJAX request
     * @param int $id
     * @return JsonResponse
     */
    public function getUserInfo(int $id): JsonResponse
    {
        try {
            $user = User::with('profile')->findOrFail($id);
            return response()->json([
                'success' => true,
                'data' => $user
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy người dùng'
            ], 404);
        }
    }

    /**
     * Toggle block status cho AJAX request
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleBlock(int $id, Request $request): JsonResponse
    {
        try {
            $request->validate([
                'status' => 'required|boolean',
            ]);
            
            $user = User::findOrFail($id);
            $newStatus = $request->boolean('status');
            // Map boolean to enum status: true => inactive (blocked), false => active
            $user->status = $newStatus ? 'inactive' : 'active';
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật trạng thái thành công',
                'new_status' => $user->status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Xử lý response chung cho các action
     * @param array $result
     * @param string $successMessage
     * @param string $failMessage
     * @param string $redirectRoute
     * @return RedirectResponse
     */
    protected function handleResponse(
        array $result, 
        string $successMessage, 
        string $failMessage, 
        string $redirectRoute
    ): RedirectResponse {
        if (!empty($result['success'])) {
            return redirect()->route($redirectRoute)
                ->with('success', $result['message'] ?? $successMessage);
        }
        
        return redirect()->route($redirectRoute)
            ->with('fail', $result['message'] ?? $failMessage);
    }
}
