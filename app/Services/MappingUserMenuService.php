<?php

namespace App\Services;

use App\DataTransferObjects\Mapping\UserMenu\UserMenuDto;

interface MappingUserMenuService
{
    public function findAllUserNotMapped();
    public function findAllMenuByUser($userID);
    public function store(UserMenuDto $dto);
    public function update($userID, UserMenuDto $dto);
    public function delete($userID);
}
