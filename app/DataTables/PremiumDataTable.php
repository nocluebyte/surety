<?php

namespace App\DataTables;

use App\Models\BondPoliciesIssueChecklist;
use App\Models\Premium;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class PremiumDataTable extends DataTable
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
            ->addColumn('action', function($row){
                return $this->checkrights($row);
            })
            ->editColumn('proposal_code',function($row){
                return $this->checkViewrights($row);
            }) 
            ->editColumn('is_active', function($row){
                return getStatusHtml($row);
            })
            ->editColumn('bond_value', function ($row) {
                return numberFormatPrecision($row->bond_value, 0);
            })
            ->editColumn('payment_received', function ($row) {
                $amount = numberFormatPrecision($row->payment_received, 0);
                $negativePayment = "<span class='text-danger'>$amount</span>";
                return $row->payment_received < 0 ? $negativePayment : numberFormatPrecision($row->payment_received, 0);
            })
            ->editColumn('net_premium', function ($row) {
                return numberFormatPrecision($row->net_premium, 0);
            })
            ->editColumn('gst_amount', function ($row) {
                return numberFormatPrecision($row->gst_amount, 0);
            })
            ->editColumn('stamp_duty_charges', function ($row) {
                return numberFormatPrecision($row->stamp_duty_charges, 0);
            })
            ->editColumn('total_premium_including_stamp_duty', function ($row) {
                return numberFormatPrecision($row->total_premium_including_stamp_duty, 0);
            })
            ->rawColumns(['action', 'is_active','proposal_code', 'payment_received', 'net_premium', 'gst_amount', 'stamp_duty_charges', 'total_premium_including_stamp_duty']);
    }

    public function checkViewrights($row){
        //dump($row->company_name);
        $code = $row->proposal_code ?? '';
        $route = route('premium.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['premium.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$code}</a>";
        }
        else{
            $value = $code;
        }
        return $value;
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('premium.edit', [$row->id]);
        $deleteUrl = route('premium.destroy', [$row->id]);

        if($user -> hasAnyAccess(['users.info', 'premium.edit', 'premium.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['premium.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['premium.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'premium.edit', 'premium.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Premium $model)
    {
        $model = BondPoliciesIssueChecklist::RoleBasedScope($this->role,$this->team_member_id)->select('bond_policies_issue_checklist.id', DB::raw("bond_types.name as bond_type"), 'p.bond_value', DB::raw('bond_policies_issue_checklist.net_premium as payment_received'), DB::raw("DATE_FORMAT(bond_policies_issue_checklist.date_of_receipt, '%d/%m/%Y') as payment_received_date"),DB::raw("CONCAT(p.code, '/V', p.version) as proposal_code"), 'p.status', 'nbis.net_premium', 'nbis.gst_amount', 'nbis.stamp_duty_charges', 'nbis.total_premium_including_stamp_duty')
            ->join('proposals as p',function($join){
                $join->on('bond_policies_issue_checklist.proposal_id','=','p.id');
                $join->whereNull('p.deleted_at');
            })
            ->join('bond_policies_issue', function($join){
                $join->on('p.id', '=', 'bond_policies_issue.proposal_id');
            })
            ->join('bond_types',function($join){
                $join->on('p.bond_type_id','=','bond_types.id');               
                $join->whereNull('bond_types.deleted_at');
            })
            ->join('nbis', function($join) {
                $join->on('bond_policies_issue_checklist.proposal_id', '=', 'nbis.proposal_id')
                ->where('nbis.status', 'Approved')
                ->whereNull('nbis.deleted_at');
            })
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'p.is_issue' => 1,
            ])
            ->whereNull('bond_policies_issue_checklist.deleted_at');
            // ->where('p.is_amendment',0);

        if(request()->get('proposal_code')){
            $model->where('p.code', 'like', '%' . request()->get('proposal_code') . '%')->orWhere('p.version', 'like', '%' .request()->get('proposal_code') . '%');
        }
        
        if(request()->get('bond_type')){
            $model->where('bond_types.id', 'like', '%' . request()->get('bond_type') . '%');
        }

        if(request()->get('bond_value')) {
            $model->where('p.bond_value', 'like', '%' . request()->get('bond_value') . '%');
        }

        if(request()->get('net_premium')) {
            $model->where('nbis.net_premium', 'like', '%' . request()->get('net_premium') . '%');
        }

        if(request()->get('gst_amount')) {
            $model->where('nbis.gst_amount', 'like', '%' . request()->get('gst_amount') . '%');
        }

        if(request()->get('stamp_duty_charges')) {
            $model->where('nbis.stamp_duty_charges', 'like', '%' . request()->get('stamp_duty_charges') . '%');
        }

        if(request()->get('total_premium_including_stamp_duty')) {
            $model->where('nbis.total_premium_including_stamp_duty', 'like', '%' . request()->get('total_premium_including_stamp_duty') . '%');
        }

        if(request()->get('payment_received')) {
            $model->where('bond_policies_issue_checklist.net_premium', 'like', '%' . request()->get('payment_received') . '%');
        }

        if(request()->get('payment_received_date')) {
            $model->where(DB::raw("DATE_FORMAT(bond_policies_issue_checklist.date_of_receipt, '%d/%m/%Y')"), 'like', '%' . request()->get('payment_received_date') . '%');
        }

        if(request()->get('status')) {
            $model->where('p.status', 'like', '%' . request()->get('status') . '%');
        }

        if (request()->get('filter_bond_type')) {
            $model->where('p.bond_type_id', 'like', '%' . request()->get('filter_bond_type') . '%');
        }

        return $this->applyScopes($model);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html()
    {
        return $this->builder()
            ->parameters(['searching' => false, 'dom' => '<"wrapper"B>lfrtip', 'buttons' => ['excel', 'pdf'],])
            ->columns($this->getColumns())
            ->ajax('');
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            ['name' => 'premium', 'data' => 'premium', 'title' => trans("premium.premium")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Premium_' . date('YmdHis');
    // }
}
