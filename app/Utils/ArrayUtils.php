<?php

namespace App\Utils;

trait ArrayUtils
{
    public static function transform($items, $maps)
    {
        return array_map(function ($item) use ($maps) {
            $transformed = [];
            foreach ($maps as $key => $newKey) {
                if (isset($item[$key])) {
                    $transformed[$newKey] = $item[$key];
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
}
