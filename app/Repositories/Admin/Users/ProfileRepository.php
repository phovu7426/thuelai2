<?php

namespace App\Repositories\Admin\Users;

use App\Models\Profile;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class ProfileRepository extends BaseRepository
{
    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    public function updateProfile($userId, array $data): Model|bool|null
    {
        return $this->updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}







