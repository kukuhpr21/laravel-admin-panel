<?php

namespace App\View\Components;

use Closure;
use App\Utils\SessionUtils;
use App\Services\MenuService;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sidebar extends Component
{
    private MenuService $menuService;
    /**
     * Create a new component instance.
     */
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sessionUtils = new SessionUtils();
        $menus        = $sessionUtils->get('menus');
        $menusDecode  = json_decode($menus, true);
        $menus        = $this->menuService->makeHTMLSiderbar($menusDecode, request()->segments());
        return view('components.sidebar', compact('menus'));
    }
}
