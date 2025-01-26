<?php

namespace App\Utils;

class PermissionCheckUtils
{
    public static function execute(string $value)
    {
        $splitValue = explode('.', $value);
        $sizeValue  = count($splitValue);

        if ($sizeValue != 2) {
            return false;
        }

        $link       = $splitValue[0];
        $permission = $splitValue[1];

        $sessionUtils    = new SessionUtils();
        $userID          = $sessionUtils->get('id');
        $menuPermissions = CacheUtils::get('menuPermissions', $userID);
        $menuPermissions = json_decode($menuPermissions);

        return !empty(array_filter($menuPermissions, function ($item) use ($link, $permission) {
            if (str_starts_with($link, $item->link)) {
                return in_array($permission, $item->permissions);
            }
        }));
    }
}
