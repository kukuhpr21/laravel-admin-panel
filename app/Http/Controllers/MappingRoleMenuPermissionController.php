<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use App\Services\RoleService;
use App\Services\PermissionService;
use App\Services\MappingRoleMenuPermissionService;
use App\DataTables\RoleHasMenuHasPermissionDataTable;
use App\Http\Requests\StoreMappingRoleMenuPermissionRequest;
use App\Http\Requests\UpdateMappingRoleMenuPermissionRequest;
use App\DataTransferObjects\Mapping\RoleMenuPermission\RoleMenuPermissionDto;

class MappingRoleMenuPermissionController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingRoleMenuPermissionService $mappingRoleMenuPermissionService;
    private RoleService $roleService;
    private MenuService $menuService;
    private PermissionService $permissionService;

    public function __construct(MappingRoleMenuPermissionService $mappingRoleMenuPermissionService, RoleService $roleService, MenuService $menuService, PermissionService $permissionService) {
        $this->mappingRoleMenuPermissionService = $mappingRoleMenuPermissionService;
        $this->roleService = $roleService;
        $this->menuService = $menuService;
        $this->permissionService = $permissionService;
    }

    public function index(RoleHasMenuHasPermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.app.settings.mappings.rolesmenuspermissions.list');
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

        return view('pages.app.settings.mappings.rolesmenuspermissions.create',
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
        $response = $this->mappingRoleMenuPermissionService->store(RoleMenuPermissionDto::fromRequest($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('roles-menus-permissions');
        }

        return redirect()->route('roles-menus-permissions-add');
    }

    public function edit($role_id, $menu_id)
    {
        $roleID             = CryptUtils::dec($role_id);
        $menuID             = CryptUtils::dec($menu_id);
        $role               = $this->roleService->findOne($roleID);
        $menu               = $this->menuService->findOne((int) $menuID);

        if (!ResponseUtils::isSuccess($role) && !ResponseUtils::isSuccess($menu)) {
            return abort(404);
        }

        $response           = $this->mappingRoleMenuPermissionService->findAllPermissionByRoleAndMenu($roleID, $menuID);
        $permissionResponse = $this->permissionService->findAll();

        $permissionsSelected = json_decode($response['data']);
        $dataPermission      = json_decode($permissionResponse['data']);

        $sizePermission     = count($dataPermission);

        $map                = ['id' => 'value', 'name' => 'text'];
        $permissions        = $sizePermission > 0 ? ArrayUtils::transformToSelect2($dataPermission, $map) : $dataPermission;

        $responses = [];

        if ($sizePermission == 0) {
            array_push($responses, $permissionResponse);
        }

        $roleName = '';

        if ($role['status'] == 'success') {
            $roleName = json_decode($role['data'])->name;
        }

        $menuName = '';

        if ($menu['status'] == 'success') {
            $menuName = json_decode($menu['data'])->name;
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.settings.mappings.rolesmenuspermissions.edit', compact(
            'permissions',
            'sizePermission',
            'permissionsSelected',
            'roleName',
            'menuName',
            'role_id',
            'menu_id',
        ));
    }

    public function update($role_id, $menu_id, UpdateMappingRoleMenuPermissionRequest $request)
    {
        $roleID   = CryptUtils::dec($role_id);
        $menuID   = CryptUtils::dec($menu_id);
        $response = $this->mappingRoleMenuPermissionService->update($roleID, $menuID, RoleMenuPermissionDto::fromRequestUpdate($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('roles-menus-permissions');
        }
        return redirect()->route('roles-menus-permissions-edit', ['role_id' => $role_id, 'menu_id' => $menu_id]);

    }

    public function delete($role_id, $menu_id)
    {
        $roleID   = CryptUtils::dec($role_id);
        $menuID   = CryptUtils::dec($menu_id);
        $response = $this->mappingRoleMenuPermissionService->delete($roleID, $menuID);
        ResponseUtils::showToast($response);
        return redirect()->route('roles-menus-permissions');
    }
}
