<?php

namespace App\Repositories\User\Users;

use App\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function findByEmail(string $email, array $options = [])
    {
        $relations = $options['relations'] ?? [];
        $query = $this->getModel()->where('email', $email)->first();
        $this->applyRelations($query, $relations);
        return $query;
    }
}
