<?php

namespace App\DataTransferObjects\Mapping\RoleMenuPermission;

use App\Http\Requests\StoreMappingRoleMenuPermissionRequest;
use App\Http\Requests\UpdateMappingRoleMenuPermissionRequest;

class RoleMenuPermissionDto
{
    public function __construct(
        public readonly string $role,
        public readonly string $menu,
        public readonly string|array $permissions,
    ) {
    }

    public static function fromRequest(StoreMappingRoleMenuPermissionRequest $request)
    {
        return new self(
            role: $request->validated('role'),
            menu: $request->validated('menu'),
            permissions: $request->validated('permissions'),
        );
    }

    public static function fromRequestUpdate(UpdateMappingRoleMenuPermissionRequest $request)
    {
        return new self(
            role: '',
            menu: '',
            permissions: $request->validated('permissions')
        );
    }
}
