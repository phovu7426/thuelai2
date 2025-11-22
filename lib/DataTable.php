<?php

namespace lib;

class DataTable
{
    /**
     * Hàm lấy ra danh sách giá trị của các key truyền vào nếu có cho TH insert, update
     * @param array $keys
     * @param array $data
     * @return array
     */
    public static function getChangeData(array $data, array $keys): array
    {
        return array_filter($data, fn($key) => in_array($key, $keys, true), ARRAY_FILTER_USE_KEY);
    }

    /**
     * Hàm lấy ra danh sách giá trị của các key truyền vào nếu có cho TH select
     * @param array $keys
     * @param array $data
     * @return array
     */
    public static function getFiltersData(array $data, array $keys = []): array
    {
        if (empty($keys)) {
            return array_filter(
                $data,
                fn($value, $key) => !is_null($value) && $value !== '' && $value !== false,
                ARRAY_FILTER_USE_BOTH
            );
        }
        return array_filter(
            $data,
            fn($value, $key) => in_array($key, $keys, true) && !is_null($value) && $value !== '' && $value !== false,
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * Hàm lấy ra danh sách options truyền vào nếu có cho TH select
     * @param array $data
     * @return array
     */
    public static function getOptionsData(array $data = []): array
    {
        $options['sortBy'] = $data['sortBy'] ?? 'id';
        $options['sortOrder'] = $data['sortOrder'] ?? 'asc';
        $options['page'] = $data['page'] ?? 1;
        if (!empty($data['relations'])) {
            $options['relations'] = $data['relations'];
        }
        return $options;
    }
}
