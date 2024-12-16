<?php

namespace App\DataTransferObjects\Permission;

use App\Http\Requests\StorePermissionRequest;

class StorePermissionDto
{
    public function __construct(
        public readonly string $name
    ) {
    }

    public static function fromRequest(StorePermissionRequest $request)
    {
        return new self(
            name: $request->validated('name'),
        );
    }
}
