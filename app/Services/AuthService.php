<?php

namespace App\Services;

use App\DataTransferObjects\Auth\LoginPostDto;

interface AuthService
{
    public function login(LoginPostDto $dto);
}
