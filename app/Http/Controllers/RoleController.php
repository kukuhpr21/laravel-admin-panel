<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\DataTables\RolesDataTable;
use App\Http\Requests\StoreRoleRequest;
use App\DataTransferObjects\Role\StoreRoleDto;

class RoleController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private RoleService $roleService;

    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('pages.app.settings.roles.list');
    }

    public function create()
    {
        $roles = self::getRoles();
        return view('pages.app.settings.roles.create', compact('roles'));
    }

    public function store(StoreRoleRequest $request)
    {
        $response = $this->roleService->store(StoreRoleDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('roles');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $id                        = CryptUtils::dec($id);
        $response                  = $this->roleService->findOne($id);
        $data                      = json_decode($response['data']);
        $data->id                  = CryptUtils::enc($data->id);
        $data->list_role_available = self::transformListRoleAvailableToSelect2($data->list_role_available);
        $roles                     = self::getRoles();
        return view('pages.app.settings.roles.edit', compact('data', 'roles'));
    }

    public function update($id, StoreRoleRequest $request)
    {
        $id       = CryptUtils::dec($id);
        $request     = StoreRoleDto::fromRequest($request);
        $name     = $request->name;
        $listRoleAvailable = $request->list_role_available;
        $response = $this->roleService->update($id, $name, $listRoleAvailable);
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('roles');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->roleService->delete($id);
        ResponseUtils::showToast($response);
        return redirect()->route('roles');
    }

    private function getRoles()
    {
        $map            = ['id' => 'value', 'name' => 'text'];
        $allRole        = json_decode($this->roleService->findAll()['data']);
        $roles          = [];
        $role_transform = ArrayUtils::transform($allRole, $map);

        foreach ($role_transform as $item) {
            array_push($roles, $item);
        }
        return $roles;
    }

    private function transformListRoleAvailableToSelect2($listRoleAvailable)
    {
        $listRoleAvailable = explode(',', $listRoleAvailable);
        $roles = [];
        foreach ($listRoleAvailable as $item) {
            $data = ['id' => $item];
            array_push($roles, $data);
        }
        return json_decode(json_encode($roles));;
    }
}
