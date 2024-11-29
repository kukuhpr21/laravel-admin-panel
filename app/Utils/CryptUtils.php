<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class CryptUtils
{

    public static function enc($val)
    {
        return Crypt::encrypt($val);
    }

    public static function dec($val)
    {
        try {
            return Crypt::decrypt($val);
        } catch (DecryptException $e) {
            Log::error('CryptUtils (error decrypt) : '. $e->getMessage());
            return "";
        }
    }
}
