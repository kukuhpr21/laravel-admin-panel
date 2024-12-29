<?php

namespace App\DataTransferObjects\Mapping\RoleMenu;

use App\Http\Requests\StoreMappingRoleMenuRequest;
use App\Http\Requests\UpdateMappingRoleMenuRequest;

class RoleMenuDto
{
    public function __construct(
        public readonly string $role,
        public readonly string|array $menus,
    ) {
    }

    public static function fromRequest(StoreMappingRoleMenuRequest $request)
    {
        return new self(
            role: $request->validated('role'),
            menus: $request->validated('menus'),
        );
    }

    public static function fromRequestUpdate(UpdateMappingRoleMenuRequest $request)
    {
        return new self(
            role: '',
            menus: $request->validated('menus')
        );
    }
}
