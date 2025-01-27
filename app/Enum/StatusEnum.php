<?php

namespace App\Enum;

enum StatusEnum: string
{
    case REGISTERED = 'registered';
    case CHANGED_PASSWORD = 'changed_password';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';
}
