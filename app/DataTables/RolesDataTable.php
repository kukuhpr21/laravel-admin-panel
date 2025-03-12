<?php

namespace App\DataTables;

use App\Models\Role;
use App\Utils\CryptUtils;
use Yajra\DataTables\Html\Column;
use App\Utils\PermissionCheckUtils;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class RolesDataTable extends DataTable
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
                $id           = CryptUtils::enc($row->id);
                $linkEdit     = route('roles-edit', ['id' => $id]);
                $linkDelete   = route('roles-delete', ['id' => $id]);
                $actionDelete = "modal.showModalConfirm('Delete Role', 'Role $row->name akan dihapus ?', 'Delete', '$linkDelete')";

                $btnEdit   = "";
                $btnDelete = "";

                $path  = $this->request->path();
                if (PermissionCheckUtils::execute($path.'.update')) {
                    $btnEdit = '<a href="'.$linkEdit.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-green-600 hover:text-green-800 focus:text-green-800">Edit</a>';
                }

                if (PermissionCheckUtils::execute($path.'.delete')) {
                    $btnDelete = '<button type="button" onclick="'.$actionDelete.'" class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent hover:bg-slate-200 hover:rounded-lg p-3 focus:outline-none disabled:opacity-50 disabled:pointer-events-none text-red-600 hover:text-red-800 focus:text-red-800">Delete</button>';
                }

                return '
                    <div class="flex flex-row gap-2">
                        '.$btnEdit.$btnDelete.'
                    </div>
                ';
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Role $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
        ->setTableId('roles-table')
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
            Column::make('list_role_available'),
            Column::computed('action')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Roles_' . date('YmdHis');
    }
}
