<?php

namespace App\Services\Impl;

use App\Models\User;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Utils\SessionUtils;
use Illuminate\Support\Facades\Hash;

class AuthServiceImpl implements AuthService
{
    private SessionUtils $sessionUtils;

    public function __construct(SessionUtils $sessionUtils) {
        $this->sessionUtils = $sessionUtils;
    }
    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        // find user by email
        $user = User::with('roles')
                ->where('email', $data['email'])
                ->first();

        if ($user) {
            // checking password
            $passwordMatch = Hash::check($data['password'], $user->password);

            if ($passwordMatch) {
                // build tree menu
                // $menus = $this->menuService->allByUser($user->id);

                // $this->saveProfileToSession($user, $menus);
                return true;
            }
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
