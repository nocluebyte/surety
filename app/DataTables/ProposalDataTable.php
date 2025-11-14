<?php

namespace App\DataTables;

use App\Models\Proposal;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class ProposalDataTable extends DataTable
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
            ->editColumn('is_active', function($row){
                return getStatusHtml($row);
            })
            ->editColumn('bond_value', function ($row) {
                return isset($row->bond_value) ? numberFormatPrecision($row->bond_value, 0) : '-';
            })
            ->editColumn('code', function($row) {

                if ($this->user->hasAnyAccess(['proposals.view', 'users.superadmin'])) {
                    return '<a href="' . route('proposals.show', [encryptId($row->id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->code . '/V' . $row->version . '</span></a> ';
                } else {
                    return $row->code . '/V' . $row->version;
                }
            })->editColumn('status', function ($row) {
                if ($row->status == 'Pending') {
                    $status = '<span class="label label-lg label-light-warning font-weight-bolder label-inline">Pending</span>';
                } elseif ($row->status == 'Confirm') {
                    $status = '<span class="label label-lg label-light-success font-weight-bolder label-inline">Confirm</span>';
                } elseif ($row->status == 'Approved') {
                    $status = '<span class="label label-lg label-light-success font-weight-bolder label-inline">Approved</span>';
                }elseif ($row->status == 'Expired') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Expired</span>';
                }elseif ($row->status == 'Rejected') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Rejected</span>';
                }elseif ($row->status == 'Cancel') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Cancel</span>';
                }elseif ($row->status == 'Issued') {
                    $status = '<span class="label label-lg label-light-success font-weight-bolder label-inline">Issued</span>';
                }elseif ($row->status == 'Cancelled') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Cancelled</span>';
                }elseif ($row->status == 'Forclosed') {
                    $status = '<span class="label label-lg label-light-primary font-weight-bolder label-inline">Forclosed</span>';
                }elseif ($row->status == 'Invoked') {
                    $status = '<span class="label label-lg label-light-primary font-weight-bolder label-inline">Invoked</span>';
                }elseif ($row->status == 'Terminated') {
                    $status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Terminated</span>';
                }
                else{
                    $status = '-';
                }
                return $status;
            })
            ->editColumn('created_at', function ($row) {
                return isset($row->created_at) ? custom_date_format($row->created_at, 'd/m/Y') : '-';
            })
            ->editColumn('nbi_status', function ($row) {
                if ($row->nbi_status == 'Approved') {
                    $nbi_status = '<span class="label label-lg label-light-success font-weight-bolder label-inline">Approved</span>';
                } elseif ($row->nbi_status == 'Rejected') {
                    $nbi_status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Rejected</span>';
                } elseif ($row->nbi_status == 'Cancelled') {
                    $nbi_status = '<span class="label label-lg label-light-danger font-weight-bolder label-inline">Cancelled</span>';
                } else{
                    $nbi_status = '-';
                }
                return $nbi_status;
            })
            // ->setRowClass(function($row){
            //     return $row?->markAsRead?->created_by === $this->user->id ? '' : 'bg-light-secondary';
            // })
            ->rawColumns(['is_active', 'code', 'bond_value','status', 'created_at', 'nbi_status']);
    }

    public function checkrights($row)
    {
        $menu = '';
        $editUrl = route('proposals.edit', [$row->id]);
        $deleteUrl = route('proposals.destroy', [$row->id]);

        if($this->user -> hasAnyAccess(['users.info', 'proposals.edit', 'proposals.delete', 'users.superadmin']))
        {
            $menu .= '<td class="text-center">
                        <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                        <a href="#" class="btn btn-hover-light-primary btn-sm btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ki ki-bold-more-hor"></i>
                        </a>
                        <div class="dropdown-menu m-0 dropdown-menu-left" style="">
                            <ul class="navi navi-hover">';
        }

        if($this->user -> hasAnyAccess(['proposals.edit', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $editUrl . '" data-url="' . $editUrl . '" class="navi-link">' .
            '<span class="navi-icon"><i class="fas fa-edit"></i></span><span class="navi-text">' . __('common.edit') . '</span>' .
            '</a></li>';
        }

        if($this->user -> hasAnyAccess(['proposals.delete', 'users.superadmin']))
        {
            $menu .= '<li class="navi-item"><a href="' . $deleteUrl . '" data-id="' . $row->id . '" data-table="dataTableBuilder" class="delete-confrim navi-link">' .
                '<span class="navi-icon"><i class="fas fa-trash-alt"></i></span><span class="navi-text">' . __('common.delete') . '</span>' .
                '</a></li>';
        }

        if($this->user -> hasAnyAccess(['users.info', 'users.superadmin']))
        {
            $menu .= getInfoHtml($row);
        }

        if($this->user -> hasAnyAccess(['users.info', 'proposals.edit', 'proposals.delete', 'users.superadmin']))
        {
            $menu .= "</ul></div></div></td>";
        }

        return $menu;
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Proposal $model)
    {
        $model = Proposal::with('markAsRead','contractor.user')->select('proposals.id',
        'proposals.created_at as created_at',  'proposals.bond_value', 'proposals.is_active as is_active', 'proposals.code as code', 'proposals.version as version', 'bond_types.name as bond_type', 'proposals.status', 'proposals.contractor_id as contractor_id', DB::raw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) as full_name"), 'beneficiaries.company_name as beneficiary_name', 'proposals.pd_project_name as project_name', 'proposals.tender_header as tender_header', 'principles.company_name as contractor_company_name', 'bond_policies_issue.reference_no as sys_gen_bond_number', 'bond_policies_issue.bond_number as insurer_bond_number', 'proposals.nbi_status')
        ->where(function($q){
            $q->where('proposals.is_amendment', '0')
            ->orWhere(function($q){
                $q->whereIn('proposals.status', ['Cancel', 'Rejected'])->where('proposals.version', 1)->where('proposals.is_amendment', 1);
            })
            ->orWhere(function($q){
                $q->where('proposals.nbi_status', 'Rejected')->where('proposals.version', 1)->where('proposals.is_amendment', 1);
            });
        })
        ->RoleBasedScope($this->role,$this->team_member_id)
        ->leftJoin('bond_types', 'proposals.bond_type_id', '=', 'bond_types.id')
        ->leftJoin('principles', function($join){
            $join->on('proposals.contractor_id', '=', 'principles.id');
        })->leftJoin('users', function($join){
            $join->on('principles.user_id', '=', 'users.id');
        })
        ->leftJoin('beneficiaries', 'proposals.beneficiary_id', '=', 'beneficiaries.id')
        ->leftJoin('bond_policies_issue', 'proposals.id', '=', 'bond_policies_issue.proposal_id')
        ->leftJoin('nbis', 'proposals.id', '=', 'nbis.proposal_id')
        ->whereNull('proposals.deleted_at')
        ->groupBy('proposals.id');

        // dd($model);

        $fullName = request()->get('full_name');

        if(request()->get('code')){
            $model->where('proposals.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('created_at')) {
            $model->where('proposals.created_at', 'like', '%' . request()->get('created_at') . '%');
        }

        if(request()->get('bond_value')) {
            $model->where('proposals.bond_value', 'like', '%' . request()->get('bond_value') . '%');
        }

        if (request()->get('bond_type')) {
            $model->where('bond_types.id', 'like', '%' . request()->get('bond_type') . '%');
        }

        if(request()->get('beneficiary_name')) {
            $model->where('beneficiaries.company_name', 'like', '%' . request()->get('beneficiary_name') . '%');
        }

        if (request()->get('contractor_company_name')) {
            $model->where('principles.company_name', 'like', '%' . request()->get('contractor_company_name') . '%');
        }

        // if(request()->get('full_name')) {
        //     $model->where('full_name', 'like', '%' . request()->get('full_name') . '%');
        // }

        if (request()->get('full_name',false)) {
            $model->whereHas('contractor.user',function($q) use($fullName){
                $q->whereRaw("CONCAT_WS(' ',users.first_name,users.middle_name,users.last_name) LIKE ?", '%' . $fullName . '%');
            });
        }

        if (request()->get('status')) {
            $model->where('proposals.status', 'like', '%' . request()->get('status') . '%');
        }

        if(request()->get('project_name')) {
            $model->where('proposals.pd_project_name', 'like', '%' . request()->get('project_name') . '%');
        }

        if(request()->get('tender_header')) {
            $model->where('proposals.tender_header', 'like', '%' . request()->get('tender_header') . '%');
        }

        if(request()->get('sys_gen_bond_number')) {
            $model->where('bond_policies_issue.reference_no', 'like', '%' . request()->get('sys_gen_bond_number') . '%');
        }

        if(request()->get('insurer_bond_number')) {
            $model->where('bond_policies_issue.bond_number', 'like', '%' . request()->get('insurer_bond_number') . '%');
        }

        if(request()->get('nbi_status')) {
            $model->where('nbis.status', 'like', '%' . request()->get('nbi_status') . '%');
        }

        if (request()->get('filter_bond_type')) {
            $model->where('bond_types.id', 'like', '%' . request()->get('filter_bond_type') . '%');
        }

        if (request()->get('filter_status')) {
            $model->where('proposals.status', 'like', '%' . request()->get('filter_status') . '%');
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
            ['name' => 'proposals', 'data' => 'proposals', 'title' => trans("proposals.proposals")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Proposal_' . date('YmdHis');
    // }
}
