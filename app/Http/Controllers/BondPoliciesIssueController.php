<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\{BondPoliciesIssueRequest,BondPoliciesChecklistRequest, UpdateBondNumberRequest};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\{BondPoliciesIssue, BidBond, Beneficiary,BondPoliciesIssueChecklist, PerformanceBond,Nbi, AdvancePaymentBond, RetentionBond, MaintenanceBond, Bonds, Proposal, BondForeClosure, BondCancellation, BondProgress};
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use App\DataTables\BondPoliciesIssueDataTable;

class BondPoliciesIssueController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');

        $this->common = new CommonController();

        $this->permission = '';

        $this->middleware('encryptUrl', ['only' => ['store', 'show', 'update', 'destroy', 'edit']]);
        $this->middleware('permission:proposals.bond_issue_checklist', ['only' => ['bondPoliciesIssueChecklist', 'bondPoliciesChecklistStore']]);
        $this->middleware('permission:proposals.issue_bond', ['only' => ['create', 'store']]);

        $this->title = trans('bond_policies_issue.bond_policies_issue');

        view()->share(['title' => $this->title]);
    }

    public function index(BondPoliciesIssueDataTable $dataTable)
    {
        $this->data['bond_conditionality'] = Config('srtpl.filters.bond_conditionality');
        $this->data['type_of_bond'] = $this->common->getBondTypes();
        return $dataTable->render('bond.bond_policies_issue.index', $this->data);
    }

    public function create()
    {
        $beneficiary = Beneficiary::with('user')->get();
       
        $proposal_id = request()->get('proposal_id');
        $this->data['proposal_id'] = $proposal_id;

        $this->data['contractors'] = $this->common->getContractor();
        $this->data['currencys'] = $this->common->getCurrency();

       
        $nbiData = Nbi::with(['proposal', 'contractor', 'beneficiary', 'bondType', 'currency','hsn_code','reInsuranceGrouping'])->where('proposal_id',$proposal_id)->first();
        $this->data['nbiData'] = $nbiData;

        $this->data['checklistData'] = BondPoliciesIssueChecklist::where('proposal_id',$proposal_id)->where('is_amendment',0)->first();

        //dd($this->data['nbiData']);

        $this->data['beneficiaries'] = $this->common->getBeneficiary();
        // $this->data['beneficiary_details'] = Beneficiary::get(['id', 'address', 'phone_no'])->toArray();
        $this->data['beneficiary_address'] = $beneficiary->pluck('address', 'id')->toArray();
        $this->data['beneficiary_phone_no'] = $beneficiary->pluck('user.mobile', 'id')->toArray();
        $this->data['reference_no'] = isset($nbiData) ? 'IB/'.$nbiData->policy_no : '';
        $this->data['bond_types'] = $this->common->getBondTypes();
        $this->data['currency_symbol'] = $nbiData->currency->symbol;

        return view('bond.bond_policies_issue.create', $this->data);
    }

    public function store(BondPoliciesIssueRequest $request)
    {
        //dd($request->all());
        // $policyIssueVersion = versionGenerator('bond_policies_issue', 1, $request->proposal_id);
        // // dd($policyIssueVersion);
        // if($policyIssueVersion > 1){
        //     BondPoliciesIssue::orderBy('proposal_id','desc')->orderBy('id', 'desc')->first()->update(['is_amendment' => 1]);
        // }

        $check_entry = BondPoliciesIssue::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
            return redirect()->route('bond_policies_issue.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $bond_policies_issue_input = [
                'reference_no' => $request['reference_no'],
                'proposal_id' => $request['proposal_id'],
                'version' => $request['version'],
                'contractor_id' => $request['contractor_id'],
                'bond_number' => $request['bond_number'],
                'bond_type' => $request['bond_type'] ?? 'Proposal',
                'insured_name' => $request['insured_name'],
                'insured_address' => $request['insured_address'],
                'project_details' => $request['project_details'],
                'beneficiary_id' => $request['beneficiary_id'],
                'beneficiary_address' => $request['beneficiary_address'],
                'beneficiary_phone_no' => $request['beneficiary_phone_no'],
                'bond_conditionality' => $request['bond_conditionality'],
                'contract_value' => $request['contract_value'],
                'contract_currency' => $request['contract_currency'],
                'bond_value' => $request['bond_value'],
                'cash_margin' => $request['cash_margin'],
                'tender_id' => $request['tender_id'],
                'tender_details_id' => $request['tender_details_id'],
                'bond_period_start_date' => $request['bond_period_start_date'],
                'bond_period_end_date' => $request['bond_period_end_date'],
                'bond_period' => $request['bond_period'],
                'rate' => $request['rate'],
                'net_premium' => $request['net_premium'],
                'gst' => $request['gst'],
                'gst_amount' => $request['gst_amount'],
                'gross_premium' => $request['gross_premium'],
                'stamp_duty_charges' => $request['stamp_duty_charges'],
                'total_premium' => $request['total_premium'],
                'intermediary_name' => $request['intermediary_name'],
                'intermediary_code' => $request['intermediary_code'],
                'phone_no' => $request['phone_no'],
                'special_condition' => $request['special_condition'],
                'premium_date' => $request['premium_date'] ?? null,
                'premium_amount' => $request['premium_amount'] ?? 0,
                'additional_premium' => $request['additional_premium'] ?? null,
                'status' => 'Approved',
                'is_amendment' => 0,
                'bond_type_id' => $request['bond_type_id'] ?? null,
            ];
            $bond_policies_issue = BondPoliciesIssue::create($bond_policies_issue_input);

            if($request->hasFile('bond_stamp_paper')) {
                $this->common->storeMultipleFiles($request, $request['bond_stamp_paper'], 'bond_stamp_paper', $bond_policies_issue, $bond_policies_issue->id, 'bond_policies_issue');
            }

            $proposal = $bond_policies_issue->proposal;

            if($proposal->version > 1){
                BondPoliciesIssue::where('proposal_id', $proposal->proposal_parent_id)->update(['is_amendment' => 1]);
            }

            Proposal::where('id', $request->proposal_id)
            ->update([
                'is_issue' => 1,
                'status'=>'Issued'
            ]);

            DB::commit();
            return redirect()->route('proposals.show', encryptId($request->proposal_id))->with('success', __('bond_policies_issue.create_success'));
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating Bond Policy Issue: ' . $e->getMessage());
            throw $e;
        }
    }

    public function bondPoliciesIssueChecklist($proposal_id){
        // dd($request->all(),$bond_id);
        if($proposal_id > 0){
            $this->data['proposal_id'] = $proposal_id;

            $proposals = Proposal::with('parentProposal')->findOrFail($proposal_id);   
            $parentProposal = $proposals->parentProposal; 
            $past_premium = 0;
            if(isset($parentProposal) && $parentProposal->count()>0 && isset($parentProposal->proposalChecklist) && $parentProposal->proposalChecklist->count()>0){
                $past_premium = $parentProposal->proposalChecklist->premium_amount;                
            }   

            $this->data['past_premium'] = $past_premium;
            $this->data['proposals'] = $proposals;
            $this->data['bond_start_date'] = $proposals->bond_start_date;

            $this->data['nbiData'] = Nbi::with(['proposal', 'issuingOfficeBranch'])->where('proposal_id',$proposal_id)->where('status', 'Approved')->first();

            $this->data['title'] = trans('bond_policies_issue.bond_policies_issue_checklist');
            $this->data['currency_symbol'] = $this->common->getCurrencySymbol($proposals->contractor_country_id);

            return view('bond.bond_policies_issue.checklist', $this->data);
        }
    }

    public function bondPoliciesChecklistStore(BondPoliciesChecklistRequest $request){
        $check_entry = BondPoliciesIssueChecklist::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;

        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {            
            return redirect()->route('bondPoliciesIssueChecklist', [encryptId($request->proposal_id)])->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            // $previousChecklist = BondPoliciesIssueChecklist::with('dMS')->where('proposal_id',$request->proposal_id)->orderBy('proposal_id','desc')->orderBy('id', 'desc')->first() ?? [];

            // BondPoliciesIssueChecklist::where('proposal_id',$request->proposal_id)->where('version','<',$request->version)->update(['is_amendment' => 1]);

            // if($previousChecklist != null && $previousChecklist->proposal_id == $request->proposal_id && $previousChecklist->dMS->count() > 0){
            //     foreach($previousChecklist->dMS as $item){
            //         $item->update(['is_amendment' => 1]);
            //     }
            // }

            $input = $request->except(['_token', 'deed_attach_document','board_attach_document','broker_attach_document', 'saveBtn','agent_attach_document','collateral_attach_document']);

            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = json_encode($value);
                }
            }
           
            $bond_checklist = BondPoliciesIssueChecklist::create($input);
            //$bond_checklist->update(['is_amendment' => 0, 'version' => $request->version, 'proposal_id' => $request->proposal_id]);
            $bond_checklist_id = $bond_checklist->id;

            foreach (['deed_attach_document', 'board_attach_document', 'broker_attach_document', 'agent_attach_document', 'collateral_attach_document'] as $documentType) {
                if($request->hasFile($documentType)){
                    $this->common->storeMultipleFiles($request, $request[$documentType], $documentType, $bond_checklist, $bond_checklist_id, 'bond_checklist');

                } /*else if($previousChecklist != null && $previousChecklist->proposal_id == $request->proposal_id) {
                    $existingDoc_amendment = $previousChecklist->dMS->where('checklist_bond_type', $request->bond_type)->where('is_amendment', 0)->where('attachment_type', $documentType)->first();
                    $file_name = $existingDoc_amendment->file_name ?? '';

                    $prev_path_dir = 'uploads/bond_checklist/' . $bond_checklist_id;

                    if (!File::exists($prev_path_dir)) {
                        File::makeDirectory($prev_path_dir, 0775, true);
                    }

                    if(isset($existingDoc_amendment)){
                        $prev_path = $prev_path_dir . '/' . $existingDoc_amendment->file_name;
                        if (File::exists($existingDoc_amendment->attachment)) {
                            File::copy($existingDoc_amendment->attachment, $prev_path);
                        }

                        $bond_checklist->dMS()->create([
                            'file_name' => $existingDoc_amendment->file_name,
                            'attachment' => $prev_path,
                            'attachment_type' => $documentType,
                            'checklist_bond_type' => $request->bond_type,
                            'is_amendment' => '0',
                        ]);
                    }
                } */
            }

            // $attachment_map = [
            //     'Direct' => ['broker_attach_document', 'agent_attach_document'],
            //     'Broker' => ['agent_attach_document'],
            //     'Agent'  => ['broker_attach_document']
            // ];

            // if (isset($attachment_map[$request->broker_mandate])) {
            //     foreach ($bond_checklist->dMS as $item) {
            //         if (in_array($item->attachment_type, $attachment_map[$request->broker_mandate])) {
            //             $item->update(['is_amendment' => 1]);
            //             $item->delete();
            //             File::delete($item->attachment);
            //         }
            //     }
            // }

            // $requirementDocs = [
            //     'deed_attach_document' => 'executed_deed_indemnity',
            //     'board_attach_document' => 'executed_board_resolution',
            // ];

            // foreach ($requirementDocs as $existingDoc => $checkedFlag) {
            //     $docs = $bond_checklist->dMS()->where('attachment_type', $existingDoc)->first();

            //     if ($docs && $request->$checkedFlag == 'No') {
            //         $docs->update(['is_amendment' => 1]);
            //         $docs->delete();
            //         File::delete($docs->attachment);
            //     }
            // }

            DB::commit();
           // $proposals = Proposal::findOrFail($request->proposal_id);
           Proposal::where('id',$request->proposal_id)->where('version',$request->version)->update(['is_checklist_approved' => '1']);

            return redirect()->route('proposals.show', encryptId($request->proposal_id))->with('success', __('bond_policies_issue.create_success'));

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error creating Bond Policy Issue checklist: ' . $e->getMessage());
            throw $e;
        }
    }

    public function edit($id, Request $request)
    {
        // dd($request->all(), $id);
        $policyChecklist = BondPoliciesIssueChecklist::with('dMS')->where('proposal_id', $id)->where('is_amendment', 0)->first();

        // dd($policyChecklist);
        if($id > 0){
            $this->data['proposal_id'] = $id;

            $proposals = Proposal::findOrFail($id);
            $this->data['bond_start_date'] = $proposals->bond_start_date;

            $this->data['title'] = trans('bond_policies_issue.bond_policies_issue_checklist');
            $this->data['policyChecklist'] = $policyChecklist;
            $this->data['dms_data'] = $policyChecklist->dMS->groupBy('attachment_type');

            return view('bond.bond_policies_issue.checklist', $this->data);
        }
    }

    public function updateBondNumber(UpdateBondNumberRequest $request){
        $bond_issue_id = $request->bond_issue_id;
        $bondData = BondPoliciesIssue::where('id',$bond_issue_id)->first();
        $bondData->bond_number = $request->bond_number;
        $bondData->save();

        if($request->hasFile('bond_stamp_paper')) {
            $this->common->storeMultipleFiles($request, $request['bond_stamp_paper'], 'bond_stamp_paper', $bondData, $bond_issue_id, 'bond_policies_issue');
        }
        return redirect()->back()->with('success', __('bond_policies_issue.update_bond_number_success'));
    }

    public function show($id)
    {
        $bond_policy_issue = BondPoliciesIssue::findOrFail($id);
        $this->data['bond_policy_issue_dms'] = isset($bond_policy_issue) ? $bond_policy_issue->dMS->groupBy('attachment_type') : [];
        $this->data['bond_policy_issue'] = $bond_policy_issue;
        $proposals = $bond_policy_issue->proposal;
        $this->data['proposals'] = $proposals;
        $nbi = $proposals->nbi->where('status', 'Approved')->first();
        $currency_symbol = $nbi ? $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first() : '';
        $this->currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
        view()->share('currencySymbol', $this->currencySymbol);
        $this->data['nbis'] = $nbi;

        $bond_foreclosure = BondForeClosure::with('dMS')->where('proposal_id', $proposals->id)->first();
        $this->data['bond_foreclosure_dms'] = isset($bond_foreclosure) ? $bond_foreclosure->dMS->groupBy('attachment_type') : [];
        $this->data['bond_foreclosure'] = $bond_foreclosure;

        $bond_cancellation = BondCancellation::with('dMS')->where('proposal_id', $proposals->id)->first();
        $this->data['bond_cancellation_dms'] = isset($bond_cancellation) ? $bond_cancellation->dMS->groupBy('attachment_type') : [];
        $this->data['bond_cancellation'] = $bond_cancellation;

        $bond_progress = BondProgress::with('dMS')->where('proposal_id', $proposals->id)->get() ?? [];
        $this->data['bond_progress'] = $bond_progress;

        return view('bond.bond_policies_issue.show', $this->data);
    }
}
