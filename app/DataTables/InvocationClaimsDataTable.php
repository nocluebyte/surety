<?php

namespace App\DataTables;

use App\Models\InvocationClaims;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Sentinel;
use Localization;
use Illuminate\Support\Facades\DB;

class InvocationClaimsDataTable extends DataTable
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
            ->editColumn('code',function($row){
                return $this->checkViewrights($row);
            }) 
            ->editColumn('contractor', function($row) {
                return '<a href="' . route('principle.show', [encryptId($row->contractor_id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->contractor.'</span></a> ';
            })  
            ->editColumn('total_bond_value', function ($row) {
                return numberFormatPrecision($row->total_bond_value, 0);
            })
            ->editColumn('contract_price', function ($row) {
                return numberFormatPrecision($row->contract_price, 0);
            })
            ->editColumn('proposal', function($row) {
                return '<a href="' . route('proposals.show', [encryptId($row->proposal_id)]) . '" class="navi-link" target="_self">' .
                        '<span class="navi-text rm-text">' . $row->proposal_code.'/V'.$row->version.'</span></a> ';
            })   
            ->rawColumns(['code','contractor', 'proposal']);
    }

    public function checkrights($row)
    {
        
    }

    public function checkViewrights($row){
        //dump($row->company_name);
        $code = $row->code ?? '';
        $route = route('invocation-claims.show',[encryptId($row->id)]);
        
        if ($this->user->hasAnyAccess(['invocation_claims.view', 'users.superadmin'])) {
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
    public function query(InvocationClaims $model)
    {
        $slug = $this->user->roles->pluck('slug')->first();

        $model = InvocationClaims::select('invocation_claims.id','invocation_claims.proposal_id',
        DB::raw("invocation_claims.code"),
        DB::raw("p.code as proposal_code"),
        DB::raw("p.version"),
        DB::raw("p.bond_value"),
        DB::raw("p.contractor_id"),
        'bt.name as bond_type',   
        'c.company_name as contractor',       
        DB::raw("DATE_FORMAT(invocation_claims.invocation_claim_date, '%d/%m/%Y') as invocation_claim_date"), 
        'invocation_claims.claimed_amount','invocation_claims.total_claim_approved')
            ->join('bond_types as bt',function($join){
                $join->on('invocation_claims.bond_type','=','bt.id');               
                $join->whereNull('bt.deleted_at');
            })
            ->join('proposals as p',function($join){
                $join->on('invocation_claims.proposal_id','=','p.id');
                $join->whereNull('p.deleted_at');
            })            
            ->join('principles as c',function($join){
                $join->on('p.contractor_id','=','c.id');                           
                $join->whereNull('c.deleted_at');
            });           

        if(request()->get('proposal')){
            $model->where('p.code', 'like', '%' . request()->get('proposal') . '%')->orwhere('p.version', 'like', '%' . request()->get('proposal') . '%');
        }
        
        if(request()->get('contractor')){
            $model->where('c.company_name', 'like', '%' . request()->get('contractor') . '%');
        }

        if(request()->get('bond_type')) {
            $model->where('bt.name', 'like', '%' . request()->get('bond_type') . '%');
        }

        if(request()->get('bond_value')) {
            $model->where('p.bond_value', 'like', '%' . request()->get('bond_value') . '%');
        }
        if(request()->get('invocation_claim_date')) {
            $model->where(DB::raw("DATE_FORMAT(invocation_claims.invocation_claim_date, '%d/%m/%Y')"), 'like', '%' . request()->get('invocation_claim_date') . '%');
        }
        if(request()->get('claimed_amount')) {
            $model->where('invocation_claims.claimed_amount', 'like', '%' . request()->get('claimed_amount') . '%');
        }
        if(request()->get('total_claim_approved')) {
            $model->where('invocation_claims.total_claim_approved', 'like', '%' . request()->get('total_claim_approved') . '%');
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
