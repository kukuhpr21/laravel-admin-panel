<?php

namespace App\Services;

use App\DataTransferObjects\User\UserDto;

interface UserService
{
    public function store(UserDto $dto);
    public function update(UserDto $dto);
    public function changeStatus(UserDto $dto);
    public function findOne(string $id);

}
