<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\PermissionService;
use App\DataTables\MenuHasPermissionDataTable;
use App\Services\MappingMenuPermissionService;
use App\Http\Requests\StoreMappingMenuPermissionRequest;
use App\DataTransferObjects\Mapping\MenuPermission\MenuPermissionDto;
use App\Http\Requests\UpdateMappingMenuPermissionRequest;
use App\Services\MenuService;

class MappingMenuPermissionController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingMenuPermissionService $mappingMenuPermissionService;
    private PermissionService $permissionService;
    private MenuService $menuService;

    public function __construct(
        MappingMenuPermissionService $mappingMenuPermissionService,
        PermissionService $permissionService,
        MenuService $menuService,
        ) {
        $this->mappingMenuPermissionService = $mappingMenuPermissionService;
        $this->permissionService = $permissionService;
        $this->menuService = $menuService;
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

        $dataMenu           = json_decode($menuResponse['data']);
        $dataPermission     = json_decode($permissionResponse['data']);

        $sizeMenu           = count($dataMenu);
        $sizePermission     = count($dataPermission);

        $map                = ['id' => 'value', 'name' => 'text'];
        $menus              = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;
        $permissions        = $sizePermission > 0 ? ArrayUtils::transformToSelect2($dataPermission, $map) : $dataPermission;
        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        if ($sizePermission == 0) {
            array_push($responses, $permissionResponse);
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.menuspermissions.create',
        compact(
            'menus',
            'permissions',
            'sizeMenu',
            'sizePermission',
        ));
    }

    public function store(StoreMappingMenuPermissionRequest $request)
    {
        $response = $this->mappingMenuPermissionService->store(MenuPermissionDto::fromRequest($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('menus-permissions');
        }

        return redirect()->route('menus-permissions-add');
    }

    public function edit($menu_id)
    {
        $menuID             = CryptUtils::dec($menu_id);
        $menu               = $this->menuService->findOne((int) $menuID);
        $response           = $this->mappingMenuPermissionService->findAllPermissionByMenu($menuID);
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

        $menuName = '';

        if ($menu['status'] == 'success') {
            $menuName = json_decode($menu['data'])->name;
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.menuspermissions.edit', compact(
            'permissions',
            'sizePermission',
            'permissionsSelected',
            'menuName',
            'menu_id',
            'permissions',
        ));
    }

    public function update($menu_id, UpdateMappingMenuPermissionRequest $request)
    {
        $menuID   = CryptUtils::dec($menu_id);
        $response = $this->mappingMenuPermissionService->update($menuID, MenuPermissionDto::fromRequestUpdate($request));
        ResponseUtils::showToast($response);
        return redirect()->route('menus-permissions');
    }

}
