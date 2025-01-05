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

        $sessionUtils = new SessionUtils();
        $menuPermissions = $sessionUtils->get('menuPermissions');
        $menuPermissions = json_decode($menuPermissions);

        return !empty(array_filter($menuPermissions, function ($item) use ($link, $permission) {
            if ($item->link === $link) {
                return in_array($permission, $item->permissions);
            }
        }));
    }
}
