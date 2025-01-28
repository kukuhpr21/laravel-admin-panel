<?php

namespace App\Services\Impl;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Enum\StatusEnum;
use App\Utils\CacheUtils;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Services\AuthService;
use App\Services\MenuService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\Auth\LoginPostDto;
use App\DataTransferObjects\Auth\ChangePasswordDto;

class AuthServiceImpl implements AuthService
{
    use ResponseUtils;

    private SessionUtils $sessionUtils;
    private MenuService $menuService;

    public function __construct(SessionUtils $sessionUtils, MenuService $menuService) {
        $this->sessionUtils = $sessionUtils;
        $this->menuService = $menuService;
    }

    public function login(LoginPostDto $dto)
    {
        try {
            // find user by email
            $user = User::with('roles')
                    ->where([
                        'email' => $dto->email,
                        'status_id' => StatusEnum::ACTIVE->value])
                    ->first();

            if ($user) {
                if (!strcasecmp($dto->password, env('DEFAULT_PASSWORD')) ) {
                    return ResponseUtils::failed('Invalid email or password, please change password');
                } else {

                    // checking password
                    $passwordMatch = Hash::check($dto->password, $user->password);

                    if ($passwordMatch) {
                        $this->saveProfileToSession($user);
                        return ResponseUtils::success('Login success');
                    }

                    return ResponseUtils::failed('Invalid email or password');
                }
            }

            return ResponseUtils::failed('Invalid email or password');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed login : '.$errorMessage);
        }
    }

    public function changePassword(ChangePasswordDto $dto)
    {
        try {
            if ($dto->new_password == $dto->confirm_password) {
                // find user by email
                $user = User::with('roles')
                        ->where([
                            'email' => $dto->email,
                            ])
                        ->first();

                if ($user) {
                    if (!strcasecmp($dto->new_password, env('DEFAULT_PASSWORD')) ) {
                        return ResponseUtils::failed('Failed change password, do not use default password');
                    } else {
                        $status = $user->status_id;

                        if ($status == StatusEnum::INACTIVE->value || $status == StatusEnum::DELETED->value) {
                            return ResponseUtils::failed('Invalid email');
                        } else {
                            $status = ($status == StatusEnum::REGISTERED->value) ? StatusEnum::CHANGED_PASSWORD->value : $status;

                            $user = User::where([
                                'email' => $dto->email,
                                ])->update([
                                'password' => Hash::make($dto->new_password),
                                'status_id' => $status,
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
                    }
                }
                return ResponseUtils::failed('Invalid email');
            } else {
                return ResponseUtils::failed('Password not match');
            }

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed change password : '.$errorMessage);
        }
    }

    private function saveProfileToSession($user): void
    {
        $this->sessionUtils->save('id', $user->id);
        $this->sessionUtils->save('name', $user->name);
        $this->sessionUtils->save('email', $user->email);
        $this->sessionUtils->save('temp_role', $user->roles);
    }
}
