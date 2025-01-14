<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Permission;
use App\Utils\ResponseUtils;
use App\Services\PermissionService;
use App\Models\RoleHasMenuHasPermission;
use App\DataTransferObjects\Permission\StorePermissionDto;

class PermissionServiceImpl implements PermissionService
{
    use ResponseUtils;

    public function store(StorePermissionDto $dto)
    {
        try {
            $permission = Permission::create([
                'id' => self::getID($dto->name),
                'name' => $dto->name
            ]);

            if ($permission) {
                return ResponseUtils::success(
                    message: 'Success create permission',
                    data: $permission
                );
            }

            return ResponseUtils::failed('Failed create permission');

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create permission : '.$errorMessage);
        }

    }

    public function findOne(string $id)
    {
        try {
            $permission = Permission::where('id', $id)->first();

            if ($permission) {
                return ResponseUtils::success('permission is exist', $permission);
            } else {
                return ResponseUtils::failed('permission not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find one permission : '.$errorMessage);
        }
    }

    public function findAll()
    {
        try {
            $permission = Permission::all();

            if (count($permission) > 0) {
                return ResponseUtils::success('permission is exist', $permission);
            } else {
                return ResponseUtils::failed('permission not found');
            }
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all permission : '.$errorMessage);
        }
    }

    public function update(string $id, string $newName)
    {
        try {
            $newID = self::getID($newName);
            $permission = permission::where(
                'id',
                $newID
                )
                ->first();

            if (!$permission) {
                if ($this->permissionIsNotUsed($id)) {

                    $oldpermissionIsDeleted = permission::where('id', $id)->delete();

                    if ($oldpermissionIsDeleted) {

                        $result = permission::create([
                            'id' => $newID,
                            'name' => $newName
                        ]);

                        if ($result) {
                            return ResponseUtils::success('Success updating permission', $result);
                        }
                    }
                    return ResponseUtils::failed('Failed updating permission', "failed delete permission in method update permission");
                }
                return ResponseUtils::warning('Permission has been used');
            }

            return ResponseUtils::warning('No data change');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update permission : '.$errorMessage);
        }
    }

    public function delete(string $id)
    {
        try {
            if ($this->permissionIsNotUsed($id)) {
                $result = permission::where('id', $id)->delete();

                if ($result) {
                    return ResponseUtils::success( 'Success deleting permission', $result);
                }
                return ResponseUtils::failed( 'Failed deleting permission');
            }
            return ResponseUtils::warning('Permission has been used');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete permission : '.$errorMessage);
        }
    }
    private static function getID(string $name): string
    {
        return  strtolower(str_replace(" ", "_", $name));
    }

    private function permissionIsNotUsed(string $permissionID): bool
    {
        $data = RoleHasMenuHasPermission::where('permission_id', $permissionID)->first();
        return !$data;
    }
}
