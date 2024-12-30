<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\UserRole\UserRoleDto;

interface MappingUserRoleService
{
    public function findAllUserNotMapped();
    public function findAllRoleByUser($userID);
    public function store(UserRoleDto $dto);
    public function update($userID, UserRoleDto $dto);
    public function delete($userID);
}
