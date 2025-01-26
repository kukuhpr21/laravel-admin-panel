<?php

namespace App\Utils;

use Illuminate\Support\Facades\Cache;

class CacheUtils
{
    public static function put($key, $id, $value)
    {
        $ttl   = 86400;
        $value = CryptUtils::enc($value);
        Cache::tags($id)->put($key, $value, $ttl);
    }

    public static function get($key, $id)
    {
        $result = Cache::get($key, null);

        if (!empty($result)) {
            return CryptUtils::dec($result);
        } else {
            $sessionUtils = new SessionUtils();
            $resultSession = $sessionUtils->get($key);
            self::put($key, $id, $resultSession);
            return $resultSession;
        }
    }

    public static function delete($key, $id)
    {
        $key = "$id.$key";
        Cache::tags($id)->delete($key);
    }

    public static function deleteWithTags($prefix)
    {
        Cache::tags($prefix)->flush();
    }
}
