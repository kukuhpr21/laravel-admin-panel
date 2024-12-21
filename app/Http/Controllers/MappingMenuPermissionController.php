<?php

namespace App\Http\Controllers;

use App\DataTables\MenuHasPermissionDataTable;

class MappingMenuPermissionController extends Controller
{
    public function index(MenuHasPermissionDataTable $dataTable)
    {
        return $dataTable->render('pages.app.mappings.menuspermissions.list');
    }

    public function create()
    {
        return view('pages.app.mappings.menuspermissions.create');
    }

    public function store()
    {

    }
}
