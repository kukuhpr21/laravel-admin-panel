<?php

namespace App\View\Components;

use Closure;
use App\Utils\SessionUtils;
use App\Services\MenuService;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Sidebar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $sessionUtils = new SessionUtils();
        $menus        = $sessionUtils->get('menus');
        $menusDecode  = json_decode($menus, true);
        $menus        = $this->makeHTMLSiderbar($menusDecode, request()->segments());
        return view('components.sidebar', compact('menus'));
    }

    public function makeHTMLSiderbar(array $menus, array $segments): string
    {
        $tree = '';

        foreach ($menus as $item) {
            $isActive = implode('/', $segments) === $item['link'] ? 'bg-gray-200' : '';

            $icon = '';

            if ($item['icon'] != '#') {
                $icon = '<i class="'.$item['icon'].' ri-lg"></i>';
            }

            if ($item['children']) {
                $id = $item['id'].'-accordion';
                $tree .= '<li class="hs-accordion" id="'.$id.'">';
                $tree .= '<button type="button" class="hs-accordion-toggle '. $isActive .' hs-accordion-active:text-blue-600 hs-accordion-active:hover:bg-transparent w-full text-start flex items-center gap-x-3.5 py-2 px-3 text-sm text-gray-700 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100" aria-expanded="true" aria-controls="'.$id.'">';
                $tree .= $icon;
                $tree .= $item['name'];
                $tree .= '<svg class="hs-accordion-active:block ms-auto hidden size-4 text-gray-600 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m18 15-6-6-6 6"/></svg>';
                $tree .= '<svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg>';
                $tree .= '</button>';
                $tree .= '<div id="'.$id.'" class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 hidden" role="region" aria-labelledby="'.$id.'">';
                $tree .= '<ul class="hs-accordion-group p-2 gap-2" data-hs-accordion-always-open>';
                $tree .= self::makeHTMLSiderbar($item['children'], $segments);
                $tree .= '</ul>';
            } else {
                $tree .= '<li class="my-2">';
                $tree .= '<a wire:navigate class="flex items-center gap-x-3.5 py-2 px-3 '. $isActive .' text-sm text-gray-700 rounded-lg hover:bg-gray-100" href="'.route($item['link_alias']).'">';
                $tree .= $icon;
                $tree .= $item['name'];
                $tree .= '</a>';
            }

           $tree .= '</li>';
        }
        return $tree;
    }
}
