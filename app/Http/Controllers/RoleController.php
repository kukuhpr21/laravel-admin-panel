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
        $id       = CryptUtils::dec($id);
        $response = $this->roleService->findOne($id);
        $data     = json_decode($response['data']);
        $data->id = CryptUtils::enc($data->id);
        $roles    = self::getRoles();
        return view('pages.app.settings.roles.edit', compact('data', 'roles'));
    }

    public function update($id, StoreRoleRequest $request)
    {
        $id       = CryptUtils::dec($id);
        $name     = StoreRoleDto::fromRequest($request)->name;
        $response = $this->roleService->update($id, $name);
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
}
