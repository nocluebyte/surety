<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{
    BondForeClosure,
    BondPoliciesIssue,
    Proposal,
    CasesDecision,
    UtilizedLimitStrategys,
    CasesBondLimitStrategy,
    CasesLimitStrategy
};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BondForeClosureRequest;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BondForeClosureController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('permission:proposals.bond_fore_closure', ['only' => ['create', 'store']]);
        $this->title = trans('bond_fore_closure.bond_fore_closure');
        $this->common = new CommonController();
        view()->share('title', $this->title);
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $proposal_id = $request->proposal_id;
        $bondPoliciesIssue = BondPoliciesIssue::where('proposal_id', $proposal_id)->first();
        $this->data['bondNumber'] = $bondPoliciesIssue->bond_number;
        $this->data['reference_no'] = $bondPoliciesIssue->reference_no;
        $proposal = Proposal::findOrFail($proposal_id);

        $this->data['contractors'] = $this->common->getContractor();
        $this->data['beneficiary'] = $this->common->getBeneficiary();
        $this->data['project_details'] = $this->common->getProjectDetails();
        $this->data['tenders'] = $this->common->getTender();
        $this->data['bond_types'] = $this->common->getBondTypes();
        $this->data['nbi'] = $proposal->nbi()->where('status', 'Approved')->first();
        $nbi = $this->data['nbi'];
        $this->data['currency_symbol'] = $nbi ? $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first() : '';

        $this->data['type_of_foreclosure'] = $this->common->getTypeofForeClosure();
        $this->data['proposal'] = $proposal;
        $this->data['start_foreclosure_date'] = Carbon::parse($proposal->bond_start_date)->addDay()->format('Y-m-d');

        $backAction = route($request->type . '.show', encryptId($request->back_action_id));
        $this->data['backAction'] = $backAction;
        $this->data['type'] = $request->type;
        $this->data['back_action_id'] = $request->back_action_id;

        return view('bond_fore_closure.create', $this->data);
    }

    public function store(BondForeClosureRequest $request)
    {
        $check_entry = BondForeClosure::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->bond_number == $request['bond_number'])) {
            return back()->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try {
            $input = $request->except(['_token', 'backAction', 'proof_of_foreclosure_count', 'original_bond_received_attachment_count', 'confirming_foreclosure_attachment_count', 'any_other_proof_attachment_count', 'proof_of_foreclosure', 'original_bond_received_attachment', 'confirming_foreclosure_attachment', 'any_other_proof_attachment', 'type', 'back_action_id', 'issue_bond_number']);

            $bondForeClosure = BondForeClosure::create($input);

            $foreClosureAttachments = [
                'proof_of_foreclosure',
                'original_bond_received_attachment',
                'confirming_foreclosure_attachment',
                'any_other_proof_attachment',
            ];

            foreach($foreClosureAttachments as $item){
                if($request->hasFile($item)){
                    $this->common->storeMultipleFiles($request, $request[$item], $item, $bondForeClosure, $bondForeClosure->id, 'bond_fore_closure');
                }
            }

            $proposal = Proposal::firstWhere('id', $bondForeClosure->proposal_id);

            
            $proposal->cases()->update([
                'is_bond_managment_action_taken'=>1,
                'bond_managment_action_type'=>'bond_foreclosure'
            ]);

           CasesDecision::firstWhere('proposal_id',$proposal->id)->update([
             'is_bond_managment_action_taken'=>1,
             'bond_managment_action_type'=>'bond_foreclosure'
           ]);

           $proposal->update(['is_bond_foreclosure' => 1,'status'=>'Forclosed']);

           
           UtilizedLimitStrategys::where('proposal_code',$proposal->code)->update([
                'is_bond_managment_action_taken'=>1,
                'bond_managment_action_type'=>'bond_foreclosure'
           ]);


           $bond_limit_strategy =  CasesBondLimitStrategy::firstWhere([
                'contractor_id'=>$proposal->contractor_id,
                'bond_type_id'=>$proposal->bond_type,
                'is_current'=>0
           ]);

           if (isset($bond_limit_strategy)) {

            $bond_current_cap = $bond_limit_strategy->bond_current_cap;
            $bond_utilized_cap = $bond_limit_strategy->utilizedlimit()->where([
                'is_current'=>0,
                'is_amendment'=>0,
                'is_bond_managment_action_taken'=>0
            ])->sum('value');
            $bond_utilized_cap_persontage = safe_divide($bond_utilized_cap * 100, $bond_current_cap);
            $bond_remaining_cap = $bond_current_cap - $bond_utilized_cap;
            $bond_remaining_cap_persontage = safe_divide($bond_remaining_cap * 100, $bond_current_cap);

           $bond_limit_strategy->update([
                'bond_utilized_cap'=>$bond_utilized_cap,
                'bond_utilized_cap_persontage'=>$bond_utilized_cap_persontage,
                'bond_remaining_cap'=>$bond_remaining_cap,
                'bond_remaining_cap_persontage'=>$bond_remaining_cap_persontage
           ]);

        }

            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', __('common.something_went_wrong_please_try_again'));
        }

        return redirect()->route($request->type . '.show', encryptId($request->back_action_id))->with('success', __('bond_fore_closure.create_success'));
    }
}
