<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Role;
use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\DataTransferObjects\Role\StoreRoleDto;

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

    private static function getID(string $name): string
    {
        return  strtolower(str_replace(" ", "_", $name));
    }
}
