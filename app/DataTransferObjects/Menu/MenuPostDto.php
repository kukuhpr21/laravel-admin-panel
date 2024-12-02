<?php

namespace App\DataTransferObjects\Menu;

use App\Http\Requests\MenuPostRequest;

class MenuPostDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $link,
        public readonly string $linkAlias,
        public readonly string $icon,
        public readonly int $parent,
        public readonly int $order,
    ) {
    }

    public static function fromRequest(MenuPostRequest $request)
    {
        return new self(
            name: $request->validated('name'),
            link: $request->validated('name'),
            linkAlias: $request->validated('name'),
            icon: $request->validated('name'),
            parent: $request->validated('name'),
            order: $request->validated('name'),
        );
    }
}
