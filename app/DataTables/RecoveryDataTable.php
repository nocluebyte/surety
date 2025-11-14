<?php

namespace App\DataTables;

use App\Models\Recovery;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
use App\Http\Controllers\CommonController;
use Sentinel;

class RecoveryDataTable extends DataTable
{
     public function __construct(CommonController $commonController){
        $this->user = Sentinel::getUser();
        $this->role = $this->user?->roles?->first()?->slug;
        $this->team_member_id = $commonController->getTeamMemberByUserId($this->role,$this->user->id);
    }
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('invocation_number',function($row){
                $route = route('recovery.show',encryptId($row->id));
                if ($this->user->hasAnyAccess('users.superadmin', 'invocation_notification.view'))
                    return "<a href={$route}>{$row->invocation_number}</a>";
                else
                    return $row->invocation_number ?? '-';
            })
            ->editColumn('date',function($row){
                return custom_date_format($row->date,'d/m/Y');
            })
            ->editColumn('recover_amount',fn($row)=> numberFormatPrecision($row->recover_amount,0))
            ->editColumn('outstanding_amount',fn($row)=> numberFormatPrecision($row->outstanding_amount,0))
            ->editColumn('bond_value',fn($row)=> numberFormatPrecision($row->bond_value,0))
            ->rawColumns(['invocation_number']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Recovery $model): QueryBuilder
    {
        $fields = [
            'recoveries.id',
            'invocation_notification.id as invocation_notification_id',
            'recoveries.code',
            'recoveries.recover_date as date',
            'beneficiaries.company_name as beneficiary',
            'principles.company_name as contractor',
            'tenders.tender_header as tender',
            DB::raw('recoveries.recover_amount'),
            DB::raw('recoveries.outstanding_amount'),
            'invocation_notification.code as invocation_number',
            'invocation_notification.invocation_amount as bond_value',
            DB::raw("CONCAT_WS(' | ', bond_policies_issue.reference_no, bond_policies_issue.bond_number) as bond_number"),
        ];

        $model = $model->RoleBasedScope($this->role,$this->team_member_id)->select($fields)
        ->leftJoin('invocation_notification',function($q){
            $q->on('recoveries.invocation_notification_id','=','invocation_notification.id');
        })
        ->leftJoin('bond_policies_issue', function($q) {
            $q->on('invocation_notification.bond_policies_issue_id', '=', 'bond_policies_issue.id');
        })
        ->leftJoin('beneficiaries',function($q){
            $q->on('invocation_notification.beneficiary_id','=','beneficiaries.id');
        })
        ->leftJoin('principles',function($q){
            $q->on('invocation_notification.contractor_id','=','principles.id');
        })
        ->leftJoin('tenders',function($q){
            $q->on('invocation_notification.tender_id','=','tenders.id');
        });

        if(request()->get('code')) {
            $model->where('recoveries.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('invocation_number')) {
            $model->where('invocation_notification.code', 'like', '%' . request()->get('invocation_number') . '%');
        }

        if(request()->get('bond_number')) {
            $model->whereRaw('CONCAT_WS(" | ", bond_policies_issue.reference_no, bond_policies_issue.bond_number) LIKE ?', '%' . request()->get('bond_number') . '%');
        }

        if(request()->get('date')) {
            $model->where('recoveries.recover_date', 'like', '%' . request()->get('date') . '%');
        }

        if(request()->get('beneficiary')) {
            $model->where('beneficiaries.company_name', 'like', '%' . request()->get('beneficiary') . '%');
        }

        if(request()->get('contractor')) {
            $model->where('principles.company_name', 'like', '%' . request()->get('contractor') . '%');
        }

        if(request()->get('tender')) {
            $model->where('tenders.tender_header', 'like', '%' . request()->get('tender') . '%');
        }

        if (request()->get('filter_contractor_name', false)) {
            $model->where('principles.id', request()->get("filter_contractor_name"));
        }

        if (request()->get('filter_invocation_no', false)) {
            $model->where('invocation_notification.id', request()->get("filter_invocation_no"));
        }

        if (request()->get('filter_beneficiary_name', false)) {
            $model->where('beneficiaries.id', request()->get("filter_beneficiary_name"));
        }

        if (request()->get('filter_bond_number', false)) {
            $model->where('bond_policies_issue.id', request()->get("filter_bond_number"));
        }

        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('recovery-table')
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
        return 'Recovery_' . date('YmdHis');
    }
}
