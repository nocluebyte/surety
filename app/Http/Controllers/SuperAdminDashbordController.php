<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{User,Account, BidBond, PerformanceBond, AdvancePaymentBond, RetentionBond, MaintenanceBond, BondPoliciesIssueChecklist, Principle, Beneficiary, BondPoliciesIssue, Setting, Nbi, Proposal,Cases, CasesDecision};
use DB;
use Sentinel;
use Carbon\Carbon;

class SuperAdminDashbordController extends Controller
{
      public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('dashboard:administrator');
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
    public function __invoke()
    {
         $loginUser = Sentinel::getUser();
        $superadmin = $loginUser->hasAccess(['users.superadmin']);
        $todaysDate = Carbon::today()->format('d-m-Y');
        $current_date = Carbon::now()->format('Y-m-d');
        $filterData['from_date'] = date('d-m-Y', strtotime($current_date));
        $filterData['to_date'] = date('d-m-Y', strtotime($current_date));
        $filterData['date'] = !empty($filterDate) ? $filterDate : $filterData['from_date'] . ' | ' . $filterData['to_date'];
        $this->data['filterInfo'] = $filterData;
        $this->data['todaysDate'] = $todaysDate;

         // Total Contractor
        $this->data['totalContractor'] = DB::table('principles')->whereNull('deleted_at')->count() ?? 0;

        // Total Beneficiary
        $this->data['totalBeneficiary'] = DB::table('beneficiaries')->whereNull('deleted_at')->count() ?? 0;

        // Current Exposure
        // $current_exposure = Cases::Completed()->sum('bond_value') ?? 0;
        $current_exposure = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            ])
            ->groupBy('bond_policies_issue.tender_id')
            ->get();
        $this->data['current_exposure'] = $current_exposure->pluck('bond_value')->sum();
        // dd($this->data['current_exposure']);

        // Total Projects
        $this->data['totalProjects'] = DB::table('project_details')->whereNull('deleted_at')->count() ?? 0;

        // Total Tenders
        $this->data['totalTenders'] = DB::table('tenders')->whereNull('deleted_at')->count() ?? 0;

        // Total Proposals
        $this->data['totalProposals'] = DB::table('proposals')->whereNull('deleted_at')->where('is_amendment', 0)
        ->orWhere(function($q){
            $q->whereIn('proposals.status', ['Cancel', 'Rejected'])->where('proposals.version', 1)->where('proposals.is_amendment', 1);
        })->count() ?? 0;

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
        ])
        ->where('bond_policies_issue.is_amendment', 0)
        ->whereDate('bond_policies_issue.bond_period_end_date','<',$this->now)->count() ?? 0;

        // Total Bonds
        // $bond_count = Proposal::where([
        //     'is_issue'=>1,	
        //     'is_amendment'=>0,
        //     'is_invocation_notification'=>0,	
        //     'is_bond_foreclosure'=>0,	
        //     'is_bond_cancellation'=>0,
        // ])->count() ?? 0;

        $bond_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            ])->count() ?? 0;

        $this->data['bond_count'] = $bond_count;

        $amended_bonds_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_amendment' => 1,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
        ])->count() ?? 0;
        $this->data['amended_bonds_count'] = $amended_bonds_count;

        // dd($amended_bonds_count);

        // Total Premium
        // $premium_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
        // ->where([
        //     'proposals.is_issue'=>1,
        //     'proposals.is_amendment'=>0,	
        //     'proposals.is_invocation_notification'=>0,	
        //     'proposals.is_bond_foreclosure'=>0,	
        //     'proposals.is_bond_cancellation'=>0,
        // ])->sum('premium_amount') ?? 0;

        $premium_amount = NBI::leftJoin('proposals','nbis.proposal_id','proposals.id')
        ->where([
            'proposals.is_checklist_approved'=>1,
            'nbis.status'=>'Approved',
        ])->sum('nbis.net_premium') ?? 0;

        // $premium_amount = BondPoliciesIssueChecklist::whereNull('deleted_at')->sum('net_premium') ?? 0;

        $this->data['premium_amount'] = $premium_amount;

        // Average Rate of Portfolio    
        // $this->data['average_rate_of_portfolio'] = $current_exposure > 0 ? ($premium_amount/$current_exposure) * 100 : 0;

        /*-----------------------------------------------------------------------------------------------*/

        // Bond Issued Pie Chart
        // $bondIssued = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
        //         'proposals.is_amendment' => 0,
        //         'proposals.is_invocation_notification'=>0,	
        //         'proposals.is_bond_foreclosure'=>0,	
        //         'proposals.is_bond_cancellation'=>0,
        //         ])->groupBy('bond_policies_issue.bond_type_id')->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as countBondType'))
        // ->get();

        $bondIssued = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,	
                'proposals.is_bond_foreclosure'=>0,	
                'proposals.is_bond_cancellation'=>0,
                ])->groupBy('bond_policies_issue.bond_type_id')->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as countBondType'))
        ->get();

        $this->data['bondIssuedCount'] = [];
        if(isset($bondIssued) && count($bondIssued) > 0){
            $this->data['bondIssuedCount'] = array_filter($bondIssued->pluck('countBondType', 'name')->toArray());
        } else {
            $this->data['bondIssuedCount'] = [];
        }
        // dd($this->data['bondIssuedCount']);

        /*-------------------------------------------------------------------------------------*/

        // Month wise Bond Issued Line Chart
        $defaultYear = getDefaultYear();
        $defaultYearPeriod = [$defaultYear->from_date ?? '',$defaultYear->to_date ?? ''];
        $getInitMonth = $this->common->getInitMonthArray();

        foreach ($getInitMonth as $key => $value) {
            // $bond_count =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
            //     'proposals.is_amendment' => 0,
            //     'proposals.is_invocation_notification'=>0,	
            //     'proposals.is_bond_foreclosure'=>0,	
            //     'proposals.is_bond_cancellation'=>0,
            //     ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->count() ?? 0;

            $bond_count = BondPoliciesIssue::leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at', $key)
            ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'), $defaultYearPeriod)
            ->count() ?? 0;

             $getInitMonth[$key] = $bond_count;

            /*************************************************************************** */

            // $bond_amount =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
            //     'proposals.is_amendment' => 0,
            //     'proposals.is_invocation_notification'=>0,	
            //     'proposals.is_bond_foreclosure'=>0,	
            //     'proposals.is_bond_cancellation'=>0,
            //     ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;

            $bond_amount =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getBondAmount[$key] = $bond_amount;

            /*********************************************************************************** */

            // $total_premium =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
            //     'proposals.is_amendment' => 0,
            //     'proposals.is_invocation_notification'=>0,	
            //     'proposals.is_bond_foreclosure'=>0,	
            //     'proposals.is_bond_cancellation'=>0,
            //     ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.total_premium') ?? 0;

            // $total_premium =  BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
            //     'bond_policies_issue.is_amendment' => 0,
            //     'proposals.is_issue' => 1,
            //     'proposals.is_invocation_notification'=>0,	
            //     'proposals.is_bond_foreclosure'=>0,	
            //     'proposals.is_bond_cancellation'=>0,
            //     ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.total_premium') ?? 0;

            $total_premium = BondPoliciesIssueChecklist::whereNull('deleted_at')->whereMonth('created_at',$key)->whereBetween(DB::raw('DATE(created_at)'),$defaultYearPeriod)->sum('net_premium') ?? 0;
            $getTotalPremium[$key] = $total_premium;

            /******************************************************************************** */

            // $decision_amount = CasesDecision::whereMonth('created_at', $key)->whereBetween(DB::raw('DATE(created_at)'), $defaultYearPeriod)->sum('bond_value') ?? 0;
            $decision_amount = CasesDecision::
            leftJoin('proposals', 'cases_decisions.proposal_id', 'proposals.id')
            ->leftJoin('bond_policies_issue', 'proposals.id', 'bond_policies_issue.proposal_id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                // 'proposals.is_invocation_notification'=>0,
                // 'proposals.is_bond_foreclosure'=>0,
                // 'proposals.is_bond_cancellation'=>0,
            ])
            ->whereMonth('cases_decisions.created_at', $key)->whereBetween(DB::raw('DATE(cases_decisions.created_at)'), $defaultYearPeriod)->sum('cases_decisions.bond_value') ?? 0;
            $getDecisionAmount[$key] = $decision_amount;

            /******************************************************************************** */

            // $issued_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
            //     'proposals.is_invocation_notification'=>0,	
            //     'proposals.is_bond_foreclosure'=>0,	
            //     'proposals.is_bond_cancellation'=>0,
            //     ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;

            $issued_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getIssuedAmount[$key] = $issued_amount;

            /******************************************************************************* */

            $invoked_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>1,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getInvokedAmount[$key] = $invoked_bond_amount;

            /******************************************************************************* */

            $cancelled_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>1,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getCancelledAmount[$key] = $cancelled_bond_amount;

            /******************************************************************************* */

            $foreclosed_bond_amount = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>1,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getForeClosedAmount[$key] = $foreclosed_bond_amount;

            /******************************************************************************* */

            $risk_exposure = BondPoliciesIssue::leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
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


        // dd($this->data['risk_exposure_month_wise']);

        // $bond_counts_by_month = [];
        // $bondType = [];

        // foreach ($getInitMonth as $key => $value) {
        //     $bond_counts = BondPoliciesIssue::where('is_amendment', 0)
        //         ->groupBy('bond_policies_issue.bond_type_id')
        //         ->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')
        //         ->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as count'))
        //         ->whereMonth('bond_policies_issue.created_at',$key)
        //         ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)
        //         ->get();

        //     foreach ($bond_counts as $count) {
        //         $bond_counts_by_month[$key][$count->name] = $count->count;
        //         $bondType[] = $count->name;
        //     }
        //     // dd($bondType);
        // }

        // $bond_issued_month_wise = [];
        // foreach ($bondType as $bond_type) {
        //     $monthly_counts = [];
        //     foreach ($getInitMonth as $key => $value) {
        //         $monthly_counts[] = $bond_counts_by_month[$key][$bond_type] ?? 0;
        //     }
        //     $bond_issued_month_wise[] = [
        //         'name' => $bond_type,
        //         'data' => $monthly_counts
        //     ];
        // }
        // $this->data['bond_issued_month_wise'] = $bond_issued_month_wise ?? [];
        // dd($this->data['bond_issued_month_wise']);

        /* ---------------------------------------------------------------------------*/

        // Sector wise NBI
        // $sectorWiseNbis = Nbi::where('status', 'Agreed')->whereNotIn('nbi_type', ['Proposal'])->whereNotNull('trade_sector_id')->groupBy('trade_sector_id')
        // ->leftJoin('trade_sectors', 'trade_sectors.id', '=', 'nbis.trade_sector_id')->select('trade_sectors.name', DB::raw('count(nbis.id) as countNbi'))->get();

        // $this->data['nbiCount'] = [];
        // if(isset($sectorWiseNbis)){
        //     $this->data['nbiCount'] = array_filter($sectorWiseNbis->pluck('countNbi', 'name')->toArray());
        // } else {
        //     $this->data['nbiCount'] = [];
        // }
        // dd($this->data['nbiCount']);

        //line chart start
        $bondTypes = DB::table('proposals')->where('proposals.is_issue', 1)->groupBy('proposals.bond_type')->leftJoin('bond_types', 'bond_types.id', '=', 'proposals.bond_type')->select('bond_types.name as name', DB::raw('count(proposals.bond_type) as totalBonds'))->get() ?? [];

        $this->data['bondTypes'] = array_filter($bondTypes->pluck('totalBonds', 'name')->toArray()) ?? [];

        // dd($this->data['bondTypes']);
        //line chart end





        // foreach ($getInitMonth as $key => $value) {
        //     $bond_count =  BondPoliciesIssue::where('is_amendment', 0)->whereMonth('created_at',$key)->whereBetween(DB::raw('DATE(created_at)'),$defaultYearPeriod)->count() ?? 0;
        //      $getInitMonth[$key] = $bond_count;
        //   }
        //   $this->data['bond_issued_month_wise'] = array_values($getInitMonth);

        ////////////////////////////////////////////////////////////////////////////////////////

        // $bond_counts_by_month = [];
        // $bondType = [];

        // foreach ($getInitMonth as $key => $value) {
        //     $bond_counts = BondPoliciesIssue::where('is_amendment', 0)
        //         ->groupBy('bond_policies_issue.bond_type_id')
        //         ->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')
        //         ->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as count'))
        //         ->whereMonth('bond_policies_issue.created_at',$key)
        //         ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)
        //         ->get();

        //     foreach ($bond_counts as $count) {
        //         $bond_counts_by_month[$key][$count->name] = $count->count;
        //         $bondType[] = $count->name;
        //     }
        // }

        // $bond_issued_month_wise = [];
        // foreach ($bondType as $bond_type) {
        //     $monthly_counts = [];
        //     foreach ($getInitMonth as $key => $value) {
        //         $monthly_counts[] = $bond_counts_by_month[$key][$bond_type] ?? 0;
        //     }
        //     $bond_issued_month_wise[] = [
        //         'name' => $bond_type,
        //         'data' => $monthly_counts
        //     ];
        // }
        // $this->data['bond_issued_month_wise'] = $bond_issued_month_wise ?? [];
        // dd($this->data['bond_issued_month_wise']);

        //////////////////////////////////////////////////////////////////////////////////////

        // $bond_counts_by_month = [];
        // $lineChartLabels = [
        //     'Approved Application Amount',
        //     'Issued Bond Amount',
        // ];

        // foreach ($getInitMonth as $key => $value) {
        //     $bond_counts = BondPoliciesIssue::where('is_amendment', 0)
        //         ->groupBy('bond_policies_issue.bond_type_id')
        //         ->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')
        //         ->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as count'), 'bond_policies_issue.bond_value')
        //         ->whereMonth('bond_policies_issue.created_at',$key)
        //         ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)
        //         ->get();
        //     // dd($bond_counts, $key, $value);

        //     foreach ($bond_counts as $count) {
        //         $bond_counts_by_month[$key][$count->name] = $count->bond_value;
        //         // $lineChartLabels[] = $count->name;
        //     }
        // }

        // $bond_issued_month_wise = [];
        // foreach ($lineChartLabels as $bond_type) {
        //     $monthly_counts = [];
        //     foreach ($getInitMonth as $key => $value) {
        //         $monthly_counts[] = $bond_counts_by_month[$key][$bond_type] ?? 0;
        //     }
        //     $bond_issued_month_wise[] = [
        //         'name' => $bond_type,
        //         'data' => $monthly_counts
        //     ];
        // }
        // $this->data['bond_issued_month_wise'] = $bond_issued_month_wise ?? [];

        // dd($this->data['bond_issued_month_wise']);

        return view('dashboard.superadmin.index', $this->data);
    }
}
