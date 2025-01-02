<?php

namespace App\Services\Impl;

use Exception;
use App\Models\Menu;
use App\Models\RoleHasMenu;
use App\Models\UserHasMenu;
use App\Utils\ResponseUtils;
use App\Services\MenuService;
use App\Models\MenuHasPermission;
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed create menu : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find one menu : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu by user : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed find all menu parent : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed delete menu : '.$errorMessage);
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
            $errorMessage = $e->getMessage();
            return ResponseUtils::internalServerError('Failed update menu : '.$errorMessage);
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

    public function makeHTMLMenu(array $menus): string
    {
        $tree = '<div class="hs-accordion-treeview-root" role="tree" aria-orientation="vertical">';

        foreach ($menus as $item) {

            $id         = $item['id'];
            $idHeading  = 'tree-heading-'.$id;
            $idCollapse = 'tree-collapse-'.$id;

            $name = $id.'. '.$item['name'];
            $tree .= '<div class="hs-accordion active" role="treeitem" aria-expanded="true" id="'.$idHeading.'">';

            if ($item['children']) {
                $tree .= '<div class="hs-accordion-heading py-0.5 flex items-center gap-x-0.5 w-full">
                            <button class="hs-accordion-toggle size-6 flex justify-center items-center hover:bg-gray-100 rounded-md focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" aria-expanded="true" aria-controls="'.$idCollapse.'">
                                <svg class="size-4 text-gray-800" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path class="hs-accordion-active:hidden block" d="M12 5v14"></path>
                                </svg>
                            </button>
                            <div class="grow hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-1.5 rounded-md cursor-pointer">
                                <div class="flex items-center gap-x-3">
                                    <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M20 20a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.9a2 2 0 0 1-1.69-.9L9.6 3.9A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13a2 2 0 0 0 2 2Z"></path>
                                    </svg>
                                    <div class="grow">
                                        <span class="text-sm text-gray-800">'.$name.'</span>
                                    </div>
                                </div>
                            </div>
                          </div>';

                $tree .= '<div id="'.$idCollapse.'" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300" role="group" aria-labelledby="'.$idHeading.'">';
                $tree .= '<div class="hs-accordion-group ps-7 relative before:absolute before:top-0 before:start-3 before:w-0.5 before:-ms-px before:h-full before:bg-gray-100" role="group" data-hs-accordion-always-open="">';
                $tree .= self::makeHTMLMenu($item['children']);
                $tree .= '</div></div>';
            } else {
                $tree .= '<div class="hs-accordion-selectable hs-accordion-selected:bg-gray-100 px-2 rounded-md cursor-pointer" role="treeitem">
                            <div class="flex items-center gap-x-3">
                                <svg class="shrink-0 size-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                    <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                </svg>
                                <div class="grow">
                                    <span class="text-sm text-gray-800">'.$name.'</span>
                                </div>
                            </div>
                          </div>';

            }

            $tree .= '</div>';
        }
        $tree .= '</div>';

        return $tree;
    }
}
