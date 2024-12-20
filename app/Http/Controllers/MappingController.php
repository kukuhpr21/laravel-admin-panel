<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function menuPermission()
    {
        return view('pages.app.mappings.menu-permission');
    }
}
