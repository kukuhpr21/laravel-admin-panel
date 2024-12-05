<?php

namespace App\View\Components;

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
        $name =  $this->sessionUtils->get('name');
        $role =  json_decode($this->sessionUtils->get('role'), true)['name'];
        return view('components.navbar', compact('name', 'role'));
    }
}
