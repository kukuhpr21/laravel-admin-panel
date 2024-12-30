<?php

namespace App\Services\Impl;

use Exception;
use App\Models\User;
use App\Utils\ResponseUtils;
use App\Services\UserService;

class UserServiceImpl implements UserService
{
    use ResponseUtils;
    public function findOne(string $id)
    {
        try {
            $user = User::where('id', $id)->first();

            if ($user) {
                return ResponseUtils::success('User is exist', $user);
            } else {
                return ResponseUtils::failed('User not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find one user : '.$errorMessage);
        }
    }

}
