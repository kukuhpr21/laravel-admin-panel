<?php

namespace App\Services;

use App\DataTransferObjects\Role\StoreRoleDto;

interface RoleService
{
    public function store(StoreRoleDto $dto);
}
