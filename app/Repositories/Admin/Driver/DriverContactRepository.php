<?php

namespace App\Repositories\Admin\Driver;

use App\Models\DriverContact;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class DriverContactRepository extends BaseRepository
{
    public function __construct(DriverContact $driverContact)
    {
        $this->model = $driverContact;
    }

    /**
     * Tìm nhiều liên hệ theo danh sách ID
     * @param array $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Cập nhật nhiều liên hệ cùng lúc
     * @param Collection $contacts
     * @param array $data
     * @return bool
     */
    public function updateMultiple(Collection $contacts, array $data): bool
    {
        try {
            foreach ($contacts as $contact) {
                $contact->update($data);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Xóa nhiều liên hệ cùng lúc
     * @param Collection $contacts
     * @return bool
     */
    public function deleteMultiple(Collection $contacts): bool
    {
        try {
            foreach ($contacts as $contact) {
                $contact->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


