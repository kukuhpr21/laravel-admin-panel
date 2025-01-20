<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\SessionUtils;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\StatusService;
use App\DataTables\UserDataTable;
use App\Http\Requests\StoreUserRequest;
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

    public function index(Request $request)
    {

        $statuses    = self::listFilterStatus();
        $roles       = self::listFilterRole();
        $status      = $request->post() && $request->has('status') && !empty($request->get('status')) ? $request->get('status') : 'all';
        $role        = $request->post() && $request->has('role') && !empty($request->get('role')) ? $request->get('role') : 'all';
        $createdAt   = $request->post() && $request->has('created_at') && !empty($request->get('created_at'))? $request->get('created_at') : '';

        $dataTable = new UserDataTable($status, $role, $createdAt);
        return $dataTable->render('pages.app.users.list', compact('status', 'statuses', 'role', 'roles', 'createdAt'));

    }

    public function create()
    {
        $roles        = self::listRoleAvailable();
        return view('pages.app.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {

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

    private function listRoleAvailable()
    {
        $sessionUtils = new SessionUtils();
        $map          = ['id' => 'value', 'name' => 'text'];
        $result       = [];
        $roleRaw        = $sessionUtils->get('role');
        $roleRaw        = json_decode($roleRaw, true)['list_role_available'];
        $roleRaw        = explode(',', $roleRaw);

        $roles = [];

        foreach ($roleRaw as $item) {
            array_push($roles, ['id' => $item, 'name' => ucwords(str_replace("_", " ", $item))]);
        }

        $data_transform = ArrayUtils::transformToSelect2($roles, $map);

        foreach ($data_transform as $item) {
            array_push($result, $item);
        }
        return $result;
    }
}
