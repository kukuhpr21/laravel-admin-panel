<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\MenuPermission\MenuPermissionDto;

interface MappingMenuPermissionService
{
    public function findAllMenuNotMapped();
    public function findAllPermissionByMenu($menuID);
    public function store(MenuPermissionDto $dto);
    public function update($menuID, MenuPermissionDto $dto);
    public function delete($menuID);
}
