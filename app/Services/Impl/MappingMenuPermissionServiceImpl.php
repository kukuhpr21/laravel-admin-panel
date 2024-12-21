<?php

namespace App\Services\Impl;

use Exception;
use App\Utils\ResponseUtils;
use Illuminate\Support\Facades\DB;
use App\Services\MappingMenuPermissionService;

class MappingMenuPermissionServiceImpl implements MappingMenuPermissionService
{
    use ResponseUtils;

    public function findAllMenuNotMapped()
    {
        try {
            $menus = DB::table('menu as m')
                    ->select('m.id', 'm.name')
                    ->where('m.link', '!=', '#')
                    ->distinct()
                    ->whereNotIn('m.id', function ($query) {
                        $query->select('mp.menu_id')
                            ->from('menu_has_permissions as mp');
                    })
                    ->get();
            if ($menus) {
                return ResponseUtils::success(
                    message: 'Success find all menu not mapped',
                    data: $menus,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all menu not mapped',
                data: $menus,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu not mapped : '.$errorMessage);
        }
    }
}
