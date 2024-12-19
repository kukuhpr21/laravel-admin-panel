<?php

namespace App\Services\Impl;

use Exception;
use App\Models\User;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use App\Services\AuthService;
use App\Services\MenuService;
use Illuminate\Support\Facades\Hash;
use App\DataTransferObjects\Auth\LoginPostDto;

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
                    ->where('email', $dto->email)
                    ->first();

            if ($user) {
                // checking password
                $passwordMatch = Hash::check($dto->password, $user->password);

                if ($passwordMatch) {
                    // build tree menu
                    $menus = $this->menuService->findAllByUser((int)$user->id);

                    if (ResponseUtils::isSuccess($menus)) {

                        $this->saveProfileToSession($user, $menus['data']);

                        return ResponseUtils::success('Login success');
                    }

                    return ResponseUtils::failed('Login failed', `Not yet prepare data for email $dto->email`);
                }

                return ResponseUtils::failed('Invalid email or password');

            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed login : '.$errorMessage);
        }
    }

    private function saveProfileToSession($user, $menus): void
    {
        $this->sessionUtils->save('id', $user->id);
        $this->sessionUtils->save('name', $user->name);
        $this->sessionUtils->save('email', $user->email);
        $this->sessionUtils->save('temp_role', $user->roles);
        $this->sessionUtils->save('menus', json_encode($menus));
    }
}
