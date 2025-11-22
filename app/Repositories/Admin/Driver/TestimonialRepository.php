<?php

namespace App\Repositories\Admin\Driver;

use App\Models\Testimonial;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

class TestimonialRepository extends BaseRepository
{
    public function __construct(Testimonial $testimonial)
    {
        $this->model = $testimonial;
    }

    /**
     * Tìm nhiều đánh giá theo danh sách ID
     * @param array $ids
     * @return Collection
     */
    public function findByIds(array $ids): Collection
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    /**
     * Cập nhật nhiều đánh giá cùng lúc
     * @param Collection $testimonials
     * @param array $data
     * @return bool
     */
    public function updateMultiple(Collection $testimonials, array $data): bool
    {
        try {
            foreach ($testimonials as $testimonial) {
                $testimonial->update($data);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Xóa nhiều đánh giá cùng lúc
     * @param Collection $testimonials
     * @return bool
     */
    public function deleteMultiple(Collection $testimonials): bool
    {
        try {
            foreach ($testimonials as $testimonial) {
                $testimonial->delete();
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}


