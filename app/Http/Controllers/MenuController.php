<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('pages.app.menu.create');
    }
}
