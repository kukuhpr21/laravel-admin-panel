<?php

namespace App\DataTransferObjects\Role;

use App\Http\Requests\StoreRoleRequest;

class StoreRoleDto
{
    public function __construct(
        public readonly string $name,
        public readonly array $list_role_available
    ) {
    }

    public static function fromRequest(StoreRoleRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            list_role_available: $request->validated('list_role_available'),
        );
    }
}
