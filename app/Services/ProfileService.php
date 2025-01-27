<?php

namespace App\Services;

use App\DataTransferObjects\Profile\ProfileDto;

interface ProfileService
{
    public function changeProfile(ProfileDto $dto);
    public function changePassword(ProfileDto $dto);
}
