<?php

namespace App\DataTransferObjects\Mapping\MenuPermission;

use App\Http\Requests\StoreMappingMenuPermissionRequest;

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
}
