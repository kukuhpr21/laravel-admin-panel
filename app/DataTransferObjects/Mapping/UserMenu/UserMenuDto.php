<?php

namespace App\DataTransferObjects\Mapping\UserMenu;

use App\Http\Requests\StoreMappingUserMenuRequest;
use App\Http\Requests\UpdateMappingUserMenuRequest;

class UserMenuDto
{
    public function __construct(
        public readonly string $user,
        public readonly string|array $menus,
    ) {
    }

    public static function fromRequest(StoreMappingUserMenuRequest $request)
    {
        return new self(
            user: $request->validated('user'),
            menus: $request->validated('menus'),
        );
    }

    public static function fromRequestUpdate(UpdateMappingUserMenuRequest $request)
    {
        return new self(
            user: '',
            menus: $request->validated('menus')
        );
    }
}
