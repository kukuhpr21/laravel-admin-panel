<?php

namespace App\DataTables;

use App\Utils\CryptUtils;
use App\Models\UserHasMenu;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserHasMenusDataTable extends DataTable
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
            $userID       = CryptUtils::enc($row->user_id);
            $linkEdit     = route('users-menus-edit', ['user_id' => $userID]);
            $linkDelete   = route('users-menus-delete', ['user_id' => $userID]);
            $actionDelete = "modal.showModalConfirm('Delete Mapping User Menu', 'Menu pada user $row->user akan dihapus ?', 'Delete', '$linkDelete')";
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
    public function query(UserHasMenu $model): QueryBuilder
    {
        return $model->newQuery()
        ->addSelect('user_has_menus.user_id as user_id', 'users.name as user', DB::raw('GROUP_CONCAT(menus.name ORDER BY menus.name ASC) as menu'))
        ->leftJoin('users', 'users.id', '=', 'user_has_menus.user_id')
        ->leftJoin('menus', 'menus.id', '=', 'user_has_menus.menu_id')
        ->groupBy('user_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('userhasmenus-table')
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
            Column::make('user'),
            Column::make('menu'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'UserHasMenus_' . date('YmdHis');
    }
}
