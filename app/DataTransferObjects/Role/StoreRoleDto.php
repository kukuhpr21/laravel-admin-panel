<?php

namespace App\DataTransferObjects\Role;

use App\Http\Requests\StoreRoleRequest;

class StoreRoleDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $list_role_availabel
    ) {
    }

    public static function fromRequest(StoreRoleRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            list_role_availabel: $request->validated('list_role_availabel'),
        );
    }
}
