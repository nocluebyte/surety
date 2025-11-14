<?php

namespace App\DataTables;

use App\Models\{
    Cases,
    UnderWriter
};
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Request;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DB;
use Sentinel;

class CasesDataTable extends DataTable
{
    public function __construct(){
        $this->user = Sentinel::getUser();
        $this->role = $this->user?->roles?->first()?->slug;
        $this->underwriter = UnderWriter::firstWhere('user_id', $this->user?->id);
    }

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {

               return $this->hasAnyAction($row);
            })
            ->editColumn('contractor_name',function($row){
                return $this->checkViewrights($row);
            })
            ->addColumn('dms', function ($row) {
                if($row->user_id){
                    return '<a href="' . route('cases.caseDmsMail', [encryptId($row->user_id)]) . '" data-toggle="modal" data-target-modal="#commonModalID"  data-url="' . route('cases.caseDmsMail', [encryptId($row->user_id)]) . '" class="call-modal navi-link" type="button" title="Send Mail"><i class="fa fa-envelope"></i></a>'; 
                } else {
                    return ' - ';
                }            
            })
            ->editColumn('date', fn($row) => custom_date_format($row->date, 'd/m/Y'))
            ->editColumn('underwriter_assigned_date', fn($row) => isset($row->underwriter_assigned_date) ? custom_date_format($row->underwriter_assigned_date, 'd/m/Y | H:i') : '-')
            ->editColumn('underwriter', fn($row) => empty($row->underwriter) ? '-' : $row->underwriter)
            ->editColumn('generated_from', function($row) {
                return $row->generated_from;
            })
            ->rawColumns(['dms', 'action','contractor_name'])
            // ->setRowClass(function($row){
            //     return $row?->markAsRead?->created_by === $this?->user?->id ? ' ' : 'bg-light-secondary' ;
            //  })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Cases $model)
    {
        $company_name = request()->get('company_name',null);
        $status = request()->get('status',null);
        $type = request()->get('type',null);
        $category = request()->get('category',null);
        $date = request()->get('date',null);
        $underwriter = request()->get('underwriter',null);
        $underwriter_assigned_date = request()->get('underwriter_assigned_date', null);
        $filter_underwriter = request()->get("filter_underwriter",null);
        $beneficiary_name = request()->get('beneficiary_name', null);

        $field = [
            //DB::raw("CONCAT_WS(' ',bu.first_name,bu.middle_name,bu.last_name) as underwriter"),
            DB::raw("
                CASE 
                    WHEN cases.underwriter_type = 'Underwriter' THEN CONCAT_WS(' ',bu.first_name,bu.middle_name,bu.last_name)
                    WHEN cases.underwriter_type = 'User' THEN CONCAT_WS(' ',uu.first_name,uu.middle_name,uu.last_name)
                END AS underwriter

            "),
            DB::raw("
                CASE 
                    WHEN cases.casesable_type = 'Proposal' THEN beneficiaries.company_name
                    WHEN cases.casesable_type = 'Beneficiary' THEN beneficiaries.company_name
                    ELSE NULL 
                 END AS beneficiary_name
            "),
            DB::raw("
                CASE 
                    WHEN cases.casesable_type = 'Principle' THEN principles.company_name
                    WHEN cases.casesable_type = 'Proposal' THEN pcontractor.company_name    
                    WHEN cases.casesable_type = 'InvocationNotification' THEN invocation_review.company_name                             
                    ELSE NULL 
                 END AS contractor_name
            "),
            DB::raw("
                CASE 
                    WHEN cases.casesable_type = 'Beneficiary' THEN bu.id
                    WHEN cases.casesable_type = 'Principle' THEN bu.id
                    WHEN cases.casesable_type = 'Proposal' THEN bu.id
                    WHEN cases.casesable_type = 'InvocationNotification' THEN bu.id                                        
                    ELSE NULL 
                 END AS user_id
            "),                  
            DB::raw("CASE 
                    WHEN cases.status = 'Transfer' THEN 'Pending' 
                    ELSE cases.status
                    END AS status"),
            'cases.case_type',
            'cases.underwriter_assigned_date',
            'cases.id',
            DB::raw(
        "CASE 
                    WHEN proposals.version = 1  THEN CONCAT(cases.casesable_type,' | ','New') 
                    WHEN proposals.version > 1   THEN CONCAT(cases.casesable_type,' | ','Amendment')
                    ELSE cases.casesable_type
                    END AS generated_from
            "),
            'cases.created_at as date',
            DB::raw('(SELECT COUNT(*) FROM cases_decisions WHERE cases_decisions.cases_id = cases.id) as has_decisions'),
             DB::raw('(SELECT COUNT(*) FROM cases_limit_strategys WHERE cases_limit_strategys.cases_id = cases.id) as has_cases_limit_strategys'),
              DB::raw('(SELECT COUNT(*) FROM cases_bond_limit_strategies WHERE cases_bond_limit_strategies.cases_id = cases.id) as has_cases_bond_limit_strategies')
            
        ];
        $model = Cases::with(['markAsRead'=>fn($q)=> $q->where('created_by',$this->user->id)])->RoleBasedScope($this->role,$this->underwriter?->id)->select($field)
            ->whereIn('cases.status', ['Pending','Transfer'])
            ->leftJoin('beneficiaries', function ($join) {
                $join->on('cases.beneficiary_id', '=', 'beneficiaries.id');
                // $join->orOn('cases.casesable_id', '=', 'beneficiaries.id');
                $join->whereIn('cases.casesable_type',['Proposal','Beneficiary']);
                $join->whereNull('beneficiaries.deleted_at');
            })
            ->leftJoin('principles', function ($join) {                
                $join->on('cases.casesable_id', '=', 'principles.id');
                $join->where('cases.casesable_type', '=', 'Principle');                
                $join->whereNull('principles.deleted_at');

            })
            ->leftJoin('principles as pcontractor', function ($join) {
                $join->on('cases.contractor_id', '=', 'pcontractor.id');
                $join->where('cases.casesable_type', '=', 'Proposal');                         
                $join->whereNull('pcontractor.deleted_at');

            })
            ->leftJoin('principles as invocation_review', function ($join) {                
                $join->on('cases.contractor_id', '=', 'invocation_review.id');
                $join->where('cases.casesable_type', '=', 'InvocationNotification');                
                $join->whereNull('invocation_review.deleted_at');

            })
            ->leftJoin('proposals', function ($join) {
                $join->on('cases.casesable_id', '=', 'proposals.id');
                $join->where('cases.casesable_type', '=', 'Proposal');
                $join->whereNull('proposals.deleted_at');

            })
            // ->leftJoin('bid_bonds', function ($join) {
            //     $join->on('cases.casesable_id', '=', 'bid_bonds.id');
            //     $join->whereIn('cases.casesable_type', ['BidBond','InvocationNotification-BidBond']);
            //     $join->whereNull('bid_bonds.deleted_at');
            // })
            // ->leftJoin('performance_bonds', function ($join) {
            //     $join->on('cases.casesable_id', '=', 'performance_bonds.id');
            //     $join->whereIn('cases.casesable_type',['PerformanceBond','InvocationNotification-PerformanceBond']);
            //     $join->whereNull('performance_bonds.deleted_at');
            // })
            // ->leftJoin('advance_payment_bonds', function ($join) {
            //     $join->on('cases.casesable_id', '=', 'advance_payment_bonds.id');
            //     $join->whereIn('cases.casesable_type',['AdvancePaymentBond','InvocationNotification-AdvancePaymentBond']);
            //     $join->whereNull('advance_payment_bonds.deleted_at');
            // })
            // ->leftJoin('retention_bonds', function ($join) {
            //     $join->on('cases.casesable_id', '=', 'retention_bonds.id');
            //     $join->whereIn('cases.casesable_type', ['RetentionBond','InvocationNotification-RetentionBond']);
            //     $join->whereNull('retention_bonds.deleted_at');
            // })
            // ->leftJoin('maintenance_bonds', function ($join) {
            //     $join->on('cases.casesable_id', '=', 'maintenance_bonds.id');
            //     $join->whereIn('cases.casesable_type', ['MaintenanceBond','InvocationNotification-MaintenanceBond']);
            //     $join->whereNull('maintenance_bonds.deleted_at');
            // })
            
            // ->leftJoin('principles as pbc', function ($join) {
            //     // $join->on('bid_bonds.contractor_id', '=', 'pbc.id');
            //     // $join->orOn('performance_bonds.contractor_id', '=', 'pbc.id');
            //     // $join->orOn('advance_payment_bonds.contractor_id', '=', 'pbc.id');
            //     // $join->orOn('retention_bonds.contractor_id', '=', 'pbc.id');
            //     // $join->orOn('maintenance_bonds.contractor_id', '=', 'pbc.id');
            //     $join->whereNotIn('cases.casesable_type', ['Proposal','Principle']);
            //     $join->whereNull('pbc.deleted_at');
            // })
            ->leftJoin('underwriters', function ($join) {
                $join->on('cases.underwriter_id', '=', 'underwriters.id');
            })
            ->leftJoin('users as bu', function ($join) {
                $join->on('underwriters.user_id', '=', 'bu.id');             
                $join->whereNull('bu.deleted_at');
            })
            ->leftJoin('users as uu', function ($join) {
                $join->on('cases.underwriter_id', '=', 'uu.id');             
                $join->whereNull('bu.deleted_at');
            })
            ->when($company_name, function ($q) use ($company_name) {
                $q->where(DB::raw("
            CASE
                WHEN cases.casesable_type = 'Beneficiary' 
                THEN beneficiaries.company_name
                WHEN cases.casesable_type = 'Principle'
                THEN principles.company_name
                WHEN cases.casesable_type = 'Proposal'
                THEN pcontractor.company_name
                WHEN cases.casesable_type = 'InvocationNotification'
                THEN invocation_review.company_name
                ELSE NULL
            END
        "), 'LIKE', '%' . $company_name . '%');
            })
            ->when($beneficiary_name, function($q) use($beneficiary_name) {
                $q->where('beneficiaries.company_name', 'LIKE', '%' . $beneficiary_name . '%');
            })
            ->when(in_array($this->role,['risk-underwriter','commercial-underwriter']),function($q){
                $q->where('cases.underwriter_id',$this->underwriter ->id);
            })
            ->when($status, function ($q) use ($status) {
                $q->where('cases.status', 'LIKE', '%' . $status . '%');
            })
            ->when($type, function ($q) use ($type) {
                $q->where('cases.casesable_type', 'LIKE', '%' . $type . '%');
            })
            ->when($category, function ($q) use ($category) {
                $q->where('cases.case_type', 'LIKE', '%' . $category . '%');
            })
            ->when($date, function ($q) use ($date) {
                $q->where('cases.created_at', 'LIKE', '%' . $date . '%');
            })
            ->when($underwriter, function ($q) use ($underwriter) {
                $q->whereRaw("CASE 
                    WHEN cases.underwriter_type = 'Underwriter' THEN CONCAT_WS(' ',bu.first_name,bu.middle_name,bu.last_name)
                    WHEN cases.underwriter_type = 'User' THEN CONCAT_WS(' ',uu.first_name,uu.middle_name,uu.last_name)
                END LIKE ?", '%' . $underwriter . '%');
            })
            ->when($underwriter_assigned_date, function ($q) use ($underwriter_assigned_date) {
                $q->where('cases.underwriter_assigned_date', 'LIKE', '%' . $underwriter_assigned_date . '%');
            });

        if (request()->get('filter_underwriter')) {
            $model->whereHas('underwriter', function ($q) use($filter_underwriter)  {
                list($underwriter_type,$underwriter_id) = parseGroupedOptionValue($filter_underwriter);  
                $q->where([
                    "underwriter_id" => $underwriter_id ,
                    "underwriter_type" => $underwriter_type,
                ]);
            });
        }

        if (request()->get('filter_case_type', false)) {
            $model->where('cases.case_type', request()->get("filter_case_type"));
        }

        if (request()->get('filter_generated_from', false)) {
            $model->where('cases.casesable_type', request()->get("filter_generated_from"));
        }

         //dd($model->get());

        return $this->applyScopes($model);
    }

    public function checkViewrights($row){
        //dump($row->company_name);
        $contractor_name = $row->contractor_name ?? '';
        $route = route('cases.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['cases.view', 'users.superadmin'])) {
            $value =  "<a href='{$route}'>{$contractor_name}</a>";
        }
        else{
            $value = $contractor_name;
        }
        return $value;
    }

    public function hasAnyAction($row){

        $Actionhtml = '';

        if (array_sum([$row['has_decisions'], $row['has_cases_limit_strategys'], $row['has_cases_bond_limit_strategies']]) <= 0) {
            $Actionhtml = '<td class="text-center">
                    <div class="dropdown dropdown-inline text-center" title="" data-placement="left" data-original-title="Quick actions">
                    <center>
            
                    <label class="checkbox checkbox-lg">
                                            <input type="checkbox" class="checkbox_animated checkRow" value="' . $row->id . '" name="multichkbox[]">
                                            <span></span>
                                        </label>
                    </center></div></td>';
        }

        return $Actionhtml;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('cases-table')
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
        return 'Cases_' . date('YmdHis');
    }
}
