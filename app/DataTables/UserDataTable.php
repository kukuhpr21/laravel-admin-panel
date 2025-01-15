<?php

namespace App\DataTables;

use App\Models\User;
use App\Utils\CryptUtils;
use App\Models\UserHasRole;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class UserDataTable extends DataTable
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
        ->addColumn('status', function($row) {
            $status = $row->status;
            $bg  = ($status == 'Active') ? 'bg-teal-600' : 'bg-red-600';
            return '<span class="'.$bg.' py-1 px-3 rounded-md text-white">'.$status.'</span>';
        })
        ->addColumn('action', function($row) {
            $userID       = CryptUtils::enc($row->user_id);
            $linkEdit     = route('users-edit', ['id' => $userID]);
            $linkChangeStatus   = route('users-change-status', ['id' => $userID]);
            return '
                <div class="flex flex-row gap-2">
                    <a href="'.$linkEdit.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-green-600 hover:text-green-800 focus:text-green-800">Edit</a>
                    <a href="'.$linkChangeStatus.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-blue-600 hover:text-blue-800 focus:text-green-800">Change Status</a>
                </div>
            ';
        })
        ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(UserHasRole $model): QueryBuilder
    {
        return $model->newQuery()
        ->addSelect('user_has_roles.user_id as user_id', 'users.name as name', 'users.email', 'users.created_at', 'users.updated_at', 'statuses.name as status', DB::raw('GROUP_CONCAT(roles.name ORDER BY roles.name ASC) as role'))
        ->leftJoin('users', 'users.id', '=', 'user_has_roles.user_id')
        ->leftJoin('statuses', 'statuses.id', '=', 'users.status_id')
        ->leftJoin('roles', 'roles.id', '=', 'user_has_roles.role_id')
        ->groupBy('user_id');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('user-table')
                    ->columns($this->getColumns())
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
            Column::make('name'),
            Column::make('email'),
            Column::make('role'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('status'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'User_' . date('YmdHis');
    }
}
