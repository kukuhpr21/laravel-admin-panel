<?php

namespace App\Services;

use App\DataTransferObjects\Status\StoreStatusDto;

interface StatusService
{
    public function store(StoreStatusDto $dto);
    public function findAll();
    public function findOne(string $id);
    public function update(string $id, string $newName);
    public function delete(string $id);
}
