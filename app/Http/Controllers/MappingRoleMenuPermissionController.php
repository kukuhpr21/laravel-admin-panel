<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\DataTables\RoleHasMenuHasPermissionDataTable;
use App\Http\Requests\StoreMappingRoleMenuPermissionRequest;
use App\Http\Requests\UpdateMappingRoleMenuPermissionRequest;

class MappingRoleMenuPermissionController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private RoleService $roleService;
    private MenuService $menuService;
    private PermissionService $permissionService;

    public function __construct(RoleService $roleService, MenuService $menuService, PermissionService $permissionService) {
        $this->roleService = $roleService;
        $this->menuService = $menuService;
        $this->permissionService = $permissionService;
    }

    public function index(RoleHasMenuHasPermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.app.mappings.rolesmenuspermissions.list');
    }

    public function create()
    {
        $responses          = [];
        $roleResponse       = $this->roleService->findAll();
        $menuResponse       = $this->menuService->findAll();
        $permissionResponse = $this->permissionService->findAll();

        $dataRole           = json_decode($roleResponse['data']);
        $dataMenu           = json_decode($menuResponse['data']);
        $dataPermission     = json_decode($permissionResponse['data']);

        $sizeRole           = count($dataRole);
        $sizeMenu           = count($dataMenu);
        $sizePermission     = count($dataPermission);

        $map                = ['id' => 'value', 'name' => 'text'];
        $roles              = $sizeRole > 0 ? ArrayUtils::transformToSelect2($dataRole, $map) : $dataRole;
        $menus              = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;
        $permissions        = $sizePermission > 0 ? ArrayUtils::transformToSelect2($dataPermission, $map) : $dataPermission;

        if ($sizeRole == 0) {
            array_push($responses, $roleResponse);
        }

        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        if ($sizePermission == 0) {
            array_push($responses, $permissionResponse);
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.rolesmenuspermissions.create',
        compact(
            'roles',
            'menus',
            'permissions',
            'sizeRole',
            'sizeMenu',
            'sizePermission',
        ));
    }

    public function store(StoreMappingRoleMenuPermissionRequest $request)
    {

    }

    public function edit($role_id, $menu_id)
    {

    }

    public function update($role_id, $menu_id, UpdateMappingRoleMenuPermissionRequest $request)
    {

    }

    public function delete($role_id, $menu_id)
    {

    }
}
