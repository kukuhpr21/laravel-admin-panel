<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\StatusService;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    use ArrayUtils;

    private StatusService $statusService;
    private RoleService $roleService;

    public function __construct(StatusService $statusService, RoleService $roleService) {
        $this->statusService = $statusService;
        $this->roleService = $roleService;
    }
    public function index(Request $request, UserDataTable $dataTable)
    {
        //Log::info('xxxx'.request()->role);
        $dataTable->ajax()->setData($request->all());
        // $dataTable->dataTable()->filter(function ($query) {
        //     if (request()->has('status') && request()->status != 'all') {

        //         $query->where('statuses.id', request()->status);
        //     }
        //     if (request()->has('role') && request()->status != 'all') {
        //         $query->where('roles.id', request()->role);
        //     }
        // });
        $statuses = self::listFilterStatus();
        $roles = self::listFilterRole();
        return $dataTable->render('pages.app.users.list', compact('statuses', 'roles'));
    }

    private function listFilterStatus()
    {
        $map = ['id' => 'value', 'name' => 'text'];
        $result = [];
        array_push($result, ['value' => 'all', 'text' => 'Semua Status']);
        $data_transform = ArrayUtils::transformToSelect2(json_decode($this->statusService->findAll()['data']), $map);

        foreach ($data_transform as $item) {
            array_push($result, $item);
        }
        return $result;
    }

    private function listFilterRole()
    {
        $map = ['id' => 'value', 'name' => 'text'];
        $result = [];
        array_push($result, ['value' => 'all', 'text' => 'Semua Role']);
        $data_transform = ArrayUtils::transformToSelect2(json_decode($this->roleService->findAll()['data']), $map);

        foreach ($data_transform as $item) {
            array_push($result, $item);
        }
        return $result;
    }
}
