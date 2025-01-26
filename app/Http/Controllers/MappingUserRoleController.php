<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\MappingUserRoleService;
use App\DataTables\UserHasRolesDataTable;
use App\Http\Requests\StoreMappingUserRoleRequest;
use App\DataTransferObjects\Mapping\UserRole\UserRoleDto;
use App\Http\Requests\UpdateMappingUserRoleRequest;

class MappingUserRoleController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingUserRoleService $mappingUserRoleService;
    private UserService $userService;
    private RoleService $roleService;

    public function __construct(
        MappingUserRoleService $mappingUserRoleService,
        UserService $userService,
        RoleService $roleService,
        ) {
        $this->mappingUserRoleService = $mappingUserRoleService;
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    public function index(UserHasRolesDataTable $dataTable)
    {
        return $dataTable->render('pages.app.settings.mappings.usersroles.list');
    }

    public function create()
    {
        $responses    = [];
        $userResponse = $this->mappingUserRoleService->findAllUserNotMapped();
        $roleResponse = $this->roleService->findAll();

        $dataUser = json_decode($userResponse['data']);
        $dataRole = json_decode($roleResponse['data']);

        $sizeUser = count($dataUser);
        $sizeRole = count($dataRole);

        $map   = ['id' => 'value', 'name' => 'text'];
        $users = $sizeUser > 0 ? ArrayUtils::transformToSelect2($dataUser, $map) : $dataUser;
        $roles = $sizeRole > 0 ? ArrayUtils::transformToSelect2($dataRole, $map) : $dataRole;

        if ($sizeUser == 0) {
            array_push($responses, $userResponse);
        }

        if ($sizeRole == 0) {
            array_push($responses, $roleResponse);
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.settings.mappings.usersroles.create',
        compact(
            'users',
            'roles',
            'sizeUser',
            'sizeRole',
        ));
    }

    public function store(StoreMappingUserRoleRequest $request)
    {
        $response = $this->mappingUserRoleService->store(UserRoleDto::fromRequest($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('users-roles');
        }

        return redirect()->route('users-roles-add');
    }

    public function edit($user_id)
    {
        $userID       = CryptUtils::dec($user_id);
        $user         = $this->userService->findOne($userID);

        if (!ResponseUtils::isSuccess($user)) {
            return abort(404);
        }

        $response     = $this->mappingUserRoleService->findAllRoleByUser($userID);
        $roleResponse = $this->roleService->findAll();

        $rolesSelected = json_decode($response['data']);
        $dataRole      = json_decode($roleResponse['data']);

        $sizeRole = count($dataRole);

        $map   = ['id' => 'value', 'name' => 'text'];
        $roles = $sizeRole > 0 ? ArrayUtils::transformToSelect2($dataRole, $map) : $dataRole;

        $responses = [];

        if ($sizeRole == 0) {
            array_push($responses, $roleResponse);
        }

        $userName = '';

        if ($user['status'] == 'success') {
            $userName = json_decode($user['data'])->name;
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.settings.mappings.usersroles.edit', compact(
            'roles',
            'sizeRole',
            'rolesSelected',
            'userName',
            'user_id',
        ));
    }

    public function update($user_id, UpdateMappingUserRoleRequest $request)
    {
        $userID   = CryptUtils::dec($user_id);
        $response = $this->mappingUserRoleService->update($userID, UserRoleDto::fromRequestUpdate($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('users-roles');
        }
        return redirect()->route('users-roles-edit', ['user_id' => $user_id]);
    }

    public function delete($user_id)
    {
        $userID   = CryptUtils::dec($user_id);
        $response = $this->mappingUserRoleService->delete($userID);
        ResponseUtils::showToast($response);
        return redirect()->route('users-roles');
    }
}
