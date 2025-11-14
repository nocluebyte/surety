<?php

namespace App\DataTables;

use App\Models\Blacklist;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class BlacklistDataTable extends DataTable
{
    public function __construct(){
        $user = Sentinel::getUser();
        $this->user = $user;
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable($query)
    {
        return dataTables()
            ->eloquent($query)
            ->editColumn('is_active', function($row){
                // return getStatusBlacklist($row);
                // return getStatusHtml($row);
                return getInactiveStatus($row);
            })
            ->editColumn('code',function($row){
                return $this->checkViewrights($row);
            })
            ->editColumn('blacklist_date',function($row){
                return custom_date_format($row->blacklist_date ?? '', 'd/m/Y');
            })
            ->rawColumns(['is_active', 'code', 'blacklist_date']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('blacklist.show',[encryptId($row->id)]);

        if ($this->user->hasAnyAccess(['blacklist.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$code}</a>";
        }
        else{
            $value = $code;
        }
        return $value;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Blacklist $model)
    {
        $model = Blacklist::select('blacklists.id', 'blacklists.contractor_id', 'blacklists.source', 'blacklists.is_active', 'principles.company_name as company_name', 'blacklists.blacklist_date', 'blacklists.code')
            ->leftJoin('principles', 'blacklists.contractor_id', '=', 'principles.id')
            ->whereNull('blacklists.deleted_at')
            ->groupBy('blacklists.id');
        $filter_created_date = request()->get('filter_created_date', false);

        if (request()->get('code')) {
            $model->where('blacklists.code', 'like', '%' . request()->get('code') . '%');
        }

        if (request()->get('company_name')) {
            $model->where('company_name', 'like', '%' . request()->get('company_name') . '%');
        }

        if (request()->get('source')) {
            $model->where('source', 'like', '%' . request()->get('source') . '%');
        }

        if (request()->get('blacklist_date')) {
            $model->where('blacklist_date', 'like', '%' . request()->get('blacklist_date') . '%');
        }

        if($filter_created_date) {
            $filter_created_date = explode('|', $filter_created_date);
            $fromDate = !empty($filter_created_date[0]) ? custom_date_format($filter_created_date[0], 'Y-m-d') : '';
            $toDate = !empty($filter_created_date[1]) ? custom_date_format($filter_created_date[1], 'Y-m-d') : '';
            $model->when($fromDate && $toDate, function($q) use ($fromDate, $toDate) {
                $q->whereDate('blacklist_date', '>=', $fromDate)->whereDate('blacklist_date', '<=', $toDate);
            });
        }

        if(request()->get('filter_status')) {
            $model->where('blacklists.is_active', 'like', '%' . request()->get('filter_status') . '%');
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('blacklist-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('create'),
                        Button::make('export'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Blacklist_' . date('YmdHis');
    }
}
