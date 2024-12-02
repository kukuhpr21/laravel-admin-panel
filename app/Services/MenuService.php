<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use App\DataTransferObjects\Menu\MenuPostDto;

interface MenuService
{
    public function store(MenuPostDto $dto): JsonResponse;
    public function findOne(int $id): JsonResponse;
    public function findAll(): JsonResponse;
    public function findAllByUser(int $userID, bool $buildTree = true): JsonResponse;
    public function findAllParent(): JsonResponse;
    public function delete(int $id): JsonResponse;
    public function update(int $id, MenuPostDto $dto): JsonResponse;
}
