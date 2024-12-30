<?php

namespace App\Services\Impl;

use Exception;
use App\Utils\ResponseUtils;
use Illuminate\Support\Facades\DB;
use App\Services\MappingUserRoleService;
use App\DataTransferObjects\Mapping\UserRole\UserRoleDto;
use App\Models\UserHasRole;

class MappingUserRoleServiceImpl implements MappingUserRoleService
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
                            ->from('user_has_roles as ur');
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

    public function findAllRoleByUser($userID)
    {
        try {
            $model = new UserHasRole();
            $userRole = $model->newQuery()->addSelect('roles.id', 'roles.name')
            ->leftJoin('roles', 'roles.id', '=', 'user_has_roles.role_id')
            ->where('user_id', $userID)
            ->get();

            if ($userRole) {
                return ResponseUtils::success(
                    message: 'Success find all user role',
                    data: $userRole,
                );
            }
            return ResponseUtils::failed(
                message: 'Failed find all user role',
                data: $userRole,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all user role : '.$errorMessage);
        }
    }

    public function store(UserRoleDto $dto)
    {
        try {
            $data = [];
            if (is_array($dto->roles)) {
                foreach ($dto->roles as $role) {
                    array_push($data, [
                        'user_id' => $dto->user,
                        'role_id' => $role,
                    ]);
                }
            } else {
                array_push($data, [
                    'user_id' => $dto->user,
                    'role_id' => $dto->roles,
                ]);
            }

            $result = UserHasRole::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success mapping user role',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed mapping user role',
                data: $result,
            );

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed store mapping user role : '.$errorMessage);
        }
    }

    public function update($userID, UserRoleDto $dto)
    {
        try {

            UserHasRole::where('user_id', $userID)->delete();

            $data = [];
            if (is_array($dto->roles)) {
                foreach ($dto->roles as $role) {
                    array_push($data, [
                        'user_id' => $userID,
                        'role_id' => $role,
                    ]);
                }
            } else {
                array_push($data, [
                    'user_id' => $userID,
                    'role_id' => $dto->roles,
                ]);
            }

            $result = UserHasRole::insert($data);

            if ($result) {
                return ResponseUtils::success(
                    message: 'Success update mapping user role',
                    data: $result,
                );
            }

            return ResponseUtils::failed(
                message: 'Failed update mapping user role',
                data: $result,
            );
        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update mapping user role : '.$errorMessage);
        }
    }

    public function delete($userID)
    {
        try {
            $result = UserHasRole::where('user_id', $userID)->delete();

            if ($result) {
                return ResponseUtils::success('Success delete mapping user role');
            }

            return ResponseUtils::warning('Failed delete mapping user role');

        } catch(Exception $e) {
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete mapping user role : '.$errorMessage);
        }
    }
}
