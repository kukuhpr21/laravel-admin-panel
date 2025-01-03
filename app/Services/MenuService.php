<?php

namespace App\Services;

use App\DataTransferObjects\Menu\MenuPostDto;

interface MenuService
{
    public function store(MenuPostDto $dto);
    public function findOne(int $id);
    public function findAll(bool $buildTree = false);
    public function findAllByUser(string $userID, bool $buildTree = true);
    public function findAllParent();
    public function delete(int $id);
    public function update(int $id, MenuPostDto $dto);
    public function makeHTMLMenu(array $menus): string;
}
