<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    BondTypeWiseExport,
};
use App\Models\Setting;

class BondTypeWiseReportController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:bond_type_wise.list');
        $this->title = __('reports.bond_type_wise');
        $this->common = new CommonController();
        view()->share('title', $this->title);
        $this->fields = collect(config('report.bond_type_wise'));
    }

    public function index(){
        $bond_types = $this->common->getBondTypes();
        $this->data['bond_types'] = $bond_types;
        $this->data['fields'] = $this->fields->chunk(4);
        $this->data['status'] = Config('srtpl.report_filter.bond_type_wise_report.status');
        return view('reports.bond_type_wise.index',$this->data);
    }

    public function show(Request $request)
    {
        $selected_bond_type = $request->selected_bond_type;
        $selected_bond_status = $request->selected_bond_status;
        $checked_fields = $request->multicheckbox;
        $bond_types = $this->common->getBondTypes();
        $this->data['bond_types'] = $bond_types;
        $this->data['status'] = Config('srtpl.report_filter.bond_type_wise_report.status');
        $this->data['fields'] = $this->fields;
        $this->data['chunk_fields'] = $this->fields->chunk(4);
        $this->data['selected_bond_type'] = $selected_bond_type;
        $this->data['selected_bond_status'] = $selected_bond_status;
        $this->data['checked_fields'] = $checked_fields;

        return view('reports.bond_type_wise.show',$this->data);
    }

    public function datalist(Request $request)
    {
        $selected_bond_type = $request->selected_bond_type;
        $selected_bond_status = $request->selected_bond_status;
        $checked_fields = $request->multicheckbox; 
        $expiring_bond = Setting::where('name', 'expiring_bond')->pluck('value')->first() ?? 0;

        $bond_type_wise_data_query = DB::table('proposals')
            ->where(['bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,])
            ->select([
                'bond_policies_issue.reference_no as bond_number',
                'bond_policies_issue.bond_number as insurer_bond_number',
                'bond_types.name as bond_type',
                'proposals.bond_value',
                'proposals.bond_start_date',
                'proposals.bond_end_date',
                'bond_policies_issue.bond_conditionality',
                'beneficiaries.code as beneficiary_id',
                'beneficiaries.company_name as beneficiary_name',
                'project_details.code as project_id',
                'project_details.project_value',
                'principles.company_name as contractor_name',
                'principles.pan_no as contractor_pan_no',
                'tenders.contract_value',
                'tenders.bond_value as bond_exposure',
                DB::raw('(CASE WHEN bond_policies_issue.bond_period_end_date < CURDATE() THEN "Yes" ELSE "No" END) as expired_bond'),
                DB::raw('(CASE WHEN DATE_SUB(bond_policies_issue.bond_period_end_date, INTERVAL ' . (int)$expiring_bond . ' DAY) <= CURDATE() AND bond_policies_issue.bond_period_end_date > CURDATE() THEN "Yes" ELSE "No" END) as expiring_bond'),
                'proposals.status as bond_status',
                DB::raw('CONCAT(principles.code, " | ", principles.company_name) as list_of_contractors_applied'),
                're_insurance_groupings.name as re_insurance_grouping',
                'bond_policies_issue_checklist.intermediary_detail_type',
                'bond_policies_issue_checklist.intermediary_detail_name',
                'bond_policies_issue_checklist.intermediary_detail_mobile',
                'bond_policies_issue_checklist.intermediary_detail_address',
            ])
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
            ->leftJoin('beneficiaries', 'proposals.beneficiary_id', 'beneficiaries.id')
            ->leftJoin('project_details', 'proposals.project_details', 'project_details.id')
            ->leftJoin('tenders', 'proposals.tender_details_id', 'tenders.id')
            ->leftJoin('bond_policies_issue', 'proposals.id', 'bond_policies_issue.proposal_id')
            ->leftJoin('bond_policies_issue_checklist', 'proposals.id', 'bond_policies_issue_checklist.proposal_id')
            ->when($selected_bond_type, function($q) use($selected_bond_type) {
                $q->where('proposals.bond_type', $selected_bond_type);
            })
            ->when($selected_bond_status,function($q)use($selected_bond_status){
                $q->where('proposals.status',$selected_bond_status);
            });

        if($request->wantsJson()){
            $bond_type_wise_data = $bond_type_wise_data_query->paginate(500);
            $this->data['bond_type_wise_data'] = $bond_type_wise_data;
            $this->data['checked_fields'] = $checked_fields;

            return response()->json([
                'html' => view('reports.bond_type_wise.list', $this->data)->render(),
            ]);
        }
        else {
            $bond_type_wise_data =  $bond_type_wise_data_query->get();
            return $bond_type_wise_data;
        }
    }

    public function excel(Request $request){
        $this->data['checkedFields'] = $request->checked_fields;
        $this->data['bond_type_wise_data'] = $this->datalist(Request());
        return Excel::download(new BondTypeWiseExport($this->data),'bond_type_wise.xlsx');
    }
}
