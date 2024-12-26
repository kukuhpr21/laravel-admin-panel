<?php

namespace App\Services\Impl;

use Exception;
use App\Utils\ResponseUtils;
use Illuminate\Support\Facades\DB;
use App\Services\MappingMenuPermissionService;
use App\DataTransferObjects\Mapping\MenuPermission\MenuPermissionDto;
use App\Models\MenuHasPermission;

class MappingMenuPermissionServiceImpl implements MappingMenuPermissionService
{
    use ResponseUtils;

    public function findAllMenuNotMapped()
    {
        try {
            $menus = DB::table('menus as m')
                    ->select('m.id', 'm.name')
                    ->where('m.link', '!=', '#')
                    ->distinct()
                    ->whereNotIn('m.id', function ($query) {
                        $query->select('mp.menu_id')
                            ->from('menu_has_permissions as mp');
                    })
                    ->get();
            if (count($menus) > 0) {
                return ResponseUtils::success(
                    message: 'Success find all menu not mapped',
                    data: $menus,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all menu not mapped',
                data: $menus,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu not mapped : '.$errorMessage);
        }
    }

    public function findAllPermissionByMenu($menuID)
    {
        try {
            $model = new MenuHasPermission();
            $menuPermission = $model->newQuery()->addSelect('permissions.id', 'permissions.name')
            ->leftJoin('permissions', 'permissions.id', '=', 'menu_has_permissions.permission_id')
            ->where('menu_id', $menuID)
            ->get();

            if ($menuPermission) {
                return ResponseUtils::success(
                    message: 'Success find all menu permission',
                    data: $menuPermission,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all menu permission',
                data: $menuPermission,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu permission : '.$errorMessage);
        }
    }

    public function store(MenuPermissionDto $dto)
    {
        try {
            $data = [];
            if (is_array($dto->permissions)) {
                foreach ($dto->permissions as $permission) {
                    array_push($data, [
                        'menu_id' => $dto->menu,
                        'permission_id' => $permission,
                    ]);
                }
            } else {
                array_push($data, [
                    'menu_id' => $dto->menu,
                    'permission_id' => $dto->permissions,
                ]);
            }

            $result = MenuHasPermission::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success mapping menu permission',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed mapping menu permission',
                data: $result,
            );

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed store mapping menu permission : '.$errorMessage);
        }
    }

    public function update($menuID, MenuPermissionDto $dto)
    {
        try {

            MenuHasPermission::where('menu_id', $menuID)->delete();

            $data = [];
            if (is_array($dto->permissions)) {
                foreach ($dto->permissions as $permission) {
                    array_push($data, [
                        'menu_id' => $menuID,
                        'permission_id' => $permission,
                    ]);
                }
            } else {
                array_push($data, [
                    'menu_id' => $menuID,
                    'permission_id' => $dto->permissions,
                ]);
            }

            $result = MenuHasPermission::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success update mapping menu permission',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed update mapping menu permission',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update mapping menu permission : '.$errorMessage);
        }
    }
}
