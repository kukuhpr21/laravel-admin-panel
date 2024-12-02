<?php

namespace App\DataTransferObjects\Auth;

use App\Http\Requests\LoginRequest;

class LoginPostDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }

    public static function fromRequest(LoginRequest $request)
    {
        return new self(
            email: $request->validated('email'),
            password: $request->validated('password'),
        );
    }
}
