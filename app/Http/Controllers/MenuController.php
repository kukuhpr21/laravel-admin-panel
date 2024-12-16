<?php

namespace App\Http\Controllers;

use App\DataTables\MenusDataTable;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(MenusDataTable $dataTable)
    {
        return $dataTable->render('pages.app.menus.list');
    }

    public function create()
    {
        return view('pages.app.menus.create');
    }
}
