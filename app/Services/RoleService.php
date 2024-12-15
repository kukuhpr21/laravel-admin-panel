<?php

namespace App\Services;

use App\DataTransferObjects\Role\StoreRoleDto;

interface RoleService
{
    public function store(StoreRoleDto $dto);
    public function findOne(string $id);
    public function update(string $id, string $newName);
}
