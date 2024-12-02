<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;

trait ResponseUtils
{
    public static function compose(string $status, string $message, array|string $data = [], array|string $errors = []): array
    {
        return [
            'status' => $status,
            'message' => $message,
            'data' => $data,
            'errors' => $errors,
        ];
    }

    public static function success(string $message, array|string $data = [])
    {
        return self::compose(
            status: 'success',
            message: $message,
            data: $data,
        );
    }

    public static function failed(string $message, array|string $data = [])
    {
        return self::compose(
            status: 'failed',
            message: $message,
            data: $data,
        );
    }

    public static function internalServerError(array|string $errors = [])
    {
        Log::error($errors);

        return self::compose(
            status: 'error',
            message: 'Internal Server Error',
            errors: $errors,
        );
    }
}
