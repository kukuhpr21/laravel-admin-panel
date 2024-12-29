<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\RoleMenu\RoleMenuDto;

interface MappingRoleMenuService
{
    public function findAllRoleNotMapped();
    public function findAllMenuByRole($roleID);
    public function store(RoleMenuDto $dto);
    public function update($roleID, RoleMenuDto $dto);
    public function delete($roleID);
}
