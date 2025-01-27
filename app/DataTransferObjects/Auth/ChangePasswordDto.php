<?php

namespace App\DataTransferObjects\Auth;

use App\Http\Requests\AuthChangePasswordRequest;

class ChangePasswordDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $new_password,
        public readonly string $confirm_password,
    ) {
    }

    public static function fromRequest(AuthChangePasswordRequest $request)
    {
        return new self(
            email: $request->validated('email'),
            new_password: $request->validated('new_password'),
            confirm_password: $request->validated('confirm_password'),
        );
    }
}
