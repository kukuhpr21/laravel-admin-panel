<?php

namespace App\Services\Impl;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use App\Utils\ConstantUtils;
use App\Utils\ResponseUtils;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\User\StoreUserDto;

class UserServiceImpl implements UserService
{
    use ResponseUtils;
    private string $passwordDefault = ConstantUtils::DEFAULT_PASSWORD;
    public function store(StoreUserDto $dto)
    {
        try {
            $id = (string) Str::uuid();
            User::create([
                'id' => $id,
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($this->passwordDefault),
            ]);
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create user : '.$errorMessage);
        }
    }

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
