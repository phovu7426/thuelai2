<?php

namespace App\Repositories\Admin\Posts;

use App\Models\PostCategory;
use App\Repositories\BaseRepository;

class PostCategoryRepository extends BaseRepository
{
    public function __construct(PostCategory $postCategory)
    {
        $this->model = $postCategory;
    }

    /**
     * Lấy danh sách với relationship parent
     * @param array $filters
     * @param array $options
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getList(array $filters = [], array $options = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $options['relations'] = ['parent'];
        return parent::getList($filters, $options);
    }
}


