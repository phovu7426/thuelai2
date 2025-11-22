<?php

namespace App\Repositories\Admin;

use App\Models\ContactInfo;
use App\Repositories\BaseRepository;

class ContactInfoRepository extends BaseRepository
{
    public function __construct(ContactInfo $contactInfo)
    {
        $this->model = $contactInfo;
    }

    public function getModel(): ContactInfo
    {
        return $this->model;
    }

    /**
     * Lấy record đầu tiên
     * @return ContactInfo|null
     */
    public function getFirstRecord(): ?ContactInfo
    {
        return $this->getModel()->first();
    }

    /**
     * Override applyFilters để custom search cho contact info
     */
    protected function applyFilters($query, array $filters): void
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('address', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply other filters using parent method
        $otherFilters = array_diff_key($filters, ['search' => '']);
        parent::applyFilters($query, $otherFilters);
    }

    /**
     * Tìm theo ID - override để return ContactInfo type
     * @param int $id
     * @param array $options
     * @return ContactInfo|null
     */
    public function findById(int $id, array $options = []): ?ContactInfo
    {
        $result = parent::findById($id, $options);
        return $result instanceof ContactInfo ? $result : null;
    }
}
