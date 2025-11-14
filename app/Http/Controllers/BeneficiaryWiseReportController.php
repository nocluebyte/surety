<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    BeneficiaryWiseExport,
};

class BeneficiaryWiseReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:beneficiary_wise.list');
        $this->title = __('reports.beneficiary_wise');
        $this->common = new CommonController();
        view()->share('title', $this->title);
        $this->fields = collect(config('report.beneficiary_wise'));
    }

    public function index(){
        $beneficiary = $this->common->getBeneficiary();
        $this->data['beneficiary'] = $beneficiary;
        $this->data['status'] = Config('srtpl.filters.proposal_status_filter');
        $this->data['fields'] = $this->fields->chunk(4);
        return view('reports.beneficiary_wise.index',$this->data);
    }

    public function show(Request $request)
    {
        $selected_beneficiary = $request->selected_beneficiary;
        $selected_status = $request->selected_status;
        $checked_fields = $request->multicheckbox;
        $beneficiary = $this->common->getBeneficiary();
        $this->data['beneficiary'] = $beneficiary;
        $this->data['status'] = Config('srtpl.filters.proposal_status_filter');
        $this->data['fields'] = $this->fields;
        $this->data['chunk_fields'] = $this->fields->chunk(4);
        $this->data['selected_beneficiary'] = $selected_beneficiary;
        $this->data['selected_status'] = isset($selected_status) ? implode(',' ,$selected_status) : '';
        $this->data['checked_fields'] = $checked_fields;

        return view('reports.beneficiary_wise.show',$this->data);
    }

    public function datalist(Request $request)
    {
        $selected_beneficiary = $request->selected_beneficiary;
        $selected_status = isset($request->selected_status) ? array_filter($request->selected_status) : '';
        $checked_fields = $request->multicheckbox;

        $beneficiary_wise_data_query = DB::table('beneficiaries')
            ->select([
                'proposals.code as proposal_id',
                'proposals.version',
                'beneficiaries.code as beneficiary_id',
                'beneficiaries.company_name as beneficiary_name',
                'beneficiaries.pan_no as beneficiary_pan_no',
                'beneficiaries.beneficiary_type',
                'principles.code as contractor_id',
                'principles.company_name as contractor_name',
                // 'principles.pan_no as contractor_pan_no',
                'project_details.code as project_id',
                'project_details.project_name as project_title',
                'project_details.project_value',
                'project_details.project_start_date',
                'project_details.project_end_date',
                'tenders.code as tender_details_id',
                'tenders.tender_id as tender_id',
                'tenders.tender_header',
                'tenders.contract_value',
                'bond_types.name as bond_type',
                'proposals.bond_value',
                'proposals.bond_start_date',
                'proposals.bond_end_date',
                // 'proposals.bond_period',
                'bond_policies_issue.reference_no as sys_gen_bond_number',
                'bond_policies_issue.bond_number as insurer_bond_number',
                // DB::raw("CONCAT_WS(' - ', bond_policies_issue.reference_no, bond_policies_issue.bond_number) as bond_issue_number"),
                // 'bond_policies_issue.premium_amount as premium_amount',
                // 'bond_policies_issue.premium_date as premium_date',
                // 're_insurance_groupings.name as re_insurance_grouping',
                'proposals.status',
            ])
            ->leftJoin('bond_policies_issue', function($join){
                $join->on('beneficiaries.id', 'bond_policies_issue.beneficiary_id')
                ->where('bond_policies_issue.is_amendment', '=', 0);
            })
            ->leftJoin('proposals', function($join) {
                $join->on('bond_policies_issue.proposal_id', '=', 'proposals.id')
                    ->where('bond_policies_issue.is_amendment', '=', 0)
                    ->where('proposals.is_issue', '=', 1);
            })
            ->leftJoin('bond_types', 'proposals.bond_type', 'bond_types.id')
            ->leftJoin('principles', 'proposals.contractor_id', 'principles.id')
            ->leftJoin('nbis',function($join){
              $join->on('proposals.id','=','nbis.proposal_id')
              ->where('nbis.status','=','Approved');
            })
            ->leftJoin('re_insurance_groupings',function($join){
                $join->on('nbis.re_insurance_grouping_id','=','re_insurance_groupings.id')
                ->where('nbis.status','=','Approved');
            })
            ->leftJoin('project_details', 'proposals.project_details', 'project_details.id')
            ->leftJoin('tenders', 'proposals.tender_details_id', 'tenders.id')
            ->when($selected_beneficiary, function($q) use($selected_beneficiary) {
                $q->where('proposals.beneficiary_id', $selected_beneficiary);
            })
            ->when($selected_status, function($q) use ($selected_status) {
                $q->whereIn('proposals.status', $selected_status);
            })
            ->orderBy('beneficiaries.id');

            if($request->wantsJson()){
               $beneficiary_wise_data =  $beneficiary_wise_data_query->paginate(500);
                $this->data['beneficiary_wise_data'] = $beneficiary_wise_data;
                $this->data['checked_fields'] = $checked_fields;

                return response()->json([
                    'html' => view('reports.beneficiary_wise.list', $this->data)->render(),
                ]);
            }
            else {
                $beneficiary_wise_data =  $beneficiary_wise_data_query->get();
                return $beneficiary_wise_data;
            }
    }

    public function excel(Request $request){
        $this->data['checkedFields'] = $request->checked_fields;
        $this->data['beneficiary_wise_data'] = $this->datalist(Request());
        return Excel::download(new BeneficiaryWiseExport($this->data),'beneficiary_wise.xlsx');
    }
}
