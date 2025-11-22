<?php

namespace App\Services;

use App\Repositories\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

class BaseService
{
    protected BaseRepository $repository;

    protected function getRepository(): BaseRepository
    {
        return $this->repository;
    }

    /**
     * Lấy danh sách tất cả
     * @param array $filters
     * @param array $options
     * @return Collection
     */
    public function getAll(array $filters = [], array $options = []): Collection
    {
        return $this->getRepository()->getAll($filters, $options);
    }

    /**
     * Lấy danh sách tất cả
     * @param array $filters
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getList(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->getRepository()->getList($filters, $options);
    }

    /**
     * Lấy thông tin theo ID
     * @param $id
     * @return Model|null
     */
    public function findById($id, array $options = []): ?Model
    {
        return $this->getRepository()->findById($id, $options);
    }

    /**
     * Xóa
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'messages' => 'Xóa thất bại'
        ];
        if (($position = $this->getRepository()->findById($id))
            && ($this->getRepository()->delete($position))
        ) {
            $return['success'] = true;
            $return['messages'] = 'Xóa thành công';
        }
        return $return;
    }

    /**
     * Hàm dùng chung cho autocomplete
     * @param string|null $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'name', int $limit = 50): JsonResponse
    {
        // Convert null to empty string
        $term = $term ?? '';
        return $this->getRepository()->autocomplete($term, $column, $limit);
    }

    /**
     * Hàm dùng chung cho autocomplete
     * @return array
     */
    public function getColumns(): array
    {
        return $this->getRepository()->getColumns();
    }
}
