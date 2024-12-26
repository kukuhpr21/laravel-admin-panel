<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\ResponseUtils;
use App\Services\PermissionService;
use App\DataTables\MenuHasPermissionDataTable;
use App\DataTransferObjects\Mapping\MenuPermission\MenuPermissionDto;
use App\Http\Requests\StoreMappingMenuPermissionRequest;
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

        $dataMenu           = json_decode($menuResponse['data']);
        $dataPermission     = json_decode($permissionResponse['data']);

        $sizeMenu           = count($dataMenu);
        $sizePermission     = count($dataPermission);

        $menus              = $sizeMenu > 0 ? self::transformToSelect2($dataMenu) : $dataMenu;
        $permissions        = $sizePermission > 0 ? self::transformToSelect2($dataPermission) : $dataPermission;
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



    private function transformToSelect2($items)
    {
        $map  = ['id' => 'value', 'name' => 'text'];
        $data = [];

        if (count($items) > 0) {

            $transforms = ArrayUtils::transform( $items, $map);

            foreach ($transforms as $item) {
                array_push($data, $item);
            }
        }

        return $data;
    }
}
