<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\InvocationClaimsRequest;
use App\DataTables\InvocationClaimsDataTable;
use App\Models\{InvocationNotification,BidBond, PerformanceBond,AdvancePaymentBond, BondTypes, RetentionBond,MaintenanceBond,InvocationClaims,Proposal};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Sentinel;
use Carbon\Carbon;
use Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class InvocationClaimsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index']]);
        $this->middleware('permission:invocation_claims.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:invocation_claims.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:invocation_claims.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:invocation_claims.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('invocation_claims.invocation_claims');
        view()->share('title', $this->title);
    }

    public function index(InvocationClaimsDataTable $datatable)
    {
        $this->data = [];        
        return $datatable->render('invocation_claims.index', $this->data);
    }

    public function create(Request $request)
    {
        $invId = $request->id ?? null;
        $this->data['bond_types'] = $this->common->getBondTypes();        
        $invocationData = InvocationNotification::with('bondType')->where('id',$invId)->first();
        $bondType = $invocationData->BondType->name;
        $bondname = Str::slug($bondType); 
        $this->data['generateCode'] = codeGenerator('invocation_claims', 4, 'INC'); 

        $this->data['proposals'] = Proposal::where('is_amendment',0)->select('id', DB::raw("CONCAT(code, '/V', version) as code"))->pluck('code','id')->toArray();  
        //$this->data['proposalData'] = Proposal::where('id',$proposal_id)->first()
        
           
        $this->data['bond_type'] = $invocationData->bond_type;                           
        $this->data['invocationData'] = $invocationData;    
        $this->data['claim_status'] = Config('srtpl.claim_status');    
        $this->data['invocation_id'] = $invId;  
        // /dd($inocationData);        
        return view('invocation_claims.create', $this->data); 
    }

    public function store(InvocationClaimsRequest $request)
    {
        //dd($request->all());
        $check_entry = InvocationClaims::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
            return redirect()->route('invocation-claims.create', ['id' => $request->invocation_id])->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $input = $request->except(['_token','claim_form_attachment','invocation_notice_attachment','contract_copy_attachment','correspondence_detail_attachment','arbitration_attachment','dispute_attachment','cancelled_cheque','assessment_note_attachment','approval_note_attachment']);
            $input['code'] = codeGenerator('invocation_claims', 4, 'INC'); 
            $invocationClaims = InvocationClaims::create($input);
            $invocation_claim_id = $invocationClaims->id;

            foreach (['claim_form_attachment','invocation_notice_attachment','contract_copy_attachment','correspondence_detail_attachment','arbitration_attachment','dispute_attachment','cancelled_cheque','assessment_note_attachment','approval_note_attachment'] as $documentType) {
                if($request->hasFile($documentType)){
                    $this->common->storeMultipleFiles($request, $request[$documentType], $documentType, $invocationClaims, $invocation_claim_id, 'invocation_claims');
                }
            }
            Proposal::where('id',$request->proposal_id)->update(['is_claim_converted' => '1']);
            InvocationNotification::where('id',$request->invocation_id)->update(['is_claim_converted' => '1']);             
            DB::commit();
            return redirect()->route('invocation-claims.index')->with('success', __('invocation_claims.create_success'));            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating invocation notification: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show($id)
    {
        $invocationClaimData = InvocationClaims::with('bondType','dMS','proposal')->where('id',$id)->first();                
        $bondType = $invocationClaimData->BondType->name;
        $bondname = Str::slug($bondType); 
        $bondData = [];
        $this->data['invocationClaimData'] = $invocationClaimData;
        $this->data['dms_data'] = $invocationClaimData->dMS->groupBy('attachment_type');
        $this->data['bondData'] = $bondData;
        //$this->data['bond_permission'] = $bond_permission;
        return view('invocation_claims.show', $this->data);    
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
}
