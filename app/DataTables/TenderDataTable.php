<?php

namespace App\DataTables;

use App\Models\Tender;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\CommonController;

class TenderDataTable extends DataTable
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
            ->editColumn('is_active', function ($row){
                return getStatusHtml($row);
            })
            ->editColumn('contract_value', function ($row) {
                return numberFormatPrecision($row->contract_value, 0);
            })
            ->editColumn('rfp_date', fn($row) => custom_date_format($row->rfp_date, 'd/m/Y'))
            ->rawColumns(['code', 'is_active']);
    }

    public function checkViewrights($row){

        $code = $row->code ?? '';
        $route = route('tender.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['tender.view','users.superadmin'])) {
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
    public function query(Tender $model)
    {
        $model = Tender::RoleBasedScope($this->role,$this->team_member_id)->select('tenders.id','tenders.contract_value', 'tenders.period_of_contract', 'tenders.phone_no as tenders_phone_no', 'tenders.rfp_date', 'tenders.is_active', 'tenders.code', 'tenders.type_of_contracting', 'bond_types.name as bond_type', 'tenders.tender_header', 'tenders.tender_id', 'tenders.pd_project_name as project_name', 'beneficiaries.company_name as beneficiary_name', 'project_types.name as project_type')
            ->leftJoin('bond_types', 'tenders.bond_type_id', '=', 'bond_types.id')
            ->leftJoin('beneficiaries', 'tenders.beneficiary_id', '=', 'beneficiaries.id')
            ->leftJoin('project_types', 'tenders.project_type', 'project_types.id')
            ->whereNull('tenders.deleted_at')
            ->groupBy('tenders.id');

        $fullName = request()->get('full_name');

        if(request()->get('code')) {
            $model->where('tenders.code', 'like', '%' . request()->get('code') . '%');
        }

        if(request()->get('tender_header')) {
            $model->where('tenders.tender_header', 'like', '%' . request()->get('tender_header') . '%');
        }

        // if (request()->get('full_name',false)) {
        //     $model->whereRaw("CONCAT_WS(' ',first_name,middle_name,last_name) LIKE ?", '%' . $fullName . '%');
        // }

        // if(request()->get('email')) {
        //     $model->where('tenders.email', 'like', '%' . request()->get('email') . '%');
        // }

        if(request()->get('contract_value')) {
            $model->where('contract_value', 'like', '%' . str_replace(',', '', request()->get('contract_value')) . '%');
        }

        // if (request()->get('bond_type')) {
        //     $model->where('bond_types.name', 'like', '%' . request()->get('bond_type') . '%');
        // }

        if(request()->get('type_of_contracting')) {
            $model->where('type_of_contracting', 'like', '%' . request()->get('type_of_contracting') . '%');
        }

        if(request()->get('tender_id')) {
            $model->where('tender_id', 'like', '%' . request()->get('tender_id') . '%');
        }

        if(request()->get('project_name')) {
            $model->where('tenders.pd_project_name', 'like', '%' . request()->get('project_name') . '%');
        }

        if(request()->get('beneficiary_name')) {
            $model->where('beneficiaries.company_name', 'like', '%' . request()->get('beneficiary_name') . '%');
        }

        // if (request()->get('bond_type_id')) {
        //     $model->whereHas('bondType', function ($q) {
        //         $q->where('id', request()->get("bond_type_id"));
        //     });
        // }

        if (request()->get('filter_beneficiary_id')) {
            $model->where('tenders.beneficiary_id', request()->get("filter_beneficiary_id"));
        }

        if (request()->get('filter_project_type')) {
            $model->where('tenders.project_type', request()->get('filter_project_type'));
        }

        if (request()->get('filter_type_of_contracting', false)) {
            $model->where('type_of_contracting', request()->get("filter_type_of_contracting"));
        }

        // if(request()->get('period_of_contract')) {
        //     $model->where('period_of_contract', 'like', '%' . request()->get('period_of_contract') . '%');
        // }

        // if(request()->get('phone_no')) {
        //     $model->where('tenders.phone_no', 'like', '%' . request()->get('phone_no') . '%');
        // }

        if(request()->get('rfp_date')) {
            $model->where('rfp_date', 'like', '%' . request()->get('rfp_date') . '%');
        }

        if(request()->get('project_type')) {
            $model->where('project_types.name', 'like', '%' . request()->get('project_type') . '%');
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
            ['name' => 'tender', 'data' => 'tender', 'title' => trans("tender.tender")],
            ['data' => 'action', 'name' => 'action', 'title' => trans("comman.action"), 'render' => null, 'orderable' => false, 'searchable' => false, 'exportable' => false, 'printable' => false, 'footer' => '', 'width' => '80px'],
        ];
    }

    /**
     * Get the filename for export.
     */
    // protected function filename(): string
    // {
    //     return 'Tender_' . date('YmdHis');
    // }
}
