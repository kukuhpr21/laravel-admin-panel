<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Role;
use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\DataTransferObjects\Role\StoreRoleDto;
use App\Models\RoleHasMenu;
use App\Models\UserHasRole;

class RoleServiceImpl implements RoleService
{
    use ResponseUtils;

    public function store(StoreRoleDto $dto)
    {
        try {
            $role = Role::create([
                'id' => self::getID($dto->name),
                'name' => $dto->name
            ]);

            if ($role) {
                return ResponseUtils::success(
                    message: 'Success create role',
                    data: $role
                );
            }

            return ResponseUtils::failed('Failed create role');

        } catch (Exception $e) {
            return ResponseUtils::internalServerError(`Failed create role : $e`);
        }

    }

    public function findOne(string $id)
    {
        try {
            $role = Role::where('id', $id)->first();

            if ($role) {
                return ResponseUtils::success('Role is exist', $role);
            } else {
                return ResponseUtils::failed('Role not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed find one role : $e`);
        }
    }

    public function update(string $id, string $newName)
    {
        try {
            $newID = self::getID($newName);
            $role = Role::where(
                'id',
                $newID
                )
                ->first();

            if (!$role) {
                if ($this->roleIsNotUsed($id)) {

                    $oldRoleIsDeleted = Role::where('id', $id)->delete();

                    if ($oldRoleIsDeleted) {

                        $result = Role::create([
                            'id' => $newID,
                            'name' => $newName
                        ]);

                        if ($result) {
                            return ResponseUtils::success('Success updating role', $result);
                        }
                    }
                    return ResponseUtils::failed('Failed updating role', "failed delete role in method update role");
                }
                return ResponseUtils::warning('Role has been used');
            }

            return ResponseUtils::warning('No data change');
        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed update role : $e`);
        }
    }

    private static function getID(string $name): string
    {
        return  strtolower(str_replace(" ", "_", $name));
    }

    private function roleIsNotUsed(string $roleID): bool
    {
        $roleHasMenu = RoleHasMenu::where('role_id', $roleID)->first();
        $userHasRole = UserHasRole::where('role_id', $roleID)->first();
        return !$roleHasMenu && !$userHasRole;
    }
}
