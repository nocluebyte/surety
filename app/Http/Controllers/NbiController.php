<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\{Proposal,Nbi,NbiLog, Currency,HsnCode,Setting, UtilizedLimitStrategys};
use App\Http\Requests\{NbiRequest};
use Illuminate\Support\Facades\DB;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use App\Exports\{NbiExport};
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use App\Service\LeegalityService;

class NbiController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['store', 'show', 'update', 'destroy', 'edit', 'export', 'pdfExport']]);
        $this->middleware('permission:proposals.nbi_list', ['only' => ['index']]);
        $this->middleware('permission:nbi.view', ['only' => ['show']]);
        $this->middleware('permission:proposals.terms_sheet', ['only' => ['create', 'store']]);

        $this->common = new CommonController();
        $this->title = trans('nbi.title');
        view()->share('title', $this->title);
    }
    public function index(ProposalDataTable $datatable)
    {
        return $datatable->render('proposals.index');
    }
    public function create(Request $request)
    {
        $id = $request->get('id',false);
        $proposal =  Proposal::with(['createdBy', 'sourceName', 'proposalContractors','projectDetails','Endorsement','tradeSector'])->findOrFail($id);  
        
        $this->data['proposal'] = $proposal;
        $trade_sector_data = $proposal->tradeSector->where('is_main','Yes')->first();
        $this->data['trade_sector_data'] = $trade_sector_data ?? '';        
     
        if($proposal->status == 'Reject'){
            $proposal->bond_value = 0;
        }
        $seriesNumber = codeGenerator('nbis', 2, $id);
        $this->data['seriesNumber'] = $seriesNumber;
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['beneficiary'] = $this->common->getBeneficiary();
        $this->data['bondTypes'] = $this->common->getBondTypes();
        $this->data['currencys'] = $this->common->getCurrency();
        $hsn_codes = $this->get_hsn();
        $this->data['hsn_codes'] = $hsn_codes->pluck('hsn_code', 'id')->toArray();
        $hsnAttr = [];
        if ($hsn_codes->count() > 0) {
            foreach ($hsn_codes as $key => $hsn) {
                $hsnAttr[$hsn->id] = ['id' => $hsn->id, 'hsn_code' => $hsn->hsn_code, 'igst' => $hsn->igst, 'cgst' => $hsn->cgst, 'sgst' => $hsn->sgst];
            }
        }
        $this->data['hsnAttr'] = $hsnAttr;
        $this->data['re_insurance_grouping'] = $this->common->getReInsuranceGrouping();
        $this->data['issuingOfficeBranchs'] = $this->common->getIssuingOfficeBranch();
        $this->data['sector'] = $this->common->getTradeSector();
        $this->data['currency_symbol'] = $this->common->getCurrencySymbol($proposal->contractor->country_id);
        return view('nbi.create', $this->data);
    }
    public function store(NbiRequest $request,LeegalityService $leegalityService)
    {
        $policyIssueVersion = versionGenerator('nbis', 1, $request->proposal_id);

        $check_entry = Nbi::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        $proposal_id = $request->proposal_id;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
            return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('success', 'Please Check into proposal entry added succesfully you submit form multiple time!!');
        }
        DB::beginTransaction();
        try{
            $seriesNumber = codeGenerator('nbis', 2, $proposal_id);
            $nbi_data = [
                'policy_no'=>$seriesNumber,
                'proposal_id'=>$proposal_id,
                'version'=>$policyIssueVersion ?? null,
                'contractor_id'=>$request->contractor_id ?? null,
                'insured_address'=>$request->insured_address ?? null,
                'endorsement_number'=>$request->endorsement_number ?? null,
                'project_details'=>$request->project_details ?? null,
                'beneficiary_id'=>$request->beneficiary_id ?? null,
                'beneficiary_address'=>$request->beneficiary_address ?? null,
                'beneficiary_contact_person_name'=>$request->beneficiary_contact_person_name ?? null,
                'beneficiary_contact_person_phone_no'=>$request->beneficiary_contact_person_phone_no ?? null,
                'bond_type'=>$request->bond_type ?? null,
                //'bond_number'=>$request->bond_number ?? null,
                'bond_conditionality'=>$request->bond_conditionality ?? null,
                'contract_value'=>$request->contract_value ?? null,
                'contract_currency_id'=>$request->contract_currency_id ?? null,
                'bond_value'=>$request->bond_value ?? null,
                'cash_margin_if_applicable'=>$request->cash_margin_if_applicable ?? null,
                'cash_margin_amount' => $request->cash_margin_amount ?? null,
                'tender_id_loa_ref_no'=>$request->tender_id_loa_ref_no ?? null,
                'bond_period_start_date'=>custom_date_format($request->bond_period_start_date,'Y-m-d'),
                'bond_period_end_date'=>custom_date_format($request->bond_period_end_date,'Y-m-d'),
                'bond_period_days'=>$request->bond_period_days ?? null,
                'initial_fd_validity' => $request->initial_fd_validity,
                'rate'=>$request->rate ?? null,
                'net_premium'=>$request->net_premium ?? null,
                'hsn_code_id'=>$request->hsn_code_id ?? null,
                'cgst'=>$request->cgst ?? null,
                'cgst_amount'=>$request->cgst_amount ?? null,
                'sgst'=>$request->sgst ?? null,
                'sgst_amount'=>$request->sgst_amount ?? null,
                'igst'=>$request->igst ?? null,
                'gst_amount'=>$request->gst_amount ?? null,
                'gross_premium'=>$request->gross_premium ?? null,
                'stamp_duty_charges'=>$request->stamp_duty_charges ?? null,
                'total_premium_including_stamp_duty'=>$request->total_premium_including_stamp_duty ?? null,
                'intermediary_name'=>$request->intermediary_name ?? null,
                'intermediary_code_and_contact_details'=>$request->intermediary_code_and_contact_details ?? null,
                'bond_wording'=>$request->bond_wording ?? null,
                're_insurance_grouping_id'=>$request->re_insurance_grouping_id ?? null,
                'issuing_office_branch_id'=>$request->issuing_office_branch_id ?? null,
                'trade_sector_id' => $request->trade_sector_id ?? null,
            ];
            $nbi = Nbi::create($nbi_data);

            if($nbi->proposal->is_amendment == 1 && $nbi->proposal->status == 'Rejected') {
                $nbi->update(['status' => 'Rejected']);
                $nbi->proposal->update(['nbi_status' => 'Rejected']);
            }

            DB::commit();
            return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('success', __('nbi.create_success'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('error', __('common.something_went_wrong_please_try_again'));
        }
    }
    public function show($id,$is_export = false){
        $this->data['nbi'] = Nbi::with(['proposal', 'contractor', 'beneficiary', 'bondType', 'currency','hsn_code','reInsuranceGrouping'])->findOrFail($id);
        $nbi = $this->data['nbi'];
        $this->data['currency_symbol'] = $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first();
        if($is_export){
            return $this->data;
        }else{
            return view('nbi.show', $this->data);
        }
    }
    public function nbiStatusChange(Request $request){
        // dd($request->all());
        $id = $request->id;
        $new_status = $request->new_status;
        DB::beginTransaction();
        try{
            $nbi = Nbi::findOrFail($id);
            $nbi->update(['status' => $new_status, 'rejection_reason_id' => $request->rejection_reason_id ?? null]);
            $case = $nbi->proposal->cases->first();
            $caseDecision = $case->casesDecision()->update(['nbi_status' => $new_status]);
            $utilizedLimit = UtilizedLimitStrategys::where('cases_id', $case->id)->update(['nbi_status' => $new_status]);
            $case->update(['nbi_status' => $new_status]);

            $previousNbi = Nbi::where('proposal_id', $nbi->proposal_id)->whereNotIn('id', [$nbi->id])->get();
            if(isset($previousNbi)){
                foreach($previousNbi as $item){
                    $item->update(['status' => 'Cancelled']);
                }
            }

            $proposalData = Proposal::where('id', $nbi->proposal_id)->first();
            if($new_status == 'Rejected'){
                Proposal::where('id', $proposalData->proposal_parent_id)->update(['is_amendment' => 0]);
            }

            Proposal::where('id',$nbi->proposal_id)->update([
                'is_nbi' => '1',
                'nbi_status' => $new_status ?? null,
                'is_amendment' => $new_status == 'Rejected' ? 1 : 0,
            ]);

            $logsArr = [
                'nbi_id'=>$id,
                'proposal_id'=>$nbi->proposal_id,
                'current_status'=>$nbi->status,
                'new_status'=>$new_status,
                'remarks'=>$request->remarks ?? Null,
            ];
            NbiLog::Create($logsArr);
            $message = 'This NBI has been '.strtolower($new_status).' succesfully.';
            Session::flash('success', $message);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    public function edit($id)
    {
        $nbi = Nbi::with(['proposal'])->findOrFail($id);
        $proposal =  $nbi->proposal;
        $this->data['proposal'] = $proposal;
        $this->data['nbi'] = $nbi;
        $this->data['contractors'] = $this->common->getContractor();
        $this->data['beneficiary'] = $this->common->getBeneficiary();
        $this->data['bondTypes'] = $this->common->getBondTypes();
        $this->data['currencys'] = $this->common->getCurrency();
        $hsn_codes = $this->get_hsn();
        $this->data['hsn_codes'] = $hsn_codes->pluck('hsn_code', 'id')->toArray();
        $hsnAttr = [];
        if ($hsn_codes->count() > 0) {
            foreach ($hsn_codes as $key => $hsn) {
                $hsnAttr[$hsn->id] = ['id' => $hsn->id, 'hsn_code' => $hsn->hsn_code, 'igst' => $hsn->igst, 'cgst' => $hsn->cgst, 'sgst' => $hsn->sgst];
            }
        }
        $this->data['hsnAttr'] = $hsnAttr;
        $this->data['re_insurance_grouping'] = $this->common->getReInsuranceGrouping($nbi->re_insurance_grouping_id);
        $this->data['issuingOfficeBranchs'] = $this->common->getIssuingOfficeBranch($nbi->issuing_office_branch_id);
        $this->data['sector'] = $this->common->getTradeSector($nbi->trade_sector_id);
        return view('nbi.edit', $this->data);
    }
    public function update(NbiRequest $request){
        $proposal_id = $request->proposal_id;
        $id = $request->id;
        DB::beginTransaction();
        try{
            $nbi = Nbi::findOrFail($id);
            $new_status = 'Agreed';
            $nbi_data = [
                'insured_address'=>$request->insured_address ?? null,
                'project_details'=>$request->project_details ?? null,
                'beneficiary_id'=>$request->beneficiary_id ?? null,
                'beneficiary_address'=>$request->beneficiary_address ?? null,
                'beneficiary_contact_person_name'=>$request->beneficiary_contact_person_name ?? null,
                'beneficiary_contact_person_phone_no'=>$request->beneficiary_contact_person_phone_no ?? null,
                'bond_type'=>$request->bond_type ?? null,
                //'bond_number'=>$request->bond_number ?? null,
                'bond_conditionality'=>$request->bond_conditionality ?? null,
                'contract_value'=>$request->contract_value ?? null,
                'contract_currency_id'=>$request->contract_currency_id ?? null,
                'bond_value'=>$request->bond_value ?? null,
                'cash_margin_if_applicable'=>$request->cash_margin_if_applicable ?? null,
                'tender_id_loa_ref_no'=>$request->tender_id_loa_ref_no ?? null,
                'bond_period_start_date'=>custom_date_format($request->bond_period_start_date,'Y-m-d'),
                'bond_period_end_date'=>custom_date_format($request->bond_period_end_date,'Y-m-d'),
                'bond_period_days'=>$request->bond_period_days ?? null,
                'initial_fd_validity' => $request->initial_fd_validity,
                'rate'=>$request->rate ?? null,
                'net_premium'=>$request->net_premium ?? null,
                'hsn_code_id'=>$request->hsn_code_id ?? null,
                'cgst'=>$request->cgst ?? null,
                'cgst_amount'=>$request->cgst_amount ?? null,
                'sgst'=>$request->sgst ?? null,
                'sgst_amount'=>$request->sgst_amount ?? null,
                'igst'=>$request->igst ?? null,
                'gst_amount'=>$request->gst_amount ?? null,
                'gross_premium'=>$request->gross_premium ?? null,
                'stamp_duty_charges'=>$request->stamp_duty_charges ?? null,
                'total_premium_including_stamp_duty'=>$request->total_premium_including_stamp_duty ?? null,
                'intermediary_name'=>$request->intermediary_name ?? null,
                'intermediary_code_and_contact_details'=>$request->intermediary_code_and_contact_details ?? null,
                'bond_wording'=>$request->bond_wording ?? null,
                'status'=>$new_status,
                're_insurance_grouping_id'=>$request->re_insurance_grouping_id ?? null,
                'issuing_office_branch_id'=>$request->issuing_office_branch_id ?? null,
                'trade_sector_id' => $request->trade_sector_id ?? null,
            ];
            $logsArr = [
                'nbi_id'=>$id,
                'proposal_id'=>$nbi->proposal_id,
                'current_status'=>$nbi->status,
                'new_status'=>$new_status,
            ];
            NbiLog::Create($logsArr);
            $nbi->update($nbi_data);
            DB::table( 'nbis')->where('proposal_id', $nbi->proposal_id)->where('id','!=',$id)->whereNotIn('status',['Agreed','Expired','Cancelled'])->update(['status' => 'Cancelled']);
            DB::commit();
            return redirect()->route('proposals.show',[$proposal_id])->with('success', __('nbi.update_success'));

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('proposals.show',[$proposal_id])->with('error', __('common.something_went_wrong_please_try_again'));
        }
    }
    public function export($id){
        $this->data['id'] = $id;
        return Excel::download(new NbiExport($this->data), 'nbi.xlsx');
    }
    public function get_hsn($hsn_id=null){
        $hsn_codes = DB::table('hsn_codes')
            ->select(DB::raw("CONCAT(hsn_code,' - ',FLOOR(gst), '%') as hsn_code"), 'id', 'gst','igst','sgst','cgst')
            ->when($hsn_id > 0, function ($sql) use ($hsn_id) {
                $sql->orWhere('id', $hsn_id);
            })
            ->where('is_active', 'Yes')->whereNull('deleted_at')->get();
        return $hsn_codes;
    }
    public function pdfExport(Request $request, $id){
        $nbi = Nbi::with(['proposal','contractor','beneficiary','bondType','hsn_code','issuingOfficeBranch'])->findOrFail($id);
        $this->data['nbi'] = $nbi;
        $settings = Setting::get();
        $this->data['settings'] = $settings;
        $logo_setting = $settings->where('name', 'print_logo')->first();
        $this->data['favicon'] = $this->getSettingVal($settings,'favicon');
        $this->data['print_logo'] = $this->getSettingVal($settings,'print_logo');
        $this->data['company_name'] = $this->getSettingVal($settings,'company_name');
        $this->data['subtitle'] = $this->getSettingVal($settings,'subtitle');
        $this->data['print_company_address_title'] = $this->getSettingVal($settings,'print_company_address_title');
        $this->data['print_company_address'] = $this->getSettingVal($settings,'print_company_address');
        $this->data['print_email_id'] = $this->getSettingVal($settings,'print_email_id');
        $this->data['print_title'] = $this->getSettingVal($settings,'print_title');
        $this->data['print_disclosure'] = $this->getSettingVal($settings,'print_disclosure');
        $this->data['terms_conditions'] = $this->getSettingVal($settings,'terms_conditions');
        $print_description = $this->getSettingVal($settings,'print_description');
        $this->data['print_description'] = ($print_description) ? json_decode($print_description) : [];
        $this->data['currency_symbol'] = $nbi ? $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first() : '';
        // return view('nbi.pdf', $this->data);
        $pdf = PDF::loadView('nbi.pdf', $this->data);
        $pdf->setOrientation('portrait');
        $pdf->setOptions(['footer-right' => '[page] / [topage]']);
        $pdf->setOption('margin-right', 9);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 8);
        $pdf->setOption('title', __('nbi.title').' | PDF');
        $pdf->stream();
        return $pdf->inline('nbi' . '.pdf');
    }
    function getSettingVal($settings,$field){
        $row = $settings->where('name', $field)->first();
        return $row->value ?? '';
    }

    function terminateProposal(Request $request){
        $nbi_id = $request->nbi_id;
        DB::beginTransaction();
        try {
            $nbi = Nbi::findOrFail($nbi_id);
            $nbi->update(['status' => 'Cancelled']);
            $nbi->proposal()->update(['status' => 'Terminated', 'nbi_status' => 'Cancelled']);
            $case = $nbi->proposal->cases->first();
            $caseDecision = $case->casesDecision()->update(['nbi_status' => 'Cancelled']);
            $utilizedLimit = UtilizedLimitStrategys::where('cases_id', $case->id)->update(['nbi_status' => 'Cancelled']);
            $case->update(['nbi_status' => 'Cancelled']);

            $message = 'This Proposal has been Terminated succesfully.';
            Session::flash('success', $message);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        } catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
}
