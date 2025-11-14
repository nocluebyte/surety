<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Sentinel;
use Carbon\Carbon;

class ContractorDashbordController extends Controller
{
     public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('dashboard:contractor');
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
        $loginUser = Sentinel::getUser();
        $todaysDate = Carbon::today()->format('d-m-Y');
        $current_date = Carbon::now()->format('Y-m-d');

        // Total Proposals
        $this->data['totalProposals'] = DB::table('proposals')->whereNull('proposals.deleted_at')
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->where([
            'is_amendment' => 0,
        ])
        ->whereColumn('contractor_id', 'principles.id')
        ->orWhere(function($q){
            $q->whereIn('proposals.status', ['Cancel', 'Rejected'])->whereColumn('contractor_id', 'principles.id')->where('proposals.version', 1)->where('proposals.is_amendment', 1);
        })->count() ?? 0;

        // Bond Count
        $this->data['bond_count'] = DB::table('bond_policies_issue')->leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            ])
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->count() ?? 0;

        // Amended Bonds
        $amended_bonds_count = DB::table('bond_policies_issue')->leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_amendment' => 1,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
        ])
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
        ->count() ?? 0;
        $this->data['amended_bonds_count'] = $amended_bonds_count;

        // Expiring Bonds
        $expiring_bond = DB::table('settings')->where('name', 'expiring_bond')->pluck('value')->first() ?? 0;
        $this->data['expiring_bonds'] = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
        ->where([
            'proposals.is_issue'=>1,
            'proposals.is_amendment'=>0,	
            'proposals.is_invocation_notification'=>0,	
            'proposals.is_bond_foreclosure'=>0,	
            'proposals.is_bond_cancellation'=>0,
        ])
        // ->where('bond_policies_issue.is_amendment', 0)
        ->whereRaw('DATE_SUB(bond_policies_issue.bond_period_end_date, INTERVAL ? DAY) <= NOW()', $expiring_bond)
        ->whereDate('bond_policies_issue.bond_period_end_date','>',$this->now)
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
        ->count() ?? 0;

        //Expired Bonds
        $this->data['expired_bonds'] = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
        ->where([
            'proposals.is_issue'=>1,
            'proposals.is_amendment'=>0,	
            'proposals.is_invocation_notification'=>0,	
            'proposals.is_bond_foreclosure'=>0,	
            'proposals.is_bond_cancellation'=>0,
        ])
        ->where('bond_policies_issue.is_amendment', 0)
        ->whereDate('bond_policies_issue.bond_period_end_date','<',$this->now)
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
        ->count() ?? 0;

        /************************************************************************** */

        $bondIssued = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,	
                'proposals.is_bond_foreclosure'=>0,	
                'proposals.is_bond_cancellation'=>0,
                ])->groupBy('bond_policies_issue.bond_type_id')->leftJoin('bond_types', 'bond_types.id', '=', 'bond_policies_issue.bond_type_id')->select('bond_types.name', DB::raw('count(bond_policies_issue.bond_type_id) as countBondType'))
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
        ->get();

        $this->data['bondIssuedCount'] = [];
        if(isset($bondIssued) && count($bondIssued) > 0){
            $this->data['bondIssuedCount'] = array_filter($bondIssued->pluck('countBondType', 'name')->toArray());
        } else {
            $this->data['bondIssuedCount'] = [];
        }

        /**************************************************************************** */
        // Total Net Premium
        $premium_amount = DB::table('nbis')->leftJoin('proposals','nbis.proposal_id','proposals.id')
        ->where([
            'proposals.is_checklist_approved'=>1,
            'nbis.status'=>'Approved',
        ])
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('nbis.contractor_id', 'principles.id')
        ->sum('nbis.net_premium') ?? 0;
        $this->data['premium_amount'] = $premium_amount;

        /***************************************************************************** */
        // Current Exposure
        $current_exposure = DB::table('bond_policies_issue')->leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')
        ->leftJoin('principles', function($join) use ($loginUser) {
            $join->on('proposals.contractor_id', '=', 'principles.id');
            $join->where('principles.user_id', $loginUser->id);
        })
        ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
        ->where([
            'bond_policies_issue.is_amendment' => 0,
            'proposals.is_issue' => 1,
            'proposals.is_invocation_notification'=>0,
            'proposals.is_bond_foreclosure'=>0,
            'proposals.is_bond_cancellation'=>0,
            ])
            ->groupBy('bond_policies_issue.tender_id')
            ->get();
        $this->data['current_exposure'] = $current_exposure->pluck('bond_value')->sum();

        /***************************************************************************** */

        // Month wise Bond Issued Line Chart
        $defaultYear = getDefaultYear();
        $defaultYearPeriod = [$defaultYear->from_date ?? '',$defaultYear->to_date ?? ''];
        $getInitMonth = $this->common->getInitMonthArray();

        foreach ($getInitMonth as $key => $value) {
            $bond_count_month_wise = DB::table('bond_policies_issue')->leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at', $key)
            ->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'), $defaultYearPeriod)
            ->count() ?? 0;

             $getInitMonth[$key] = $bond_count_month_wise;

            /*************************************************************************** */

            $bond_amount = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getBondAmount[$key] = $bond_amount;

            /*********************************************************************************** */

            $total_premium = DB::table('bond_policies_issue_checklist')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('bond_policies_issue_checklist.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue_checklist.contractor_id', 'principles.id')
            ->whereNull('bond_policies_issue_checklist.deleted_at')->whereMonth('bond_policies_issue_checklist.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue_checklist.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue_checklist.net_premium') ?? 0;
            $getTotalPremium[$key] = $total_premium;

            /******************************************************************************** */

            $decision_amount = DB::table('cases_decisions')->
            leftJoin('proposals', 'cases_decisions.proposal_id', 'proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('cases_decisions.contractor_id', 'principles.id')
            ->leftJoin('bond_policies_issue', 'proposals.id', 'bond_policies_issue.proposal_id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
            ])
            ->whereMonth('cases_decisions.created_at', $key)->whereBetween(DB::raw('DATE(cases_decisions.created_at)'), $defaultYearPeriod)->sum('cases_decisions.bond_value') ?? 0;
            $getDecisionAmount[$key] = $decision_amount;

            /******************************************************************************** */

            $issued_amount = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getIssuedAmount[$key] = $issued_amount;

            /******************************************************************************* */

            $invoked_bond_amount = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>1,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getInvokedAmount[$key] = $invoked_bond_amount;

            /******************************************************************************* */

            $cancelled_bond_amount = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>1,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getCancelledAmount[$key] = $cancelled_bond_amount;

            /******************************************************************************* */

            $foreclosed_bond_amount = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>1,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->sum('bond_policies_issue.bond_value') ?? 0;
            $getForeClosedAmount[$key] = $foreclosed_bond_amount;

            /******************************************************************************* */

            $risk_exposure = DB::table('bond_policies_issue')->leftJoin('proposals','bond_policies_issue.proposal_id','proposals.id')
            ->leftJoin('principles', function($join) use ($loginUser) {
                $join->on('proposals.contractor_id', '=', 'principles.id');
                $join->where('principles.user_id', $loginUser->id);
            })
            ->whereColumn('bond_policies_issue.contractor_id', 'principles.id')
            ->where([
                'bond_policies_issue.is_amendment' => 0,
                'proposals.is_issue' => 1,
                'proposals.is_invocation_notification'=>0,
                'proposals.is_bond_foreclosure'=>0,
                'proposals.is_bond_cancellation'=>0,
                ])->whereMonth('bond_policies_issue.created_at',$key)->whereBetween(DB::raw('DATE(bond_policies_issue.created_at)'),$defaultYearPeriod)->groupBy('bond_policies_issue.tender_id')->get();
            $getRiskExposure[$key] = $risk_exposure->pluck('bond_value')->sum();
        }
        $this->data['bond_issued_month_wise'] = array_values($getInitMonth);
        $this->data['bond_amount_month_wise'] = array_values($getBondAmount);
        $this->data['total_premium_month_wise'] = array_values($getTotalPremium);
        $this->data['decision_amount_month_wise'] = array_values($getDecisionAmount);
        $this->data['issued_amount_month_wise'] = array_values($getIssuedAmount);
        $this->data['risk_exposure_month_wise'] = array_values($getRiskExposure);
        $this->data['invoked_amount_month_wise'] = array_values($getInvokedAmount);
        $this->data['cancelled_amount_month_wise'] = array_values($getCancelledAmount);
        $this->data['foreclosed_amount_month_wise'] = array_values($getForeClosedAmount);

        // dd($this->data['bond_count']);

        return view('dashboard.contractor.index', $this->data);
    }
}
