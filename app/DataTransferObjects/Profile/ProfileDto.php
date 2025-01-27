<?php

namespace App\DataTransferObjects\Profile;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ChangeProfileRequest;

class ProfileDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $new_password,
        public readonly string $confirm_password,
    ) {
    }

    public static function fromRequestChangeProfile(ChangeProfileRequest $request, $id)
    {
        return new self(
            id: $id,
            name: $request->validated('name'),
            email: $request->validated('email'),
            new_password: '',
            confirm_password: '',
        );
    }

    public static function fromRequestChangePassword(ChangePasswordRequest $request, $id)
    {
        return new self(
            id: $id,
            name: '',
            email: '',
            new_password: $request->validated('new_password'),
            confirm_password: $request->validated('confirm_password'),
        );
    }
}
