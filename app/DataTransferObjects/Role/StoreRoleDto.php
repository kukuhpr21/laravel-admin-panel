<?php

namespace App\DataTransferObjects\Role;

use App\Http\Requests\StoreRoleRequest;

class StoreRoleDto
{
    public function __construct(
        public readonly string $name
    ) {
    }

    public static function fromRequest(StoreRoleRequest $request)
    {
        return new self(
            name: $request->validated('name'),
        );
    }
}
