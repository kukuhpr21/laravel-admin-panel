<?php

namespace App\Utils;

trait ToastUtils
{
    private static function composeToast(string $status, string $message)
    {

        $data = [
            'status'  => $status,
            'message' => $message,
        ];

        session()->flash('toast', $data);
    }

    public static function successToast(string $message)
    {
        self::composeToast('success', $message);
    }

    public static function infoToast(string $message)
    {
        self::composeToast('info', $message);
    }

    public static function warningToast(string $message)
    {
        self::composeToast('warning', $message);
    }

    public static function errorToast(string $message)
    {
        self::composeToast('error', $message);
    }
}
