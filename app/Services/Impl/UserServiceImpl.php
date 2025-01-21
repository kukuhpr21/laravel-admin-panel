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
use App\DataTransferObjects\User\StoreUserDto;

class UserServiceImpl implements UserService
{
    use ResponseUtils;
    private string $passwordDefault;
    private string $userStatusDefault;

    public function __construct() {
        $this->passwordDefault = env('DEFAULT_PASSWORD');
        $this->userStatusDefault = env('DEFAULT_USER_STATUS');
    }

    public function store(StoreUserDto $dto)
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
