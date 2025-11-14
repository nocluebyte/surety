<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\{
    InvocationClaimsRequest,
    RecoveryRequest
};
use App\DataTables\RecoveryDataTable;
use App\Models\{InvocationNotification,BidBond, PerformanceBond,AdvancePaymentBond, BondTypes, RetentionBond,MaintenanceBond,InvocationClaims,Proposal,Recovery};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Sentinel;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RecoveryController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'getRecovery']]);
        $this->middleware('permission:recovery.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:recovery.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:recovery.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:recovery.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('recovery.recovery');
        view()->share('title', $this->title);
    }

    public function index(RecoveryDataTable $datatable)
    {
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['beneficiaries'] = $this->common->getBeneficiary();
        $this->data['invocation_number'] = $this->common->getInvocationNumber();
        $bondPoliciesIssue = InvocationNotification::pluck('bond_policies_issue_id')->toArray() ?? [];
        $this->data['bond_number'] = $this->common->getBondNumber($bondPoliciesIssue);

        return $datatable->render('recovery.index', $this->data);
    }

    public function create(Request $request)
    {
        // $bond_numbers = InvocationNotification::pluck('bond_number','id')->toArray();
        // $this->data['bond_numbers'] = $bond_numbers;
        $bondPoliciesIssue = InvocationNotification::where('total_outstanding_amount', '!=', 0)->where('status', 'Paid')->pluck('bond_policies_issue_id')->toArray() ?? [];
        // $this->data['bond_numbers'] = collect($this->common->getBondNumber())->except($bondPoliciesIssue)->toArray() ?? [];
        $this->data['bond_numbers'] = $this->common->getBondNumber($bondPoliciesIssue) ?? [];

        $this->data['benificery'] = $this->common->getBeneficiary();
        $this->data['contractor'] = $this->common->getContractor();
        $this->data['tender'] = $this->common->getTender();
        $this->data['code'] = $this->common->IDGenerator('R','recoveries',6);
        return view('recovery.create', $this->data); 
    }

    public function store(RecoveryRequest $request)
    {
        // dd($request->all());
        $invocation_notification_id = $request->invocation_notification_id ?? null;
        $recovery_amount = $request->recovery_amount;
        $check_entry = Recovery::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
            return redirect()->route('recovery.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {

            $invocation_notification = InvocationNotification::firstWhere('id',$invocation_notification_id);

            $invocation_notification->increment('total_recoverd_amount',$recovery_amount);
            $invocation_notification->decrement('total_outstanding_amount',$recovery_amount);
           
           $recovery_number =  $this->common->IDGenerator('R','recoveries',6);
            Recovery::create([
                'code'=>$recovery_number,
                'invocation_notification_id'=>$request->invocation_notification_id ?? null,
                'invocation_number'=>$request->invocation_number ?? null,
                'bond_value'=>$request->bond_value ?? null,
                'claimed_amount'=>$request->claimed_amount ?? null,
                'disallowed_amount'=>$request->disallowed_amount ?? null,
                'total_approved_bond_value'=>$request->total_approved_bond_value ?? null,
                'invocation_remark'=>$request->invocation_remark ?? null,
                'recover_date'=>$request->recovery_date ?? null,
                'recover_amount'=>$request->recovery_amount ?? null,
                'outstanding_amount'=>$request->total_outstanding_amount - $request->recovery_amount,
                'remark'=>$request->remark ?? null
            ]);


            DB::commit();
            return redirect()->route('recovery.index')->with('success', __('common.create_success'));            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating invocation notification: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show($id)
    {
        $recovery = Recovery::with([
            'invocationNotification',
            'invocationNotification.beneficiary:id,company_name as name',
            'invocationNotification.contractor:id,company_name as name,country_id',
            'invocationNotification.tender:id,tender_header as name',
        ])->findOrFail($id);
            
        $this->data['recovery'] = $recovery;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($recovery->invocationNotification->contractor->country_id);

        return view('recovery.show',$this->data);
    }

    public function edit($id,Request $request)
    {
        
    }

    public function update($id, Request $request)
    {
        
    }

    public function destroy($id)
    {
        
    }

    public function getRecovery(Request $request){
        
        $invocation_notification = InvocationNotification::select([
            'invocation_notification.id as invocation_notification_id',
            'invocation_notification.reason_for_invocation as invocation_remark',
            'invocation_notification.contractor_id',
            'invocation_notification.invocation_amount as bond_value',
            'invocation_notification.code as invocation_number',
            'invocation_notification.total_outstanding_amount',
            DB::raw('invocation_notification.claimed_amount'),
            DB::raw('invocation_notification.disallowed_amount'),
            DB::raw('invocation_notification.total_approved_bond_value'),
            'currencys.symbol as currency_symbol',
        ])
        ->leftJoin('principles', function($join){
            $join->on('invocation_notification.contractor_id', '=', 'principles.id');
        })
        ->leftJoin('countries', function($join){
            $join->on('principles.country_id', '=', 'countries.id');
        })
        ->leftJoin('currencys', function($join){
            $join->on('countries.id', '=', 'currencys.country_id');
        })
        ->where('invocation_notification.bond_policies_issue_id', $request->invocation_id)
        ->first();
        // ->findOrFail($request->invocation_id);

        return response()->json($invocation_notification);
    }
}
