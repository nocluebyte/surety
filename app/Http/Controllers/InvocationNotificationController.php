<?php

namespace App\Http\Controllers;

use App\Models\InvocationNotificationAnalysis;
use App\Models\InvocationNotificationClaimExaminerLog;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\{
    InvocationNotificationRequest,
    InvocationNotificationPayoutRequest,
    InvocationNotificationClaimExaminerRequest,
    InvocationCancellelationRequest,
    InvocationNotificationAnalysisRequest,
    InvocationNotificationDmsRequest
};
use App\DataTables\InvocationNotificationDataTable;
use App\Models\{BidBond, PerformanceBond,AdvancePaymentBond, BondTypes, RetentionBond,MaintenanceBond,Country,State,InvocationNotification,Cases,Proposal, BondPoliciesIssue,DMS,DmsComment, User, ClaimExaminer};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Sentinel;
use Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Rules\Remarks;

class InvocationNotificationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['show', 'edit', 'update', 'destroy']]);
        $this->middleware('permission:invocation_notification.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:invocation_notification.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:invocation_notification.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('invocation_notification.invocation_notification');
        view()->share('title', $this->title);
    }

    public function index(InvocationNotificationDataTable $datatable)
    {
        $this->data = [];
        $this->data['type_of_bond'] = $this->common->getBondTypes();      
        return $datatable->render('invocation_notification.index', $this->data);
    }    

    public function create(Request $request,$proposal_id = null)
    {
        $this->data = [];
        //$bond_type = $request->bond_type;
        $this->data['proposal_id'] = $proposal_id ?? null;      
        $this->data['generateCode'] = codeGenerator('invocation_notification', 4, 'INV');  
       
        $this->data['proposals'] = Proposal::where('is_amendment',0)->pluck('code','id')->toArray();        
        $this->data['proposalData'] = Proposal::where('id',$proposal_id)->first();        

        // $this->data['bond_types'] = $this->common->getBondTypes();

        $bondPoliciesIssue = InvocationNotification::pluck('bond_policies_issue_id')->toArray() ?? [];
        $this->data['bond_number'] = collect($this->common->getBondNumber())->except($bondPoliciesIssue)->toArray() ?? [];
        $this->data['contractorOptions'] = [];
        // $this->data['bond_number'] = $this->common->getBondNumber();
        //dd($this->data['bond_types']);
        $this->data['invocation_date'] = $this->now->format('Y-m-d');
        // dd($this->data['invocation_date']);
       
        return view('invocation_notification.create', $this->data);
    }

    public function store(InvocationNotificationRequest $request)
    {
        // dd($request->all());
        //$bonTypeData = BondTypes::where('id',$request->bond_type)->first();
       // $bondName = Str::slug($bonTypeData->name);
        $check_entry = InvocationNotification::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
            return redirect()->route('invocation-notification.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $input = $request->except(['_token','invocation_notification_attachment','notice_attachment','from_bond', 'contract_agreement', 'beneficiary_communication_attachment', 'legal_documents', 'any_other_documents', 'invocation_notification_attachment_count', 'notice_attachment_count', 'contract_agreement_count', 'beneficiary_communication_attachment_count', 'legal_documents_count', 'any_other_documents_count']);
            $input['code'] = codeGenerator('invocation_notification', 4, 'INV');
            $input['total_outstanding_amount'] =  $input['invocation_amount'];
            $invocationNotification = InvocationNotification::create($input);
            $invocation_id = $invocationNotification->id;

            $notificationDocments = [
                'any_other_documents',
                'legal_documents',
                'beneficiary_communication_attachment',
                'contract_agreement',
                'invocation_notification_attachment',
                'notice_attachment',
            ];

            forEach($notificationDocments as $item){
                if($request->hasFile($item)){
                    $this->common->storeMultipleFiles($request, $request[$item], $item, $invocationNotification, $invocation_id, 'invocation_notification');
                }
            }

            // $this->common->storeMultipleFiles($request, $request['invocation_notification_attachment'], 'invocation_notification_attachment', $invocationNotification, $invocation_id, 'invocation_notification');

            // $this->common->storeMultipleFiles($request, $request['notice_attachment'], 'notice_attachment', $invocationNotification, $invocation_id, 'invocation_notification');

            // foreach (['notice_attachment'] as $documentType) {
            //     $filePath = uploadFile($request, 'invocation_notification/' . $invocation_id, $documentType);
            //     $fileName  =  basename($filePath);
            //     // $fileName = $documentType->getClientOriginalName();
            //     $invocationNotification->dMS()->create([
            //         'file_name' => $fileName,
            //         'attachment' => $filePath,
            //         'attachment_type' => $documentType,
            //         'checklist_bond_type' => $request->bond_type,
            //     ]);
            // }            
           
            $casesInput = [
                'case_type' => 'Review',
                'contractor_id' => $request->contractor_id,
                'proposal_id' => $request->proposal_id,
                'beneficiary_id' => $request->beneficiary_id,
                'tender_id' => $request->tender_id,
                'bond_type_id' => $request->bond_type_id,
                'bond_start_date' => $request->bond_start_date,
                'bond_end_date' => $request->bond_end_date,
            ];
            $invocationNotification->cases()->create($casesInput);

            // $getProposal = Proposal::where('proposal_parent_id', $request->proposal_id)->where('is_amendment', 0)->first();

            $getProposal = Proposal::where('code', $invocationNotification->proposal->code)->where('status', '!=', 'Issued')->get();

            if(isset($getProposal)) {
                foreach($getProposal as $item) {
                    $item->update(['is_amendment' => 1]);
                }
            }
            // if($getProposal && $getProposal->version > 1){
            //     $getProposal->update(['is_amendment' => 1]);
            // }

            Proposal::where('id',$request->proposal_id)->update(['is_invocation_notification' => '1', 'status' => 'Invoked', 'is_amendment' => 0]);
             
            DB::commit();           
            return redirect()->route('invocation-notification.index')->with('success', __('invocation_notification.create_success'));
            // } else {
            //     return redirect()->route('invocation-notification.index')->with('success', __('invocation_notification.create_success'));
            // }
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating invocation notification: ' . $e->getMessage());
            throw $e;
        }
    }

    public function show($id)
    {
        $invocationData = InvocationNotification::with([
            'bondType',
            'dMS',
            'proposal',
            'recovery',
            'claimExaminerLog.claimExaminer',
            'claimExaminerLog.createdBy',
            'cancellelationReason:id,reason,description',
            'contractor.group',
            // 'claimExaminer:id,user_id',
            'claimExaminer',
            'cases',
            'analysis',
            'invocationNotificationHistory'=>
            fn($q) => $q->where('id','<',$id)->with(
                'proposal:id,contractor_company_name,beneficiary_company_name,pd_project_name,tender_header',
                'bondType:id,name as bond_type'
            )
        ])
       ->findOrFail($id);  
            
        $bondType = $invocationData->BondType->name;
        $bondname = Str::slug($bondType); 
        $bondData = [];
        $this->data['invocationData'] = $invocationData;
        $this->data['document_type'] = $this->common->getDocumentTypeOpction();
        $this->data['file_source'] = $this->common->getFileSourceOpction();
        $this->data['dms_data'] = $invocationData->dMS->groupBy('attachment_type');
        $this->data['general_docs'] = $invocationData->dMS->where('attachment_type', '!=', 'attachment');
        $this->data['other_docs'] = DMS::where('dmsable_id', $invocationData->contractor_id)->where('dmsable_type', 'Other')->orderBy('created_at')->get();
        $this->data['review_docs'] = DMS::leftJoin('cases', function ($join) {
                    $join->on('dms.dmsable_id', '=', 'cases.id');
                })
                ->where('cases.casesable_type', 'InvocationNotification')
                ->where('cases.casesable_id', $id)
                ->where('dms.dmsable_type', 'Cases')
                ->where('dms.dmsamend_type', 'InvocationNotification')
                ->select('dms.*', 'cases.id as caseId')
                ->orderBy('dms.created_at')
                ->get();
        // dd($this->data['review_docs']);
        $this->data['bondData'] = $bondData;
        $proposalData = $invocationData->proposal;
        $this->data['contractor'] = $proposalData->contractor->company_name;
        $this->data['beneficiary'] = $proposalData->beneficiary->company_name;
        $this->data['project_name'] = $proposalData->projectDetails->project_name;
        $this->data['tender'] = $proposalData->tender_id;
        $this->data['claim_examiner'] = $this->common->getClaimExaminer();
        $this->data['cancellelation_reason'] = $this->common->getInvocationReason();
        $this->data['reference_no'] = BondPoliciesIssue::where('id', $invocationData->bond_policies_issue_id)->pluck('reference_no')->first();

        $nbi = $proposalData->nbi->where('status', 'Approved')->first();
        $currency_symbol = $nbi ? $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first() : '';
        $this->currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
        view()->share('currencySymbol', $this->currencySymbol);
        $this->data['recoveries'] = $invocationData->recovery;
        //$this->data['bond_permission'] = $bond_permission;
        return view('invocation_notification.show', $this->data);
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

    public function getProposalList(Request $request){
        $bond_type = $request->bond_type;
        if($bond_type > 0){
            $proposalData = Proposal::where(['is_invocation_notification' => 0,'is_amendment' => 0,'status'=> 'Approved', 'is_issue' => 1])->where('bond_type',$bond_type)->get();            
            return $proposalData;

        }
    }

    public function getBondData(Request $request){
        // dd($request->all());
        $bond_policies_issue_id = $request->bond_policies_issue_id;
        if($bond_policies_issue_id > 0){
            $bondData = DB::table('bond_policies_issue')
            ->leftJoin('proposals', 'bond_policies_issue.proposal_id', '=', 'proposals.id')
            ->leftJoin('principles', 'proposals.contractor_id', '=', 'principles.id')
            ->leftJoin('beneficiaries', 'proposals.beneficiary_id', '=', 'beneficiaries.id')
            ->leftJoin('project_details', 'proposals.project_details', '=', 'project_details.id')
            ->leftJoin('tenders', 'proposals.tender_details_id', '=', 'tenders.id')
            ->leftJoin('bond_types', 'proposals.bond_type', '=', 'bond_types.id')
            ->leftJoin('nbis', 'bond_policies_issue.proposal_id', '=', 'nbis.proposal_id')->where('nbis.status', 'Approved')
            ->leftJoin('currencys', 'nbis.contract_currency_id', '=', 'currencys.id')
            ->select([
                'principles.company_name as contractor',
                'beneficiaries.company_name as beneficiary',
                'project_details.project_name',
                'tenders.tender_id as tender',
                'bond_types.name as bond_type',
                'proposals.bond_value as bond_value',
                'proposals.bond_start_date as bond_start_date',
                'proposals.bond_end_date as bond_end_date',
                'proposals.id as proposal_id',
                'nbis.bond_conditionality as bond_conditionality',
                'principles.id as contractor_id',
                'beneficiaries.id as beneficiary_id',
                'tenders.id as tender_id',
                'project_details.id as project_details_id',
                'bond_types.id as bond_type_id',
                'bond_policies_issue.bond_number as bond_number',
                'currencys.symbol as currency_symbol',
            ])
            ->where('bond_policies_issue.id', $bond_policies_issue_id)
            ->first();

            $encryptedID = encryptId($bondData->proposal_id);
            $bondData->encryptedID = $encryptedID;

            return $bondData;
        }
    }

    public function invocationPayout(InvocationNotificationPayoutRequest $request,$id){

        $input = $request->validated();
        $input['status'] = 'Paid';
  
        InvocationNotification::firstWhere('id',$id)->update($input);

        return back()->withSuccess(__('common.update_success'));
    }
    

    public function invocationClaimExaminer(InvocationNotificationClaimExaminerRequest $request,$id){
        $input = $request->validated();

        list($claim_examiner_type, $claim_examiner_id) = parseGroupedOptionValue($request->claim_examiner_id);
        
        DB::beginTransaction();
        try {
            
            InvocationNotification::firstWhere('id',$id)
            ->update([
                'claim_examiner_id'=>$claim_examiner_id ?? null,
                'claim_examiner_type' => $claim_examiner_type ?? null,
                'claim_examiner_assigned_date'=>now()
            ]);

            InvocationNotificationClaimExaminerLog::create([
                'invocation_notification_id'=>$id,
                'claim_examiner_id'=>$claim_examiner_id ?? null,
                'claim_examiner_type' => $claim_examiner_type ?? null,
                'claim_examiner_assigned_date'=>now()
            ]);

            DB::commit();

            return back()->withSuccess(__('common.update_success'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error',__('common.something_went_wrong_please_try_again'));
        }
    
    }

    public function invocationCancellelation(InvocationCancellelationRequest $request,$id){
        $input = $request->validated();
        $input['status'] = 'Cancel';
        
        InvocationNotification::firstWhere('id',$id)
            ->update($input);

        return back()->withSuccess(__('common.update_success'));
    }

    public function invocationActionplan(InvocationNotificationAnalysisRequest $request,$id){
        $input = $request->validated();
        $input['invocation_notification_id'] = $id;

        InvocationNotificationAnalysis::create($input);

        return back()->withSuccess(__('common.create_success'));
    }

    public function dmsattachment(InvocationNotificationDmsRequest $request){
        

        $input = $request->validated();

        DB::beginTransaction();

        try {
         
             $invocationNotification = InvocationNotification::findOrFail($input['id']);


             $this->common->storeMultipleFiles($request,$input['attachment'],'attachment',$invocationNotification,$invocationNotification->id,"invocation_notification/{$invocationNotification->code}");
 
             DB::commit();
 
             return back()->withSuccess(__('common.create_success'));
 
         } catch (\Throwable $th) {
             DB::rollBack();
             return back()->withErrors(__('common.something_went_wrong_please_try_again'));
         }
    }

    public function dmsattachmentdownload($id){
        $dms_attachments = DMS::AttachmentInsideDmsTab('Cases',$id)->get();

        $this->data['dms_attachments'] = $dms_attachments;

        return response()->json(['html'=> view('cases.modal.dms.dms_download_attachment.index',$this->data)->render()]);
    
    }

    public function dmsAttachmentComment($id){
        
        $dms_attachment = DMS::AttachmentInsideDmsTab('Cases',$id)->first();
        $this->data['dms_attachment'] = $dms_attachment;

        return response()->json(['html'=>view('invocation_notification.modal.dms.dms_comment.index',$this->data)->render()]);
    }

    public function dmsAttachmentStoreComment(Request $request){

       $validated =  $request->validate([
            'comment'=>['required', new Remarks],
            'dms_id'=>'required'
        ]);

        $dms = DmsComment::create($validated);

        if ($dms) {
            return back()->withSuccess(__('common.create_success'));
        }
        return back()->withErrors(__('common.something_went_wrong_please_try_again'));
    }

    public function dmsAttachmentCommentLog($id){

        $comments = DmsComment::with('createdBy')->where('dms_id',$id)->get();
        $this->data['comments'] = $comments;

        return response()->json(['html'=> view('invocation_notification.modal.dms.dms_comment_log.index',$this->data)->render()]);
      
    }

    public function dmsUpdate(Request $request,$id){

        $validated = $request->validate([
            'final_submission'=>'required',
            'document_type_id'=>'required',
            'file_source_id'=>'required',
        ]);
       DB::beginTransaction();

       try {
            /*$dmsamend_id = $request->dmsamend_id ?? null;*/
            $update_data = [
                'final_submission'=>$request->final_submission ??  'No',
                /*'dmsamend_id'=>$dmsamend_id,
                'dmsamend_type'=>($dmsamend_id > 0) ? 'Principle':  Null,*/
                'document_type_id'=>$request->document_type_id ??  Null,
                'file_source_id'=>$request->file_source_id ??  Null,
            ];
            DMS::where('id', $id)->update($update_data);
            DB::commit();
            return back()->withSuccess(__('dms.amendment_hase_been_successfully'));

        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->withErrors(__('common.something_went_wrong_please_try_again'));
        }
    }

    public function checkClaimExaminerApprovedLimit(Request $request, InvocationNotification $invocationData){
        list($claim_examiner_type, $claim_examiner_id) = parseGroupedOptionValue($request->claim_examiner_id);

        if($claim_examiner_type == 'User'){
            $userMaxApprovedLimit = User::where('id', $claim_examiner_id)->pluck('claim_examiner_max_approved_limit')->first();
        } else {
            $userMaxApprovedLimit = ClaimExaminer::where('id', $claim_examiner_id)->pluck('max_approved_limit')->first();
        }

        if(isset($invocationData->claim_examiner_id) && $claim_examiner_id == $invocationData->claim_examiner_id) {
           $result = 1;
        } else if($userMaxApprovedLimit <= $invocationData->invocation_amount) {
            $result = 2;
        } else {
            $result = '';
        }
        return $result;
    }
}
