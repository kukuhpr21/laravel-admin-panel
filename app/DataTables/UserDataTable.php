<?php

namespace App\DataTables;

use App\Utils\CryptUtils;
use App\Models\UserHasRole;
use App\Utils\CacheUtils;
use App\Utils\SessionUtils;
use Yajra\DataTables\Html\Column;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Log;

class UserDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */

    private string $filter_status;
    private string $filter_role;
    private string $filter_created_at;
    private SessionUtils $sessionUtils;
    private array $listRoleAvailable = [];

    public function __construct(string $filter_status = '', string $filter_role = '', string $filter_created_at = '') {
        $this->filter_status = $filter_status;
        $this->filter_role = $filter_role;
        $this->filter_created_at = $filter_created_at;
        $this->sessionUtils = new SessionUtils();
        $cacheRole = json_decode(CacheUtils::get('role', $this->sessionUtils->get('id')));
        $this->listRoleAvailable = explode(',', $cacheRole->list_role_available);
    }

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
        $query = $model->newQuery()
        ->addSelect('user_has_roles.user_id as user_id', 'users.name as name', 'users.email', 'users.created_at', 'users.updated_at', 'statuses.name as status', DB::raw('GROUP_CONCAT(roles.name ORDER BY roles.name ASC) as role'))
        ->leftJoin('users', 'users.id', '=', 'user_has_roles.user_id')
        ->leftJoin('statuses', 'statuses.id', '=', 'users.status_id')
        ->leftJoin('roles', 'roles.id', '=', 'user_has_roles.role_id');

        // filter
        if (request()->has('status') && request()->status != 'all') {
            $query->where('statuses.id', request()->status);
        }

        if (request()->has('role') && request()->role != 'all') {
            $query->where('roles.id',request()->role);
        } else {
            if (!empty($this->listRoleAvailable)) {
                $query->whereIn('roles.id', $this->listRoleAvailable);
            }
        }

        if (request()->has('created_at') && !empty(request()->created_at)) {
            $query->whereDate('created_at', request()->created_at);
        }

        $query->groupBy('user_id');

        return $this->applyScopes($query);
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
                    ->postAjax([
                        'url' => route('users'),
                        'data' => 'function(d) {
                            d.status ="'.$this->filter_status.'";
                            d.role = "'.$this->filter_role.'";
                            d.created_at = "'.$this->filter_created_at.'";
                        }'
                    ])
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
