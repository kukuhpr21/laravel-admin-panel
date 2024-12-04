<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Menu;
use App\Models\RoleHasMenu;
use App\Models\UserHasMenu;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use Illuminate\Http\Response;
use App\Models\MenuHasPermission;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\DataTransferObjects\Menu\MenuPostDto;

class MenuServiceImpl implements MenuService
{
    use ResponseUtils;

    public function store(MenuPostDto $dto)
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

            if ($menu) {

                return ResponseUtils::success(
                    message: 'Success create menu',
                    data: $menu,
                );

            }

        } catch (Exception $e) {
            return ResponseUtils::internalServerError(`Failed create menu : $e`);
        }
    }

    public function findOne(int $id)
    {
        try {
            $menu = Menu::where('id', $id)->first();

            if ($menu) {
                return ResponseUtils::success('Menu is exist', $menu);
            } else {
                return ResponseUtils::failed('Menu not found', ['id' => $id]);
            }

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed find one menu : $e`);
        }
    }

    public function findAll(bool $buildTree = false)
    {
        try {
            $menus = Menu::orderBy('id', 'asc')->get();

            if (!$menus) {
                return ResponseUtils::failed('Menu is empty');
            }

            if ($buildTree) {
                $menus = $this->buildTreeMenu($menus->toArray());
            }

            return ResponseUtils::success('Menu is exist', $menus);

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed find all menu : $e`);
        }
    }

    public function findAllByUser(int $userID, bool $buildTree = true)
    {
        try {
            $menus = UserHasMenu::select('id', 'name', 'link', 'link_alias', 'icon', 'parent', 'order')
                ->where('user_id', $userID)
                ->leftJoin('menus', 'menus.id', '=', 'user_has_menus.menu_id')
                ->orderBy('order', 'asc')
                ->get()->toArray();

            if ($buildTree) {
                $menus = $this->buildTreeMenu($menus);
            }

            return ResponseUtils::success('Menu is exist', $menus);

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed find all menu by user : $e`);
        }
    }

    public function findAllParent()
    {
        try {
            $menus = Menu::where('parent', 0)
                ->orWhereRaw('id = parent')
                ->orWhereRaw("link = '#'")
                ->orderBy('order', 'asc')
                ->get()->toArray();

            if (!$menus) {
                return ResponseUtils::failed('Menu is empty');
            }

            return ResponseUtils::success('Menu is exist', $menus);

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed find all menu parent : $e`);
        }
    }

    public function delete(int $id)
    {
        try {
            if ($this->menuIsNotUsed($id)) {
                $result =  Menu::where('id', $id)->delete();

                if (!$result) {
                    return ResponseUtils::failed('Failed delete menu', ['id' => $id]);
                }

                return ResponseUtils::success('Success delete menu', ['id' => $id]);

            }

            return ResponseUtils::failed('Failed delete menu, menu is used', ['id' => $id]);

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed delete menu : $e`);
        }
    }

    public function update(int $id, MenuPostDto $dto)
    {
        try {
            $menu = Menu::where('id', $id)->first();
            $menu->name       = $dto->name;
            $menu->link       = $dto->link;
            $menu->link_alias = $dto->linkAlias;
            $menu->icon       = $dto->icon;
            $menu->parent     = $dto->parent;
            $menu->order      = $dto->order;
            $result = $menu->save();

            if (!$result) {
                return ResponseUtils::failed('Failed update menu', ['id' => $id]);
            }

            return ResponseUtils::success('Success update menu', $menu);

        } catch(Exception $e) {
            return ResponseUtils::internalServerError(`Failed update menu : $e`);
        }
    }

    private function menuIsNotUsed(string $menuID): bool
    {
        $menuHasPermission = MenuHasPermission::where('menu_id', $menuID)->first();
        $roleHasMenu = RoleHasMenu::where('menu_id', $menuID)->first();
        $userHasMenu = UserHasMenu::where('menu_id', $menuID)->first();
        return !$menuHasPermission && !$roleHasMenu && !$userHasMenu;
    }

    private function buildTreeMenu(array $menus, int $parent = 0): array
    {
        $tree = [];

        foreach ($menus as $element) {

            if ($element['parent'] == $parent) {

                $children = self::buildTreeMenu($menus, $element['id']);

                $element['children'] = [];

                if ($children) {
                    $element['children'] = $children;
                }

                $tree[] = $element;
            }
        }

        return $tree;
    }
}
