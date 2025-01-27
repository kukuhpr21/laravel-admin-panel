<?php

namespace App\Services\Impl;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Enum\StatusEnum;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\Profile\ProfileDto;

class ProfileServiceImpl implements ProfileService
{
    use ResponseUtils;

    public function changeProfile(ProfileDto $dto)
    {
        try {
            $user = User::where([
                'id' => $dto->id,
                'status_id' => StatusEnum::ACTIVE->value
                ])->update([
                'name' => $dto->name,
                'email' => $dto->email,
                'updated_at' => Carbon::now(),
            ]);

            if ($user) {
                $sessionUtils = new SessionUtils();
                $sessionUtils->save('name', $dto->name);
                $sessionUtils->save('email', $dto->email);
                return ResponseUtils::success(
                    message: 'Success change profile'
                );
            } else {
                return ResponseUtils::failed('Failed change profile');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed change profile : '.$errorMessage);
        }
    }

    public function changePassword(ProfileDto $dto)
    {
        try {
            if ($dto->new_password == $dto->confirm_password) {

                if (!strcasecmp($dto->new_password, env('DEFAULT_PASSWORD')) ) {
                    return ResponseUtils::failed('Failed change password, do not use default password');
                } else {
                    $user = User::where([
                        'id' => $dto->id,
                        'status_id' => StatusEnum::ACTIVE->value
                        ])->update([
                        'password' => Hash::make($dto->new_password),
                        'updated_at' => Carbon::now(),
                    ]);

                    if ($user) {
                        return ResponseUtils::success(
                            message: 'Success change password'
                        );
                    } else {
                        return ResponseUtils::failed('Failed change password');
                    }
                }

            } else {
                return ResponseUtils::failed('Password not match');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed change password : '.$errorMessage);
        }
    }
}
