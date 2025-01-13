<?php

namespace App\Services\Impl;

use Exception;
use App\Utils\ResponseUtils;
use App\Models\RoleHasMenuHasPermission;
use App\Services\MappingRoleMenuPermissionService;
use App\DataTransferObjects\Mapping\RoleMenuPermission\RoleMenuPermissionDto;

class MappingRoleMenuPermissionServiceImpl implements MappingRoleMenuPermissionService
{
    use ResponseUtils;

    public function findAllPermissionByRoleAndMenu($roleID, $menuID)
    {
        try {
            $model = new RoleHasMenuHasPermission();
            $menuPermission = $model->newQuery()->addSelect('permissions.id', 'permissions.name')
            ->leftJoin('permissions', 'permissions.id', '=', 'role_has_menu_has_permission.permission_id')
            ->where([
                'role_id' => $roleID,
                'menu_id' => $menuID
                ])
            ->get();

            if ($menuPermission) {
                return ResponseUtils::success(
                    message: 'Success find all role menu permission',
                    data: $menuPermission,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all role menu permission',
                data: $menuPermission,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all role menu permission : '.$errorMessage);
        }
    }

    public function store(RoleMenuPermissionDto $dto)
    {
        try {

            $data = [];
            if (is_array($dto->permissions)) {
                foreach ($dto->permissions as $permission) {
                    array_push($data, [
                        'role_id'       => $dto->role,
                        'menu_id'       => $dto->menu,
                        'permission_id' => $permission,
                    ]);
                }
            } else {
                array_push($data, [
                    'role_id'       => $dto->role,
                    'menu_id'       => $dto->menu,
                    'permission_id' => $dto->permissions,
                ]);
            }

            $result = RoleHasMenuHasPermission::insertOrIgnore($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success mapping role menu permission',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed mapping role menu permission',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed store mapping role menu permission : '.$errorMessage);
        }
    }

    public function update($roleID, $menuID, RoleMenuPermissionDto $dto)
    {
        try {

            RoleHasMenuHasPermission::where([
                'role_id' => $roleID,
                'menu_id' => $menuID
                ])->delete();

            $data = [];
            if (is_array($dto->permissions)) {
                foreach ($dto->permissions as $permission) {
                    array_push($data, [
                        'role_id'       => $roleID,
                        'menu_id'       => $menuID,
                        'permission_id' => $permission,
                    ]);
                }
            } else {
                array_push($data, [
                    'role_id'       => $roleID,
                    'menu_id'       => $menuID,
                    'permission_id' => $dto->permissions,
                ]);
            }

            $result = RoleHasMenuHasPermission::insertOrIgnore($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success update mapping role menu permission',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed update mapping role menu permission',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update mapping role menu permission : '.$errorMessage);
        }
    }

    public function delete($roleID, $menuID)
    {
        try {
            $result = RoleHasMenuHasPermission::where([
                'role_id' => $roleID,
                'menu_id' => $menuID
                ])->delete();

            if ($result) {
                return ResponseUtils::success('Success delete mapping role menu permission');
            }

            return ResponseUtils::warning('Failed delete mapping role menu permission');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete mapping role menu permission : '.$errorMessage);
        }
    }
}
