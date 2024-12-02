<?php

namespace App\Utils;

use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\Boolean;

trait ResponseUtils
{
    use ToastUtils;

    public static function composeResponse(string $status, string $message, array|string $data = [], array|string $errors = []): array
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
        return self::composeResponse(
            status: 'success',
            message: $message,
            data: $data,
        );
    }

    public static function failed(string $message, array|string $data = [])
    {
        Log::info($data);

        return self::composeResponse(
            status: 'failed',
            message: $message,
            data: $data,
        );
    }

    public static function internalServerError(array|string $errors = [])
    {
        Log::error($errors);

        return self::composeResponse(
            status: 'error',
            message: 'Internal Server Error',
            errors: $errors,
        );
    }

    public static function isSuccess(array $response): bool
    {
        return $response['status'] == 'success';
    }

    public static function isFailed(array $response): bool
    {
        return $response['status'] == 'failed';
    }

    public static function isError(array $response): bool
    {
        return $response['status'] == 'error';
    }

    public static function showToast(array $response)
    {

        switch ($response['status']) {
            case 'success':
                ToastUtils::successToast($response['message']);
                break;
            case 'failed':
                ToastUtils::warningToast($response['message']);
                break;
            default:
                ToastUtils::errorToast($response['message']);
                break;
        }

    }

}
