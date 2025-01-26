<?php

namespace App\Services\Impl;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use App\Utils\ResponseUtils;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\User\UserDto;

class UserServiceImpl implements UserService
{
    use ResponseUtils;
    private string $passwordDefault;
    private string $userStatusDefault;

    public function __construct() {
        $this->passwordDefault = env('DEFAULT_PASSWORD');
        $this->userStatusDefault = env('DEFAULT_USER_STATUS');
    }

    public function store(UserDto $dto)
    {
        try {
            DB::beginTransaction();

            $id = (string) Str::uuid();
            $user = DB::table('users')->insert([
                'id' => $id,
                'status_id' => $this->userStatusDefault,
                'name' => $dto->name,
                'email' => $dto->email,
                'password' => Hash::make($this->passwordDefault),
                'created_at' => Carbon::now(),
            ]);

            if ($user) {

                $dataUserRoles = [];

                foreach ($dto->roles as $role) {
                    array_push($dataUserRoles, [
                        'user_id' => $id,
                        'role_id' => $role,
                    ]);
                }
                $userRoles = DB::table('user_has_roles')->insert($dataUserRoles);

                if (!$userRoles) {
                    DB::rollBack();
                    return ResponseUtils::failed('Failed create user');
                }

                DB::commit();
                return ResponseUtils::success(
                    message: 'Success create user'
                );
            } else {
                DB::rollBack();
                return ResponseUtils::failed('Failed create user');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create user : '.$errorMessage);
        }
    }

    function update(UserDto $dto)
    {
        try {
            DB::beginTransaction();

            $user = DB::table('users')->where('id', $dto->id)->update([
                'status_id' => $dto->status_id,
                'name' => $dto->name,
                'email' => $dto->email,
                'updated_at' => Carbon::now(),
            ]);

            if ($user) {

                DB::table('user_has_roles')->where('user_id', $dto->id)->delete();

                $dataUserRoles = [];

                foreach ($dto->roles as $role) {
                    array_push($dataUserRoles, [
                        'user_id' => $dto->id,
                        'role_id' => $role,
                    ]);
                }
                $userRoles = DB::table('user_has_roles')->insert($dataUserRoles);

                if (!$userRoles) {
                    DB::rollBack();
                    return ResponseUtils::failed('Failed update user');
                }

                DB::commit();
                return ResponseUtils::success(
                    message: 'Success update user'
                );
            } else {
                DB::rollBack();
                return ResponseUtils::failed('Failed update user');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update user : '.$errorMessage);
        }
    }

    public function changeStatus(UserDto $dto)
    {
        try {
            $user = User::where('id', $dto->id)->update([
                'status_id' => $dto->status_id,
                'updated_at' => Carbon::now(),
            ]);

            if ($user) {
                return ResponseUtils::success(
                    message: 'Success change status user'
                );
            } else {
                return ResponseUtils::failed('Failed change status user');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed change status user : '.$errorMessage);
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
