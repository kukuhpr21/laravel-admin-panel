<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\MenuPermission\MenuPermissionDto;

interface MappingMenuPermissionService
{
    public function findAllMenuNotMapped();
    public function store(MenuPermissionDto $dto);
}
