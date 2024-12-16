<?php

namespace App\Http\Controllers;

use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use App\Services\PermissionService;
use App\DataTables\PermissionDataTable;
use App\Http\Requests\StorePermissionRequest;
use App\DataTransferObjects\Permission\StorePermissionDto;

class PermissionController extends Controller
{
    use ResponseUtils;

    private PermissionService $permissionService;

    public function __construct(PermissionService $permissionService) {
        $this->permissionService = $permissionService;
    }
    public function index(PermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.app.permissions.list');
    }

    public function create()
    {
        return view('pages.app.permissions.create');
    }

    public function store(StorePermissionRequest $request)
    {
        $response = $this->permissionService->store(StorePermissionDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('permissions');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->permissionService->findOne($id);
        $data     = json_decode($response['data']);
        $data->id = CryptUtils::enc($data->id);
        return view('pages.app.permissions.edit', compact('data'));
    }

    public function update($id, StorePermissionRequest $request)
    {
        $id       = CryptUtils::dec($id);
        $name     = StorePermissionDto::fromRequest($request)->name;
        $response = $this->permissionService->update($id, $name);
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('permissions');
        }
        return redirect()->back();
    }

    public function delete($id)
    {
        $id       = CryptUtils::dec($id);
        $response = $this->permissionService->delete($id);
        ResponseUtils::showToast($response);
        return redirect()->route('permissions');
    }
}
