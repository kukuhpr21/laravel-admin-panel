<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Role;
use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\DataTransferObjects\Role\StoreRoleDto;
use App\Models\RoleHasMenuHasPermission;
use App\Models\UserHasRole;

class RoleServiceImpl implements RoleService
{
    use ResponseUtils;

    public function store(StoreRoleDto $dto)
    {
        try {
            $role = Role::create([
                'id' => self::getID($dto->name),
                'name' => $dto->name,
                'list_role_available' => implode(',', $dto->list_role_available),
            ]);

            if ($role) {
                return ResponseUtils::success(
                    message: 'Success create role',
                    data: $role
                );
            }

            return ResponseUtils::failed('Failed create role');

        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create role : '.$errorMessage);
        }

    }

    public function findAll()
    {
        try {
            $roles = Role::all();

            if ($roles) {
                return ResponseUtils::success('Role is exist', $roles);
            }

            return ResponseUtils::failed('Role not found');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all role : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find one role : '.$errorMessage);
        }
    }

    public function findRolesByUser(string $id)
    {
        try {
            $roles = UserHasRole::with('role')
                ->select('role_id')
                ->where('user_id', $id)
                ->get();
            if ($roles) {
                return ResponseUtils::success('Roles is exist', $roles);
            } else {
                return ResponseUtils::failed('Roles not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find roles by user : '.$errorMessage);
        }
    }

    public function update(string $id, string $newName, array $listRoleAvailable)
    {
        try {
            $newID = self::getID($newName);
            $listRoleAvailable = implode(',', $listRoleAvailable);
            $role = Role::where(['id' => $id, 'list_role_available' => $listRoleAvailable])->first();

            if (!$role) {
                if ($id == $newID) {
                    $result = Role::where('id', $newID)->update([
                        'name' => $newName,
                        'list_role_available' => $listRoleAvailable,
                    ]);

                    if ($result) {
                        return ResponseUtils::success('Success updating role', $result);
                    }
                    return ResponseUtils::failed('Failed updating role', "failed delete role in method update role");
                } else {

                    if ($this->roleIsNotUsed($id)) {

                        $oldRoleIsDeleted = Role::where('id', $id)->delete();

                        if ($oldRoleIsDeleted) {

                            $result = Role::create([
                                'id' => $newID,
                                'name' => $newName,
                                'list_role_available' => $listRoleAvailable,
                            ]);

                            if ($result) {
                                return ResponseUtils::success('Success updating role', $result);
                            }
                        }
                        return ResponseUtils::failed('Failed updating role', "failed delete role in method update role");
                    }
                    return ResponseUtils::warning('Role has been used');
                }
            }

            return ResponseUtils::warning('No data change');
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update role : '.$errorMessage);
        }
    }

    public function delete(string $id)
    {
        try {
            if ($this->roleIsNotUsed($id)) {
                $result = Role::where('id', $id)->delete();

                if ($result) {
                    return ResponseUtils::success( 'Success deleting role', $result);
                }
                return ResponseUtils::failed( 'Failed deleting role');
            }
            return ResponseUtils::warning('Role has been used');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete role : '.$errorMessage);
        }
    }
    private static function getID(string $name): string
    {
        return  strtolower(str_replace(" ", "_", $name));
    }

    private function roleIsNotUsed(string $roleID): bool
    {
        $roleHasMenuHasPermission = RoleHasMenuHasPermission::where('role_id', $roleID)->first();
        $userHasRole = UserHasRole::where('role_id', $roleID)->first();
        return !$roleHasMenuHasPermission && !$userHasRole;
    }
}
