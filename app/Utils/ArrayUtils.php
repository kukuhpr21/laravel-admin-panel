<?php

namespace App\Utils;

trait ArrayUtils
{
    public static function transform($items, $maps)
    {
        return array_map(function ($item) use ($maps) {
            $transformed = [];
            foreach ($maps as $key => $newKey) {
                if (is_array($item)) {
                    if (isset($item[$key])) {
                        $transformed[$newKey] = $item[$key];
                    }
                } else {
                    if (isset($item->$key)) {
                        $transformed[$newKey] = $item->$key;
                    }
                }

            }
            return $transformed;
        }, $items);

    }

    public static function hasOnlyKeys(array $array, array $allowedKeys): bool
    {
        $keys = array_keys($array);
        sort($keys);
        sort($allowedKeys);

        return $keys === $allowedKeys;
    }

    public static function transformToSelect2($items, $map)
    {
        $data = [];

        if (count($items) > 0) {

            $transforms = ArrayUtils::transform( $items, $map);

            foreach ($transforms as $item) {
                array_push($data, $item);
            }
        }

        return $data;
    }
}
