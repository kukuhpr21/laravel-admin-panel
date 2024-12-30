<?php

namespace App\DataTransferObjects\User;

use App\Http\Requests\StoreUserRequest;

class StoreUserDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $status_id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly string $created_at,
        public readonly string $updated_at,
    ) {
    }

    public static function fromRequest(StoreUserRequest $request)
    {
        return new self(
            id: '',
            status_id: $request->validated('status_id'),
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password'),
            created_at: '',
            updated_at: ''
        );
    }
}
