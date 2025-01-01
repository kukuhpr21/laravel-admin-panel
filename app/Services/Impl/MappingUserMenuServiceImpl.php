<?php

namespace App\Services\Impl;

use Exception;
use App\Models\UserHasmenu;
use App\Utils\ResponseUtils;
use Illuminate\Support\Facades\DB;
use App\Services\MappingUserMenuService;
use App\DataTransferObjects\Mapping\userMenu\userMenuDto;

class MappingUserMenuServiceImpl implements MappingUserMenuService
{
    use ResponseUtils;

    public function findAllUserNotMapped()
    {
        try {
            $menus = DB::table('users as u')
                    ->select('u.id', 'u.name')
                    ->distinct()
                    ->whereNotIn('u.id', function ($query) {
                        $query->select('ur.user_id')
                            ->from('user_has_menus as ur');
                    })
                    ->get();
            if (count($menus) > 0) {
                return ResponseUtils::success(
                    message: 'Success find all user not mapped',
                    data: $menus,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all user not mapped',
                data: $menus,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all user not mapped : '.$errorMessage);
        }
    }

    public function findAllMenuByUser($userID)
    {
        try {
            $model = new UserHasMenu();
            $userMenu = $model->newQuery()->addSelect('menus.id', 'menus.name')
            ->leftJoin('menus', 'menus.id', '=', 'user_has_menus.menu_id')
            ->where('user_id', $userID)
            ->get();

            if ($userMenu) {
                return ResponseUtils::success(
                    message: 'Success find all user menu',
                    data: $userMenu,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all user menu',
                data: $userMenu,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all user menu : '.$errorMessage);
        }
    }

    public function store(UserMenuDto $dto)
    {
        try {
            $data = [];
            if (is_array($dto->menus)) {
                foreach ($dto->menus as $menu) {
                    array_push($data, [
                        'user_id' => $dto->user,
                        'menu_id' => $menu,
                    ]);
                }
            } else {
                array_push($data, [
                    'user_id' => $dto->user,
                    'menu_id' => $dto->menus,
                ]);
            }

            $result = UserHasmenu::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success mapping user menu',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed mapping user menu',
                data: $result,
            );

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed store mapping user menu : '.$errorMessage);
        }
    }

    public function update($userID, userMenuDto $dto)
    {
        try {

            UserHasmenu::where('user_id', $userID)->delete();

            $data = [];
            if (is_array($dto->menus)) {
                foreach ($dto->menus as $menu) {
                    array_push($data, [
                        'user_id' => $userID,
                        'menu_id' => $menu,
                    ]);
                }
            } else {
                array_push($data, [
                    'user_id' => $userID,
                    'menu_id' => $dto->menus,
                ]);
            }

            $result = UserHasmenu::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success update mapping user menu',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed update mapping user menu',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update mapping user menu : '.$errorMessage);
        }
    }

    public function delete($userID)
    {
        try {
            $result = UserHasmenu::where('user_id', $userID)->delete();

            if ($result) {
                return ResponseUtils::success('Success delete mapping user menu');
            }

            return ResponseUtils::warning('Failed delete mapping user menu');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete mapping user menu : '.$errorMessage);
        }
    }
}
