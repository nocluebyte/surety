<?php

namespace App\Http\Controllers;

use App\Models\{
    Beneficiary,
    BondPoliciesIssue,
    ProjectDetail,
    Tender,
    Setting,
    CasesDecision,
    BondPoliciesIssueChecklist
};
use Illuminate\Http\Request;
use DB;

class BeneficiaryDashbordController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('dashboard:beneficiary');
        // $this->middleware('permission:department.list', ['only' => ['index', 'show']]);
        // $this->middleware('permission:department.add', ['only' => ['create', 'store']]);
        // $this->middleware('permission:department.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:department.delete', ['only' => ['destroy']]);

        $this->common = new CommonController();
        $this->title = "Dashboard";
        view()->share('title', $this->title);
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   
        $beneficiary = Beneficiary::firstWhere('user_id',$this->user->id);
        $this->data['totalProjects'] = ProjectDetail::where('beneficiary_id',$beneficiary->id)->count();
        $this->data['totalTenders'] = Tender::where('beneficiary_id',$beneficiary->id)->count();

           // Expiring Bonds
        $expiring_bond = Setting::where('name', 'expiring_bond')->pluck('value')->first() ?? 0;

        $this->data['expiring_bonds'] = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
        ->where([
            'proposals.is_issue'=>1,
            'proposals.is_amendment'=>0,	
            'proposals.is_invocation_notification'=>0,	
            'proposals.is_bond_foreclosure'=>0,	
            'proposals.is_bond_cancellation'=>0,
        ])
        // ->where('bond_policies_issue.is_amendment', 0)
        ->whereRaw('DATE_SUB(bond_policies_issue.bond_period_end_date, INTERVAL ? DAY) <= NOW()', $expiring_bond)
        ->whereDate('bond_policies_issue.bond_period_end_date','>',$this->now)->count() ?? 0;

        //Expired Bonds
        $this->data['expired_bonds'] = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
        ->where([
            'proposals.is_issue'=>1,
            'proposals.is_amendment'=>0,	
            'proposals.is_invocation_notification'=>0,	
            'proposals.is_bond_foreclosure'=>0,	
            'proposals.is_bond_cancellation'=>0,
            'proposals.beneficiary_id'=>$beneficiary->id
        ])
        ->where('bond_policies_issue.is_amendment', 0)
        ->whereDate('bond_policies_issue.bond_period_end_date','<',$this->now)->count() ?? 0;

        $bond_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            'proposals.beneficiary_id'=>$beneficiary->id
            ])->count() ?? 0;

        $this->data['bond_count'] = $bond_count;

        $amended_bonds_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_amendment' => 1,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            'proposals.beneficiary_id'=>$beneficiary->id
        ])->count() ?? 0;
        $this->data['amended_bonds_count'] = $amended_bonds_count;

          //line chart start
        $bondTypes = DB::table('proposals')->where('proposals.beneficiary_id',$beneficiary->id)->where('proposals.is_issue', 1)->groupBy('proposals.bond_type')->leftJoin('bond_types', 'bond_types.id', '=', 'proposals.bond_type')->select('bond_types.name as name', DB::raw('count(proposals.bond_type) as totalBonds'))->get() ?? [];

           $bondIssued = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,	
                'proposals.is_bond_foreclosure'=>0,	
                'proposals.is_bond_cancellation'=>0,
                'proposals.beneficiary_id'=>$beneficiary->id
                ])->groupBy('bond_policies_issue.bond_type_id')->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as countBondType'))
        ->get();

        $this->data['bondIssuedCount'] = [];
        if(isset($bondIssued) && count($bondIssued) > 0){
            $this->data['bondIssuedCount'] = array_filter($bondIssued->pluck('countBondType', 'name')->toArray());
        } else {
            $this->data['bondIssuedCount'] = [];
        }

        /*-------------------------------------------------------------------------------------*/

        // Month wise Bond Issued Line Chart
        $defaultYear = getDefaultYear();
        $defaultYearPeriod = [$defaultYear->from_date ?? '',$defaultYear->to_date ?? ''];
        $getInitMonth = $this->common->getInitMonthArray();

        foreach ($getInitMonth as $key => $value) {

            $bond_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at', $key)
            ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'), $defaultYearPeriod)
            ->count() ?? 0;

             $getInitMonth[$key] = $bond_count;

            /*************************************************************************** */

            $bond_amount =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getBondAmount[$key] = $bond_amount;

            /*********************************************************************************** */

            $total_premium = BondPoliciesIssueChecklist::whereNull('deleted_at')->whereMonth('created_at',$key)->whereBetween(DB::raw('DATE(created_at)'),$defaultYearPeriod)->sum('net_premium') ?? 0;
            $getTotalPremium[$key] = $total_premium;

            /******************************************************************************** */

            $decision_amount = CasesDecision::
            leftJoin('proposals', 'cases_decisions.proposal_id', 'proposals.id')
            ->leftJoin('bond_policies_issue', 'proposals.id', 'bond_policies_issue.proposal_id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                  'proposals.beneficiary_id'=>$beneficiary->id
                // 'proposals.is_invocation_notification'=>0,
                // 'proposals.is_bond_foreclosure'=>0,
                // 'proposals.is_bond_cancellation'=>0,
            ])
            ->whereMonth('cases_decisions.created_at', $key)->whereBetween(DB::raw('DATE(cases_decisions.created_at)'), $defaultYearPeriod)->sum('cases_decisions.bond_value') ?? 0;
            $getDecisionAmount[$key] = $decision_amount;

            /******************************************************************************** */

            $issued_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getIssuedAmount[$key] = $issued_amount;

            /******************************************************************************* */

            $invoked_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>1,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getInvokedAmount[$key] = $invoked_bond_amount;

            /******************************************************************************* */

            $cancelled_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>1,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getCancelledAmount[$key] = $cancelled_bond_amount;

            /******************************************************************************* */

            $foreclosed_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>1,
                'proposals.is_bond_cancellation'=>0,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getForeClosedAmount[$key] = $foreclosed_bond_amount;

            /******************************************************************************* */

            $risk_exposure = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                  'proposals.beneficiary_id'=>$beneficiary->id
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->groupBy('bond_policies_issue.tender_id')->get();
            $getRiskExposure[$key] = $risk_exposure->pluck('bond_value')->sum();
        }
        // dd($getInitMonth);
        $this->data['bond_issued_month_wise'] = array_values($getInitMonth);
        $this->data['bond_amount_month_wise'] = array_values($getBondAmount);
        $this->data['total_premium_month_wise'] = array_values($getTotalPremium);
        $this->data['decision_amount_month_wise'] = array_values($getDecisionAmount);
        $this->data['issued_amount_month_wise'] = array_values($getIssuedAmount);
        $this->data['risk_exposure_month_wise'] = array_values($getRiskExposure);
        $this->data['invoked_amount_month_wise'] = array_values($getInvokedAmount);
        $this->data['cancelled_amount_month_wise'] = array_values($getCancelledAmount);
        $this->data['foreclosed_amount_month_wise'] = array_values($getForeClosedAmount);

        //line chart start
        $bondTypes = DB::table('proposals')->where('proposals.is_issue', 1)->groupBy('proposals.bond_type')->leftJoin('bond_types', 'bond_types.id', '=', 'proposals.bond_type')->select('bond_types.name as name', DB::raw('count(proposals.bond_type) as totalBonds'))->get() ?? [];

        $this->data['bondTypes'] = array_filter($bondTypes->pluck('totalBonds', 'name')->toArray()) ?? [];

        // Month Wise bar graph of No of Tenders

        foreach ($getInitMonth as $key => $value) {
            $tenders = DB::table('tenders')
            ->leftJoin('beneficiaries', 'tenders.beneficiary_id', '=', 'beneficiaries.id')
            ->where([
                'tenders.deleted_at' => null,
                'beneficiaries.user_id' => $this->user->id
            ])
            ->whereMonth('tenders.created_at',$key)->whereBetween(DB::raw('DATE(tenders.created_at)'),$defaultYearPeriod)->count() ?? 0;
            $getTendersMonthWise[$key] = $tenders;

            
        }
        $this->data['month_wise_tenders'] = array_values($getTendersMonthWise);
        // dd($this->data['month_wise_tenders']);

        return view('dashboard.beneficiary.index',$this->data);
    }
}
