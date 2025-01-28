<?php

namespace App\Utils;

use Illuminate\Support\Facades\DB;

class PermissionCheckUtils
{
    public static function execute(string $value)
    {
        $splitValue = explode('.', $value);
        $sizeValue  = count($splitValue);

        if ($sizeValue != 2) {
            return false;
        }

        $link            = $splitValue[0];
        $permission      = $splitValue[1];
        $menuPermissions = self::getMenusPermissions();

        return !empty(array_filter($menuPermissions, function ($item) use ($link, $permission) {
            if (str_starts_with($link, $item['link'])) {
                return in_array($permission, $item['permissions']);
            }
        }));
    }

    private static function getMenusPermissions()
    {
        $sessionUtils    = new SessionUtils();
        $userID          = $sessionUtils->get('id');
        $role            = json_decode(CacheUtils::get('role', [$userID]))->id;
        $menuPermissions = CacheUtils::get('menuPermissions', [$role]);

        if (!$menuPermissions) {
            $menuPermissions = self::getMenuPermissionByUser($userID);
            CacheUtils::put('menuPermissions', [$role], $menuPermissions);
        }

        return $menuPermissions;
    }

    private static function getMenuPermissionByUser($userID)
    {
        $response = DB::table('user_has_roles')
                ->select('menus.link', DB::raw('GROUP_CONCAT(role_has_menu_has_permission.permission_id ORDER BY role_has_menu_has_permission.permission_id ASC) as permissions'))
                ->leftJoin('role_has_menu_has_permission', 'role_has_menu_has_permission.role_id', '=', 'user_has_roles.role_id')
                ->leftJoin('menus', 'menus.id', '=', 'role_has_menu_has_permission.menu_id')
                ->where('user_has_roles.user_id', $userID)
                ->where('menus.link', '!=', '#')
                ->groupBy('user_has_roles.user_id', 'role_has_menu_has_permission.role_id', 'role_has_menu_has_permission.menu_id')
                ->get()->toArray();

        $result = [];

        foreach ($response as $item) {
            $data['link'] = $item->link;
            $data['permissions'] = explode(',', $item->permissions);
            array_push($result, $data);
        }
        return $result;
    }
}
