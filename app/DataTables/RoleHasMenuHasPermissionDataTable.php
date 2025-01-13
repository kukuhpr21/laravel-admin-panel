<?php

namespace App\DataTables;

use App\Utils\CryptUtils;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use App\Models\RoleHasMenuHasPermission;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class RoleHasMenuHasPermissionDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->addIndexColumn()
        ->addColumn('action', function($row) {
            $roleID       = CryptUtils::enc($row->role_id);
            $menuID       = CryptUtils::enc($row->menu_id);
            $linkEdit     = route('roles-menus-permissions-edit', ['role_id' => $roleID, 'menu_id' => $menuID]);
            $linkDelete   = route('roles-menus-permissions-delete', ['role_id' => $roleID, 'menu_id' => $menuID]);
            $actionDelete = "modal.showModalConfirm('Delete Mapping Role Menu Permission', 'Permission pada role  $row->role dan menu $row->menu akan dihapus ?', 'Delete', '$linkDelete')";
            return '
                <div class="flex flex-row gap-2">
                    <a href="'.$linkEdit.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-green-600 hover:text-green-800 focus:text-green-800">Edit</a>
                    <button type="button" onclick="'.$actionDelete.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-red-600 hover:text-red-800 focus:text-red-800">Delete</button>
                </div>
            ';
        })
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(RoleHasMenuHasPermission $model): QueryBuilder
    {
        return $model->newQuery()
        ->addSelect('role_has_menu_has_permission.role_id as role_id' , 'role_has_menu_has_permission.menu_id as menu_id', 'roles.name as role' , 'menus.name as menu', DB::raw('GROUP_CONCAT(permissions.name ORDER BY permissions.name ASC) as permission'))
        ->leftJoin('roles', 'roles.id', '=', 'role_has_menu_has_permission.role_id')
        ->leftJoin('menus', 'menus.id', '=', 'role_has_menu_has_permission.menu_id')
        ->leftJoin('permissions', 'permissions.id', '=', 'role_has_menu_has_permission.permission_id')
        ->groupBy('role_id' , 'menu_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('rolehasmenuhaspermission-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->orderBy(1)
                    ->selectStyleSingle();
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('DT_RowIndex', '#'),
            Column::make('role'),
            Column::make('menu'),
            Column::make('permission'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'RoleHasMenuHasPermission_' . date('YmdHis');
    }
}
