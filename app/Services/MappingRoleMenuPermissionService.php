<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\RoleMenuPermission\RoleMenuPermissionDto;

interface MappingRoleMenuPermissionService
{
    public function findAllPermissionByRoleAndMenu($roleID, $menuID);
    public function store(RoleMenuPermissionDto $dto);
    public function update($roleID, $menuID, RoleMenuPermissionDto $dto);
    public function delete($roleID, $menuID);
}
