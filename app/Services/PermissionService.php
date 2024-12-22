<?php

namespace App\Services;

use App\DataTransferObjects\Permission\StorePermissionDto;

interface PermissionService
{
    public function store(StorePermissionDto $dto);
    public function findOne(string $id);
    public function findAll();
    public function update(string $id, string $newName);
    public function delete(string $id);
}
