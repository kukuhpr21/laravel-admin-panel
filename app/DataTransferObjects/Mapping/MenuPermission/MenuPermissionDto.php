<?php

namespace App\DataTransferObjects\Mapping\MenuPermission;

use App\Http\Requests\StoreMappingMenuPermissionRequest;
use App\Http\Requests\UpdateMappingMenuPermissionRequest;

class MenuPermissionDto
{
    public function __construct(
        public readonly string $menu,
        public readonly string|array $permissions,
    ) {
    }

    public static function fromRequest(StoreMappingMenuPermissionRequest $request)
    {
        return new self(
            menu: $request->validated('menu'),
            permissions: $request->validated('permissions'),
        );
    }

    public static function fromRequestUpdate(UpdateMappingMenuPermissionRequest $request)
    {
        return new self(
            menu: '',
            permissions: $request->validated('permissions')
        );
    }
}
