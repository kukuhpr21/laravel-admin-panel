<?php

namespace App\Http\Controllers;

use App\DataTables\RolesDataTable;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('pages.app.roles.list');
    }

    public function create()
    {
        return view('pages.app.roles.create');
    }
}
