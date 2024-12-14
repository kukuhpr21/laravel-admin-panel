<?php

namespace App\Http\Controllers;

use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\DataTables\RolesDataTable;
use App\Http\Requests\StoreRoleRequest;
use App\DataTransferObjects\Role\StoreRoleDto;

class RoleController extends Controller
{
    use ResponseUtils;

    private RoleService $roleService;

    public function __construct(RoleService $roleService) {
        $this->roleService = $roleService;
    }
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('pages.app.roles.list');
    }

    public function create()
    {
        return view('pages.app.roles.create');
    }

    public function store(StoreRoleRequest $request)
    {
        $response = $this->roleService->store(StoreRoleDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('roles');
        }
    }
}
