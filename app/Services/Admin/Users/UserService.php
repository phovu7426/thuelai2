<?php

namespace App\Services\Admin\Users;

use App\Repositories\User\Users\UserRepository;
use App\Services\Admin\Users\ProfileService;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use lib\DataTable;

class UserService extends BaseService
{
    protected ProfileService $profileService;

    public function __construct(UserRepository $userRepository, ProfileService $profileService)
    {
        $this->repository = $userRepository;
        $this->profileService = $profileService;
    }

    protected function getRepository(): UserRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo tài khoản
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới tài khoản thất bại'
        ];
        if (empty($data['name'])) {
            $data['name'] = $data['email'];
        }
        // Handle image upload
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $storedPath = $data['image']->store('users', 'public');
            $data['image'] = 'storage/' . $storedPath;
        }
        // Map users table fields
        $userKeys = ['name', 'email', 'password', 'google_id', 'image', 'status'];
        $insertData = DataTable::getChangeData($data, $userKeys);
        if ($insertData && ($user = $this->getRepository()->create($insertData))) {
            // Also create/update profile
            $profileKeys = ['phone', 'address', 'birth_date', 'gender'];
            $profileData = DataTable::getChangeData($data, $profileKeys) ?? [];
            if (!empty($profileData)) {
                $this->profileService->update($user->id, $profileData);
            }

            $return['success'] = true;
            $return['message'] = 'Thêm mới tài khoản thành công';
            $return['data'] = $user;
        }
        return $return;
    }

    /**
     * Hàm cập nhật tài khoản
     * @param $id
     * @param array $data
     * @return array
     */
    public function update($id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật tài khoản thất bại'
        ];
        if (empty($data['name'])) {
            $data['name'] = $data['email'];
        }
        // Handle image upload
        if (!empty($data['image']) && $data['image'] instanceof UploadedFile) {
            $storedPath = $data['image']->store('users', 'public');
            $data['image'] = 'storage/' . $storedPath;
        }
        $userKeys = ['name', 'email', 'password', 'google_id', 'image', 'status'];
        $updateData = DataTable::getChangeData($data, $userKeys);
        if (($user = $this->getRepository()->findById($id, ['relations' => ['profile']]))) {
            $updated = true;
            if (!empty($updateData)) {
                $updated = (bool) $this->getRepository()->update($user, $updateData);
            }

            // Update or create profile
            $profileKeys = ['phone', 'address', 'birth_date', 'gender'];
            $profileData = DataTable::getChangeData($data, $profileKeys) ?? [];
            if (!empty($profileData)) {
                $this->profileService->update($user->id, $profileData);
            }

            if ($updated) {
                $return['success'] = true;
                $return['message'] = 'Cập nhật tài khoản thành công';
                $return['data'] = $user->fresh('profile');
            }
        }
        return $return;
    }

    /**
     * Hàm đồng bộ lại vai trò của người dùng
     * @param $id
     * @param array $roles
     * @return void
     */
    public function assignRoles($id, array $roles): void
    {
        $user = $this->getRepository()->findById($id);
        // Chặn phân quyền cho tài khoản admin
        if ($user->email === 'dinhminhlh@gmail.com') {
            throw new \Exception('Không thể phân quyền cho tài khoản admin!');
        }
        $user->syncRoles($roles);
    }

    /**
     * Hàm thay đổi trạng thái tài khoản
     * @param $id
     * @param int $status
     * @return array
     */
    public function changeStatus($id, int $status = 0): array
    {
        $return = [
            'success' => false,
            'messages' => 'Thay đổi trạng thái tài khoản thất bại'
        ];
        $status = !empty($status) ? 1 : 0;
        if ($user = $this->getRepository()->findById($id)) {
            if ((!empty($user->status) && !empty($status))
                || (empty($user->status) && empty($status))
            ) {
                $return['messages'] = 'Trạng thái cần không thay đổi không đúng';
            } elseif ($this->getRepository()->update($user, ['status' => $status])) {
                $return['success'] = true;
                $return['messages'] = 'Thay đổi trạng thái tài khoản thành công';
            }
        } else {
            $return['messages'] = 'Tài khoản không hợp lệ';
        }
        return $return;
    }

    /**
     * Hàm lấy ra danh sách người dùng theo từ
     * @param string $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'title', int $limit = 10): JsonResponse
    {
        return parent::autocomplete($term, 'email', $limit);
    }

    /**
     * Hàm xóa tài khoản
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa tài khoản thất bại'
        ];
        $user = $this->getRepository()->findById($id);
        // Chặn xóa tài khoản admin
        if ($user && ($user->email === 'admin@gmail.com' || $user->hasRole('admin'))) {
            $return['message'] = 'Không thể xóa tài khoản admin!';
            return $return;
        }
        if ($user && $this->getRepository()->delete($user)) {
            $return['success'] = true;
            $return['message'] = 'Xóa tài khoản thành công';
        }
        return $return;
    }
}
