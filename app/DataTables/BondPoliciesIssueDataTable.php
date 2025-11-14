<?php

namespace App\DataTables;

use App\Models\BondPoliciesIssue;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
use Sentinel;
use App\Http\Controllers\CommonController;

class BondPoliciesIssueDataTable extends DataTable
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
    public function dataTable($query)
    {
        return dataTables()
        ->eloquent($query)
        ->editColumn('is_active', function ($row) {
            return getStatusHtmlTeam($row);
        })
        ->editColumn('bond_value', function ($row) {
            return isset($row->bond_value) ? numberFormatPrecision($row->bond_value, 0) : '-';
        })
        ->editColumn('premium_amount', function ($row) {
            return isset($row->premium_amount) ? numberFormatPrecision($row->premium_amount, 0) : '-';
        })
        ->editColumn('bondNumber', function($row) {
            $user = Sentinel::getUser();

            if ($user->hasAnyAccess(['bond_policies_issue.view', 'users.superadmin'])) {
                return '<a href="' . route('bond_policies_issue.show', [encryptId($row->id)]) . '" class="navi-link" target="_self">' .
                    '<span class="navi-text rm-text">' . $row->bondNumber . '</span></a> ';
            } else {
                return $row->bondNumber;
            }
        })
        ->rawColumns(['action', 'is_active', 'bond_value', 'premium_amount', 'bondNumber']);
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BondPoliciesIssue $model)
    {
        $model = BondPoliciesIssue::RoleBasedScope($this->role, $this->team_member_id)->select(
            'bond_policies_issue.id',
            DB::raw('(CASE WHEN bond_policies_issue.bond_number is not null THEN CONCAT(bond_policies_issue.reference_no, " | ", bond_policies_issue.bond_number) ELSE bond_policies_issue.reference_no END) as bondNumber'),
            'bond_policies_issue.insured_name as contractor_name',
            'beneficiaries.company_name as beneficiary_name',
            'bond_policies_issue.bond_value',
            'bond_policies_issue.bond_conditionality',
            'bond_policies_issue.premium_amount',
            'proposals.status',
            'bond_types.name as bond_type',
        )
        ->leftJoin('beneficiaries', function($join){
            $join->on('bond_policies_issue.beneficiary_id' , '=', 'beneficiaries.id');
        })
        ->leftJoin('proposals', function($join){
            $join->on('bond_policies_issue.proposal_id', '=', 'proposals.id');
        })
        ->leftJoin('bond_types', function($join) {
            $join->on('bond_policies_issue.bond_type_id', '=', 'bond_types.id');
        })
        ->where([
            // 'proposals.is_amendment' => 0,
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            // 'proposals.is_invocation_notification'=>0,	
            // 'proposals.is_bond_foreclosure'=>0,	
            // 'proposals.is_bond_cancellation'=>0,
        ])
        ->whereNull('bond_policies_issue.deleted_at')
        ->groupBy('bond_policies_issue.id');

        if(request()->get('bondNumber')) {
            $model->whereRaw("CONCAT_WS(' ',bond_policies_issue.reference_no, bond_policies_issue.bond_number) LIKE ?", '%' . request()->get('bondNumber') . '%');
        }

        if(request()->get('contractor_name')) {
            $model->where('bond_policies_issue.insured_name', 'like', '%' . request()->get('contractor_name') . '%');
        }

        if(request()->get('beneficiary_name')) {
            $model->where('beneficiaries.company_name', 'like', '%' . request()->get('beneficiary_name') . '%');
        }

        if(request()->get('bond_value')) {
            $model->where('bond_policies_issue.bond_value', 'like', '%' . request()->get('bond_value') . '%');
        }

        if(request()->get('bond_conditionality')) {
            $model->where('bond_policies_issue.bond_conditionality', request()->get('bond_conditionality'));
        }

        if(request()->get('premium_amount')) {
            $model->where('bond_policies_issue.premium_amount', 'like', '%' . request()->get('premium_amount') . '%');
        }

        if(request()->get('status')) {
            $model->where('proposals.status', 'like', '%' . request()->get('status') . '%');
        }

        if(request()->get('bond_type')) {
            $model->where('bond_types.id', 'like', '%' . request()->get('bond_type') . '%');
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('bondpoliciesissue-table')
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
        return 'BondPoliciesIssue_' . date('YmdHis');
    }
}
