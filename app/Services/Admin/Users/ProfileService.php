<?php

namespace App\Services\Admin\Users;

use App\Repositories\Admin\Users\ProfileRepository;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Model;
use lib\DataTable;

class ProfileService extends BaseService
{
    public function __construct(ProfileRepository $profileRepository)
    {
        $this->repository = $profileRepository;
    }

    protected function getRepository(): ProfileRepository
    {
        return $this->repository;
    }

    /**
     * Hàm lấy thông tin hồ sơ
     * @param $user_id
     * @return Model|null
     */
    public function findByUserId($user_id): ?Model
    {
        return $this->getRepository()->findOne(['user_id' => $user_id]);
    }

    /**
     * Hàm cập nhật hồ sơ
     * @param $user_id
     * @param array $data
     * @return array
     */
    public function update($user_id, array $data): array
    {
        $return = [
            'success' => false,
            'messages' => 'Cập nhật hồ sơ thất bại'
        ];
        $keys = ['address', 'phone', 'birth_date', 'gender'];
        $updateData = DataTable::getChangeData($data, $keys);
        if (!empty($user_id)
            && !empty($updateData)
            && User::query()->where('id', $user_id)->exists()
            && $this->getRepository()->updateProfile($user_id, $updateData)
        ) {
            $return['success'] = true;
            $return['messages'] = 'Cập nhật hồ sơ thành công';
        }
        return $return;
    }
}
