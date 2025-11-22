<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ContactInfoRepository;
use App\Services\BaseService;
use App\Helpers\ContactInfoHelper;
use lib\DataTable;
use Illuminate\Support\Facades\Log;

class ContactInfoService extends BaseService
{
    public function __construct(ContactInfoRepository $contactInfoRepository)
    {
        $this->repository = $contactInfoRepository;
    }

    protected function getRepository(): ContactInfoRepository
    {
        return $this->repository;
    }

    /**
     * Service xử lý tạo thông tin liên hệ
     * @param array $data
     * @return array
     */
    public function create(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Thêm mới thông tin liên hệ thất bại'
        ];

        try {
            $keys = [
                'address',
                'phone',
                'email',
                'working_time',
                'facebook',
                'instagram',
                'youtube',
                'linkedin',
                'map_embed',
                'pricing_background_image'
            ];
            $insertData = DataTable::getChangeData($data, $keys);

            if ($contactInfo = $this->getRepository()->create($insertData)) {
                // Clear cache sau khi tạo mới
                ContactInfoHelper::clearCache();

                $return['success'] = true;
                $return['message'] = 'Thêm mới thông tin liên hệ thành công';
                $return['data'] = $contactInfo;
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Hàm cập nhật thông tin liên hệ
     * @param int $id
     * @param array $data
     * @return array
     */
    public function update(int $id, array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật thông tin liên hệ thất bại'
        ];

        try {
            $contactInfo = $this->getRepository()->findById($id);

            if (!$contactInfo) {
                $return['message'] = 'Thông tin liên hệ không tồn tại';
                return $return;
            }

            $keys = [
                'address',
                'phone',
                'email',
                'working_time',
                'facebook',
                'instagram',
                'youtube',
                'linkedin',
                'map_embed',
                'pricing_background_image'
            ];
            $updateData = DataTable::getChangeData($data, $keys);

            if ($this->getRepository()->update($contactInfo, $updateData)) {
                // Clear cache sau khi cập nhật
                ContactInfoHelper::clearCache();

                $return['success'] = true;
                $return['message'] = 'Cập nhật thông tin liên hệ thành công';
                $return['data'] = $contactInfo->fresh();
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Xóa thông tin liên hệ
     * @param $id
     * @return array
     */
    public function delete($id): array
    {
        $return = [
            'success' => false,
            'message' => 'Xóa thông tin liên hệ thất bại'
        ];

        try {
            $contactInfo = $this->getRepository()->findById($id);

            if (!$contactInfo) {
                $return['message'] = 'Thông tin liên hệ không tồn tại';
                return $return;
            }

            if ($this->getRepository()->delete($contactInfo)) {
                // Clear cache sau khi xóa
                ContactInfoHelper::clearCache();

                $return['success'] = true;
                $return['message'] = 'Xóa thông tin liên hệ thành công';
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }

    /**
     * Lấy hoặc tạo bản ghi đầu tiên
     * @return mixed
     */
    public function getFirstOrCreate()
    {
        $contactInfo = $this->getRepository()->getFirstRecord();

        if (!$contactInfo) {
            // Tạo bản ghi mặc định
            $contactInfo = $this->getRepository()->create([
                'address' => '',
                'phone' => '',
                'email' => '',
                'working_time' => '',
                'facebook' => '',
                'instagram' => '',
                'youtube' => '',
                'linkedin' => '',
                'map_embed' => '',
                'pricing_background_image' => ''
            ]);
        }

        return $contactInfo;
    }

    /**
     * Lấy thông tin liên hệ đầu tiên (để sử dụng global)
     * @return array|null
     */
    public function getFirstContactInfo(): ?array
    {
        $contactInfo = $this->getRepository()->getFirstRecord();

        if (!$contactInfo) {
            return null;
        }

        return [
            'address' => $contactInfo->address,
            'phone' => $contactInfo->phone,
            'email' => $contactInfo->email,
            'working_time' => $contactInfo->working_time,
            'facebook' => $contactInfo->facebook,
            'instagram' => $contactInfo->instagram,
            'youtube' => $contactInfo->youtube,
            'linkedin' => $contactInfo->linkedin,
            'map_embed' => $contactInfo->map_embed,
            'pricing_background_image' => $contactInfo->pricing_background_image,
        ];
    }

    /**
     * Cập nhật hoặc tạo mới thông tin liên hệ (chỉ có 1 record)
     * @param array $data
     * @return array
     */
    public function updateContactInfo(array $data): array
    {
        $return = [
            'success' => false,
            'message' => 'Cập nhật thông tin liên hệ thất bại'
        ];

        try {
            $contactInfo = $this->getRepository()->getFirstRecord();

            // Debug: Log dữ liệu nhận được
            Log::info('ContactInfo update data received:', $data);

            $keys = [
                'address',
                'phone',
                'email',
                'working_time',
                'facebook',
                'instagram',
                'youtube',
                'linkedin',
                'map_embed',
                'pricing_background_image'
            ];
            $updateData = DataTable::getChangeData($data, $keys);

            // Debug: Log dữ liệu sau khi filter
            Log::info('ContactInfo update data filtered:', $updateData);

            if ($contactInfo) {
                // Cập nhật record hiện có
                if ($this->getRepository()->update($contactInfo, $updateData)) {
                    // Clear cache sau khi cập nhật
                    ContactInfoHelper::clearCache();

                    $return['success'] = true;
                    $return['message'] = 'Cập nhật thông tin liên hệ thành công';
                    $return['data'] = $contactInfo->fresh();
                }
            } else {
                // Tạo mới record
                if ($newContactInfo = $this->getRepository()->create($updateData)) {
                    // Clear cache sau khi tạo mới
                    ContactInfoHelper::clearCache();

                    $return['success'] = true;
                    $return['message'] = 'Tạo mới thông tin liên hệ thành công';
                    $return['data'] = $newContactInfo;
                }
            }
        } catch (\Exception $e) {
            $return['message'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        return $return;
    }
}
