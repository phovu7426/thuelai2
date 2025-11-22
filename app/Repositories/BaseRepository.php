<?php

namespace App\Repositories;

use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

abstract class BaseRepository
{
    protected Model $model;

    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Lấy tất cả danh sách
     * @param array $filters
     * @param array $options
     * @return Collection
     */
    public function getAll(array $filters = [], array $options = []): Collection
    {
        $query = $this->applyQueryDefaults($filters, $options);
        return $query->get();
    }

    /**
     * Lấy danh sách có bộ lọc, phân trang & sắp xếp
     * @param array $filters
     * @param array $options
     * @return LengthAwarePaginator
     */
    public function getList(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = $this->applyQueryDefaults($filters, $options);
        $perPage = $options['perPage'] ?? 10;
        // Phân trang
        return $query->paginate($perPage);
    }

    /**
     * Hàm chung để xử lý các phần tử cơ bản của query
     * @param array $filters
     * @param array $options
     * @return Builder
     */
    private function applyQueryDefaults(array $filters, array $options): Builder
    {
        $relations = $options['relations'] ?? [];
        $columns = $options['columns'] ?? ['*'];
        $sortBy = $options['sortBy'] ?? 'id';
        $sortOrder = $options['sortOrder'] ?? 'asc';
        $query = $this->getModel()->select($columns);
        // Áp dụng quan hệ
        $this->applyRelations($query, $relations);
        // Áp dụng bộ lọc
        $this->applyFilters($query, $filters);
        // Sắp xếp
        return $query->orderBy($sortBy, $sortOrder);
    }

    /**
     * Thêm điều kiện bộ lọc vào truy vấn.
     */
    protected function applyFilters(Builder $query, array $filters): void
    {
        foreach ($filters as $column => $value) {
            if (!empty($value)) {
                if (is_array($value)) {
                    $query->whereIn($column, $value);
                } elseif (is_string($value)) {
                    $query->where($column, 'like', '%' . $value . '%');
                } else {
                    $query->where($column, $value);
                }
            } elseif (is_null($value)) {
                $query->whereNull($column);
            }
        }
    }

    /**
     * Thêm quan hệ vào truy vấn.
     */
    protected function applyRelations($query, array $relations): void
    {
        if (!empty($relations)) {
            if ($query instanceof Model) {
                $query = $query->newQuery(); // Chuyển model thành Builder
            }
            $query->with($relations);
        }
    }


    /**
     * Tìm một bản ghi theo ID
     * @param int $id
     * @param array $options
     * @return Model|null
     */
    public function findById(int $id, array $options = []): ?Model
    {
        $relations = $options['relations'] ?? [];
        $columns = $options['columns'] ?? ['*'];
        $query = $this->getModel()->newQuery()->select($columns);
        if (!empty($relations)) {
            $query->with($relations);
        }
        return $query->find($id);
    }

    /**
     * Tìm một bản ghi theo ID
     * @param array $filters
     * @param array $options
     * @return Model|null
     */
    public function findOne(array $filters, array $options = []): ?Model
    {
        $query = $this->applyQueryDefaults($filters, $options);
        return $query->first();
    }

    /**
     * Tìm một bản ghi theo ID, nếu không có thì báo lỗi
     * @param int $id
     * @return Model
     */
    public function findOrFail(int $id): Model
    {
        return $this->getModel()->findOrFail($id);
    }

    /**
     * Tạo mới bản ghi
     * @param array $data
     * @return Model|null
     */
    public function create(array $data): ?Model
    {
        try {
            if ($this->hasColumn('user_id')) {
                $data['user_id'] = Auth::id() ?? 0;
            }
            $create = $this->getModel()->create($data);
            if ($create && $this->getModel()->where('id', $create->id)->exists()) {
                return $create;
            } else {
                return null;
            }
        } catch (Throwable $e) {
            Log::error('Repository create error: ' . $e->getMessage(), ['exception' => $e]);
            return null;
        }
    }

    /**
     * Cập nhật bản ghi
     * @param Model $model
     * @param array $data
     * @return bool
     */
    public function update(Model $model, array $data): bool
    {
        try {
            if ($this->hasColumn('user_id')) {
                $data['user_id'] = Auth::id() ?? 0;
            }
            if ($model->update($data)) {
                return true;
            }
            return false;
        } catch (Throwable $e) {
            Log::error('Repository update error: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }

    /**
     * Cập nhật bản ghi
     * @param array $filters
     * @param array $data
     * @return bool
     */
    public function updateOrCreate(array $filters, array $data): bool
    {
        try {
            if (
                !empty($filters)
                && !empty($data)
                && $this->getModel()->updateOrCreate($filters, $data)
            ) {
                return true;
            }
            return false;
        } catch (Throwable $e) {
            Log::error('Repository updateOrCreate error: ' . $e->getMessage(), ['exception' => $e]);
            return false;
        }
    }

    /**
     * Xóa bản ghi
     * @param Model $model
     * @return bool
     */
    public function delete(Model $model): bool
    {
        try {
            if ($model->delete()) {
                return true;
            }
            return false;
        } catch (Throwable $e) {
            return false;
        }
    }

    /**
     * Hàm dùng chung cho autocomplete
     * @param string|null $term
     * @param string $column
     * @param int $limit
     * @return JsonResponse
     */
    public function autocomplete(?string $term = '', string $column = 'title', int $limit = 10): JsonResponse
    {
        // Convert null to empty string
        $term = $term ?? '';
        
        $columns = $this->getColumns();
        $selectColumns[] = 'id';
        if (in_array('name', $columns)) {
            $selectColumns[] = 'name';
        }
        if (in_array('title', $columns)) {
            $selectColumns[] = 'title';
        }
        $results = $this->getModel()->query()
            ->where($column, 'like', '%' . $term . '%')
            ->select($selectColumns)
            ->limit($limit)
            ->get();
        return response()->json($results);
    }

    /**
     * Kiểm tra xem bảng có tồn tại cột hay không
     * @param string $column
     * @return bool
     */
    public function hasColumn(string $column): bool
    {
        $table = $this->getModel()->getTable(); // Lấy tên bảng từ model
        return Schema::hasColumn($table, $column);
    }

    /**
     * Lấy danh sách các cột trong bảng của model hiện tại
     * @return array
     */
    public function getColumns(): array
    {
        $table = $this->getModel()->getTable(); // Lấy tên bảng từ model
        return array_values(Schema::getColumnListing($table)); // Trả về danh sách các cột
    }
}
