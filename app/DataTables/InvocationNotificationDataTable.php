<?php

namespace App\DataTables;

use App\Models\BidBond;
use App\Models\InvocationNotification;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Str;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class InvocationNotificationDataTable extends DataTable
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
            ->editColumn('code',function($row){
                return $this->checkViewrights($row);
            }) 
            ->editColumn('contractor', function($row) {
                if ($this->user->hasAnyAccess('users.superadmin', 'principles.view'))
                    return '<a href="' . route('principle.show', [encryptId($row->contractor_id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->contractor.'</span></a> ';
                else
                    return $row->contractor;
            })  
            ->editColumn('proposal_code', function($row) {
                return '<a href="' . route('proposals.show', [encryptId($row->proposal_id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->proposal_code.'/V'.$row->version.'</span></a> ';
            })          
            ->editColumn('beneficiary_name', function($row) {
                if ($this->user->hasAnyAccess('users.superadmin', 'beneficiary.view'))
                    return '<a href="' . route('beneficiary.show', [encryptId($row->beneficiary_id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->beneficiary_name.'</span></a> ';
                else
                    return $row->beneficiary_name;
            })
            ->editColumn('bond_value', function($row) {
                return isset($row->bond_value) ? numberFormatPrecision($row->bond_value, 0) : '-';
            })
            ->editColumn('status', function ($row) {
                if ($row->status == 'Pending') {
                    $status = '<span class="label label-lg label-light-warning font-weight-bolder label-inline">Pending</span>';
                } elseif ($row->status == 'Paid') {
                    $status = '<span class="label label-lg label-light-success font-weight-bolder label-inline">Paid</span>';
                } elseif ($row->status == 'Cancel') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Cancel</span>';
                }
                else{
                    $status = '-';
                }
                return $status;
            })
            ->rawColumns(['code','contractor','proposal_code', 'beneficiary_name', 'bond_value', 'status']);
    }

    public function checkrights($row)
    {
        $user = Sentinel::getUser();
        $menu = '';
        $editUrl = route('invocation-notification.edit', [$row->id]);
        $deleteUrl = route('invocation-notification.destroy', [$row->id]);

        if($user -> hasAnyAccess(['users.info', 'invocation_notification.edit', 'invocation_notification.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($user -> hasAnyAccess(['invocation_notification.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($user -> hasAnyAccess(['invocation_notification.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($user -> hasAnyAccess(['users.info', 'invocation_notification.edit', 'invocation_notification.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(InvocationNotification $model)
    {
        $slug = $this->user->roles->pluck('slug')->first();

        $model = InvocationNotification::RoleBasedScope($this->role,$this->team_member_id)->select('invocation_notification.id','invocation_notification.proposal_id',
        'invocation_notification.status',
        DB::raw("invocation_notification.code"),
        DB::raw("p.code as proposal_code"),
        DB::raw("p.version"),
        DB::raw("p.bond_value"),
        DB::raw("p.contractor_id"),
        'bt.name as bond_type',   
        'c.company_name as contractor',
        DB::raw("p.bond_start_date"),
        DB::raw("p.bond_end_date"),
        'b.company_name as beneficiary_name',
        DB::raw("p.tender_header"),
        DB::raw("bpi.reference_no as sys_gen_bond_number"),
        DB::raw("invocation_notification.bond_number as insurer_bond_number"),
        DB::raw("invocation_notification.beneficiary_id"),
        DB::raw("DATE_FORMAT(invocation_notification.invocation_date, '%d/%m/%Y') as invocation_date"), 
        'invocation_notification.closed_reason')
            ->join('bond_types as bt',function($join){
                $join->on('invocation_notification.bond_type_id','=','bt.id');               
                $join->whereNull('bt.deleted_at');
            })
            ->join('proposals as p',function($join){
                $join->on('invocation_notification.proposal_id','=','p.id');
                $join->whereNull('p.deleted_at');
            })            
            ->join('principles as c',function($join){
                $join->on('p.contractor_id','=','c.id');                           
                $join->whereNull('c.deleted_at');
            })      
            ->join('beneficiaries as b', function($join){
                $join->on('p.beneficiary_id', '=', 'b.id');
                $join->whereNull('b.deleted_at');
            })
            ->join('bond_policies_issue as bpi', function($join){
                $join->on('invocation_notification.bond_policies_issue_id', '=', 'bpi.id');
            });
            
        if(request()->get('code')){
            $model->where('invocation_notification.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('proposal_code')){
            $model->where('p.code', 'like', '%' . request()->get('proposal_code') . '%')->orwhere('p.version', 'like', '%' . request()->get('proposal_code') . '%');
        }
        
        if(request()->get('contractor')){
            $model->where('c.company_name', 'like', '%' . request()->get('contractor') . '%');
        }

        if(request()->get('bond_type')) {
            $model->where('bt.id', 'like', '%' . request()->get('bond_type') . '%');
        }

        if(request()->get('bond_value')) {
            $model->where('p.bond_value', 'like', '%' . request()->get('bond_value') . '%');
        }
        if(request()->get('bond_start_date')) {
            $model->where(DB::raw("DATE_FORMAT(p.bond_start_date, '%d/%m/%Y')"),'like','%' . request()->get('bond_start_date'). '%');
        }
        if(request()->get('bond_end_date')) {
            $model->where(DB::raw("DATE_FORMAT(p.bond_end_date, '%d/%m/%Y')"), 'like', '%' . request()->get('bond_end_date') . '%');
        }

        if(request()->get('invocation_notification_date')) {
            $model->where(DB::raw("DATE_FORMAT(invocation_notification.invocation_date, '%d/%m/%Y')"), 'like', '%' . request()->get('invocation_notification_date') . '%');
        }
        if(request()->get('status')) {
            $model->where('invocation_notification.closed_reason', 'like', '%' . request()->get('status') . '%');
        }

        if(request()->get('beneficiary_name')){
            $model->where('b.company_name', 'like', '%' . request()->get('beneficiary_name') . '%');
        }
        if(request()->get('tender_header')){
            $model->where('p.tender_header', 'like', '%' . request()->get('tender_header') . '%');
        }
        if(request()->get('sys_gen_bond_number')){
            $model->where('bpi.reference_no', 'like', '%' . request()->get('sys_gen_bond_number') . '%');
        }
        if(request()->get('insurer_bond_number')){
            $model->where('invocation_notification.bond_number', 'like', '%' . request()->get('insurer_bond_number') . '%');
        }
        return $this->applyScopes($model);
    }

    public function checkViewrights($row){
        //dump($row->company_name);
        $code = $row->code ?? '';
        $route = route('invocation-notification.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['invocation_notification.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$code}</a>";
        }
        else{
            $value = $code;
        }
        return $value;
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
            ['name' => 'invocation_notification', 'data' => 'invocation_notification', 'title' => trans("invocation_notification.invocation_notification")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'BidBond_' . date('YmdHis');
    // }
}
