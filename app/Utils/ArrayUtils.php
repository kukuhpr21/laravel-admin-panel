<?php

namespace App\Utils;

trait ArrayUtils
{
    public static function mapping($source, $maps)
    {
        $result = [];

        foreach ($source as $keySource => $valueSource) {

            $items = [];

            foreach ($maps as $keyMap => $valueMap) {

                if ($keySource == $keyMap) {

                    array_push($items, [$valueMap => $valueSource]);

                }
            }

            array_push($result, $items);

        }

        return $result;

    }
}
