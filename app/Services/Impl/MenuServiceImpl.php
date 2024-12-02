<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Menu;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\DataTransferObjects\Menu\MenuPostDto;

class MenuServiceImpl implements MenuService
{
    use ResponseUtils;

    public function store(MenuPostDto $dto): JsonResponse
    {
        try {
            $menu = Menu::create([
                'name'       => $dto->name,
                'link'       => !empty($dto->link) ? $dto->link : '#',
                'link_alias' => !empty($dto->linkAlias) ? $dto->linkAlias : '#',
                'icon'       => !empty($dto->icon) ? $dto->icon : '#',
                'parent'     => $dto->parent != '#' ? $dto->parent : 0,
                'order'      => $dto->order,
            ]);

            return Response::json(
                ResponseUtils::compose(
                    status: 'success',
                    message: 'Success create menu',
                    data: $menu,
                ),
                200
            );
        } catch (Exception $e) {

            $errorMessage = 'Failed create menu : '.$e;

            Log::error($errorMessage);

            return Response::json(
                ResponseUtils::compose(
                    status: 'error',
                    message: 'Server error',
                    errors: $errorMessage
                ),
                500
            );
        }
    }

    public function findOne(int $id): JsonResponse
    {
        try {
            $menu = Menu::where('id', $id)->first();

        } catch(Exception $e) {
            $errorMessage = 'Failed findOne menu : '.$e;

            Log::error($errorMessage);

            return Response::json(
                ResponseUtils::compose(
                    status: 'error',
                    message: 'Server error',
                    errors: $errorMessage
                ),
                500
            );
        }
    }

    public function findAll(): JsonResponse
    {

    }

    public function findAllByUser(int $userID, bool $buildTree = true): JsonResponse
    {

    }

    public function findAllParent(): JsonResponse
    {

    }

    public function delete(int $id): JsonResponse
    {

    }

    public function update(int $id, MenuPostDto $dto): JsonResponse
    {

    }
}
