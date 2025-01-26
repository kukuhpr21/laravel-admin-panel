<?php

namespace App\View\Components;

use App\Utils\CacheUtils;
use App\Utils\SessionUtils;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    private SessionUtils $sessionUtils;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $this->sessionUtils = new SessionUtils();
        $userID =  $this->sessionUtils->get('id');
        $name =  $this->sessionUtils->get('name');
        $role =  json_decode(CacheUtils::get('role', $userID), true)['name'];
        return view('components.navbar', compact('name', 'role'));
    }
}
