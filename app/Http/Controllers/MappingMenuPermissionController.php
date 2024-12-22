<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\ResponseUtils;
use App\Services\PermissionService;
use App\DataTables\MenuHasPermissionDataTable;
use App\Services\MappingMenuPermissionService;

class MappingMenuPermissionController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingMenuPermissionService $mappingMenuPermissionService;
    private PermissionService $permissionService;

    public function __construct(
        MappingMenuPermissionService $mappingMenuPermissionService,
        PermissionService $permissionService
        ) {
        $this->mappingMenuPermissionService = $mappingMenuPermissionService;
        $this->permissionService = $permissionService;
    }

    public function index(MenuHasPermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.app.mappings.menuspermissions.list');
    }

    public function create()
    {
        $responses          = [];
        $menuResponse       = $this->mappingMenuPermissionService->findAllMenuNotMapped();
        $permissionResponse = $this->permissionService->findAll();
        $menus              = count(json_decode($menuResponse['data'])) > 0 ? self::getMenuSelect2($menuResponse) : json_decode($menuResponse['data']);
        $permissions        = count(json_decode( $permissionResponse['data'])) > 0 ? self::getPermissionSelect2($permissionResponse) : json_decode($permissionResponse['data']);

        array_push($responses, $menuResponse, $permissionResponse);

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.menuspermissions.create',
        compact(
            'menus',
            'permissions',
        ));
    }

    public function store()
    {

    }

    private function getMenuSelect2($menus)
    {
        $map  = ['id' => 'value', 'name' => 'text'];
        $data = [];
        $menus = json_decode($menus['data']);
        if (count($menus) > 0) {
            $transforms = ArrayUtils::transform($menus, $map);

            foreach ($transforms as $item) {
                array_push($data, $item);
            }
        }

        return $data;
    }

    private function getPermissionSelect2($permissions)
    {
        $map  = ['id' => 'value', 'name' => 'text'];
        $data = [];
        $permissions = json_decode($permissions['data']);

        if (count($permissions) > 0) {

            $transforms = ArrayUtils::transform( $permissions, $map);

            foreach ($transforms as $item) {
                array_push($data, $item);
            }
        }

        return $data;
    }
}
