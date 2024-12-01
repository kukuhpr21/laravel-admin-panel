<?php

namespace App\Services\Impl;

use App\Models\Menu;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use Illuminate\Http\Response;
use App\DataTransferObjects\Menu\MenuCreateDto;
use Exception;
use Illuminate\Support\Facades\Log;

class MenuServiceImpl implements MenuService
{
    use ResponseUtils;

    public function store(MenuCreateDto $dto)
    {
        try {
            Menu::create([
                'name'       => $dto->name,
                'link'       => !empty($dto->link) ? $dto->link : '#',
                'link_alias' => !empty($dto->linkAlias) ? $dto->linkAlias : '#',
                'icon'       => !empty($dto->icon) ? $dto->icon : '#',
                'parent'     => $dto->parent != '#' ? $dto->parent : 0,
                'order'      => $dto->order,
            ]);

            return Response::json(
                ResponseUtils::compose(
                    'success',
                    'Success create menu'
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
}
