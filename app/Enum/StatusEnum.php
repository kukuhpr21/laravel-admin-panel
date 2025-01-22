<?php

namespace App\Enum;

enum StatusEnum: string
{
    case REGISTERED = 'registered';
    case CHANGE_PASSWORD = 'changed_password';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';
}
