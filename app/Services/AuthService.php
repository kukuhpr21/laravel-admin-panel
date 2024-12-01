<?php

namespace App\Services;

use App\Http\Requests\LoginRequest;

interface AuthService
{
    public function login(LoginRequest $request);
}
