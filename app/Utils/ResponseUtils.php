<?php

namespace App\Utils;

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
}
