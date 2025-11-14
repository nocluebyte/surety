<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Illuminate\Http\Request;
use DB;
use PhpParser\Node\Expr\AssignOp\Concat;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    ContractorWiseExport,
};
use App\Models\Setting;

class ContractorWiseReportController extends Controller
{
      public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:contractor_wise.list');
        $this->title = __('reports.contractor_wise');
        $this->common = new CommonController();
        $this->fields = collect(config('report.contractor_wise'));
        view()->share('title', $this->title);
    }
    public function index(){

        $contractor = $this->common->getContractor();
        $this->data['contractor'] = $contractor;
        $this->data['status'] = Config('srtpl.filters.proposal_status_filter');
        $this->data['fields'] = $this->fields->chunk(4);
        return view('reports.contractor_wise.index',$this->data);
    }

    public function show(Request $request){

        $contractor_filter = $request->contractor;
        $selected_status = $request->selected_status;
        $checked_fields = $request->multicheckbox;
        $contractor = $this->common->getContractor();
        $this->data['contractor'] = $contractor; 
        $this->data['status'] = Config('srtpl.filters.proposal_status_filter');
        $this->data['fields'] = $this->fields;
        $this->data['chunk_fields'] = $this->fields->chunk(4);
        $this->data['contractor_filter'] = $contractor_filter;
        $this->data['selected_status'] = isset($selected_status) ? implode(',' ,$selected_status) : '';
        $this->data['checked_fields'] = $checked_fields;

        return view('reports.contractor_wise.show',$this->data);

    }

    public function datalist(Request $request){

        $contractor_filter = $request->contractor;
        $selected_status = $request->selected_status;
        $checked_fields = $request->multicheckbox; 
        $expiring_bond = Setting::where('name', 'expiring_bond')->pluck('value')->first() ?? 0;

        $agencyRatings = DB::table('agency_rating_details')
            ->selectRaw('agency_rating_details.agencyratingdetailsable_id as contractor_id,
                GROUP_CONCAT(DISTINCT " ", agencies.agency_name, " | ", agency_rating_details.rating, " | ", agency_rating_details.rating_date) as agency_ratings')
            ->join('agencies', 'agency_rating_details.agency_id', '=', 'agencies.id')
            ->where('agency_rating_details.agencyratingdetailsable_type', 'Principle')
            ->whereNull('agency_rating_details.deleted_at')
            ->groupBy('agency_rating_details.agencyratingdetailsable_id');

        $nbisApproved = DB::table('nbis')
            ->select('proposal_id', 'cash_margin_if_applicable', 'cash_margin_amount', 'trade_sector_id', 're_insurance_grouping_id')
            ->where('status', 'Approved');

        // $premiumAgg = DB::table('nbis')
        //     ->selectRaw('contractor_id, SUM(net_premium) as total_premium_earnings')
        //     ->where('status', 'Approved')
        //     ->groupBy('contractor_id');

        // $casesDecision = DB::table('cases as principleCases')
        //     ->select('principleCases.contractor_id', 'principleCases.decision_taken_date', 'cases_decisions.remark as decision_remarks')
        //     ->join('cases_decisions', 'cases_decisions.contractor_id', '=', 'principleCases.contractor_id')
        //     ->where([
        //         ['principleCases.casesable_type', '=', 'Proposal'],
        //         ['principleCases.decision_status', '!=', null],
        //         ['principleCases.is_amendment', '=', 0],
        //         ['principleCases.is_bond_managment_action_taken', '=', 0],
        //     ]);

        $casesDecision = DB::table('cases as principleCases')
            ->select('principleCases.proposal_id', 'principleCases.contractor_id', 'principleCases.decision_taken_date', 'cases_decisions.remark as decision_remarks')
            ->join('cases_decisions', 'cases_decisions.proposal_id', '=', 'principleCases.proposal_id')
            ->where([
                ['principleCases.casesable_type', '=', 'Proposal'],
                ['principleCases.decision_status', '!=', null],
                ['principleCases.is_amendment', '=', 0],
                ['principleCases.is_bond_managment_action_taken', '=', 0],
            ]);

        $limitStrategy = DB::table('cases_limit_strategys')
            ->select('casesable_id', 'proposed_individual_cap', 'proposed_overall_cap', 'proposed_group_cap', 'proposed_valid_till')
            ->where('is_current', 0);

        $adverseInformation = DB::table('adverse_informations')
        ->selectRaw(
            'adverse_informations.contractor_id,
            GROUP_CONCAT(DISTINCT " ", adverse_informations.code," | ",adverse_informations.adverse_information) adverse_information_details')
        ->groupBy('adverse_informations.contractor_id');

        $blackListInformation = DB::table('blacklists')
        ->selectRaw(
            'blacklists.contractor_id,
            GROUP_CONCAT(DISTINCT " ", blacklists.code," | ",blacklists.reason) blacklisted_details')
        ->groupBy('blacklists.contractor_id');


        $contractor_wise_data_query = DB::table('principles')
            ->select([
                'proposalCases.created_at as application_date',
                'proposals.code as proposal_id',
                'proposals.version',
                'principles.code as contractor_id',
                'principles.company_name as contractor_name',
                'principles.pan_no as contractor_pan_no',
                'states.name as state',
                'countries.name as country',
                'proposals.parent_group',
                'trade_sectors.name as trade_sector',
                'principle_types.name as principle_type',
                'proposalCases.contractor_rating',
                'agency_rating_details.agency_ratings as credit_rating_agency_and_grade',
                're_insurance_groupings.name as re_insurance_grouping',
                'nbis.cash_margin_if_applicable as cash_margin',
                'nbis.cash_margin_amount as cash_margin_inr',
                'beneficiaries.code as beneficiary_id',
                'beneficiaries.company_name as beneficiary_name',
                'beneficiaries.pan_no as beneficiary_pan_no',
                'project_details.code as project_id',
                'project_details.project_name as project_title',
                'project_details.project_value',
                'project_details.project_start_date',
                'project_details.project_end_date',
                'tenders.tender_id',
                'tenders.tender_header',
                'tenders.contract_value',
                'bond_types.name as bond_type',
                'tenders.bond_value',
                'bond_policies_issue.bond_period_start_date as bond_start_date',
                'bond_policies_issue.bond_period_end_date as bond_end_date',
                'bond_policies_issue.net_premium as net_premium_paid',
                'bond_policies_issue.total_premium as gross_premium_paid',
                'bond_policies_issue_checklist.date_of_receipt as premium_date',
                'bond_policies_issue.reference_no as bond_number',
                'bond_policies_issue.bond_number as insurer_bond_number',
                'proposals.status',
                DB::raw('COALESCE(bond_cancellations.remarks, bond_fore_closures.other_remarks, invocation_notification.remark) as remarks'),
                'proposalCases.created_at as application_date_two',
                'cases_decisions.decision_taken_date as decision_date',
                'cases_decisions.decision_remarks',
                'cases_limit_strategys.proposed_individual_cap as individual_cap',
                'cases_limit_strategys.proposed_overall_cap as overall_cap',
                'cases_limit_strategys.proposed_group_cap as group_cap',
                'principles.last_review_date',
                'cases_limit_strategys.proposed_valid_till as regular_review_date',
                'principles.last_balance_sheet_date as balance_Sheet_date',
                DB::raw('CONCAT_WS(" ", users.first_name, users.middle_name, users.last_name) as assigned_underwriter_name'),
                DB::raw('CASE WHEN adverse_informations.contractor_id IS NOT NULL THEN "Yes" ELSE "No" END as any_adverse_information'),
                'adverse_informations.adverse_information_details',
                DB::raw('CASE WHEN blacklists.contractor_id IS NOT NULL THEN "Yes" ELSE "No" END as any_blacklisted_details'),
                'blacklists.blacklisted_details',
                DB::raw('(CASE WHEN bond_policies_issue.bond_period_end_date < CURDATE() THEN "Yes" ELSE "No" END) as expired_bond'),
                DB::raw('(CASE WHEN DATE_SUB(bond_policies_issue.bond_period_end_date, INTERVAL ' . (int)$expiring_bond . ' DAY) <= CURDATE() AND bond_policies_issue.bond_period_end_date > CURDATE() THEN "Yes" ELSE "No" END) as expiring_bond'),
            ])
            ->leftJoin('bond_policies_issue', function($join) {
                $join->on('principles.id', 'bond_policies_issue.contractor_id')
                    ->where('bond_policies_issue.is_amendment', '=', 0);
            })
            ->leftJoin('proposals', function($join) {
                $join->on('bond_policies_issue.proposal_id', '=', 'proposals.id')
                    ->where('bond_policies_issue.is_amendment', '=', 0)
                    ->where('proposals.is_issue', '=', 1);
            })
            ->leftJoin('cases as proposalCases', function($join) {
                $join->on('proposalCases.proposal_id', '=', 'proposals.id')
                ->where('proposalCases.is_amendment', 0);
            })
            ->leftJoinSub($agencyRatings, 'agency_rating_details', function($join){ 
                $join->on('agency_rating_details.contractor_id','=','principles.id');
            })
            ->leftJoinSub($nbisApproved, 'nbis', function($join) {
                $join->on('nbis.proposal_id','=','proposals.id');
            })
            ->leftJoin('states', 'principles.state_id', '=', 'states.id')
            ->leftJoin('countries', 'principles.country_id', '=', 'countries.id')
            ->leftJoin('principle_types', 'principles.principle_type_id', '=', 'principle_types.id')
            ->leftJoin('project_details', 'proposals.project_details', '=', 'project_details.id')
            ->leftJoin('beneficiaries', 'proposals.beneficiary_id', '=', 'beneficiaries.id')
            ->leftJoin('tenders', 'proposals.tender_details_id', '=', 'tenders.id')
            ->leftJoin('bond_types', 'tenders.bond_type_id', '=', 'bond_types.id')
            ->leftJoin('bond_policies_issue_checklist', 'proposals.id', '=', 'bond_policies_issue_checklist.proposal_id')
            ->leftJoin('bond_cancellations', 'proposals.id', '=', 'bond_cancellations.proposal_id')
            ->leftJoin('bond_fore_closures', 'proposals.id', '=', 'bond_fore_closures.proposal_id')
            ->leftJoin('invocation_notification', 'proposals.id', '=', 'invocation_notification.proposal_id')
            ->leftJoinSub($casesDecision, 'cases_decisions', function($join) {
                $join->on('cases_decisions.proposal_id','=','proposals.id');
            })
            ->leftJoinSub($limitStrategy, 'cases_limit_strategys', function($join) {
                $join->on('cases_limit_strategys.casesable_id','=','proposals.id');
            })
            ->leftJoin('cases as underwriterCases', function($join) {
                $join->on('underwriterCases.proposal_id', '=', 'proposals.id')
                    ->where('underwriterCases.is_amendment', 0);
            })
            ->leftJoin('underwriters', 'underwriterCases.underwriter_id', '=', 'underwriters.id')
            ->leftJoin('users', 'underwriters.user_id', '=', 'users.id')
            ->leftJoinSub($adverseInformation, 'adverse_informations', function($join) {
                $join->on('adverse_informations.contractor_id', '=', 'principles.id');
            })
            ->leftJoinSub($blackListInformation, 'blacklists', function($join) {
                $join->on('blacklists.contractor_id', '=', 'principles.id');
            })
            ->leftJoin('trade_sectors', 'nbis.trade_sector_id', '=', 'trade_sectors.id')
            ->leftJoin('re_insurance_groupings', 'nbis.re_insurance_grouping_id', '=', 're_insurance_groupings.id')
            ->when(isset($contractor_filter), function($q) use($contractor_filter){
                $q->where('proposals.contractor_id', $contractor_filter);
            })
            ->when($selected_status, function($q) use ($selected_status) {
                $q->whereIn('proposals.status', $selected_status);
            })
            ->orderBy('principles.id');

        $sum_net_premium = $contractor_wise_data_query->pluck('net_premium_paid')->sum();
        $sum_gross_premium = $contractor_wise_data_query->pluck('gross_premium_paid')->sum();
        if ($request->wantsJson()) {
            $contractor_wise_data = $contractor_wise_data_query->paginate(500);
            $this->data['checked_fields'] = $checked_fields;
            $this->data['contractor_wise_data'] = $contractor_wise_data;
            $this->data['sum_net_premium'] = $sum_net_premium;
            $this->data['sum_gross_premium'] = $sum_gross_premium;

            return response()->json([
                'html'=>view('reports.contractor_wise.list',$this->data)->render(),
            ]);
        } else {
            $contractor_wise_data = $contractor_wise_data_query->get();
            $this->data['sum_net_premium'] = $sum_net_premium;
            $this->data['sum_gross_premium'] = $sum_gross_premium;
            return $contractor_wise_data;
        }
    }

    public function excel(Request $request){
        $this->data['checkedFields'] = $request->checked_fields;
        $this->data['contractor_wise_data'] = $this->datalist(Request());
        return Excel::download(new ContractorWiseExport($this->data),'contractor_wise.xlsx');
    }
}
