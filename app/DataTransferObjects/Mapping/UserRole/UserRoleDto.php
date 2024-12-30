<?php

namespace App\DataTransferObjects\Mapping\UserRole;

use App\Http\Requests\StoreMappingUserRoleRequest;
use App\Http\Requests\UpdateMappingUserRoleRequest;

class UserRoleDto
{
    public function __construct(
        public readonly string $user,
        public readonly string|array $roles,
    ) {
    }

    public static function fromRequest(StoreMappingUserRoleRequest $request)
    {
        return new self(
            user: $request->validated('user'),
            roles: $request->validated('roles'),
        );
    }

    public static function fromRequestUpdate(UpdateMappingUserRoleRequest $request)
    {
        return new self(
            user: '',
            roles: $request->validated('roles')
        );
    }
}
