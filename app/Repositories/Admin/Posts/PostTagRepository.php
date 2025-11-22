<?php

namespace App\Repositories\Admin\Posts;

use App\Models\PostTag;
use App\Repositories\BaseRepository;

class PostTagRepository extends BaseRepository
{
    public function __construct(PostTag $postTag)
    {
        $this->model = $postTag;
    }
}


