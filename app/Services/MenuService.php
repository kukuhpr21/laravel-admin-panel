<?php

namespace App\Services;

use App\DataTransferObjects\Menu\MenuCreateDto;

interface MenuService
{
    public function store(MenuCreateDto $dto);
}
