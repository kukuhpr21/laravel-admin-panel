<?php

namespace App\Http\Controllers;

use App\DataTables\RoleHasMenuDataTable;
use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use App\Services\RoleService;
use App\Services\MappingRoleMenuService;
use App\Http\Requests\StoreMappingRoleMenuRequest;
use App\Http\Requests\UpdateMappingRoleMenuRequest;
use App\DataTransferObjects\Mapping\RoleMenu\RoleMenuDto;

class MappingRoleMenuController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingRoleMenuService $mappingRoleMenuService;
    private RoleService $roleService;
    private MenuService $menuService;

    public function __construct(
        MappingRoleMenuService $mappingRoleMenuService,
        RoleService $roleService,
        MenuService $menuService,
        ) {
        $this->mappingRoleMenuService = $mappingRoleMenuService;
        $this->roleService = $roleService;
        $this->menuService = $menuService;
    }

    public function index(RoleHasMenuDataTable $dataTable)
    {
        return $dataTable->render('pages.app.mappings.rolesmenus.list');
    }

    public function create()
    {
        $responses    = [];
        $roleResponse = $this->mappingRoleMenuService->findAllRoleNotMapped();
        $menuResponse = $this->menuService->findAll();

        $dataRole = json_decode($roleResponse['data']);
        $dataMenu = json_decode($menuResponse['data']);

        $sizeRole = count($dataRole);
        $sizeMenu = count($dataMenu);

        $map   = ['id' => 'value', 'name' => 'text'];
        $roles = $sizeRole > 0 ? ArrayUtils::transformToSelect2($dataRole, $map) : $dataRole;
        $menus = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;
        if ($sizeRole == 0) {
            array_push($responses, $roleResponse);
        }

        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.rolesmenus.create',
        compact(
            'roles',
            'menus',
            'sizeRole',
            'sizeMenu',
        ));
    }

    public function store(StoreMappingRoleMenuRequest $request)
    {
        $response = $this->mappingRoleMenuService->store(RoleMenuDto::fromRequest($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('roles-menus');
        }

        return redirect()->route('roles-menus-add');
    }

    public function edit($role_id)
    {
        $roleID       = CryptUtils::dec($role_id);
        $role         = $this->roleService->findOne($roleID);
        $response     = $this->mappingRoleMenuService->findAllMenuByRole($roleID);
        $menuResponse = $this->menuService->findAll();

        $menusSelected = json_decode($response['data']);
        $dataMenu      = json_decode($menuResponse['data']);

        $sizeMenu = count($dataMenu);

        $map   = ['id' => 'value', 'name' => 'text'];
        $menus = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;

        $responses = [];

        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        $roleName = '';

        if ($role['status'] == 'success') {
            $roleName = json_decode($role['data'])->name;
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.rolesmenus.edit', compact(
            'menus',
            'sizeMenu',
            'menusSelected',
            'roleName',
            'role_id',
        ));
    }

    public function update($role_id, UpdateMappingRoleMenuRequest $request)
    {
        $roleID   = CryptUtils::dec($role_id);
        $response = $this->mappingRoleMenuService->update($roleID, RoleMenuDto::fromRequestUpdate($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('roles-menus');
        }
        return redirect()->route('roles-menus-edit', ['menu_id' => $role_id]);
    }

    public function delete($role_id)
    {
        $roleID   = CryptUtils::dec($role_id);
        $response = $this->mappingRoleMenuService->delete($roleID);
        ResponseUtils::showToast($response);
        return redirect()->route('roles-menus');
    }

}
