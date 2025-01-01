<?php

namespace App\Http\Controllers;

use App\Utils\ArrayUtils;
use App\Utils\CryptUtils;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use App\Services\UserService;
use App\Services\MappingUserMenuService;
use App\DataTables\UserHasMenusDataTable;
use App\Http\Requests\StoreMappingUserMenuRequest;
use App\Http\Requests\UpdateMappingUserMenuRequest;
use App\DataTransferObjects\Mapping\UserMenu\UserMenuDto;

class MappingUserMenuController extends Controller
{
    use ResponseUtils;
    use ArrayUtils;

    private MappingUserMenuService $mappingUserMenuService;
    private UserService $userService;
    private MenuService $menuService;

    public function __construct(
        MappingUserMenuService $mappingUserMenuService,
        UserService $userService,
        MenuService $menuService,
        ) {
        $this->mappingUserMenuService = $mappingUserMenuService;
        $this->userService = $userService;
        $this->menuService = $menuService;
    }

    public function index(UserHasMenusDataTable $dataTable)
    {
        return $dataTable->render('pages.app.mappings.usersmenus.list');
    }

    public function create()
    {
        $responses    = [];
        $userResponse = $this->mappingUserMenuService->findAllUserNotMapped();
        $menuResponse = $this->menuService->findAll();

        $dataUser = json_decode($userResponse['data']);
        $dataMenu = json_decode($menuResponse['data']);

        $sizeUser = count($dataUser);
        $sizeMenu = count($dataMenu);

        $map   = ['id' => 'value', 'name' => 'text'];
        $users = $sizeUser > 0 ? ArrayUtils::transformToSelect2($dataUser, $map) : $dataUser;
        $menus = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;

        if ($sizeUser == 0) {
            array_push($responses, $userResponse);
        }

        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.usersmenus.create',
        compact(
            'users',
            'menus',
            'sizeUser',
            'sizeMenu',
        ));
    }

    public function store(StoreMappingUserMenuRequest $request)
    {
        $response = $this->mappingUserMenuService->store(UserMenuDto::fromRequest($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('users-menus');
        }

        return redirect()->route('users-menus-add');
    }

    public function edit($user_id)
    {
        $userID       = CryptUtils::dec($user_id);
        $user         = $this->userService->findOne($userID);
        $response     = $this->mappingUserMenuService->findAllMenuByUser($userID);
        $menuResponse = $this->menuService->findAll();

        $menusSelected = json_decode($response['data']);
        $dataMenu      = json_decode($menuResponse['data']);

        $sizeMenu = count($dataMenu);

        $map   = ['id' => 'value', 'name' => 'text'];
        $menus = $sizeMenu > 0 ? ArrayUtils::transformToSelect2($dataMenu, $map) : $dataMenu;

        $responses = [];

        if ($sizeMenu == 0) {
            array_push($responses, $menuResponse);
        }

        $userName = '';

        if ($user['status'] == 'success') {
            $userName = json_decode($user['data'])->name;
        }

        ResponseUtils::showToasts($responses);

        return view('pages.app.mappings.usersmenus.edit', compact(
            'menus',
            'sizeMenu',
            'menusSelected',
            'userName',
            'user_id',
        ));
    }

    public function update($user_id, UpdateMappingUserMenuRequest $request)
    {
        $userID   = CryptUtils::dec($user_id);
        $response = $this->mappingUserMenuService->update($userID, UserMenuDto::fromRequestUpdate($request));
        ResponseUtils::showToast($response);

        if ($response['status'] == 'success') {
            return redirect()->route('users-menus');
        }
        return redirect()->route('users-menus-edit', ['user_id' => $user_id]);
    }

    public function delete($user_id)
    {
        $userID   = CryptUtils::dec($user_id);
        $response = $this->mappingUserMenuService->delete($userID);
        ResponseUtils::showToast($response);
        return redirect()->route('users-menus');
    }
}
