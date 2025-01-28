<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CacheUtils;
use App\Utils\CryptUtils;
use App\Utils\SessionUtils;
use App\Utils\ResponseUtils;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\StatusService;
use App\DataTables\UserDataTable;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\DataTransferObjects\User\UserDto;
use App\Http\Requests\UpdateStatusUserRequest;

class UserController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private UserService $userService;
    private StatusService $statusService;
    private RoleService $roleService;
    private SessionUtils $sessionUtils;

    public function __construct(UserService $userService, StatusService $statusService, RoleService $roleService) {
        $this->userService = $userService;
        $this->statusService = $statusService;
        $this->roleService = $roleService;
        $this->sessionUtils = new SessionUtils();
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
        $roles = self::listRoleAvailable();
        return view('pages.app.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $response = $this->userService->store(UserDto::fromRequest($request));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('users');
        }
        return redirect()->back();
    }

    public function edit($id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $response  = $this->userService->findOne($idDecrypt);

        if (!ResponseUtils::isSuccess($response)) {
            return abort(404);
        }

        $data          = json_decode($response['data']);
        $data->id      = CryptUtils::enc($data->id);
        $rolesSelected = $this->getRoleSelected($idDecrypt);
        $roles         = self::listRoleAvailable();

        return view('pages.app.users.edit', compact(
            'data',
            'rolesSelected',
            'roles'));
    }

    public function update(UpdateUserRequest $request, $id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $response  = $this->userService->findOne($idDecrypt);
        if (!ResponseUtils::isSuccess($response)) {
            return abort(404);
        }

        $data     = json_decode($response['data']);
        $response = $this->userService->update(UserDto::fromRequestUpdate($request, $idDecrypt, $data->status_id));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('users');
        }
        return redirect()->back();
    }

    public function changeStatus($id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $response  = $this->userService->findOne($idDecrypt);

        if (!ResponseUtils::isSuccess($response)) {
            return abort(404);
        }

        $data     = json_decode($response['data']);
        $data->id = CryptUtils::enc($data->id);
        $statuses = self::listFilterStatus();
        return view('pages.app.users.change-status', compact(
            'data',
            'statuses'
        ));
    }

    public function doChangeStatus(UpdateStatusUserRequest $request, $id)
    {
        $idDecrypt = CryptUtils::dec($id);
        $response  = $this->userService->findOne($idDecrypt);

        if (!ResponseUtils::isSuccess($response)) {
            return abort(404);
        }

        $data     = json_decode($response['data']);
        $response = $this->userService->changeStatus(UserDto::fromRequestChangeStatus($request, $data->id));
        ResponseUtils::showToast($response);
        if (ResponseUtils::isSuccess($response)) {
            return redirect()->route('users');
        }
        return redirect()->back();
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
        $map    = ['id' => 'value', 'name' => 'text'];
        $result = [];

        $cacheRole         = json_decode(CacheUtils::get('role', $this->sessionUtils->get('id')));
        $listRoleAvailable = explode(',', $cacheRole->list_role_available);
        $roles             = [];

        foreach ($listRoleAvailable as $item) {
            $name = explode("_", $item);
            $name = implode(' ', $name);
            $name = ucwords($name);
            array_push($roles, ['id' => $item, 'name' => $name]);
        }

        array_push($result, ['value' => 'all', 'text' => 'Semua Role']);

        $data_transform = ArrayUtils::transformToSelect2($roles, $map);

        foreach ($data_transform as $item) {
            array_push($result, $item);
        }
        return $result;
    }

    private function listRoleAvailable()
    {
        $sessionUtils = new SessionUtils();
        $userID       = $sessionUtils->get('id');
        $cacheRole    = CacheUtils::get('role',$userID);
        $map          = ['id' => 'value', 'name' => 'text'];
        $result       = [];
        $roleRaw      = $cacheRole ?? $sessionUtils->get('role');
        $roleRaw      = json_decode($roleRaw, true)['list_role_available'];
        $roleRaw      = explode(',', $roleRaw);

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

    private function getRoleSelected($userID)
    {
        $roles = json_decode($this->roleService->findRolesByUser($userID)['data']);
        $result = [];

        foreach ($roles as $item) {
            array_push($result, json_decode(json_encode(['id' => $item->role_id])));
        }
        return $result;
    }
}
