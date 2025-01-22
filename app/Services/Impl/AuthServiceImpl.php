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
use App\Enum\StatusEnum;
use Illuminate\Support\Facades\DB;

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
                        'status_id' => StatusEnum::ACTIVE])
                    ->first();

            if ($user) {
                // checking password
                $passwordMatch = Hash::check($dto->password, $user->password);

                if ($passwordMatch) {
                    // build tree menu
                    $menus = $this->menuService->findAllByUser($user->id);

                    // get menu permission
                     $menuPermissions = $this->getMenuPermissionByUser($user->id);

                    if (ResponseUtils::isSuccess($menus)) {

                        $this->saveProfileToSession($user, $menus['data'], $menuPermissions);

                        return ResponseUtils::success('Login success');
                    }

                    return ResponseUtils::failed('Login failed', `Not yet prepare data for email $dto->email`);
                }

                return ResponseUtils::failed('Invalid email or password');

            }

            return ResponseUtils::failed('Invalid email or password');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed login : '.$errorMessage);
        }
    }

    private function saveProfileToSession($user, $menus, $menuPermissions): void
    {
        $this->sessionUtils->save('id', $user->id);
        $this->sessionUtils->save('name', $user->name);
        $this->sessionUtils->save('email', $user->email);
        $this->sessionUtils->save('temp_role', $user->roles);
        $this->sessionUtils->save('menus', json_encode($menus));
        $this->sessionUtils->save('menuPermissions', json_encode($menuPermissions));
    }

    private function getMenuPermissionByUser($useID)
    {
        $response = DB::table('user_has_roles')
                ->select('menus.link', DB::raw('GROUP_CONCAT(role_has_menu_has_permission.permission_id ORDER BY role_has_menu_has_permission.permission_id ASC) as permissions'))
                ->leftJoin('role_has_menu_has_permission', 'role_has_menu_has_permission.role_id', '=', 'user_has_roles.role_id')
                ->leftJoin('menus', 'menus.id', '=', 'role_has_menu_has_permission.menu_id')
                ->where('user_has_roles.user_id', $useID)
                ->where('menus.link', '!=', '#')
                ->groupBy('user_has_roles.user_id', 'role_has_menu_has_permission.role_id', 'role_has_menu_has_permission.menu_id')
                ->get()->toArray();

        $result = [];

        foreach ($response as $item) {
            $data['link'] = $item->link;
            $data['permissions'] = explode(',', $item->permissions);
            array_push($result, $data);
        }
        return $result;
    }
}
