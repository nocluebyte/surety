<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\PremiumRequest;
use App\DataTables\PremiumDataTable;
use App\Models\{Premium, Proposal, PremiumContractors, BondPoliciesIssueChecklist};
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Str;

class PremiumController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['except' => ['index', 'getProposalbyBond', 'getProposalbyBond']]);
        $this->middleware('permission:premium.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:premium.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:premium.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:premium.delete', ['only' => 'destroy']);

        $this->common = new CommonController();
        $this->title = trans('premium.premium');
        view()->share('title', $this->title);
    }

    public function index(PremiumDataTable $datatable)
    {
        $this->data = [];        
        $this->data['type_of_bond'] = $this->common->getBondTypes();
        return $datatable->render('premium.index', $this->data);
    }

    public function create()
    {
        $this->data['bond_types'] = $this->common->getBondTypes();
        $this->data['generateCode'] = codeGenerator('premium_collections', 4, 'PR'); 
        $this->data['tenders'] = $this->common->getTender();
        $this->data['beneficiary'] = $this->common->getBeneficiary();

        return view('premium.create', $this->data);
    }

    public function store(PremiumRequest $request)
    {
        $check_entry = Premium::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->proposal_id == $request['proposal_id'])) {
            return redirect()->route('premium.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try {
            $input = $request->validated();
            $input['code'] = codeGenerator('premium_collections', 4, 'PR'); 
            $premium = Premium::create($input);
           
            $contractors = $request->contractor_data;
            foreach($contractors as $item){
                $pContractors = [
                    'premium_id' => $premium->id,
                    'contractor_id' => $item['contractorID'],
                ];
                PremiumContractors::create($pContractors);
            }
            DB::commit();
        }
        catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('premium.create')->with('error', __('common.something_went_wrong_please_try_again'));
        }

        if ($request->save_type == "save") {
            return redirect()->route('premium.create')->with('success', __('premium.create_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('premium.index')->with('success', __('premium.create_success'));
        } else {
            return redirect()->route('premium.index')->with('success', __('premium.create_success'));
        }
    }

    public function show($id)
    {
        // $invocationData = Premium::with('bondType','premiumContractors')->where('id',$id)->first();                
        // $bondType = $invocationData->BondType->name;
        // $bondname = Str::slug($bondType); 
        // $bondData = [];
        // $this->data['invocationData'] = $invocationData;
        // $this->data['dms_data'] = $invocationData->dMS->groupBy('attachment_type');
        // $this->data['bondData'] = $bondData;
        //$this->data['bond_permission'] = $bond_permission;
        // dd($id);
        $bond_policy_issue_checklist = BondPoliciesIssueChecklist::with('dMS', 'contractor')->where('id', $id)->first();
        $this->data['issue_checklist_dms'] = isset($bond_policy_issue_checklist) ? $bond_policy_issue_checklist->dMS->groupBy('attachment_type') : [];
        $this->data['bond_policy_issue_checklist'] = $bond_policy_issue_checklist;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($bond_policy_issue_checklist->contractor->country_id);
        return view('premium.show', $this->data);
    }

    public function edit($id,Request $request)
    {
        $premium = Premium::findOrFail($id);

        $this->data['bond_types'] = $this->common->getBondTypes();

        $this->data['tenders'] = $this->common->getTender($request->tender_id);
        $this->data['beneficiary'] = $this->common->getBeneficiary($request->beneficiary_id);
        $this->data['premium'] = $premium;

        return view('premium.edit', $this->data);
    }

    public function update($id, PremiumRequest $request)
    {
        // dd($request->all());
        DB::beginTransaction();
        try{
            $premium = Premium::findOrFail($id);
            $bondType = Bonds::where('id', $request->bond_id)->pluck('bondsable_type')->first();

            $premium_id = $premium->id;
            $input = $request->validated();

            $premium->update($input);
            $premium->update(['bond_type' => $bondType]);

            $contractors = $request->contractor_data;
            if (!empty($contractors) && count($contractors) > 0) {
                $currentIds = array_column($contractors, 'contractorID');

                foreach($contractors as $row){
                    $contractorID = $row['contractorID'] ?? 0;
                    $pContractors = [
                        'premium_id' => $premium_id,
                        'contractor_id' => $contractorID,
                    ];
                    if ($contractorID > 0) {
                        PremiumContractors::where('premium_id', $premium_id)->update($pContractors);
                    } else {
                        PremiumContractors::create($pContractors);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        if ($request->save_type == "save") {
            return redirect()->route('premium.edit',[$premium_id])->with('success', __('premium.update_success'));
        } else if ($request->save_type == "save_exit") {
            return redirect()->route('premium.index')->with('success', __('premium.update_success'));
        } else {
            return redirect()->route('premium.index')->with('success', __('premium.update_success'));
        }
    }

    public function destroy($id)
    {
        $premium = Premium::with('premiumContractors')->findOrFail($id);

        if($premium)
        {
            $dependency = $premium->deleteValidate($id);
            if(!$dependency)
            {
                $premium->delete();
                $premium->premiumContractors()->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('premium.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }

    public function getProposalId(Request $request)
    {
        // dd($request->all());
        $proposals = Proposal::with('proposalContractors','contractor')->where('id', $request->proposal_id)->first();
        //$getBond = $bonds->bondsable;
        // $bond_type = Bonds::with('bondsable')->where('id', $request->bond_number)->pluck('bondsable_type')->first();
        $bond_type = $proposals->bond_type;
        $proposal_id = $request->proposal_id;
        $isJvSpv = $proposals->where('id', $proposal_id)->pluck('contract_type')->first();

        $contractorID = [];
        $contractorName = [];
        if($proposal_id){
            if(in_array($isJvSpv, ['JV', 'SPV'])){
                foreach($proposals->proposalContractors as $item){
                    $contractorID[] = $item->contractor->id;
                    $contractorName[] = $item->contractor->company_name;
                }              
            } else {
                $contractorID[] = $proposals->contractor_id;
                $contractorName[] = $proposals->contractor->company_name;
            }
            $bondData['bond_value'] = $proposals->bond_value;
            $bondData['tender_id'] = $proposals->tender_details_id;
            $bondData['contractor_ids'] = $contractorID;
            $bondData['contractor_name'] = $contractorName;
            $bondData['beneficiaryID'] = $proposals->beneficiary_id;
        }
        return $bondData;
    }

    public function getProposalbyBond(Request $request){
        $bond_type = $request->bond_type;
        if($bond_type > 0){
            $proposalData = Proposal::where(['is_amendment' => 0,'status'=> 'Approved'])->where('bond_type',$bond_type)->get();            
            return $proposalData;

        }
    }
}