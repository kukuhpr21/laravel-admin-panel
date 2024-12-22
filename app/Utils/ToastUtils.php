<?php

namespace App\Utils;

trait ToastUtils
{
    use ArrayUtils;

    private static function composeToast(string $status, string $message)
    {
        session()->flash('toast', self::mapDataToast($status, $message));
    }

    private static function mapDataToast(string $status, string $message)
    {
        return [
            'status'  => $status,
            'message' => $message,
        ];
    }

    public static function toasts(array $toasts)
    {
        $allowKeys = ['status', 'message'];
        $allowed   = false;

        foreach ($toasts as $toast) {
            $allowed = ArrayUtils::hasOnlyKeys($toast, $allowKeys);

            if (!$allowed) {
                break;
            }

        }

        if ($allowed) {
            session()->flash('toast', $toasts);
        }
    }

    public static function successToast(string $message, bool $multi = false)
    {
        if ($multi) {
            return self::mapDataToast('success', $message);
        }

        self::composeToast('success', $message);
        return;
    }

    public static function infoToast(string $message, bool $multi = false)
    {
        if ($multi) {
            return self::mapDataToast('info', $message);
        }

        self::composeToast('info', $message);
        return;
    }

    public static function warningToast(string $message, bool $multi = false)
    {
        if ($multi) {
            return self::mapDataToast('warning', $message);
        }

        self::composeToast('warning', $message);
        return;
    }

    public static function errorToast(string $message, bool $multi = false)
    {
        if ($multi) {
            return self::mapDataToast('error', $message);
        }

        self::composeToast('error', $message);
        return;
    }
}
