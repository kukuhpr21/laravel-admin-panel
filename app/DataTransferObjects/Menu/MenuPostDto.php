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
        $parent = $request->validated('parent');
        return new self(
            name: $request->validated('name'),
            link: $request->validated('link') && '#',
            linkAlias: $request->validated('link_alias') && '#',
            icon: $request->validated('icon') && '#',
            parent: $parent != '#' ? $parent : 0,
            order: $request->validated('order') && 0,
        );
    }
}
