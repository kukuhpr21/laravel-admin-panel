<?php

namespace App\Services;

use App\DataTransferObjects\User\StoreUserDto;

interface UserService
{
    public function store(StoreUserDto $dto);
    public function findOne(string $id);

}
