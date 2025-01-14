<?php

namespace App\DataTransferObjects\Status;

use App\Http\Requests\StoreStatusRequest;

class StoreStatusDto
{
    public function __construct(
        public readonly string $name
    ) {
    }

    public static function fromRequest(StoreStatusRequest $request)
    {
        return new self(
            name: $request->validated('name'),
        );
    }
}
