<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{BondPoliciesIssueChecklist, BondProgress, Proposal, Premium};
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BondProgressRequest;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BondProgressController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');

        $this->common = new CommonController();
        $this->title = trans('bond_progress.bond_progress');
        $this->middleware('encryptUrl', ['except' => ['index', 'create']]);
        $this->middleware('permission:proposals.bond_progress', ['only' => ['index','show','create','store']]);
        view()->share(['title' => $this->title]);
    }

    public function index()
    {
        // return [
        //     $bidbonddatatable->render('bid_bond.index'),
        //     $performancebonddatatable->render('performance_bond.index'), $advancePaymentBondDatatable->render('advance_payment_bond.index'), $retentionBondDataTable->render('retention_bond.index'),
        //     $maintenanceBondDataTable->render('maintenance_bond.index'),
        // ];
    }

    public function create(Request $request)
    {
        // dd($request->all());
        $id = $request->get('id',false);
        $this->data = [];
        $proposalData = Proposal::with(['nbi','proposalContractors','adverseInformation'])->findOrFail($id);    
      
        // $bonds = Bonds::with('bondsable')->where('bondsable_id', $id)->where('bondsable_type', $request->bond_type)->first();

        $backAction = route($request->type . '.show', encryptId($request->back_action_id));
        $this->data['type'] = $request->type;
        $this->data['back_action_id'] = $request->back_action_id;

        // $bondType = $bonds->bondsable_type ?? '';

        // $this->data['bondData'] = $bonds->bondsable ?? [];
        // $bondData = $this->data['bondData'];

        // $bondContractors = [];
        // $backAction = '';
        // if($request->bond_type == 'BidBond'){
        //     $bondContractors = $bondData->bidBondContractors ?? [];
        //     $backAction = 'bid-bond';
        // }else if($request->bond_type == 'PerformanceBond'){
        //     $bondContractors = $bondData->performanceBondContractors ?? [];
        //     $backAction = 'performance-bond';
        // }else if($request->bond_type == 'AdvancePaymentBond'){
        //     $bondContractors = $bondData->advancePaymentBondContractors ?? [];
        //     $backAction = 'advance-payment-bond';
        // }else if($request->bond_type == 'RetentionBond'){
        //     $bondContractors = $bondData->retentionBondContractors ?? [];
        //     $backAction = 'retention-bond';
        // }else if($request->bond_type == 'MaintenanceBond'){
        //     $bondContractors = $bondData->maitenanceBondContractors ?? [];
        //     $backAction = 'maintenance-bond';
        // }

        // // if (array_key_exists($bondType, $this->bondTypeMap)) {
        // //     $bondTypeClass = $this->bondTypeMap[$bondType];
        // //     $bondData = $bondTypeClass::findOrFail($id);
        // // }
        // // $this->data['bondData'] = $bondData;

        $this->data['backAction'] = $backAction ?? '';
        $this->data['proposalData'] = $proposalData ?? [];

        $isJvSpv = isset($proposalData) && !empty($proposalData) ? $proposalData->contract_type : '';
        $this->data['adverseInfo'] = $proposalData->adverseInformation ?? [];          
        $this->data['isJvSpv'] = $isJvSpv;
        // $premiumIds = $bondData->where('code', $bondData->code)->pluck('id') ?? [];
                $premiumDetails = BondPoliciesIssueChecklist::where('proposal_id', $proposalData->id)->firstWhere('is_amendment',0);
        $this->data['premiumDetails'] = $premiumDetails;
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($proposalData->contractor_country_id);

        return view('bond_progress.create', $this->data);
    }

    public function store(BondProgressRequest $request)
    {
        // dd($request->all());
        // $getBonds = Bonds::with('bondsable')->where('bondsable_id', $request->bond_id)->where('bondsable_type', $request->bond_type)->first();

        $input = [
            'proposal_id' => $request->proposal_id,
            'bond_type' => $request['bond_type'],
            'progress_date' => $request['progress_date'],
            'progress_remarks' => $request['progress_remarks'],
            'physical_completion_remarks' => $request['physical_completion_remarks'],
            'dispute_initiated' => $request['dispute_initiated'],
            'dispute_initiated_remarks' => $request['dispute_initiated_remarks'],
        ];

        $bondProgress = BondProgress::create($input);

        foreach (['progress_attachment','physical_completion_attachment'] as $documentType) {
            if($request->hasFile($documentType)){
                $this->common->storeMultipleFiles($request, $request[$documentType], $documentType, $bondProgress, $bondProgress->id, 'bond_progress/' . $request->code);
            }
        }

        return redirect()->route($request->type . '.show', encryptId($request->back_action_id))->with('success', __('bond_progress.create_success'));

    }
}
