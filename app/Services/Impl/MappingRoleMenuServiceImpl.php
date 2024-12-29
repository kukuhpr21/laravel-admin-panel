<?php

namespace App\Services\Impl;

use Exception;
use App\Models\RoleHasMenu;
use App\Utils\ResponseUtils;
use Illuminate\Support\Facades\DB;
use App\Services\MappingRoleMenuService;
use App\DataTransferObjects\Mapping\RoleMenu\RoleMenuDto;

class MappingRoleMenuServiceImpl implements MappingRoleMenuService
{
    use ResponseUtils;

    public function findAllRoleNotMapped()
    {
        try {
            $menus = DB::table('roles as r')
                    ->select('r.id', 'r.name')
                    ->distinct()
                    ->whereNotIn('r.id', function ($query) {
                        $query->select('rm.role_id')
                            ->from('role_has_menus as rm');
                    })
                    ->get();
            if (count($menus) > 0) {
                return ResponseUtils::success(
                    message: 'Success find all role not mapped',
                    data: $menus,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all role not mapped',
                data: $menus,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all role not mapped : '.$errorMessage);
        }
    }

    public function findAllMenuByRole($roleID)
    {
        try {
            $model = new RoleHasMenu();
            $roleMenu = $model->newQuery()->addSelect('menus.id', 'menus.name')
            ->leftJoin('menus', 'menus.id', '=', 'role_has_menus.menu_id')
            ->where('role_id', $roleID)
            ->get();

            if ($roleMenu) {
                return ResponseUtils::success(
                    message: 'Success find all role menu',
                    data: $roleMenu,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all role menu',
                data: $roleMenu,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all role menu : '.$errorMessage);
        }
    }

    public function store(RoleMenuDto $dto)
    {
        try {
            $data = [];
            if (is_array($dto->menus)) {
                foreach ($dto->menus as $menu) {
                    array_push($data, [
                        'role_id' => $dto->role,
                        'menu_id' => $menu,
                    ]);
                }
            } else {
                array_push($data, [
                    'role_id' => $dto->role,
                    'menu_id' => $dto->menus,
                ]);
            }

            $result = RoleHasMenu::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success mapping role menu',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed mapping role menu',
                data: $result,
            );

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed store mapping role menu : '.$errorMessage);
        }
    }

    public function update($roleID, RoleMenuDto $dto)
    {
        try {

            RoleHasMenu::where('role_id', $roleID)->delete();

            $data = [];
            if (is_array($dto->menus)) {
                foreach ($dto->menus as $menu) {
                    array_push($data, [
                        'role_id' => $roleID,
                        'menu_id' => $menu,
                    ]);
                }
            } else {
                array_push($data, [
                    'role_id' => $roleID,
                    'menu_id' => $dto->menus,
                ]);
            }

            $result = RoleHasMenu::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success update mapping role menu',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed update mapping role menu',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update mapping role menu : '.$errorMessage);
        }
    }

    public function delete($roleID)
    {
        try {
            $result = RoleHasMenu::where('role_id', $roleID)->delete();

            if ($result) {
                return ResponseUtils::success('Success delete mapping role menu');
            }

            return ResponseUtils::warning('Failed delete mapping role menu');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete mapping role menu : '.$errorMessage);
        }
    }
}
