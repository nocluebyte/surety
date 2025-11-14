<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Proposal;
use App\Models\{DMS, Beneficiary, Tender, Principle,Designation, BondTypes, FacilityType, BankingLimitCategory, ProjectType};
use App\Models\{BankingLimit, OrderBookAndFutureProjects, ProjectTrackRecords, ManagementProfiles, ProposalLog,TenderEvaluation, TenderEvaluationProductAllowed,TenderEvaluationWorkType,User,TenderEvaluationLocation, GroupContractor, ProposalContractor,ProposalAdditionalBonds, RejectionReason, PrincipleType, AgencyRating, Country, ProjectDetail, BondPoliciesIssueChecklist, BondPoliciesIssue, InvocationNotification, InvocationClaims,Cases, Setting, BondForeClosure, BondCancellation, BondProgress, ContractorItem};
use App\Http\Requests\{ProposalRequest, TenderEvaluationRequest,IntermediaryLatterForSignRequest};
use App\DataTables\ProposalDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Sentinel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Session;
use Log;
use PDF;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Service\LeegalityService;

class ProposalController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->middleware('encryptUrl', ['only' => ['create', 'store', 'show', 'update', 'destroy', 'edit', 'pdfExport']]);
        $this->middleware('permission:proposals.list', ['only' => ['index', 'show']]);
        $this->middleware('permission:proposals.add', ['only' => ['create', 'store']]);
        $this->middleware('permission:proposals.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:proposals.delete', ['only' => 'destroy']);
        $this->middleware('permission:proposals.delete', ['only' => 'destroy']);
        $this->common = new CommonController();
        $this->title = trans('proposals.proposals');
        view()->share('title', $this->title);
    }

    public function index(ProposalDataTable $datatable)
    {
        $this->data['type_of_bond'] = $this->common->getBondTypes();
        $this->data['status'] = Config('srtpl.filters.proposal_status_filter');
        $this->data['nbi_status'] = Config('srtpl.filters.nbi_status_filter');
        return $datatable->render('proposals.index', $this->data);
    }

    public function create()
    {
        $settings = Setting::get();
        $this->data['settings'] = $settings;
        $this->data['proposal_auto_save'] = $this->getSettingVal($settings,'proposal_auto_save_duration');
        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] = [];
        if (old('country_id')) {
            $this->data['states'] = $this->common->getStates(old('country_id'));
        }

        $this->data['isContractorCountryIndia'] = $this->data['isAddContraCountryIndia'] = $this->data['isBeneCountryIndia'] = $this->data['isAddBeneCountryIndia'] = true;
        $this->data['jsVentureTypeRequired'] = true;
        $this->data['principle_types'] = PrincipleType::where('is_active', 1)->get();
        // $this->data['contractors'] = $this->common->getJvContractor();
        $this->data['contractors'] = $this->common->getSpvContractor();
        $this->data['trade_sector'] = $this->common->getTradeSector();
        $this->data['designation'] = $this->common->getDesignation();
        $this->data['bond_types'] = $this->common->getBondTypes();
        $this->data['facility_types'] = $this->common->getFacilityType();
        $this->data['banking_limit_category'] = $this->common->getBankingLimitCategory();
        $this->data['project_type'] = $this->common->getProjectType();
        $this->data['beneficiaries'] = $this->common->getBeneficiary();
        $this->data['additional_bonds'] = $this->common->getAdditionalBonds();
        $this->data['current_status'] = Config('srtpl.current_status');
        $this->data['completion_status'] = Config('srtpl.completion_status');
        $this->data['beneficiary_address'] = Beneficiary::pluck('address', 'id')->toArray();
        $this->data['beneficiary_type'] = Beneficiary::pluck('beneficiary_type', 'id')->toArray();
        $this->data['tender_details'] = $this->common->getTender();
        $this->data['bond_type_id'] = $this->common->getBondTypes();
        $this->data['type_of_contracting'] = Config('srtpl.type_of_contracting');

        $contractorField = [DB::raw("CONCAT(principles.code, ' - ', principles.company_name) as contractor_data"), 'principles.id'];
        $this->data['contractor_id'] = Principle::select($contractorField)->where('is_active', 'Yes')->pluck('contractor_data', 'id')->toArray();

        $this->data['contractor_types'] = Config('srtpl.contractor_type');
        // $this->data['jv_contractors'] = $this->common->getJvContractor();
        $this->data['spv_contractors'] = $this->common->getSpvContractor();
        $this->data['stand_alone_contractors'] = $this->common->getStandAloneContractor();
        // dd($this->data['spv_contractors']);
        $this->data['user'] = [];

        // $spvData = Principle::withCount('contractorItem')->where('is_active', 'Yes')->where('is_spv', 'Yes')->orderBy('company_name', 'ASC')->get();
        $jvData = Principle::withCount('contractorItem')->where('is_active', 'Yes')->where('venture_type', 'JV')->orderBy('company_name', 'ASC')->select(DB::raw("CONCAT_WS(' | ', company_name,pan_no) as company_name"), 'id');
        // dd($jvData);

        // $spvOptArr = [];
        // if ($spvData->count()) {
        //     foreach ($spvData as $key => $spvVal) {
        //         // dd($spvVal);
        //         $spvOptArr[$spvVal->id] = ['data-ctcount' => $spvVal->contractor_item_count];
        //         // dd($spvOptArr[$spvVal->id]);
        //     }
        // }
        // $this->data['spv_contractors'] = $spvData->pluck('company_name', 'id')->toArray();
        // $this->data['spvOptArr'] = $spvOptArr;
        // // dd($this->data['spvOptArr']);
        // $this->data['spvContractorArr'] = [];
        // $this->data['jvConOptions'] = [];
        // $this->data['spvConOptions'] = [];
        $jvOptArr = [];
        if ($jvData->count()) {
            foreach ($jvData as $key => $jvVal) {
                // dd($jvVal);
                $jvOptArr[$jvVal->id] = ['data-ctcount' => $jvVal->contractor_item_count];
                // dd($jvOptArr[$jvVal->id]);
            }
        }
        $this->data['jv_contractors'] = $jvData->pluck('company_name', 'id')->toArray();
        $this->data['jvOptArr'] = $jvOptArr;
        // dd($this->data['jvOptArr']);
        $this->data['jvContractorArr'] = [];
        $this->data['spvConOptions'] = [];
        $this->data['jvConOptions'] = [];

        $this->data['ministry_type_id'] = $this->common->getMinistryType();
        $this->data['establishment_type'] = $this->common->getEstablishmentType();
        $this->data['trade_sector_id'] = $this->common->getTradeSector();
        $this->data['project_details'] = $this->common->getProjectDetails();
        $this->data['type_of_project'] = $this->common->getProjectType();
        // $this->data['agencies'] = $this->common->getAgency();
        // $this->data['agency_rating'] = $this->common->getRating();
        $this->data['seriesNumber'] = $this->common->getBondCode('P', 'proposals');
        $this->data['entity_types'] = $this->common->getEntityType();
        // $this->data['typeStandAlone'] = '';

        $this->data['agencies'] = $this->common->getAgency();
        $this->data['agency_rating'] = [];
        if (old('agency_id')) {
            $this->data['agency_rating'] = $this->common->getRating(old('agency_id'));
        }
        $this->data['agencyOptions'] = [];

        return view('proposals.create', $this->data);
    }

    public function store(ProposalRequest $request)
    {
        // dd($request->all());
        $check_entry = Proposal::latest()->first();
        $finishTime = Carbon::now();
        $totalDuration = 10;
        if (!empty($check_entry)) {
            $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
        }
        if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5 && $check_entry->first_name == $request['first_name'])) {
            return redirect()->route('proposals.create')->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
        }

        DB::beginTransaction();
        try{
            $code = $this->common->getBondCode('P', 'proposals');
            // $version_code = $this->common->getVersion($code, 'proposals');
            $version_code = 1;

            $input = $request->except(['_token', 'tradeSector', 'contactDetail', 'beneficiaryTradeSector', 'pbl_items', 'obfp_items', 'ptr_items', 'mp_items', 'jvContractorDetails', 'spvContractorDetails', 'contractorDetails', 'company_details', 'company_technical_details', 'company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr', 'rfp_attachment', 'bond_attachment', 'bond_wording_file', 'contractor_trade_item_id', 'contact_item_id', 'jv_contractor', 'spv_contractor', 'jv_count', 'contractor_item_id', 'beneficiary_trade_item_id', 'banking_limits_attachment', 'order_book_and_future_projects_attachment', 'project_track_records_attachment', 'management_profiles_attachment', 'contractor_tender_id', 'agency', 'series_number', 'auto_proposal_id', 'autosave', 'delete_pbl_id', 'delete_ptr_id', 'delete_obfp_id', 'delete_mp_id', 'ratingDetail', 'rating_item_id', 'rating_id', 'item_rating_date', 'contractor_country_name', 'contractor_bond_country_name', 'beneficiary_country_name', 'beneficiary_bond_country_name', 'spv_count']);

            if($input['contract_type'] == 'SPV'){
                // $input['contractor_id'] = $request->spvContractorDetails[0]['spv_contractor_id'] ?? null;
                $input['contractor_id'] = $request->spv_contractor ?? null;
            }

            if($input['contract_type'] == 'JV'){
                $input['contractor_id'] = $request->jv_contractor ?? null;
            }

            if(isset($request->auto_proposal_id)){
                $prevProposal = Proposal::findOrFail($request->auto_proposal_id);
                $prev_contractor_id = $prevProposal->contractor_id;
                $prev_beneficiary_id = $prevProposal->beneficiary_id;
                $prev_tender_id = $prevProposal->tender_details_id;
            }

            $proposal = Proposal::updateOrCreate(['id' => $request->auto_proposal_id ?? null], $input);
            $proposal_id = $request->auto_proposal_id ?? $proposal->id;

            if(!isset($request->auto_proposal_id)){
                $proposal->update(['code' => $code, 'version' => $version_code,'proposal_parent_id'=>$proposal->id]);
            }

            $contractorId = '';
            if($request->contract_type == 'Stand Alone'){
                $contractorId = $request->contractor_id ?? null;
            } elseif($request->contract_type == 'SPV'){
                // $contractorId = $request->spvContractorDetails[0]['spv_contractor_id'];
                $contractorId = $request->spv_contractor ?? null;
            } elseif($request->contract_type == 'JV'){
                $contractorId = $request->jv_contractor ?? null;
            }

            if(isset($contractorId)){
                $contractorUpdate = [
                    'registration_no' => $request['registration_no'],
                    'company_name' => $request['contractor_company_name'],
                    'address' => $request['register_address'],
                    'website' => $request['contractor_website'],
                    'country_id' => $request['contractor_country_id'],
                    'state_id' => $request['contractor_state_id'],
                    'city' => $request['contractor_city'],
                    'pincode' => $request['contractor_pincode'],
                    'gst_no' => $request['contractor_gst_no'],
                    'pan_no' => $request['contractor_pan_no'],
                    'date_of_incorporation' => $request['date_of_incorporation'],
                    'principle_type_id' => $request['principle_type_id'],
                    // 'is_jv' => $request['is_jv'],
                    'are_you_blacklisted' => $request['are_you_blacklisted'],
                    'agency_id' => $request['agency_id'],
                    'is_bank_guarantee_provided' => $request['is_bank_guarantee_provided'],
                    'circumstance_short_notes' => $request['circumstance_short_notes'],
                    'is_action_against_proposer' => $request['is_action_against_proposer'],
                    'action_details' => $request['action_details'],
                    'contractor_failed_project_details' => $request['contractor_failed_project_details'],
                    'completed_rectification_details' => $request['completed_rectification_details'],
                    'performance_security_details' => $request['performance_security_details'],
                    'relevant_other_information' => $request['relevant_other_information'],
                    'entity_type_id' => $request['contractor_entity_type_id'],
                    'staff_strength' => $request['contractor_staff_strength'],
                    // 'inception_date' => $request['contractor_inception_date'],
                ];
                $proposal->contractor->where('id', $contractorId)->update($contractorUpdate);
                $proposal->contractor->user->where('id', $proposal->contractor->user_id)
                ->update([
                    'email' => $request->contractor_email ?? null,
                    'mobile' => $request->contractor_mobile ?? null,
                ]);
            }
            // $userUpdate = [
            //     'email' => $request['contractor_email'],
            //     'mobile' => $request['contractor_mobile'],
            // ];
            // $proposal->contractor->user->where('id', $request->contractor_id)->update($userUpdate);

            if(isset($request->beneficiary_id)){
                $beneficiaryUpdate = [
                    'company_name' => $request['beneficiary_company_name'],
                    'registration_no' => $request['beneficiary_registration_no'],
                    'address' => $request['beneficiary_address'],
                    'website' => $request['beneficiary_website'],
                    'country_id' => $request['beneficiary_country_id'],
                    'state_id' => $request['beneficiary_state_id'],
                    'city' => $request['beneficiary_city'],
                    'pincode' => $request['beneficiary_pincode'],
                    'gst_no' => $request['beneficiary_gst_no'],
                    'pan_no' => $request['beneficiary_pan_no'],
                    'beneficiary_type' => $request['beneficiary_type'],
                    'establishment_type_id' => $request['establishment_type_id'],
                    'ministry_type_id' => $request['ministry_type_id'],
                    'bond_wording' => $request['beneficiary_bond_wording'],
                ];
                $proposal->beneficiary->where('id', $request->beneficiary_id)->update($beneficiaryUpdate);
                $proposal->beneficiary->user->where('id', $proposal->beneficiary->user_id)->update([
                    'mobile' => $request->beneficiary_phone_no ?? null,
                    'email' => $request->beneficiary_email ?? null,
                ]);
            }

            if(isset($request->project_details)){
                $projectDetailsUpdate = [
                    'beneficiary_id' => $request['pd_beneficiary'] ?? $request['beneficiary_id'],
                    'project_name' => $request['pd_project_name'],
                    'project_description' => $request['pd_project_description'],
                    'project_value' => $request['pd_project_value'],
                    'type_of_project' => $request['pd_type_of_project'],
                    'project_start_date' => $request['pd_project_start_date'],
                    'project_end_date' => $request['pd_project_end_date'],
                    'period_of_project' => $request['pd_period_of_project'],
                ];
                $proposal->projectDetails->where('id', $request->project_details)->update($projectDetailsUpdate);
            }

            if(isset($request->tender_details_id)){
                $tenderUpdate = [
                    'tender_id' => $request['tender_id'],
                    'tender_header' => $request['tender_header'],
                    'tender_description' => $request['tender_description'],
                    'location' => $request['location'],
                    'project_type' => $request['project_type'],
                    'beneficiary_id' => $request['tender_beneficiary_id'] ?? $request['beneficiary_id'],
                    'contract_value' => $request['tender_contract_value'],
                    'period_of_contract' => $request['period_of_contract'],
                    'bond_value' => $request['tender_bond_value'],
                    'bond_type_id' => $request['bond_type_id'],
                    'type_of_contracting' => $request['type_of_contracting'],
                    'rfp_date' => $request['rfp_date'],
                    'project_description' => $request['project_description'],
                    'project_details' => $request['project_details'],
                    'pd_beneficiary' => $request['tender_beneficiary_id'] ?? $request['beneficiary_id'],
                    'pd_project_name' => $request['pd_project_name'],
                    'pd_project_description' => $request['pd_project_description'],
                    'pd_project_value' => $request['pd_project_value'],
                    'pd_type_of_project' => $request['pd_type_of_project'],
                    'pd_project_start_date' => $request['pd_project_start_date'],
                    'pd_project_end_date' => $request['pd_project_end_date'],
                    'pd_period_of_project' => $request['pd_period_of_project'],
                ];
                $proposal->tender->where('id', $request->tender_details_id)->update($tenderUpdate);
            }

            if(!empty($contractorId)){
                $principle = Principle::findOrFail($contractorId);
            }

            // Proposal Documents - DMS

            $dmsModel = Proposal::findOrFail($proposal_id);

            if($request->hasFile('bond_wording_file')){
                $this->common->storeMultipleFiles($request, $request['bond_wording_file'], 'bond_wording_file', $proposal, $proposal_id, 'proposal/' . $code . '/V' . $version_code);
            }

            foreach (['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr'] as $documentType) {
                if($request->hasFile($documentType)){
                    foreach ($request[$documentType] as $item) {
                        $fileName = $item->getClientOriginalName();

                        $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/principle/' . $principle->id . '/' . $fileName;

                        copy($filePath1, $filePath2);

                        $proposal->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath1,
                            'attachment_type' => $documentType,
                        ]);

                        $principle->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath2,
                            'attachment_type' => $documentType,
                        ]);
                    }
                }
            }

            if($request->hasFile('rfp_attachment')){
                foreach ($request['rfp_attachment'] as $item) {
                    $fileName = $item->getClientOriginalName();

                    $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                    $filePath2 = 'uploads/tender/' . $proposal->tender->id . '/' . $fileName;

                    copy($filePath1, $filePath2);

                    $proposal->dMS()->create([
                        'file_name' => $fileName,
                        'attachment' => $filePath1,
                        'attachment_type' => 'rfp_attachment',
                    ]);

                    $proposal->tender->dMS()->create([
                        'file_name' => $fileName,
                        'attachment' => $filePath2,
                        'attachment_type' => 'rfp_attachment',
                    ]);
                }
            }

            if($request->hasFile('bond_attachment')){
                foreach ($request['bond_attachment'] as $item) {
                    $fileName = $item->getClientOriginalName();

                    // $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                    // $filePath2 = 'uploads/beneficiary/' . $proposal->beneficiary->id . '/' . $fileName;

                    // copy($filePath1, $filePath2);

                    $proposalPath = 'uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id;
                    $beneficiaryPath = 'uploads/beneficiary/' . $proposal->beneficiary->id;

                    $filePath1 = $item->storeAs($proposalPath, $fileName, 'public');
                    // $filePath1 = $item->move($proposalPath, $fileName);

                    if (!$filePath1) {
                        throw new Exception("File upload failed.");
                    }

                    $fileContents = Storage::disk('public')->get($filePath1);
                    $filePath2 = $beneficiaryPath . '/' . $fileName;
                    Storage::disk('public')->put($filePath2, $fileContents);

                    $proposal->dMS()->create([
                        'file_name' => $fileName,
                        'attachment' => $filePath1,
                        'attachment_type' => 'bond_attachment',
                    ]);

                    $proposal->beneficiary->dMS()->create([
                        'file_name' => $fileName,
                        'attachment' => $filePath2,
                        'attachment_type' => 'bond_attachment',
                    ]);
                }
            }

            $uploadFolder = 'uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id;
            // dd($uploadFolder);
            if (!file_exists($uploadFolder)) {
                mkdir($uploadFolder, 0775, true);
            }

            // $issetAutoTenderId = isset($request->auto_proposal_id) ? isset($proposal->tender_details_id) ? true : false : false;

            // $tenderDocs = isset($request->auto_proposal_id) ? $issetAutoTenderId ? $request->tender_details_id != $proposal->tender_details_id ? true : false : false : true;


            $issetAutoTenderId = isset($request->auto_proposal_id) && isset($proposal->tender_details_id);

            $tenderDocs = false;

            if ($issetAutoTenderId) {
                $tenderDocs = $request->tender_details_id != $prev_tender_id;
            }
            if(isset($request->tender_details_id) && !isset($request->auto_proposal_id)){
                $tenderDocs = true;
            }

            if($tenderDocs){
                $tender_rfp_file = DMS::where('dmsable_id', $request->tender_details_id)->where('dmsable_type', 'Tender')->get();
                if(!empty($request->tender_details_id) && isset($tender_rfp_file) && !isset($request['rfp_attachment'])){
                    foreach($tender_rfp_file as $item){
                        if(File::exists($item->attachment)){
                            // $newRfpFilepath = 'uploads/proposal/' . $code . '/V' . $version_code . '/' . $item->file_name;
                            $newRfpFilepath = $uploadFolder . '/' . $item->file_name;
                            $tenderFilePath = copy($item->attachment, $newRfpFilepath);
                        }
                        $proposal->dMS()->create([
                            'file_name' => $item->file_name,
                            'attachment' => $newRfpFilepath ?? null,
                            'attachment_type' => $item->attachment_type,
                        ]);
                    }
                }
            }

            $issetAutoBeneficiaryId = isset($request->auto_proposal_id) && isset($proposal->beneficiary_id);

            $beneficiaryDocs = false;

            if ($issetAutoBeneficiaryId) {
                $beneficiaryDocs = $request->beneficiary_id != $prev_beneficiary_id;
            }

            if(isset($request->beneficiary_id) && !isset($request->auto_proposal_id)){
                $beneficiaryDocs = true;
            }

            if($beneficiaryDocs){
                $beneficiary_attachment = DMS::where('dmsable_id', $request->beneficiary_id)->where('dmsable_type', 'Beneficiary')->get();
                $proposal_beneficiary_docs = DMS::where('dmsable_id', $proposal_id)->where('dmsable_type', 'Proposal')->where('attachment_type', 'bond_attachment')->delete();

                if(!empty($request->beneficiary_id) && isset($beneficiary_attachment) && !isset($request['bond_attachment'])){
                    foreach($beneficiary_attachment as $item){
                        if(File::exists($item->attachment)){
                            // $newpath = 'uploads/proposal/' . $code . '/V' . $version_code . '/' . $item->file_name;
                            $newpath = $uploadFolder . '/' . $item->file_name;
                            $docFilePath = copy($item->attachment, $newpath);
                        }
                        $proposal->dMS()->create([
                            'file_name' => $item->file_name,
                            'attachment' => $newpath ?? null,
                            'attachment_type' => $item->attachment_type,
                        ]);
                    }
                }
            }

            $issetAutoContractorId = isset($request->auto_proposal_id) && isset($proposal->contractor_id);

            $contractorDocs = false;

            if ($issetAutoContractorId) {
                $contractorDocs = $contractorId != $prev_contractor_id;
            }
            if(isset($contractorId) && !isset($request->auto_proposal_id)){
                $contractorDocs = true;
            }

            if($contractorDocs){
                $contractor_attachment = DMS::where('dmsable_id', $contractorId)->where('dmsable_type', 'Principle')->get();

                foreach(['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr'] as $documentType){
                    if(!empty($contractorId) && isset($contractor_attachment)){
                        foreach($contractor_attachment as $item){
                            if($item->attachment_type == $documentType){
                                if(File::exists($item->attachment)){
                                    // $newDocFilepath = 'uploads/proposal/' . $code . '/V' . $version_code . '/' . $item->file_name;

                                    // File::makeDirectory($uploadFolder);
                                    $newDocFilepath = $uploadFolder . '/' . $item->file_name;
                                    $docFilePath = copy($item->attachment, $newDocFilepath);
                                }
                                // $proposal->dMS()->updateOrCreate(['dmsable_id' => $proposal_id], [
                                //     'file_name' => $item->file_name,
                                //     'attachment' => $newDocFilepath ?? null,
                                //     'attachment_type' => $item->attachment_type,
                                // ]);
                                $proposal->dMS()->create([
                                    'file_name' => $item->file_name,
                                    'attachment' => $newDocFilepath ?? null,
                                    'attachment_type' => $item->attachment_type,
                                ]);
                            }
                        }
                    }
                }
            }

            $hasAutoProposalId = isset($request->auto_proposal_id);

            // JV, SPV
            $autosaved_jv_items = [];
            if($request->contract_type == 'JV'){
                $jvContractorDetails = $request->jvContractorDetails;
                if (!empty($jvContractorDetails) && count($jvContractorDetails) > 0) {
                    foreach($jvContractorDetails as $row) {
                        $jvDataArr = [
                            'proposal_id' => $proposal_id,
                            'proposal_contractor_type' => $request->contract_type,
                            'proposal_contractor_id' => $row['jv_contractor_id'],
                            'pan_no' => $row['jv_pan_no'],
                            'share_holding' => $row['jv_share_holding'],
                            // 'jv_spv_exposure' => $row['jv_exposure'],
                            // 'assign_exposure' => $row['jv_assign_exposure'],
                            // 'overall_cap' => $row['jv_overall_cap'],
                            // 'consumed' => $row['jv_consumed'],
                            // 'spare_capacity' => $row['jv_spare_capacity'],
                            // 'remaining_cap' => $row['jv_remaining_cap'],
                        ];
                        $proposal->proposalContractors()->updateOrCreate(['id' => $row['jv_item_id'] ?? null], $jvDataArr);
                    }
                    if(isset($request->autosave)){
                        foreach($proposal->proposalContractors as $item){
                            $autosaved_jv_items[] = $item->id;
                        }
                    }

                }
            }

            $autosaved_spv_items = [];
            if($request->contract_type == 'SPV'){
                $spvContractorDetails = $request->spvContractorDetails;
                if (!empty($spvContractorDetails) && count($spvContractorDetails) > 0) {
                    foreach($spvContractorDetails as $row) {
                        $spvDataArr = [
                            'proposal_id' => $proposal_id,
                            'proposal_contractor_type' => $request->contract_type,
                            'proposal_contractor_id' => $row['spv_contractor_id'],
                            'pan_no' => $row['spv_pan_no'],
                            'share_holding' => $row['spv_share_holding'],
                            // 'jv_spv_exposure' => $row['spv_exposure'],
                            // 'assign_exposure' => $row['spv_assign_exposure'],
                            // 'overall_cap' => $row['spv_overall_cap'],
                            // 'consumed' => $row['spv_consumed'],
                            // 'spare_capacity' => $row['spv_spare_capacity'],
                            // 'remaining_cap' => $row['spv_remaining_cap'],
                        ];
                        $proposal->proposalContractors()->updateOrCreate(['id' => $row['spv_item_id'] ?? null] ,$spvDataArr);
                    }
                    if(isset($request->autosave)){
                        foreach($proposal->proposalContractors as $item){
                            $autosaved_spv_items[] = $item->id;
                        }
                    }
                }
            }

            // Additional Bonds
            // $additionalBondItems = $request->additional_bond_items;

            // foreach ($additionalBondItems as $row) {
            //     $additionalBondItemsArr = [
            //         'proposal_id' => $proposal_id,
            //         'additional_bond_id' => $row['additional_bond_id'] ?? null,
            //         'additional_bond_issued_date' => $row['additional_bond_issued_date'] ?? null,
            //         'additional_bond_start_date' => $row['additional_bond_start_date'] ?? null,
            //         'additional_bond_end_date' => $row['additional_bond_end_date'] ?? null,
            //         'additional_bond_period' => $row['additional_bond_period'] ?? null,
            //         'additional_bond_period_year' => $row['additional_bond_period_year'] ?? null,
            //         'additional_bond_period_month' => $row['additional_bond_period_month'] ?? null,
            //         'additional_bond_period_days' => $row['additional_bond_period_days'] ?? null,
            //         'bond_value' => $row['additional_bond_value'] ?? null,                    
            //     ];

            //     $additionalBondItemsRepater = ProposalAdditionalBonds::create($additionalBondItemsArr);
            // }

            $autosavedBeneficiaryTradeSector = [];
            $beneficiaryTradeSector = $request->beneficiaryTradeSector;
            if (!empty($beneficiaryTradeSector) && count($beneficiaryTradeSector) > 0) {
                // if(isset($proposal->beneficiary->proposalBeneficiaryTradeSector)){
                //     $proposal->beneficiary->proposalBeneficiaryTradeSector()->delete();
                // }

                foreach ($beneficiaryTradeSector as $row) {
                    if(isset($row['beneficiary_trade_sector_id']) && isset($row['beneficiary_from'])){
                        $beneficiaryTradeSectorArr = [
                            // 'beneficiary_id' => $beneficiary_id,
                            'trade_sector_id' => $row['beneficiary_trade_sector_id'] ?? NULL,
                            'from'=> $row['beneficiary_from'] ?? NULL,
                            'till'=> $row['beneficiary_till'] ?? NULL,
                            'is_main'=> $row['beneficiary_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pbt_item_id'] ?? null,
                        ];
                        // $proposal->proposalBeneficiaryTradeSector()->updateOrCreate(['id' => $row['beneficiary_trade_item_id'] ?? null], $beneficiaryTradeSectorArr);
                        // $proposal->beneficiary->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr);

                        $hasBtiId = isset($row['beneficiary_trade_item_id']);

                        if($hasBtiId){
                            $proposal->beneficiary->proposalBeneficiaryTradeSector()->where('id', $row['beneficiary_trade_item_id'])->orWhere('contractor_fetch_reference_id', $row['beneficiary_trade_item_id'])->update($beneficiaryTradeSectorArr);
                        } 
                        
                        if(!$hasAutoProposalId || ($hasAutoProposalId && !$hasBtiId)){
                            $proposalBeneficiaryTradeSectorRepeater = $proposal->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr);
                        } else if($hasAutoProposalId && $hasBtiId) {
                            $proposalBeneficiaryTradeSectorRepeater = tap(
                                $proposal->proposalBeneficiaryTradeSector()
                                    ->where('contractor_fetch_reference_id', $row['beneficiary_trade_item_id'])
                                    ->orWhere('id', $row['beneficiary_trade_item_id'])
                                    ->first()
                            )->update($beneficiaryTradeSectorArr);
                        }

                        if(!$hasBtiId){
                            $beneficiaryTradeSectorRepeaterContractor = tap(
                                $proposal->beneficiary->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr)
                            )->update([
                                'contractor_fetch_reference_id' => $proposalBeneficiaryTradeSectorRepeater->id
                            ]);
                        }

                        if (!isset($row['pbt_item_id'])){
                            $proposalBeneficiaryTradeSectorRepeater->update(['contractor_fetch_reference_id' => $proposalBeneficiaryTradeSectorRepeater->id]);
                        }
                    }
                }
                if(isset($request->autosave)){
                    foreach($proposal->proposalBeneficiaryTradeSector as $item){
                        $autosavedBeneficiaryTradeSector[] = $item->id;
                    }
                }
            }

            // $autosaved_contractor_items = [];
            // if($request['is_jv'] == 'Yes'){
            //     $contractorDetails = $request->contractorDetails;
            //     if (!empty($contractorDetails) && count($contractorDetails) > 0) {
            //         foreach ($contractorDetails as $row) {
            //             $contractorDetailArr = [
            //                 // 'principle_id' => $principle_id,
            //                 'contractor_id' => $row['contractor_id'] ?? NULL,
            //                 'pan_no'=> $row['contractor_pan_no'] ?? NULL,
            //                 'share_holding'=> $row['share_holding'] ?? NULL,
            //             ];
            //             $proposal->contractorItem()->updateOrCreate(['id' => $row['contractor_item_id'] ?? null], $contractorDetailArr);
            //         }
            //         if(isset($request->autosave)){
            //             foreach($proposal->contractorItem as $item){
            //                 $autosaved_contractor_items[] = $item->id;
            //             }
            //         }
            //     }
            // }

            $autosaved_tradesector_items = [];
            $tradeSector = $request->tradeSector;
            if (!empty($tradeSector) && count($tradeSector) > 0) {
                // if(isset($principle->tradeSector)){
                //     $principle->tradeSector()->delete();
                // }

                foreach ($tradeSector as $row) {
                    if(isset($row['contractor_trade_sector']) && isset($row['contractor_from'])){
                        $tradeSectorArr = [
                            // 'principle_id' => $principle_id,
                            'trade_sector_id' => $row['contractor_trade_sector'] ?? NULL,
                            'from'=> $row['contractor_from'] ?? NULL,
                            'till'=> $row['contractor_till'] ?? NULL,
                            'is_main'=> $row['contractor_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pct_item_id'] ?? null,
                        ];
                        // $proposal->tradeSector()->updateOrCreate(['id' => $row['contractor_trade_item_id'] ?? null], $tradeSectorArr);
                        // $principle->tradeSector()->create($tradeSectorArr);

                        $hasCtiId = isset($row['contractor_trade_item_id']);

                        if($hasCtiId){
                            $principle->tradeSector()->where('id', $row['contractor_trade_item_id'])->orWhere('contractor_fetch_reference_id', $row['contractor_trade_item_id'])->update($tradeSectorArr);
                        }

                        if(!$hasAutoProposalId || ($hasAutoProposalId && !$hasCtiId)){
                            $proposalTradeSectorRepeater = $proposal->tradeSector()->create($tradeSectorArr);
                        } else if($hasAutoProposalId && $hasCtiId) {
                            if($hasAutoProposalId){
                                $proposalTradeSectorRepeater = tap(
                                    $proposal->tradeSector()
                                        ->where('contractor_fetch_reference_id', $row['contractor_trade_item_id'])
                                        ->orWhere('id', $row['contractor_trade_item_id'])
                                        ->first()
                                )->update($tradeSectorArr);
                            }
                        }

                        if(!$hasCtiId){
                            $tradeSectorRepeaterContractor = tap(
                                $principle->tradeSector()->create($tradeSectorArr)
                            )->update([
                                'contractor_fetch_reference_id' => $proposalTradeSectorRepeater->id
                            ]);
                        }

                        if (!isset($row['pct_item_id'])){
                            $proposalTradeSectorRepeater->update(['contractor_fetch_reference_id' => $proposalTradeSectorRepeater->id]);
                        }
                    }
                }
                if(isset($request->autosave)){
                    foreach($proposal->tradeSector as $item){
                        $autosaved_tradesector_items[] = $item->id;
                    }
                }
            }

            $autosaved_contact_details = [];
            $contactDetail = $request->contactDetail;
            if (!empty($contactDetail) && count($contactDetail) > 0) {
                // if(isset($principle->contactDetail)){
                //     $principle->contactDetail()->delete();
                // }

                foreach ($contactDetail as $row) {
                    $contactDetailArr = [
                        'contact_person' => $row['contact_person'] ?? NULL,
                        'email'=> $row['email'] ?? NULL,
                        'phone_no'=> $row['phone_no'] ?? NULL,
                        'contractor_fetch_reference_id' => $row['proposal_contact_item_id'] ?? null,
                    ];
                    $contactDetailIsNull = empty(array_filter($contactDetailArr, function($value) {
                        return !is_null($value);
                    }));
                    // $contactDetailArr['principle_id'] = $principle_id;
                    if(!$contactDetailIsNull){
                        // $contactDetailRepeater = $proposal->contactDetail()->updateOrCreate(['id' => $row['contact_item_id'] ?? null], $contactDetailArr);
                        // $principle->contactDetail()->create($contactDetailArr);
                    }

                    $hasCdiId = isset($row['contact_item_id']);

                    if($hasCdiId){
                        $principle->contactDetail()->where('id', $row['contact_item_id'])->orWhere('contractor_fetch_reference_id', $row['contact_item_id'])->update($contactDetailArr);
                    }

                    if(!$hasAutoProposalId || ($hasAutoProposalId && !$hasCdiId)){
                        $contactDetailRepeater = $proposal->contactDetail()->create($contactDetailArr);
                    } elseif ($hasAutoProposalId && $hasCdiId){
                        if($hasAutoProposalId){
                            $contactDetailRepeater = tap(
                                $proposal->contactDetail()
                                    ->where('contractor_fetch_reference_id', $row['contact_item_id'])
                                    ->orWhere('id', $row['contact_item_id'])
                                    ->first()
                            )->update($contactDetailArr);
                        }
                    }

                    if(!$hasCdiId){
                        $contactDetailRepeaterContractor = tap(
                            $principle->contactDetail()->create($contactDetailArr)
                        )->update([
                            'contractor_fetch_reference_id' => $contactDetailRepeater->id
                        ]);
                    }

                    if (!isset($row['proposal_contact_item_id'])){
                        $contactDetailRepeater->update(['contractor_fetch_reference_id' => $contactDetailRepeater->id]);
                    }
                }
                if(isset($request->autosave)){
                    foreach($proposal->contactDetail as $item){
                        $autosaved_contact_details[] = $item->id;
                    }
                }
            }

            // Rating

            $autosaved_rating_details = [];
            $ratingDetail = $request->ratingDetail;
            if(isset($ratingDetail) && count($ratingDetail)>0 && $contractorDocs){
                if(isset($principle->agencyRatingDetails)){
                    $principle->agencyRatingDetails()->delete();
                }

                foreach ($ratingDetail as $row) {
                    $ratingDetailsArr = [
                        'agency_id' => $row['item_agency_id'] ?? null,
                        'rating_id' => $row['item_rating_id'] ?? null,
                        'rating' => $row['rating'] ?? null,
                        'remarks' => $row['rating_remarks'] ?? null,
                        'rating_date' => $row['rating_date'] ?? null,
                    ];

                    $ratingDetailsRepeater = $proposal->agencyRatingDetails()->updateOrCreate(['id' => $row['rating_item_id'] ?? null], $ratingDetailsArr);
                    $principle->agencyRatingDetails()->create($ratingDetailsArr);
                }
                if(isset($request->autosave)){
                    foreach($proposal->agencyRatingDetails as $item){
                        $autosaved_rating_details[] = $item->id;
                    }
                }
            }

            // Proposal Banking Limits Repeater

            $proposalBankingLimits = $request->pbl_items;
            // dd($proposalBankingLimits);

            // $principleBankingLimits_id = collect($request->pbl_items)->pluck('pbl_id')->toArray();
            // $existing_principleBankingLimits = $principle->bankingLimits()->pluck('id')->toArray();
            // $diff_principleBankingLimits = array_diff($existing_principleBankingLimits, $principleBankingLimits_id);

            // $principle->bankingLimits()->whereIn('id', $diff_principleBankingLimits)->get()->each(function ($pblItem) {
            //     foreach ($pblItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
            //         File::delete($deleteItem);
            //     };
            //     $pblItem->dMS()->delete();
            //     $pblItem->delete();
            // });

            $autosaved_pbl_items = [];
            foreach ($proposalBankingLimits as $row) {
                $proposalBankingLimitsArr = [
                    'banking_category_id' => $row['banking_category_id'] ?? null,
                    'facility_type_id' => $row['facility_type_id'] ?? null,
                    'sanctioned_amount' => $row['sanctioned_amount'] ?? null,
                    'bank_name' => $row['bank_name'] ?? null,
                    'latest_limit_utilized' => $row['latest_limit_utilized'] ?? null,
                    'unutilized_limit' => $row['unutilized_limit'] ?? null,
                    'commission_on_pg' => $row['commission_on_pg'] ?? null,
                    'commission_on_fg' => $row['commission_on_fg'] ?? null,
                    'margin_collateral' => $row['margin_collateral'] ?? null,
                    'other_banking_details' => $row['other_banking_details'] ?? null,
                    // 'contractor_fetch_reference_id' => $row['pbl_id'] ?? null,
                    'contractor_fetch_reference_id' => $row['cfr_id'] ?? null,
                ];

                if(isset($row['pbl_id'])){
                    $principle->bankingLimits()->where('id', $row['pbl_id'])->orWhere('contractor_fetch_reference_id', $row['pbl_id'])->update($proposalBankingLimitsArr);
                }

                // if(!isset($request->auto_proposal_id)){
                //     $proposalBankingLimitsRepeater = $proposal->bankingLimits()->create($proposalBankingLimitsArr);
                // } else if(isset($request->auto_proposal_id) && isset($row['pbl_id'])){
                //     $proposalBankingLimitsRepeater = tap(
                //         $proposal->bankingLimits()->firstWhere('contractor_fetch_reference_id', $row['pbl_id'])
                //     )->update($proposalBankingLimitsArr);

                // } else if(isset($request->auto_proposal_id) && !isset($row['pbl_id'])){
                //     $proposalBankingLimitsRepeater = $proposal->bankingLimits()->create($proposalBankingLimitsArr);
                // }

                $hasPblId = isset($row['pbl_id']);

                if (!$hasAutoProposalId || ($hasAutoProposalId && !$hasPblId)) {
                    $proposalBankingLimitsRepeater = $proposal->bankingLimits()->create($proposalBankingLimitsArr);
                    if(isset($request->autosave)){
                        $autosaved_pbl_items[] = $proposalBankingLimitsRepeater->id;
                    }
                } elseif ($hasAutoProposalId && $hasPblId) {
                    // $proposalBankingLimitsRepeater = tap(
                    //     $proposal->bankingLimits()->firstWhere('contractor_fetch_reference_id', $row['pbl_id'])
                    // )->update($proposalBankingLimitsArr);

                    $proposalBankingLimitsRepeater = tap(
                        $proposal->bankingLimits()
                            ->where('contractor_fetch_reference_id', $row['pbl_id'])
                            ->orWhere('id', $row['pbl_id'])
                            ->first()
                    )->update($proposalBankingLimitsArr);

                    if(isset($request->autosave)){
                        $autosaved_pbl_items[] = $proposalBankingLimitsRepeater->id;
                    }
                }

                if(!isset($row['pbl_id']) && isset($principle->bankingLimits)){
                    // $contractorBankingLimitsRepeater = $principle->bankingLimits()->create($proposalBankingLimitsArr);

                    $contractorBankingLimitsRepeater = tap(
                        $principle->bankingLimits()->create($proposalBankingLimitsArr)
                    )->update([
                        'contractor_fetch_reference_id' => $proposalBankingLimitsRepeater->id
                    ]);

                    // if(isset($request->autosave)){
                    //     $autosaved_pbl_items[] = $contractorBankingLimitsRepeater->id;
                    // }
                }

                if(isset($row['delete_pbl_id'])){
                    $principle->bankingLimits()->where('id', $row['delete_pbl_id'])->delete();
                }

                if (isset($row['pbl_id']) && $contractorDocs) {
                    $bankinglimit_principle_attachment = DMS::where(['dmsable_id'=>$row['pbl_id'],'dmsable_type'=>'BankingLimits'])->get();

                    foreach ($bankinglimit_principle_attachment as $attachment) {

                        if(File::exists($attachment->attachment) && isset($proposalBankingLimitsRepeater)) {
                            $newFilepath = "uploads/proposal/{$code}/V{$version_code}/$proposal_id/{$attachment->file_name}";
                            // File::copy($attachment->attachment, $newFilepath);
                            $proposalBankingLimitsRepeater->dMS()->create([
                                'file_name' => $attachment->file_name,
                                'attachment' => $newFilepath ?? null,
                                'attachment_type' => $attachment->attachment_type,
                            ]);
                        }
                    }
                }

                if(isset($proposalBankingLimitsRepeater)){
                    $dms_proposalBankingLimits = BankingLimit::findOrFail($proposalBankingLimitsRepeater->id);
                }

                if(!isset($row['pbl_id']) && isset($contractorBankingLimitsRepeater)){
                    $dms_contractorBankingLimits = BankingLimit::findOrFail($contractorBankingLimitsRepeater->id);
                }

                if (!isset($row['cfr_id'])){
                    $proposalBankingLimitsRepeater->update(['contractor_fetch_reference_id' => $proposalBankingLimitsRepeater->id]);
                }

                if (!empty($row['banking_limits_attachment'])) {
                    // $this->common->storeMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_proposalBankingLimits, $proposal_id, 'proposal/' . $code . '/V' . $version_code);

                    // $this->common->storeMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_contractorBankingLimits, $principle->id, 'principle');

                    foreach ($row['banking_limits_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();
                        $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/principle/' . $principle->id . '/' . $fileName;
                        copy($filePath1, $filePath2);

                        if(isset($dms_proposalBankingLimits)){
                            $dms_proposalBankingLimits->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath1,
                                'attachment_type' => 'banking_limits_attachment',
                            ]);
                        }

                        if(isset($dms_contractorBankingLimits)){
                            $dms_contractorBankingLimits->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2,
                                'attachment_type' => 'banking_limits_attachment',
                            ]);
                        }

                        if(isset($row['pbl_id'])){
                            $contractorBankingLimit = BankingLimit::findOrFail($row['pbl_id']);
                            $contractorBankingLimit->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2 ?? null,
                                'attachment_type' => 'banking_limits_attachment',
                            ]);
                        }
                    }
                }
            }

            // Order Book and Future Projects Repeater
            $autosaved_obfp_items = [];

            $orderBookAndFutureProjects = $request->obfp_items;
            foreach($orderBookAndFutureProjects as $row){
                $orderBookAndFutureProjectsArr = [
                    'project_name' => $row['project_name'] ?? null,
                    'project_cost' => $row['project_cost'] ?? null,
                    'project_description' => $row['project_description'] ?? null,
                    'project_start_date' => $row['project_start_date'] ?? null,
                    'project_end_date' => $row['project_end_date'] ?? null,
                    'project_tenor' => $row['project_tenor'] ?? null,
                    'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                    'project_share' => $row['project_share'] ?? null,
                    'guarantee_amount' => $row['guarantee_amount'] ?? null,
                    'current_status' => $row['current_status'] ?? null,
                    // 'contractor_fetch_reference_id' => $row['obfp_id'] ?? null,
                    'contractor_fetch_reference_id' => $row['ocfr_id'] ?? null,
                ];

                $hasObfpId = isset($row['obfp_id']);

                if (!$hasAutoProposalId || ($hasAutoProposalId && !$hasObfpId)) {
                    $orderBookAndFutureProjectsRepeater = $proposal->orderBookAndFutureProjects()->create($orderBookAndFutureProjectsArr);

                    if(isset($request->autosave)){
                        $autosaved_obfp_items[] = $orderBookAndFutureProjectsRepeater->id;
                    }
                } elseif ($hasAutoProposalId && $hasObfpId) {
                    $orderBookAndFutureProjectsRepeater = tap(
                        $proposal->orderBookAndFutureProjects()
                            ->where('contractor_fetch_reference_id', $row['obfp_id'])
                            ->orWhere('id', $row['obfp_id'])
                            ->first()
                    )->update($orderBookAndFutureProjectsArr);

                    if(isset($request->autosave)){
                        $autosaved_obfp_items[] = $orderBookAndFutureProjectsRepeater->id;
                    }
                }

                if(isset($row['obfp_id'])){
                    $principle->orderBookAndFutureProjects()->where('id', $row['obfp_id'])->orWhere('contractor_fetch_reference_id', $row['obfp_id'])->update($orderBookAndFutureProjectsArr);
                }

                if (!isset($row['obfp_id']) && isset($principle->orderBookAndFutureProjects)){
                    $contractorOrderBookAndFutureProjectsRepeater = tap(
                        $principle->orderBookAndFutureProjects()->create($orderBookAndFutureProjectsArr)
                    )->update([
                        'contractor_fetch_reference_id' => $orderBookAndFutureProjectsRepeater->id
                    ]);
                }

                if(isset($row['delete_obfp_id'])){
                    $principle->orderBookAndFutureProjects()->where('id', $row['delete_obfp_id'])->delete();
                }

                if (isset($row['obfp_id']) && $contractorDocs) {
                    $order_book_and_future_projects_principle_attachment = DMS::where(['dmsable_id'=>$row['obfp_id'],'dmsable_type'=>'OrderBookAndFutureProjects'])->get();

                    foreach ($order_book_and_future_projects_principle_attachment as $attachment) {
                        if(File::exists($attachment->attachment) && isset($orderBookAndFutureProjectsRepeater)) {
                            $newFilepath = "uploads/proposal/{$code}/V{$version_code}/$proposal_id/{$attachment->file_name}";
                            // File::copy($attachment->attachment, $newFilepath);
                            $orderBookAndFutureProjectsRepeater->dMS()->create([
                                'file_name' => $attachment->file_name,
                                'attachment' => $newFilepath ?? null,
                                'attachment_type' => $attachment->attachment_type,
                            ]);
                        }
                    }
                }

                if(isset($orderBookAndFutureProjectsRepeater)){
                    $dms_orderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($orderBookAndFutureProjectsRepeater->id);
                }

                if (!isset($row['obfp_id']) && isset($contractorOrderBookAndFutureProjectsRepeater)){
                    $dms_contractorOrderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($contractorOrderBookAndFutureProjectsRepeater->id);
                }

                if(!isset($row['ocfr_id'])) {
                    $orderBookAndFutureProjectsRepeater->update(['contractor_fetch_reference_id' => $orderBookAndFutureProjectsRepeater->id]);
                }

                if (!empty($row['order_book_and_future_projects_attachment'])) {
                    foreach ($row['order_book_and_future_projects_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();
                        $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/principle/' . $principle->id . '/' . $fileName;
                        copy($filePath1, $filePath2);

                        if(isset($dms_orderBookAndFutureProjects)){
                            $dms_orderBookAndFutureProjects->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath1,
                                'attachment_type' => 'order_book_and_future_projects_attachment',
                            ]);
                        }

                        if(isset($dms_contractorOrderBookAndFutureProjects)){
                            $dms_contractorOrderBookAndFutureProjects->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2,
                                'attachment_type' => 'order_book_and_future_projects_attachment',
                            ]);
                        }

                        if(isset($row['obfp_id'])){
                            $contractorOrderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($row['obfp_id']);
                            $contractorOrderBookAndFutureProjects->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2 ?? null,
                                'attachment_type' => 'order_book_and_future_projects_attachment',
                            ]);
                        }
                    }
                }
            }

            // Project Track Records Repeater
            $autosaved_ptr_items = [];

            $projectTrackRecords = $request->ptr_items;
            foreach($projectTrackRecords as $row){
                $projectTrackRecordsArr = [
                    'project_name' => $row['project_name'] ?? null,
                    'project_cost' => $row['project_cost'] ?? null,
                    'project_description' => $row['project_description'] ?? null,
                    'project_start_date' => $row['project_start_date'] ?? null,
                    'project_end_date' => $row['project_end_date'] ?? null,
                    'project_tenor' => $row['project_tenor'] ?? null,
                    'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                    'actual_date_completion' => $row['actual_date_completion'] ?? null,
                    'bg_amount' => $row['bg_amount'] ?? null,
                    // 'contractor_fetch_reference_id' => $row['ptr_id'] ?? null,
                    'contractor_fetch_reference_id' => $row['pcfr_id'] ?? null,
                ];

                $hasPtrId = isset($row['ptr_id']);

                if (!$hasAutoProposalId || ($hasAutoProposalId && !$hasPtrId)) {
                    $projectTrackRecordsRepeater = $proposal->projectTrackRecords()->create($projectTrackRecordsArr);

                    if(isset($request->autosave)){
                        $autosaved_ptr_items[] = $projectTrackRecordsRepeater->id;
                    }
                } elseif ($hasAutoProposalId && $hasPtrId) {
                    $projectTrackRecordsRepeater = tap(
                        $proposal->projectTrackRecords()
                            ->where('contractor_fetch_reference_id', $row['ptr_id'])
                            ->orWhere('id', $row['ptr_id'])
                            ->first()
                    )->update($projectTrackRecordsArr);

                    if(isset($request->autosave)){
                        $autosaved_ptr_items[] = $projectTrackRecordsRepeater->id;
                    }
                }

                if(isset($row['ptr_id'])){
                    $principle->projectTrackRecords()->where('id', $row['ptr_id'])->orWhere('contractor_fetch_reference_id', $row['ptr_id'])->update($projectTrackRecordsArr);
                }

                if (!isset($row['ptr_id']) && isset($principle->projectTrackRecords)){
                    $contractorProjectTrackRecordsRepeater = tap(
                        $principle->projectTrackRecords()->create($projectTrackRecordsArr)
                    )->update([
                        'contractor_fetch_reference_id' => $projectTrackRecordsRepeater->id
                    ]);
                }

                if(isset($row['delete_ptr_id'])){
                    $principle->projectTrackRecords()->where('id', $row['delete_ptr_id'])->delete();
                }

                if (isset($row['ptr_id']) && $contractorDocs) {
                    $project_track_records_principle_attachment = DMS::where(['dmsable_id'=>$row['ptr_id'],'dmsable_type'=>'ProjectTrackRecords'])->get();

                    foreach ($project_track_records_principle_attachment as $attachment) {
                        if(File::exists($attachment->attachment) && isset($projectTrackRecordsRepeater)) {
                            $newFilepath = "uploads/proposal/{$code}/V{$version_code}/$proposal_id/{$attachment->file_name}";
                            File::copy($attachment->attachment, $newFilepath);
                            $projectTrackRecordsRepeater->dMS()->create([
                                'file_name' => $attachment->file_name,
                                'attachment' => $newFilepath ?? null,
                                'attachment_type' => $attachment->attachment_type,
                            ]);
                        }
                    }
                }

                if(isset($projectTrackRecordsRepeater)){
                    $dms_projectTrackRecords = ProjectTrackRecords::findOrFail($projectTrackRecordsRepeater->id);
                }

                if (!isset($row['ptr_id']) && isset($contractorProjectTrackRecordsRepeater)){
                    $dms_contractorProjectTrackRecords = ProjectTrackRecords::findOrFail($contractorProjectTrackRecordsRepeater->id);
                }

                if(!isset($row['pcfr_id'])) {
                    $projectTrackRecordsRepeater->update(['contractor_fetch_reference_id' => $projectTrackRecordsRepeater->id]);
                }

                if (!empty($row['project_track_records_attachment'])) {
                    foreach ($row['project_track_records_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();
                        $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/principle/' . $principle->id . '/' . $fileName;
                        copy($filePath1, $filePath2);

                        if(isset($dms_projectTrackRecords)){
                            $dms_projectTrackRecords->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath1,
                                'attachment_type' => 'project_track_records_attachment',
                            ]);
                        }

                        if(isset($dms_contractorProjectTrackRecords)){
                            $dms_contractorProjectTrackRecords->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2,
                                'attachment_type' => 'project_track_records_attachment',
                            ]);
                        }

                        if(isset($row['ptr_id'])){
                            $contractorProjectTrackRecords = ProjectTrackRecords::findOrFail($row['ptr_id']);
                            $contractorProjectTrackRecords->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2 ?? null,
                                'attachment_type' => 'project_track_records_attachment',
                            ]);
                        }
                    }
                }
            }

            // Management Profiles Repeater
            $autosaved_mp_items = [];

            $managementProfiles = $request->mp_items;
            foreach($managementProfiles as $row){
                $managementProfilesArr = [
                    'designation' => $row['designation'] ?? null,
                    'name' => $row['name'],
                    'qualifications' => $row['qualifications'],
                    'experience' => $row['experience'],
                    // 'contractor_fetch_reference_id' => $row['mp_id'] ?? null,
                    'contractor_fetch_reference_id' => $row['mcfr_id'] ?? null,
                ];

                $hasMpId = isset($row['mp_id']);

                if (!$hasAutoProposalId || ($hasAutoProposalId && !$hasMpId)) {
                    $managementProfilesRepeater = $proposal->managementProfiles()->create($managementProfilesArr);

                    if(isset($request->autosave)){
                        $autosaved_mp_items[] = $managementProfilesRepeater->id;
                    }
                } elseif ($hasAutoProposalId && $hasMpId) {
                    $managementProfilesRepeater = tap(
                        $proposal->managementProfiles()
                            ->where('contractor_fetch_reference_id', $row['mp_id'])
                            ->orWhere('id', $row['mp_id'])
                            ->first()
                    )->update($managementProfilesArr);

                    if(isset($request->autosave)){
                        $autosaved_mp_items[] = $managementProfilesRepeater->id;
                    }
                }

                if(isset($row['mp_id'])){
                    $principle->managementProfiles()->where('id', $row['mp_id'])->orWhere('contractor_fetch_reference_id', $row['mp_id'])->update($managementProfilesArr);
                }

                if (!isset($row['mp_id']) && isset($principle->managementProfiles)){
                    $contractorManagementProfilesRepeater = tap(
                        $principle->managementProfiles()->create($managementProfilesArr)
                    )->update([
                        'contractor_fetch_reference_id' => $managementProfilesRepeater->id
                    ]);
                }

                if(isset($row['delete_mp_id'])){
                    $principle->managementProfiles()->where('id', $row['delete_mp_id'])->delete();
                }

                if (isset($row['mp_id']) && $contractorDocs) {
                    $management_profiles_principle_attachment = DMS::where(['dmsable_id'=>$row['mp_id'],'dmsable_type'=>'ManagementProfiles'])->get();

                    foreach ($management_profiles_principle_attachment as $attachment) {
                        if(File::exists($attachment->attachment) && isset($managementProfilesRepeater)) {
                            $newFilepath = "uploads/proposal/{$code}/V{$version_code}/$proposal_id/{$attachment->file_name}";
                            File::copy($attachment->attachment, $newFilepath);
                            $managementProfilesRepeater->dMS()->create([
                                'file_name' => $attachment->file_name,
                                'attachment' => $newFilepath ?? null,
                                'attachment_type' => $attachment->attachment_type,
                            ]);
                        }
                    }
                }

                if(isset($managementProfilesRepeater)){
                    $dms_managementProfiles = ManagementProfiles::findOrFail($managementProfilesRepeater->id);
                }

                if (!isset($row['mp_id']) && isset($contractorManagementProfilesRepeater)){
                    $dms_contractorManagementProfiles = ManagementProfiles::findOrFail($contractorManagementProfilesRepeater->id);
                }

                if(!isset($row['mcfr_id'])) {
                    $managementProfilesRepeater->update(['contractor_fetch_reference_id' => $managementProfilesRepeater->id]);
                }

                if (!empty($row['management_profiles_attachment'])) {
                    foreach ($row['management_profiles_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();
                        $filePath1 = $item->move('uploads/proposal/' . $code . '/V' . $version_code . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/principle/' . $principle->id . '/' . $fileName;
                        copy($filePath1, $filePath2);

                        if(isset($dms_managementProfiles)){
                            $dms_managementProfiles->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath1,
                                'attachment_type' => 'management_profiles_attachment',
                            ]);
                        }

                        if(isset($dms_contractorManagementProfiles)){
                            $dms_contractorManagementProfiles->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2,
                                'attachment_type' => 'management_profiles_attachment',
                            ]);
                        }

                        if(isset($row['mp_id'])){
                            $contractorManagementProfiles = ManagementProfiles::findOrFail($row['mp_id']);
                            $contractorManagementProfiles->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2 ?? null,
                                'attachment_type' => 'management_profiles_attachment',
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            if(isset($request->autosave)){
                $response = [
                    'proposal_id' => $proposal_id,
                    'autosaved_pbl_items' => $autosaved_pbl_items,
                    'autosaved_obfp_items' => $autosaved_obfp_items,
                    'autosaved_ptr_items' => $autosaved_ptr_items,
                    'autosaved_mp_items' => $autosaved_mp_items,
                    'autosaved_jv_items' => $autosaved_jv_items,
                    'autosaved_spv_items' => $autosaved_spv_items,
                    // 'autosaved_contractor_items' => $autosaved_contractor_items,
                    'autosavedBeneficiaryTradeSector' => $autosavedBeneficiaryTradeSector,
                    'autosaved_tradesector_items' => $autosaved_tradesector_items,
                    'autosaved_contact_details' => $autosaved_contact_details,
                    'autosaved_rating_details' => $autosaved_rating_details,
                ];
                return $response;
            } else {
                return redirect()->route('proposals.index')->with('success', __('proposals.create_success'));
            }

            // $this->proposalCaseCreate($proposal_id);

        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function areProposalFieldsNonNull($data, $requiredFields) {
        foreach ($requiredFields as $field) {
            if (!array_key_exists($field, $data) || is_null($data[$field])) {
                return false;
            }
        }
        return true;
    }

    public function show($id)
    {
        $proposals = Proposal::with([
            'bankingLimits.getBankingLimitCategoryName',
            'bankingLimits.getFacilityTypeName',
            'bankingLimits.dMS',
            'orderBookAndFutureProjects.getProjectTypeName',
            'projectTrackRecords.getProjectTypeName',
            'managementProfiles.getDesignationName',
            'additionalBonds.getAdditionalBondName',
            'getDesignationName',
            'getBondTypeName',
            'dMS',
            'nbi',
            'contractor',
            'agencyRatingDetails',
            'InvocationNotification'
        ])->findOrFail($id);

        $this->common->markAsRead($proposals);
       

        //$tenderEvaluations = TenderEvaluation::with(['contractor','beneficiary'])->where('proposal_id', $id)->orderBy('id','desc')->get();
        $this->data['dms_data'] = $proposals->dMS->groupBy('attachment_type');

        $table_name =  $proposals->getTable();
        $this->data['table_name'] = $table_name;

        $this->data['proposals'] = $proposals;
        //$this->data['tenderEvaluations'] = $tenderEvaluations;
        $this->data['nbis'] = $proposals->nbi->sortByDesc('id');

        $this->data['rejectionReasonData'] = ProposalLog::where('proposal_id', $id)->where('tender_evaluation_id', null)->first();

        if(isset($this->data['rejectionReasonData'])){
            $this->data['rejection_reason'] = RejectionReason::where('id', $this->data['rejectionReasonData']->rejection_reason)->first()->reason ?? null;
        }

        $this->data['is_amend'] = $proposals->is_amendment === 0 ? true : false;
        $this->data['proposal_past'] = $proposals->findOrfail($id)->where('is_amendment', '1')->where('code', $proposals->code)->get();

        $bond_policy_issue_checklist = BondPoliciesIssueChecklist::with('dMS')->where('proposal_id', $id)->first();
        $this->data['issue_checklist_dms'] = isset($bond_policy_issue_checklist) ? $bond_policy_issue_checklist->dMS->groupBy('attachment_type') : [];
        $this->data['bond_policy_issue_checklist'] = $bond_policy_issue_checklist;

        $bond_policy_issue = BondPoliciesIssue::where('proposal_id', $id)->first();
        $this->data['bond_policy_issue_dms'] = isset($bond_policy_issue) ? $bond_policy_issue->dMS->groupBy('attachment_type') : [];
        $this->data['bond_policy_issue'] = $bond_policy_issue;

        $invocation_notification = InvocationNotification::with('dMS')->where('proposal_id', $id)->first();
        $this->data['invocation_notification_dms'] = isset($invocation_notification) ? $invocation_notification->dMS->groupBy('attachment_type') : [];
        $this->data['invocation_notification'] = $invocation_notification;

        $invocationClaimData = InvocationClaims::with('bondType','dMS','proposal')->where('proposal_id',$id)->first();
        $this->data['invocationClaimData'] = $invocationClaimData;
        $this->data['invocationClaimDms'] = isset($invocationClaimData) ? $invocationClaimData->dMS->groupBy('attachment_type') : [];

        $bond_foreclosure = BondForeClosure::with('dMS')->where('proposal_id', $id)->first();
        $this->data['bond_foreclosure_dms'] = isset($bond_foreclosure) ? $bond_foreclosure->dMS->groupBy('attachment_type') : [];
        $this->data['bond_foreclosure'] = $bond_foreclosure;

        $bond_cancellation = BondCancellation::with('dMS')->where('proposal_id', $id)->first();
        $this->data['bond_cancellation_dms'] = isset($bond_cancellation) ? $bond_cancellation->dMS->groupBy('attachment_type') : [];
        $this->data['bond_cancellation'] = $bond_cancellation;

        $bond_progress = BondProgress::with('dMS')->where('proposal_id', $id)->get() ?? [];
        $this->data['bond_progress'] = $bond_progress;

        $this->data['rejection_reasons'] = $this->common->getRejectionReason();
        $nbi = $proposals->nbi->where('status', 'Approved')->first();
        $currency_symbol = $nbi ? $nbi->currency->where('id', $nbi->contract_currency_id)->pluck('symbol')->first() : '';
        $this->currencySymbol = isset($currency_symbol) ? '('.$currency_symbol.')' : '';
        view()->share('currencySymbol', $this->currencySymbol);

        $this->data['currency_symbol'] = $proposals->contractor ? $this->common->getCurrencySymbol($proposals->contractor->country_id) : '';

        $proposal_required_fields = Config('srtpl.proposal_required_fields');

        $this->data['areProposalFieldsNonNull'] = $this->areProposalFieldsNonNull($proposals->getattributes(), $proposal_required_fields);

        return view('proposals.show', $this->data);
    }

    public function edit($id, Request $request)
    {
        $proposals = Proposal::with('bankingLimits', 'orderBookAndFutureProjects', 'projectTrackRecords', 'managementProfiles', 'dMS', 'proposalContractors', 'contractorItem', 'agencyRatingDetails','additionalContractorCountry','additionalBeneficiaryCountry','benificiaryCountry')->findOrFail($id);

        $is_amendment = $request->is_amendment ? $request->is_amendment : 'no';
        $contractorArr = []; $jvContractorArr = [];
        if(isset($proposals) && isset($proposals->proposalContractors) && $proposals->proposalContractors->count()>0){
            $contractorArr = $proposals->proposalContractors->pluck('proposal_contractor_id')->toArray();
            $jvContractorArr = $proposals->proposalContractors->pluck('mainContractor')->pluck('principle_id')->toArray();
        }
        $proposals->tender_bond_value = $proposals->bond_value;

        $this->data['countries'] =  $this->common->getCountries();
        $this->data['states'] =  $this->common->getStates($proposals->country_id);
        $selected_country = $proposals->country ? $proposals->country->name : '';

        $this->data['isContractorCountryIndia'] = isset($proposals) && strtolower($proposals->country->name) == 'india' ? true : false;
        $this->data['isAddContraCountryIndia'] = isset($proposals->additionalContractorCountry->name) && strtolower($proposals->additionalContractorCountry->name) == 'india' ? true : false;
        $this->data['isBeneCountryIndia'] = isset($proposals->benificiaryCountry->name) && strtolower($proposals->benificiaryCountry->name) == 'india' ? true : false;
        $this->data['isAddBeneCountryIndia'] = isset($proposals->additionalBeneficiaryCountry->name) && strtolower($proposals->additionalBeneficiaryCountry->name) == 'india' ? true : false;

        $this->data['jsVentureTypeRequired'] = isset($proposals) && isset($proposals->contract_type) && $proposals->contract_type == "Stand Alone" ? true : false;

        $this->data['principle_types'] = PrincipleType::where('is_active', 1)->get();
        $this->data['contractors'] = $this->common->getSpvContractor();
        $this->data['trade_sector'] = $this->common->getTradeSector();
        $this->data['designation'] = $this->common->getDesignation();
        $this->data['bond_types'] = $this->common->getBondTypes();
        $this->data['facility_types'] = $this->common->getFacilityType();
        $this->data['banking_limit_category'] = $this->common->getBankingLimitCategory();
        $this->data['project_type'] = $this->common->getProjectType();
        $this->data['beneficiaries'] = $this->common->getBeneficiary($proposals->beneficiary_id);
        $this->data['current_status'] = Config('srtpl.current_status');
        $this->data['completion_status'] = Config('srtpl.completion_status');
        $this->data['additional_bonds'] = $this->common->getAdditionalBonds();
        $this->data['tender_details'] = $this->common->getTender($proposals->tender_details_id, $proposals->project_details);
        $this->data['bond_type_id'] = $this->common->getBondTypes($proposals->bond_type);
        $this->data['type_of_contracting'] = Config('srtpl.type_of_contracting');

        $this->data['proposal_banking_limits'] = $proposals->bankingLimits;
        $this->data['order_book_and_future_projects'] = $proposals->orderBookAndFutureProjects;
        $this->data['project_track_records'] = $proposals->projectTrackRecords;
        $this->data['management_profiles'] = $proposals->managementProfiles;
        $this->data['additionalBonds'] = $proposals->additionalBonds;

        $this->data['beneficiary_address'] = Beneficiary::pluck('address', 'id')->toArray();
        $this->data['beneficiary_type'] = Beneficiary::pluck('beneficiary_type', 'id')->toArray();

        $this->data['dms_data'] = $proposals->dMS->groupBy('attachment_type')->whereNull('deleted_at');
        $this->data['proposal_contractors'] = $proposals->proposalContractors;

        $dmsRecords = DMS::where('dmsable_type', BankingLimit::class)
        ->whereIn('dmsable_id', $proposals->bankingLimits->pluck('id'))
        ->get();

        $this->data['tender_id'] = $this->common->getTender();

        $contractorField = [DB::raw("CONCAT(principles.code, ' - ', principles.company_name) as contractor_data"), 'principles.id'];
        $this->data['contractor_id'] = Principle::select($contractorField)->where('is_active', 'Yes')->pluck('contractor_data', 'id')->toArray();

        $this->data['groupedDmsRecords'] = [];

        foreach ($dmsRecords as $dmsRecord) {
            $this->data['groupedDmsRecords'][$dmsRecord->dmsable_id][] = $dmsRecord;
        }

        $this->data['contractor_types'] = Config('srtpl.contractor_type');
        $spv_contractors = $this->common->getSpvContractor();
        $spvConOptions = [];
        if (!empty($spv_contractors)) {
            foreach ($spv_contractors as $ykey => $yval) {
                if(in_array($ykey,$contractorArr)){
                    $spvConOptions[$ykey] = ['disabled' => 'disabled'];
                }
            }
        }

        $this->data['spv_contractors'] = $this->common->getSpvContractor($proposals->contractor_id);
        $this->data['stand_alone_contractors'] = $this->common->getStandAloneContractor($proposals->contractor_id);
        $this->data['spvConOptions'] = $spvConOptions;

        $jvData = Principle::withCount('contractorItem')->where('is_active', 'Yes')->where('venture_type', 'JV')->orderBy('company_name', 'ASC')->select(DB::raw("CONCAT_WS(' | ', company_name,pan_no) as company_name"), 'id');

        $jvOptArr = [];
        if ($jvData->count()) {
            foreach ($jvData as $key => $jvVal) {
                $jvOptArr[$jvVal->id] = ['data-ctcount' => $jvVal->contractor_item_count];
                if(in_array($jvVal->id,$jvContractorArr)){
                    $jvOptArr[$jvVal->id] = ['disabled' => 'disabled'];
                }
            }
        }
        $this->data['jv_contractors'] = $jvData->pluck('company_name', 'id')->toArray();
        $this->data['jvOptArr'] = $jvOptArr;
        $this->data['jvContractorArr'] = array_unique($jvContractorArr);

        $this->data['proposals'] = $proposals;
        $this->data['user'] = $this->common->getSoure($proposals->source);

        $this->data['ministry_type_id'] = $this->common->getMinistryType($proposals->ministry_type_id);
        $this->data['establishment_type'] = $this->common->getEstablishmentType($proposals->establishment_type_id);
        $this->data['trade_sector_id'] = $this->common->getTradeSector();
        $this->data['project_details'] = $this->common->getProjectDetails(null, $proposals->beneficiary_id);
        $this->data['type_of_project'] = $this->common->getProjectType($proposals->pd_type_of_project);
        // $this->data['agencies'] = $this->common->getAgency($proposals->agency_id);
        // $this->data['agency_rating'] = $this->common->getRating($proposals->agency_rating_id);
        $this->data['is_amendment'] = $is_amendment;

        $this->data['ratingDetails'] = $proposals->agencyRatingDetails;
        $this->data['entity_types'] = $this->common->getEntityType($proposals->entity_type_id);

        $this->data['currency_symbol'] = $proposals->contractor && $proposals->contractor->country_id ? $this->common->getCurrencySymbol($proposals->contractor->country_id) : '';

        // $this->data['typeStandAlone'] = $proposals->contract_type == 'Stand Alone' ? '' : 'disabled';

        $this->data['agency_rating'] = $this->common->getRating();

        $agencyArr = $proposals->agencyRatingDetails->pluck('agency_id')->toArray() ?? [];
        $this->data['agencies'] = $this->common->getAgency() ?? [];

        $agencyOptions = [];
        if (!empty($this->data['agencies'])) {
            foreach ($this->data['agencies'] as $key => $value) {
                if(in_array($key,$agencyArr)){
                    $agencyOptions[$key] = ['disabled' => 'disabled'];
                    // if($key == $blacklist->contractor_id){
                    //     $agencyOptions[$key] = ['' => ''];
                    // }
                }
            }
        }
        $this->data['agencyOptions'] = $agencyOptions;
        // dd($proposals);

        return view('proposals.edit', $this->data);
    }

    public function deleteAttachment($dmsModel, $attachmentType, $requestFlag, $requestProperty, $request)
    {
        $docs = $dmsModel->dMS()->where('attachment_type', $attachmentType)->first();

        if ($docs && $request->$requestProperty == $requestFlag) {
            $docs->delete();
            File::delete($docs->attachment);
        }
    }

    public function update($id, ProposalRequest $request)
    {
        // dd($request->all());
        $proposals = Proposal::with('bankingLimits.dMS', 'orderBookAndFutureProjects', 'projectTrackRecords', 'managementProfiles', 'dMS', 'proposalContractors', 'contractor')->findOrFail($id);
        $prev_proposal_id = $proposals->id;
        $is_amendment = $request->is_amendment;
        // dd($request->all());
        DB::beginTransaction();
        try{
            if($is_amendment == 'no'){
                $input = $request->except(['_token', '_method','tradeSector', 'contactDetail', 'beneficiaryTradeSector', 'pbl_items', 'obfp_items', 'ptr_items', 'mp_items', 'jvContractorDetails', 'spvContractorDetails', 'contractorDetails', 'company_details', 'company_technical_details', 'company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr', 'rfp_attachment', 'bond_attachment', 'bond_wording_file', 'contractor_trade_item_id', 'contact_item_id', 'jv_contractor', 'spv_contractor', 'jv_count', 'contractor_item_id', 'delete_pbl_id', 'delete_obfp_id', 'delete_ptr_id', 'delete_mp_id', 'beneficiary_trade_item_id', 'banking_limits_attachment', 'order_book_and_future_projects_attachment', 'project_track_records_attachment', 'management_profiles_attachment', 'contractor_tender_id', 'agency', 'series_number', 'auto_proposal_id', 'ratingDetail', 'rating_id', 'item_rating_date', 'contractor_country_name', 'contractor_bond_country_name', 'beneficiary_country_name', 'beneficiary_bond_country_name', 'spv_count']);

                if($input['contract_type'] == 'JV'){
                    $input['contractor_id'] = $request['jv_contractor'] ?? null;
                } else if($input['contract_type'] == 'SPV'){
                    // $input['contractor_id'] = $request->spvContractorDetails[0]['spv_contractor_id'] ?? null;
                    $input['contractor_id'] = $request['spv_contractor'] ?? null;
                } else {
                    $input['contractor_id'] = $request->contractor_id;
                }

                $proposals->update($input);

                $proposal_id = $proposals->id;

                $contractorUpdate = [
                    'registration_no' => $request['registration_no'],
                    'company_name' => $request['contractor_company_name'],
                    'address' => $request['register_address'],
                    'website' => $request['contractor_website'],
                    'country_id' => $request['contractor_country_id'],
                    'state_id' => $request['contractor_state_id'],
                    'city' => $request['contractor_city'],
                    'pincode' => $request['contractor_pincode'],
                    'gst_no' => $request['contractor_gst_no'],
                    'pan_no' => $request['contractor_pan_no'],
                    'date_of_incorporation' => $request['date_of_incorporation'],
                    'principle_type_id' => $request['principle_type_id'],
                    // 'is_jv' => $request['is_jv'],
                    'are_you_blacklisted' => $request['are_you_blacklisted'],
                    'is_bank_guarantee_provided' => $request['is_bank_guarantee_provided'],
                    'circumstance_short_notes' => $request['circumstance_short_notes'],
                    'is_action_against_proposer' => $request['is_action_against_proposer'],
                    'action_details' => $request['action_details'],
                    'contractor_failed_project_details' => $request['contractor_failed_project_details'],
                    'completed_rectification_details' => $request['completed_rectification_details'],
                    'performance_security_details' => $request['performance_security_details'],
                    'relevant_other_information' => $request['relevant_other_information'],
                    'entity_type_id' => $request['contractor_entity_type_id'],
                    'staff_strength' => $request['contractor_staff_strength'],
                    // 'inception_date' => $request['contractor_inception_date'],
                ];
                if($proposals->contractor){
                    $proposals->contractor->where('id', $input['contractor_id'])->update($contractorUpdate);
                    // $proposals->contractor->user->where('id', $proposals->contractor->user_id)
                    // ->update([
                    //     'email' => $request->contractor_email ?? null,
                    //     'mobile' => $request->contractor_mobile ?? null,
                    // ]);
                }

                // $userUpdate = [
                //     'email' => $request['contractor_email'],
                //     'mobile' => $request['contractor_mobile'],
                // ];
                // $proposals->contractor->user->where('id', $request->contractor_id)->update($userUpdate);

                $beneficiaryUpdate = [
                    'company_name' => $request['beneficiary_company_name'],
                    'registration_no' => $request['beneficiary_registration_no'],
                    'address' => $request['beneficiary_address'],
                    'website' => $request['beneficiary_website'],
                    'country_id' => $request['beneficiary_country_id'],
                    'state_id' => $request['beneficiary_state_id'],
                    'city' => $request['beneficiary_city'],
                    'pincode' => $request['beneficiary_pincode'],
                    'gst_no' => $request['beneficiary_gst_no'],
                    'pan_no' => $request['beneficiary_pan_no'],
                    'beneficiary_type' => $request['beneficiary_type'],
                    'establishment_type_id' => $request['establishment_type_id'],
                    'ministry_type_id' => $request['ministry_type_id'],
                    'bond_wording' => $request['beneficiary_bond_wording'],
                ];
                if($proposals->beneficiary){
                    $proposals->beneficiary->where('id', $request->beneficiary_id)->update($beneficiaryUpdate);
                    $proposals->beneficiary->user->where('id', $proposals->beneficiary->user_id)->update([
                        'mobile' => $request->beneficiary_phone_no ?? null,
                        'email' => $request->beneficiary_email ?? null,
                    ]);
                }

                $projectDetailsUpdate = [
                    'beneficiary_id' => $request['pd_beneficiary'],
                    'project_name' => $request['pd_project_name'],
                    'project_description' => $request['pd_project_description'],
                    'project_value' => $request['pd_project_value'],
                    'type_of_project' => $request['pd_type_of_project'],
                    'project_start_date' => $request['pd_project_start_date'],
                    'project_end_date' => $request['pd_project_end_date'],
                    'period_of_project' => $request['pd_period_of_project'],
                ];
                if($proposals->projectDetails){
                    $proposals->projectDetails->where('id', $request->project_details)->update($projectDetailsUpdate);
                }

                $tenderUpdate = [
                    'tender_id' => $request['tender_id'],
                    'tender_header' => $request['tender_header'],
                    'tender_description' => $request['tender_description'],
                    'location' => $request['location'],
                    'project_type' => $request['project_type'],
                    'beneficiary_id' => $request['tender_beneficiary_id'],
                    'contract_value' => $request['tender_contract_value'],
                    'period_of_contract' => $request['period_of_contract'],
                    'bond_value' => $request['tender_bond_value'],
                    'bond_type_id' => $request['bond_type_id'],
                    'type_of_contracting' => $request['type_of_contracting'],
                    'rfp_date' => $request['rfp_date'],
                    'project_description' => $request['project_description'],
                    'project_details' => $request['project_details'],
                    'pd_beneficiary' => $request['tender_beneficiary_id'] ?? $request['beneficiary_id'],
                    'pd_project_name' => $request['pd_project_name'],
                    'pd_project_description' => $request['pd_project_description'],
                    'pd_project_value' => $request['pd_project_value'],
                    'pd_type_of_project' => $request['pd_type_of_project'],
                    'pd_project_start_date' => $request['pd_project_start_date'],
                    'pd_project_end_date' => $request['pd_project_end_date'],
                    'pd_period_of_project' => $request['pd_period_of_project'],
                ];
                if($proposals->tender){
                    $proposals->tender->where('id', $request->tender_details_id)->update($tenderUpdate);
                }

                $contractorId = '';
                if($request->contract_type == 'Stand Alone'){
                    $contractorId = $request->contractor_id ?? null;
                } elseif($request->contract_type == 'SPV'){
                    // $contractorId = $request->spvContractorDetails[0]['spv_contractor_id'];
                    $contractorId = $request->spv_contractor ?? null;
                } elseif($request->contract_type == 'JV'){
                    $contractorId = $request->jv_contractor ?? null;
                }

                $principles = Principle::findOrFail($contractorId);
                $beneficiary = Beneficiary::findOrFail($proposals->beneficiary_id);

                // Proposal Documents - DMS

                $dmsModel = Proposal::findOrFail($proposal_id);

                // $assessmentDocs = [
                //     'audited_financials_attachment' => 'audited_financials_public_domain',
                //     'latest_presentation_attachment' => 'latest_presentation_domain',
                //     'rating_rationale_attachment' => 'rating_rationale_domain',
                //     'proposal_attachment' => 'is_manual_entry',
                // ];

                // foreach ($assessmentDocs as $existingDoc => $checkedFlag) {
                //     $this->deleteAttachment($dmsModel, $existingDoc, 'Yes', $checkedFlag, $request);
                // }

                // $requirementDocs = [
                //     'project_attachment' => 'is_project_agreement',
                //     'rfp_attachment' => 'rfp_of_project',
                //     'feasibility_attachment' => 'is_feasibility_attachment',
                // ];

                // foreach ($requirementDocs as $existingDoc => $checkedFlag) {
                //     $this->deleteAttachment($dmsModel, $existingDoc, 'No', $checkedFlag, $request);
                // }

                if($request->hasFile('bond_wording_file')){
                    $this->common->updateMultipleFiles($request, $request['bond_wording_file'], 'bond_wording_file', $proposals, $proposal_id, 'proposal/' . $proposal_id);
                }

                $contractorFilePath = 'uploads/principle/' . $proposals->contractor->id;

                foreach (['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr'] as $documentType) {
                    if($request->hasFile($documentType)){
                        // $this->common->updateMultipleFiles($request, $request[$documentType], $documentType, $proposals->contractor, $proposals->contractor->id, 'principle/' . $proposals->contractor->id);

                        foreach ($request[$documentType] as $item) {
                            $fileName = $item->getClientOriginalName();

                            $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                            copy($filePath1, $contractorFilePath . '/' . $fileName);

                            $filePath2 = $contractorFilePath . '/' . $fileName;

                            $proposals->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath1,
                                'attachment_type' => $documentType,
                            ]);

                            $proposals->contractor->dMS()->create([
                                'file_name' => $fileName,
                                'attachment' => $filePath2,
                                'attachment_type' => $documentType,
                            ]);
                        }
                    }
                }

                $dmsModel->save();

                if($request->hasFile('rfp_attachment')){
                    foreach ($request['rfp_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();

                        $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/tender/' . $proposals->tender->id . '/' . $fileName;

                        copy($filePath1, $filePath2);

                        $proposals->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath1,
                            'attachment_type' => 'rfp_attachment',
                        ]);

                        $proposals->tender->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath2,
                            'attachment_type' => 'rfp_attachment',
                        ]);
                    }
                }

                if($request->hasFile('bond_attachment')){
                    foreach ($request['bond_attachment'] as $item) {
                        $fileName = $item->getClientOriginalName();

                        $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                        $filePath2 = 'uploads/beneficiary/' . $proposals->beneficiary->id . '/' . $fileName;

                        if (!file_exists('uploads/beneficiary/' . $proposals->beneficiary->id . '/')) {
                            mkdir('uploads/beneficiary/' . $proposals->beneficiary->id . '/', 0775, true);
                        }

                        copy($filePath1, $filePath2);

                        $proposals->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath1,
                            'attachment_type' => 'bond_attachment',
                        ]);

                        $proposals->beneficiary->dMS()->create([
                            'file_name' => $fileName,
                            'attachment' => $filePath2,
                            'attachment_type' => 'bond_attachment',
                        ]);
                    }
                }

                $isSetRfpAttachment = $proposals->dMS()->where('dmsable_id', $proposal_id)->where('attachment_type', 'rfp_attachment')->first();

                $tender_rfp_file = DMS::where('dmsable_id', $request->tender_id)->where('dmsable_type', 'Tender')->first();

                if(!empty($request->tender_id) && isset($tender_rfp_file->attachment) && !isset($request->rfp_attachment) && $request->rfp_of_project == 'Yes'){
                    if(File::exists($tender_rfp_file->attachment)) {
                        $newRfpFilepath = 'uploads/proposal/' . $proposal_id . '/' . $tender_rfp_file->file_name;
                        $tenderFilePath = copy($tender_rfp_file->attachment, $newRfpFilepath);
                    }
                    if(isset($isSetRfpAttachment->attachment)) {
                        // File::delete($tender_rfp_file->attachment);
                        $dmsModel->dMS()->where('dmsable_id', $proposal_id)->where('attachment_type', 'rfp_attachment')->update([
                            'file_name' => $tender_rfp_file->file_name,
                            // 'attachment' => $tender_rfp_file->attachment,
                            'attachment' => $newRfpFilepath ?? null,
                            'attachment_type' => $tender_rfp_file->attachment_type,
                        ]);

                        $proposals->contractor->dMS()->where('dmsable_id', $proposals->contractor->id)->where('attachment_type', 'rfp_attachment')->update([
                            'file_name' => $tender_rfp_file->file_name,
                            'attachment' => $newRfpFilepath ?? null,
                            'attachment_type' => $tender_rfp_file->attachment_type,
                        ]);
                    } else {
                        $dmsModel->dMS()->create([
                            'file_name' => $tender_rfp_file->file_name,
                            // 'attachment' => $tender_rfp_file->attachment,
                            'attachment' => $newRfpFilepath ?? null,
                            'attachment_type' => $tender_rfp_file->attachment_type,
                        ]);

                        $proposals->contractor->dMS()->create([
                            'file_name' => $tender_rfp_file->file_name,
                            'attachment' => $newRfpFilepath ?? null,
                            'attachment_type' => $tender_rfp_file->attachment_type,
                        ]);
                    }
                }

                // JV, SPV, Stand Alone

                if($request['contract_type'] == 'Stand Alone'){
                    $jvContractorDetails = $request->jvContractorDetails;
                    if (!empty($jvContractorDetails) && count($jvContractorDetails) > 0) {
                        $proposals->proposalContractors()->delete();
                    }
                }

                if($request['contract_type'] == 'JV'){
                    $jvContractorDetails = $request->jvContractorDetails;
                    if (!empty($jvContractorDetails) && count($jvContractorDetails) > 0) {
                        // $jvCurrentIds = array_column($jvContractorDetails, 'jv_item_id');
                        // if(!empty($jvCurrentIds)){
                        //     dd(ProposalContractor::where('proposal_id', $proposal_id)->get(), $jvContractorDetails, $jvCurrentIds, empty($jvCurrentIds));
                        //     ProposalContractor::where('proposal_id', $proposal_id)->whereNotIn('id', $jvCurrentIds)->delete();
                        // }

                        $jvDetail_id = collect($jvContractorDetails)->pluck('jv_item_id')->toArray();
                        $existing_jvDetail = $proposals->proposalContractors()->pluck('id')->toArray();
                        $diff_jvDetail = array_diff($existing_jvDetail, $jvDetail_id);

                        $proposals->proposalContractors()->whereIn('id', $diff_jvDetail)->get()->each(function ($jvItem) {
                            $jvItem->delete();
                        });

                        // dd('444');
                        foreach($jvContractorDetails as $row) {
                            $jv_item_id = $row['jv_item_id'] ?? 0;
                            $jvDataArr = [
                                'proposal_id' => $proposal_id,
                                'proposal_contractor_type' => $request['contract_type'],
                                'proposal_contractor_id' => $row['jv_contractor_id'],
                                'pan_no' => $row['jv_pan_no'],
                                'share_holding' => $row['jv_share_holding'],
                                // 'jv_spv_exposure' => $row['jv_exposure'],
                                // 'assign_exposure' => $row['jv_assign_exposure'],
                                // 'overall_cap' => $row['jv_overall_cap'],
                                // 'consumed' => $row['jv_consumed'],
                                // 'spare_capacity' => $row['jv_spare_capacity'],
                                // 'remaining_cap' => $row['jv_remaining_cap'],
                            ];
                            if ($jv_item_id > 0) {
                                $proposals->proposalContractors()->where('id', $jv_item_id)->update($jvDataArr);
                            } else {
                                $proposals->proposalContractors()->create($jvDataArr);
                            }

                            // $principles->update([
                            //     'company_name' => $row['jv_contractor_name'],
                            //     'pan_no' => $row['jv_pan_no'],
                            // ]);
                            Principle::where('id', $row['jv_contractor_id'])->update([
                                'company_name' => $row['jv_contractor_name'],
                                'pan_no' => $row['jv_pan_no'],
                            ]);

                            ContractorItem::where('contractor_id', $row['jv_contractor_id'])->update([
                                'pan_no' => $row['jv_pan_no'],
                                'share_holding' => $row['jv_share_holding'],
                            ]);

                            // $principles->contractorItem()->where('id', $jv_item_id)->update([
                            //     'pan_no' => $row['jv_pan_no'],
                            //     'share_holding' => $row['jv_share_holding'],
                            // ]);
                        }
                    }
                }

                if($request['contract_type'] == 'SPV'){
                    $spvContractorDetails = $request->spvContractorDetails;
                    if (!empty($spvContractorDetails) && count($spvContractorDetails) > 0) {
                        $spvDetail_id = collect($spvContractorDetails)->pluck('spv_item_id')->toArray();
                        $existing_spvDetail = $proposals->proposalContractors()->pluck('id')->toArray();
                        $diff_spvDetail = array_diff($existing_spvDetail, $spvDetail_id);

                        $proposals->proposalContractors()->whereIn('id', $diff_spvDetail)->get()->each(function ($spvItem) {
                            $spvItem->delete();
                        });

                        foreach($spvContractorDetails as $row) {
                            $spv_item_id = $row['spv_item_id'] ?? 0;
                            $spvDataArr =  [
                                'proposal_id' => $proposal_id,
                                'proposal_contractor_type' => $request['contract_type'],
                                'proposal_contractor_id' => $row['spv_contractor_id'],
                                'pan_no' => $row['spv_pan_no'],
                                'share_holding' => $row['spv_share_holding'],
                                // 'jv_spv_exposure' => $row['spv_exposure'],
                                // 'assign_exposure' => $row['spv_assign_exposure'],
                                // 'overall_cap' => $row['spv_overall_cap'],
                                // 'consumed' => $row['spv_consumed'],
                                // 'spare_capacity' => $row['spv_spare_capacity'],
                                // 'remaining_cap' => $row['spv_remaining_cap'],
                            ];
                            // $proposals->proposalContractors()->create($spvDataArr);
                            // if ($spv_item_id > 0) {
                            //     ProposalContractor::where('id', $spv_item_id)->update($spvDataArr);
                            // } else {
                            //     ProposalContractor::create($spvDataArr);
                            // }
                            // $proposals->proposalContractors()->updateOrCreate([
                            //     'id' => $spv_item_id ?? null,
                            // ], $spvDataArr);
                            if ($spv_item_id > 0) {
                                $proposals->proposalContractors()->where('id', $spv_item_id)->update($spvDataArr);
                            } else {
                                $proposals->proposalContractors()->create($spvDataArr);
                            }

                            // $principles->update([
                            //     'company_name' => $row['spv_contractor_name'],
                            //     'pan_no' => $row['spv_pan_no'],
                            // ]);

                            Principle::where('id', $row['spv_contractor_id'])->update([
                                'company_name' => $row['spv_contractor_name'],
                                'pan_no' => $row['spv_pan_no'],
                            ]);

                            ContractorItem::where('contractor_id', $row['spv_contractor_id'])->update([
                                'pan_no' => $row['spv_pan_no'],
                                'share_holding' => $row['spv_share_holding'],
                            ]);

                            // $principles->contractorItem()->where('id', $spv_item_id)->update([
                            //     'pan_no' => $row['spv_pan_no'],
                            //     'share_holding' => $row['spv_share_holding'],
                            // ]);
                        }
                    }
                }

                if(isset($request->remove_dms)){
                    $deleteFiles = DMS::whereIn('id', $request->remove_dms);
                    foreach ($deleteFiles->pluck('attachment') as $deleteAttachment) {
                        File::delete($deleteAttachment);
                    };
                    $deleteFiles->delete();
                }

                 // Additional Bonds
                // $additionalBondItems = $request->additional_bond_items;
                // if (!empty($additionalBondItems) && count($additionalBondItems) > 0) {
                //     $bondCurrentIds = array_column($additionalBondItems, 'ab_id');
                //     if(!empty($bondCurrentIds)){
                //         ProposalAdditionalBonds::where('proposal_id', $proposal_id)->whereNotIn('id', $bondCurrentIds)->delete();
                //     }
                //     foreach ($additionalBondItems as $row) {
                //         $ab_id = $row['ab_id'] ?? 0;
                //         $additionalBondItemsArr = [
                //             'proposal_id' => $proposal_id,
                //             'additional_bond_id' => $row['additional_bond_id'] ?? null,
                //             'additional_bond_issued_date' => $row['additional_bond_issued_date'] ?? null,
                //             'additional_bond_start_date' => $row['additional_bond_start_date'] ?? null,
                //             'additional_bond_end_date' => $row['additional_bond_end_date'] ?? null,
                //             'additional_bond_period' => $row['additional_bond_period'] ?? null,
                //             'additional_bond_period_year' => $row['additional_bond_period_year'] ?? null,
                //             'additional_bond_period_month' => $row['additional_bond_period_month'] ?? null,
                //             'additional_bond_period_days' => $row['additional_bond_period_days'] ?? null,
                //             'bond_value' => $row['additional_bond_value'] ?? null,
                //         ];
                //         if ($ab_id > 0) {
                //             ProposalAdditionalBonds::where('id', $ab_id)->update($additionalBondItemsArr);
                //         } else {
                //             ProposalAdditionalBonds::create($additionalBondItemsArr);
                //         }
                //     }
                // }

                // Beneficiary Trade Sector Details

                $beneficiaryTradeSector_id = collect($request->beneficiaryTradeSector)->pluck('beneficiary_trade_item_id')->toArray();

                $existing_proposalTradeSector = $proposals->proposalBeneficiaryTradeSector()->pluck('id')->toArray();
                $diff_proposalTradeSector = array_diff($existing_proposalTradeSector, $beneficiaryTradeSector_id);
                $proposals->proposalBeneficiaryTradeSector()->whereIn('id', $diff_proposalTradeSector)->get()->each(function ($isSpvItem) {
                    $isSpvItem->delete();
                });

                // $proposals->beneficiary->proposalBeneficiaryTradeSector()->whereNotIn('id', $beneficiaryTradeSector_id)->delete();

                $beneficiaryTradeSector = $request->beneficiaryTradeSector;
                // dd($beneficiaryTradeSector);
                if (!empty($beneficiaryTradeSector) && count($beneficiaryTradeSector) > 0 && $proposals->beneficiary) {
                    foreach ($beneficiaryTradeSector as $row) {
                        // $beneficiaryTradeSectorArr = [
                        //     // 'beneficiary_id' => $beneficiary_id,
                        //     'trade_sector_id' => $row['beneficiary_trade_sector_id'] ?? NULL,
                        //     'from'=> $row['beneficiary_from'] ?? NULL,
                        //     'till'=> $row['beneficiary_till'] ?? NULL,
                        //     'is_main'=> $row['beneficiary_is_main'] ?? 'No',
                        // ];
                        // $proposals->proposalBeneficiaryTradeSector()->update($beneficiaryTradeSectorArr);

                        $beneficiaryTradeSectorArr = [
                            'trade_sector_id' => $row['beneficiary_trade_sector_id'] ?? NULL,
                            'from'=> $row['beneficiary_from'] ?? NULL,
                            'till'=> $row['beneficiary_till'] ?? NULL,
                            'is_main'=> $row['beneficiary_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pbt_item_id'] ?? null,
                        ];

                        // if($row['beneficiary_trade_item_id'] == $row['pbt_item_id']){
                        //     $proposalTradeSectorArr = $proposals->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr);
                        // } else {
                        //     $proposalTradeSectorArr = tap(
                        //         $proposals->proposalBeneficiaryTradeSector()
                        //         ->where('proposalbeneficiarytradesectorsable_type', 'Proposal')
                        //         ->where(function($q) use($row) {
                        //             $q->where('id', $row['beneficiary_trade_item_id']);
                        //         })
                        //         ->first()
                        //     )->update($beneficiaryTradeSectorArr);
                        // }

                        $proposalTradeSectorArr = $proposals->proposalBeneficiaryTradeSector()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['beneficiary_trade_item_id'],
                        ], $beneficiaryTradeSectorArr);

                        // $proposalTradeSectorArr = $proposals->proposalBeneficiaryTradeSector()->updateOrCreate([
                        //     'id'=>$row['beneficiary_trade_item_id'] ?? null
                        // ], $beneficiaryTradeSectorArr);
                        // dd($proposalTradeSectorArr, $beneficiary->proposalBeneficiaryTradeSector);

                        if(isset($row['beneficiary_trade_item_id'])) {
                            $beneficiaryTradeSectorRepeater = tap(
                                $beneficiary->proposalBeneficiaryTradeSector()
                                    ->where('proposalbeneficiarytradesectorsable_type', 'Beneficiary')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['pbt_item_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['pbt_item_id']);
                                        });
                                    })
                                    ->first()
                            )->update($beneficiaryTradeSectorArr);
                        } else {
                            $beneficiaryTradeSectorRepeater = $beneficiary->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr);
                        }

                        if (!isset($row['pbt_item_id'])){
                            $proposalTradeSectorArr->update(['contractor_fetch_reference_id' => $proposalTradeSectorArr->id]);
                            $beneficiaryTradeSectorRepeater->update(['contractor_fetch_reference_id' => $proposalTradeSectorArr->id]);
                        }

                        // if(isset($row['beneficiary_trade_item_id'])){
                        //     $proposals->beneficiary->proposalBeneficiaryTradeSector()->update($tradeSectorArr);
                        // } else {
                        //     $proposals->beneficiary->proposalBeneficiaryTradeSector()->create($tradeSectorArr);
                        // }

                        // if(!isset($row['beneficiary_trade_item_id'])){
                        //     $proposals->beneficiary->proposalBeneficiaryTradeSector()->create($tradeSectorArr);
                        // }

                        // $proposals->beneficiary->proposalBeneficiaryTradeSector()->updateOrCreate([
                        //     'id'=>$row['beneficiary_trade_item_id'] ?? null
                        // ], $tradeSectorArr);
                    }
                }

                // Contractor Details

                // if($request['is_jv'] == 'Yes'){

                //     $contractorDetails_id = collect($request->contractorDetails)->pluck('contractor_item_id')->toArray();
                //     $existing_contractorDetails = $proposals->contractorItem()->pluck('id')->toArray();
                //     $diff_contractorDetails = array_diff($existing_contractorDetails, $contractorDetails_id);

                //     $proposals->contractorItem()->whereIn('id', $diff_contractorDetails)->get()->each(function ($isSpvItem) {
                //         $isSpvItem->delete();
                //     });

                //     $contractorDetails = $request->contractorDetails;
                //     if (!empty($contractorDetails) && count($contractorDetails) > 0) {
                //         foreach ($contractorDetails as $row) {
                //             // $contractorDetailArr = [
                //             //     // 'principle_id' => $principle_id,
                //             //     'contractor_id' => $row['contractor_id'] ?? NULL,
                //             //     'pan_no'=> $row['contractor_pan_no'] ?? NULL,
                //             //     'share_holding'=> $row['share_holding'] ?? NULL,
                //             // ];
                //             // $proposals->contractorItem()->update($contractorDetailArr);

                //             $contractorDetailArr = $proposals->contractorItem()->updateOrCreate([
                //                 'id'=>$row['contractor_item_id'] ?? null
                //             ],[
                //                 'contractor_id' => $row['contractor_id'] ?? NULL,
                //                 'pan_no'=> $row['contractor_pan_no'] ?? NULL,
                //                 'share_holding'=> $row['share_holding'] ?? NULL,
                //             ]);
                //         }
                //     }
                // }

                // Contractor Trade Sector

                $contractorTradeSector_id = collect($request->tradeSector)->pluck('contractor_trade_item_id')->toArray();
                $existing_contractorTradeSector = $proposals->tradeSector()->pluck('id')->toArray();
                $diff_contractorTradeSector = array_diff($existing_contractorTradeSector, $contractorTradeSector_id);

                $proposals->tradeSector()->whereIn('id', $diff_contractorTradeSector)->get()->each(function ($ctsItem) {
                    $ctsItem->delete();
                });

                // $proposals->contractor->tradeSector()->whereNotIn('id', $contractorTradeSector_id)->delete();

                $tradeSector = $request->tradeSector;
                if (!empty($tradeSector) && count($tradeSector) > 0 && $proposals->contractor) {
                    foreach ($tradeSector as $row) {
                        // $tradeSectorArr = [
                        //     // 'principle_id' => $principle_id,
                        //     'trade_sector_id' => $row['contractor_trade_sector'] ?? NULL,
                        //     'from'=> $row['contractor_from'] ?? NULL,
                        //     'till'=> $row['contractor_till'] ?? NULL,
                        //     'is_main'=> $row['contractor_is_main'] ?? 'No',
                        // ];
                        // $proposals->tradeSector()->update($tradeSectorArr);

                        $contractorTradeSectorArr = [
                            'trade_sector_id' => $row['contractor_trade_sector'] ?? NULL,
                            'from'=> $row['contractor_from'] ?? NULL,
                            'till'=> $row['contractor_till'] ?? NULL,
                            'is_main'=> $row['contractor_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pct_item_id'] ?? null,
                        ];

                        // $tradeSectorArr = $proposals->tradeSector()->updateOrCreate([
                        //     'id'=>$row['contractor_trade_item_id'] ?? null
                        // ], $contractorTradeSectorArr);

                        $tradeSectorArr = $proposals->tradeSector()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['contractor_trade_item_id'],
                        ], $contractorTradeSectorArr);

                        // if($row['contractor_trade_item_id'] == $row['pct_item_id']){
                        //     $tradeSectorArr = $proposals->tradeSector()->create($contractorTradeSectorArr);
                        // } else {
                        //     $tradeSectorArr = tap(
                        //         $proposals->tradeSector()
                        //         ->where('tradesectoritemsable_type', 'Proposal')
                        //         ->where(function($q) use($row) {
                        //             $q->where('id', $row['contractor_trade_item_id']);
                        //         })
                        //         ->first()
                        //     )->update($contractorTradeSectorArr);
                        // }

                        if(isset($row['contractor_trade_item_id'])) {
                            $contractorTradeSectorRepeater = tap(
                                $principles->tradeSector()
                                    ->where('tradesectoritemsable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['pct_item_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['pct_item_id']);
                                        });
                                    })
                                    ->first()
                            )->update($contractorTradeSectorArr);
                        } else {
                            $contractorTradeSectorRepeater = $principles->tradeSector()->create($contractorTradeSectorArr);
                        }

                        if (!isset($row['pct_item_id'])){
                            $tradeSectorArr->update(['contractor_fetch_reference_id' => $tradeSectorArr->id]);
                            $contractorTradeSectorRepeater->update(['contractor_fetch_reference_id' => $tradeSectorArr->id]);
                        }

                        // if(isset($row['contractor_trade_item_id'])){
                        //     $proposals->contractor->tradeSector()->update($contractorTradeSectorArr);
                        // }

                        // if(!isset($row['contractor_trade_item_id'])){
                        //     $proposals->contractor->tradeSector()->create($contractorTradeSectorArr);
                        // }

                        // $proposals->contractor->tradeSector()->updateOrCreate([
                        //     'id'=>$row['contractor_trade_item_id'] ?? null
                        // ], $contractorTradeSectorArr);
                    }
                }

                // Contractor Conatact Details

                $contactDetails_id = collect($request->contactDetail)->pluck('contact_item_id')->toArray();
                $existing_contactDetails = $proposals->contactDetail()->pluck('id')->toArray();
                $diff_contactDetails = array_diff($existing_contactDetails, $contactDetails_id);

                $proposals->contactDetail()->whereIn('id', $diff_contactDetails)->get()->each(function ($cdItem) {
                    $cdItem->delete();
                });

                // $proposals->contractor->contactDetail()->whereNotIn('id', $contactDetails_id)->delete();

                $contactDetail = $request->contactDetail;
                if (!empty($contactDetail) && count($contactDetail) > 0 && $proposals->contractor) {
                    foreach ($contactDetail as $row) {
                        // $contactDetailArr = [
                        //     'contact_person' => $row['contact_person'] ?? NULL,
                        //     'email'=> $row['email'] ?? NULL,
                        //     'phone_no'=> $row['phone_no'] ?? NULL,
                        // ];
                        // $contactDetailIsNull = empty(array_filter($contactDetailArr, function($value) {
                        //     return !is_null($value);
                        // }));
                        // $proposals->contactDetail()->update($contactDetailArr);
                        // // $contactDetailArr['principle_id'] = $principle_id;
                        // if(!$contactDetailIsNull){
                        //     $proposals->contactDetail()->create($contactDetailArr);
                        // }

                        $contractorContactDetailArr = [
                            'contact_person' => $row['contact_person'] ?? NULL,
                            'email'=> $row['email'] ?? NULL,
                            'phone_no'=> $row['phone_no'] ?? NULL,
                            'contractor_fetch_reference_id' => $row['proposal_contact_item_id'] ?? null,
                        ];

                        // $contactDetailArr = $proposals->contactDetail()->updateOrCreate([
                        //     'id'=>$row['contact_item_id'] ?? null
                        // ], $contractorContactDetailArr);

                        $contactDetailArr = $proposals->contactDetail()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['contact_item_id'],
                        ], $contractorContactDetailArr);

                        // if($row['contact_item_id'] == $row['proposal_contact_item_id']){
                        //     $contactDetailArr = $proposals->contactDetail()->create($contractorContactDetailArr);
                        // } else {
                        //     $contactDetailArr = tap(
                        //         $proposals->contactDetail()
                        //         ->where('contactdetailsable_type', 'Proposal')
                        //         ->where(function($q) use($row) {
                        //             $q->where('id', $row['contact_item_id']);
                        //         })
                        //         ->first()
                        //     )->update($contractorContactDetailArr);
                        // }

                        if(isset($row['contact_item_id'])) {
                            $contractorContactDetailRepeater = tap(
                                $principles->contactDetail()
                                    ->where('contactdetailsable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['proposal_contact_item_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['proposal_contact_item_id']);
                                        });
                                    })
                                    ->first()
                            )->update($contractorContactDetailArr);
                        } else {
                            $contractorContactDetailRepeater = $principles->contactDetail()->create($contractorContactDetailArr);
                        }

                        if (!isset($row['proposal_contact_item_id'])){
                            $contactDetailArr->update(['contractor_fetch_reference_id' => $contactDetailArr->id]);
                            $contractorContactDetailRepeater->update(['contractor_fetch_reference_id' => $contactDetailArr->id]);
                        }

                        // if(isset($row['contact_item_id'])){
                        //     $proposals->contractor->contactDetail()->updateOrCreate($contractorContactDetailArr);
                        // }

                        // if(!isset($row['contact_item_id'])){
                        //     $proposals->contractor->contactDetail()->create($contractorContactDetailArr);
                        // }
                    }
                }

                // Rating

                $ratingDetail_id = collect($request->ratingDetail)->pluck('rating_item_id')->toArray();
                $existing_ratingDetail = $proposals->agencyRatingDetails()->pluck('id')->toArray();
                $diff_ratingDetail = array_diff($existing_ratingDetail, $ratingDetail_id);

                $proposals->agencyRatingDetails()->whereIn('id', $diff_ratingDetail)->get()->each(function ($ardItem) {
                    $ardItem->delete();
                });

                $ratingDetail = $request->ratingDetail;
                if(isset($ratingDetail) && count($ratingDetail) > 0){
                    foreach ($ratingDetail as $row) {
                        // dd($row);
                        $contractorRatingDetailArr = [
                            'agency_id' => $row['item_agency_id'] ?? null,
                            'rating_id' => $row['item_rating_id'] ?? null,
                            'rating' => $row['rating'] ?? null,
                            'remarks' => $row['rating_remarks'] ?? null,
                            'rating_date' => $row['rating_date'] ?? null,
                        ];

                        $ratingDetailRepeater = $proposals->agencyRatingDetails()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['rating_item_id'],
                        ], $contractorRatingDetailArr);

                        // if(isset($row['rating_item_id'])) {
                        //     $contractorRatingDetailRepeater = tap(
                        //         $principles->agencyRatingDetails()
                        //             ->where('agencyratingdetailsable_type', 'Principle')
                        //             ->where(function($q) use($row) {
                        //                 $q->where('id', $row['rating_item_id']);
                        //             })
                        //             ->first()
                        //     )->update($contractorRatingDetailArr);
                        // } else {
                        //     $contractorRatingDetailRepeater = $principles->agencyRatingDetails()->create($contractorRatingDetailArr);
                        // }

                        if(isset($row['rating_item_id'])){
                            $proposals->contractor->agencyRatingDetails()->updateOrCreate($contractorRatingDetailArr);
                        }

                        if(!isset($row['rating_item_id'])){
                            $proposals->contractor->agencyRatingDetails()->create($contractorRatingDetailArr);
                        }
                    }
               }

                // Proposal Banking Limits Repeater

                $proposalBankingLimits_id = collect($request->pbl_items)->pluck('pbl_id')->toArray();
                // dd($request->pbl_items, $proposalBankingLimits_id, $proposals->contractor->bankingLimits()->whereNotIn('id', $proposalBankingLimits_id)->get(), $proposals->contractor->bankingLimits);
                $existing_proposalBankingLimits = $proposals->bankingLimits()->pluck('id')->toArray();
                $diff_proposalBankingLimits = array_diff($existing_proposalBankingLimits, $proposalBankingLimits_id);
                // dd($proposals->contractor->bankingLimits()->get(), $proposals->bankingLimits()->whereIn('id', $diff_proposalBankingLimits)->get());

                $proposals->bankingLimits()->whereIn('id', $diff_proposalBankingLimits)->get()->each(function ($pblItem) {
                    // dd('555');
                    foreach ($pblItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                        File::delete($deleteItem);
                    };
                    $pblItem->dMS()->delete();
                    $pblItem->delete();
                });

                // dd('ooo');

                // $proposals->contractor->bankingLimits()->whereNotIn('id', $proposalBankingLimits_id)->get()->each(function ($cpblItem) {
                //     foreach ($cpblItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                //         File::delete($deleteItem);
                //     };
                //     $cpblItem->dMS()->delete();
                //     $cpblItem->delete();
                // });
                // $proposals->contractor->bankingLimits()->whereNotIn('id', $proposalBankingLimits_id)->delete();

                $proposalBankingLimits = $request->pbl_items;

                if($proposals->contractor){
                    foreach ($proposalBankingLimits as $row) {
                        // dd($row['pbl_id']);
                        $repeaterDetails = [
                            'banking_category_id' => $row['banking_category_id'] ?? null,
                            'facility_type_id' => $row['facility_type_id'] ?? null,
                            'sanctioned_amount' => $row['sanctioned_amount'] ?? null,
                            'bank_name' => $row['bank_name'],
                            'latest_limit_utilized' => $row['latest_limit_utilized'] ?? null,
                            'unutilized_limit' => $row['unutilized_limit'] ?? null,
                            'commission_on_pg' => $row['commission_on_pg'] ?? null,
                            'commission_on_fg' => $row['commission_on_fg'] ?? null,
                            'margin_collateral' => $row['margin_collateral'] ?? null,
                            'other_banking_details' => $row['other_banking_details'] ?? null,
                            'contractor_fetch_reference_id' => $row['cfr_id'] ?? null,
                        ];

                        $proposalBankingLimitsRepeater = $proposals->bankingLimits()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['pbl_id'],
                        ], $repeaterDetails);

                        if(isset($row['pbl_id'])) {
                            $contractorBankingLimitsRepeater = tap(
                                $principles->bankingLimits()
                                    ->where('bankinglimitsable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['cfr_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['cfr_id']);
                                        });
                                    })
                                    ->first()
                            )->update($repeaterDetails);
                        } else {
                            $contractorBankingLimitsRepeater = $principles->bankingLimits()->create($repeaterDetails);
                        }

                        // $contractorBankingLimitsRepeater = $principles->bankingLimits()->updateOrCreate([
                        //         'id' => $row['cfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['cfr_id'],
                        //     ], $repeaterDetails);

                        // if(isset($row['autoFetch']) || !isset($row['pbl_id'])){
                        //     $contractorBankingLimitsRepeater = $principles->bankingLimits()->create($repeaterDetails);
                        // }

                        // if(isset($row['pbl_id'])){
                        //     $contractorBankingLimitsRepeater = $principles->bankingLimits()->updateOrCreate([
                        //         'id' => $row['cfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['cfr_id'],
                        //     ], $repeaterDetails);

                        //     // $contractorBankingLimitsRepeater = $proposals->contractor->bankingLimits()->update($repeaterDetails);
                        //     // $contractorBankingLimitsRepeater = $contractorBankingLimitsRepeater->get();

                        //     // $bankingLimit = $proposals->contractor->bankingLimits()->first();

                        //     // $bankingLimitsQuery = $proposals->contractor->bankingLimits();
                        //     // $bankingLimitsQuery->update($repeaterDetails);
                        //     // $contractorBankingLimitsRepeater = $bankingLimitsQuery->get();

                        //     // $proposalBankingLimitsRepeater = tap(
                        //     //     $proposal->bankingLimits()
                        //     //         ->where('contractor_fetch_reference_id', $row['pbl_id'])
                        //     //         ->orWhere('id', $row['pbl_id'])
                        //     //         ->first()
                        //     // )->update($proposalBankingLimitsArr);
                        //     // dd($proposals->contractor->bankingLimits()
                        //     //         // ->where('id', $row['pbl_id'])
                        //     //         ->get());
                        //     // $contractorBankingLimitsRepeater = tap(
                        //     //     $proposals->contractor->bankingLimits()
                        //     //         ->where('id', $row['cfr_id'])
                        //     //         ->first()
                        //     // )->update($repeaterDetails);

                        //     // dd($contractorBankingLimitsRepeater);
                        // }

                        if (isset($row['autoFetch']) && $row['autoFetch']) {
                            $bankinglimit_principle_attachment = DMS::where(['dmsable_id'=>$row['pbl_id'],'dmsable_type'=>'BankingLimits'])->get();
                            foreach ($bankinglimit_principle_attachment as $attachment) {
                                if(File::exists($attachment->attachment)) {
                                    $newFilepath = "uploads/proposal/{$proposals->code}/V{$proposals->version}/$proposal_id/{$attachment->file_name}";
                                    File::copy($attachment->attachment, $newFilepath);
                                    $proposalBankingLimitsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);

                                    $contractorBankingLimitsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);
                                }
                            }
                        }

                        $dms_proposalBankingLimits = BankingLimit::with('dMS')->findOrFail($proposalBankingLimitsRepeater->id);

                        // dd(isset($row['pbl_id']));
                        $dms_contractorBankingLimits = BankingLimit::with('dMS')->findOrFail($contractorBankingLimitsRepeater->id);

                        // if(isset($request->remove_dms)) {
                        //     $dms_proposalBankingLimits->dMS()->whereIn('id', $request->remove_dms)->delete();
                        // }

                        if (!isset($row['cfr_id'])){
                            $proposalBankingLimitsRepeater->update(['contractor_fetch_reference_id' => $proposalBankingLimitsRepeater->id]);
                            $contractorBankingLimitsRepeater->update(['contractor_fetch_reference_id' => $proposalBankingLimitsRepeater->id]);
                        }

                        if (!empty($row['banking_limits_attachment'])) {
                            // $this->common->updateMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_proposalBankingLimits, $proposal_id, 'proposal');

                            // $this->common->storeMultipleFiles($request, $row['banking_limits_attachment'], 'banking_limits_attachment', $dms_contractorBankingLimits, $proposals->contractor->id, 'principle');

                            foreach ($row['banking_limits_attachment'] as $item) {
                                $fileName = $item->getClientOriginalName();

                                $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                                if(!File::exists($contractorFilePath)) {
                                    File::makeDirectory($contractorFilePath, $mode = 0777, true, true);
                                }
                                copy($filePath1, $contractorFilePath . '/' . $fileName);

                                $filePath2 = $contractorFilePath . '/' . $fileName;

                                $dms_proposalBankingLimits->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath1,
                                    'attachment_type' => 'banking_limits_attachment',
                                ]);

                                $dms_contractorBankingLimits->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath2,
                                    'attachment_type' => 'banking_limits_attachment',
                                ]);
                            }
                        }
                    }
                }

                // Order Book and Future Projects Repeater

                $orderBookAndFutureProjects_id = collect($request->obfp_items)->pluck('obfp_id')->toArray();
                $existing_orderBookAndFutureProjects = $proposals->orderBookAndFutureProjects()->pluck('id')->toArray();
                $diff_orderBookAndFutureProjects = array_diff($existing_orderBookAndFutureProjects, $orderBookAndFutureProjects_id);

                $proposals->orderBookAndFutureProjects()->whereIn('id', $diff_orderBookAndFutureProjects)->get()->each(function ($obfpItem) {
                    foreach ($obfpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                        File::delete($deleteItem);
                    };
                    $obfpItem->dMS()->delete();
                    $obfpItem->delete();
                });

                // $proposals->contractor->orderBookAndFutureProjects()->whereNotIn('id', $orderBookAndFutureProjects_id)->get()->each(function ($cobfpItem) {
                //     foreach ($cobfpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                //         File::delete($deleteItem);
                //     };
                //     $cobfpItem->dMS()->delete();
                //     $cobfpItem->delete();
                // });
                // $proposals->contractor->orderBookAndFutureProjects()->whereNotIn('id', $orderBookAndFutureProjects_id)->delete();

                $orderBookAndFutureProjects = $request->obfp_items;

                if($proposals->contractor){
                    foreach ($orderBookAndFutureProjects as $row) {

                        $obfpRepeaterDetails = [
                            'project_name' => $row['project_name'] ?? null,
                            'project_cost' => $row['project_cost'] ?? null,
                            'project_description' => $row['project_description'] ?? null,
                            'project_start_date' => $row['project_start_date'] ?? null,
                            'project_end_date' => $row['project_end_date'] ?? null,
                            'project_tenor' => $row['project_tenor'] ?? null,
                            'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                            'project_share' => $row['project_share'] ?? null,
                            'guarantee_amount' => $row['guarantee_amount'] ?? null,
                            'current_status' => $row['current_status'] ?? null,
                            'contractor_fetch_reference_id' => $row['ocfr_id'] ?? null,
                        ];

                        $orderBookAndFutureProjectsRepeater = $proposals->orderBookAndFutureProjects()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['obfp_id']
                        ], $obfpRepeaterDetails);

                        if(isset($row['obfp_id'])) {
                            $contractorOrderBookAndFutureProjectsRepeater = tap(
                                $principles->orderBookAndFutureProjects()
                                    ->where('orderbookandfutureprojectsable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['ocfr_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['ocfr_id']);
                                        });
                                    })
                                    ->first()
                            )->update($obfpRepeaterDetails);
                        } else {
                            $contractorOrderBookAndFutureProjectsRepeater = $principles->orderBookAndFutureProjects()->create($obfpRepeaterDetails);
                        }
                        
                        // $contractorOrderBookAndFutureProjectsRepeater = $principles->orderBookAndFutureProjects()->updateOrCreate([
                        //         'id' => $row['ocfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['ocfr_id']
                        //     ], $obfpRepeaterDetails);

                        // if(isset($row['autoFetch']) || !isset($row['obfp_id'])){
                        //     $contractorOrderBookAndFutureProjectsRepeater = $principles->orderBookAndFutureProjects()->create($obfpRepeaterDetails);
                        // }

                        // if(isset($row['obfp_id'])){
                        //     $contractorOrderBookAndFutureProjectsRepeater = $principles->orderBookAndFutureProjects()->updateOrCreate([
                        //         'id' => $row['ocfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['ocfr_id']
                        //     ], $obfpRepeaterDetails);
                        // }

                        if (isset($row['autoFetch']) && $row['autoFetch']) {
                            $order_book_and_future_projects_principle_attachment = DMS::where(['dmsable_id'=>$row['obfp_id'],'dmsable_type'=>'OrderBookAndFutureProjects'])->get();

                            foreach ($order_book_and_future_projects_principle_attachment as $attachment) {
                                if(File::exists($attachment->attachment)) {
                                    $newFilepath = "uploads/proposal/{$proposals->code}/V{$proposals->version}/$proposal_id/{$attachment->file_name}";
                                    File::copy($attachment->attachment, $newFilepath);
                                    $orderBookAndFutureProjectsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);

                                    $contractorOrderBookAndFutureProjectsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);
                                }
                            }
                        }

                        $dms_orderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($orderBookAndFutureProjectsRepeater->id);

                        $dms_contractorOrderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($contractorOrderBookAndFutureProjectsRepeater->id);

                        if (!isset($row['ocfr_id'])){
                            $orderBookAndFutureProjectsRepeater->update(['contractor_fetch_reference_id' => $orderBookAndFutureProjectsRepeater->id]);
                            $contractorOrderBookAndFutureProjectsRepeater->update(['contractor_fetch_reference_id' => $orderBookAndFutureProjectsRepeater->id]);
                        }

                        if (!empty($row['order_book_and_future_projects_attachment'])) {
                            // $this->common->updateMultipleFiles($request, $row['order_book_and_future_projects_attachment'], 'order_book_and_future_projects_attachment', $dms_orderBookAndFutureProjects, $proposal_id, 'proposal');

                            // $this->common->storeMultipleFiles($request, $row['order_book_and_future_projects_attachment'], 'order_book_and_future_projects_attachment', $dms_contractorOrderBookAndFutureProjects, $proposals->contractor->id, 'principle');

                            foreach ($row['order_book_and_future_projects_attachment'] as $item) {
                                $fileName = $item->getClientOriginalName();

                                $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                                if(!File::exists($contractorFilePath)) {
                                    File::makeDirectory($contractorFilePath, $mode = 0777, true, true);
                                }
                                copy($filePath1, $contractorFilePath . '/' . $fileName);

                                $filePath2 = $contractorFilePath . '/' . $fileName;

                                $dms_orderBookAndFutureProjects->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath1,
                                    'attachment_type' => 'order_book_and_future_projects_attachment',
                                ]);

                                $dms_contractorOrderBookAndFutureProjects->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath2,
                                    'attachment_type' => 'order_book_and_future_projects_attachment',
                                ]);
                            }
                        }
                    }
                }

                // Project Track Records Repeater

                $projectTrackRecords_id = collect($request->ptr_items)->pluck('ptr_id')->toArray();
                $existing_projectTrackRecords = $proposals->projectTrackRecords()->pluck('id')->toArray();
                $diff_projectTrackRecords = array_diff($existing_projectTrackRecords, $projectTrackRecords_id);

                $proposals->projectTrackRecords()->whereIn('id', $diff_projectTrackRecords)->get()->each(function ($ptrItem) {
                    foreach ($ptrItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                        File::delete($deleteItem);
                    };
                    $ptrItem->dMS()->delete();
                    $ptrItem->delete();
                });

                // $proposals->contractor->projectTrackRecords()->whereNotIn('id', $projectTrackRecords_id)->get()->each(function ($cptrItem) {
                //     foreach ($cptrItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                //         File::delete($deleteItem);
                //     };
                //     $cptrItem->dMS()->delete();
                //     $cptrItem->delete();
                // });
                // $proposals->contractor->projectTrackRecords()->whereNotIn('id', $projectTrackRecords_id)->delete();

                $projectTrackRecords = $request->ptr_items;

                if($proposals->contractor){
                    foreach ($projectTrackRecords as $row) {

                        $ptrRepeaterDetails = [
                            'project_name' => $row['project_name'] ?? null,
                            'project_cost' => $row['project_cost'] ?? null,
                            'project_description' => $row['project_description'] ?? null,
                            'project_start_date' => $row['project_start_date'] ?? null,
                            'project_end_date' => $row['project_end_date'] ?? null,
                            'project_tenor' => $row['project_tenor'] ?? null,
                            'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                            'actual_date_completion' => $row['actual_date_completion'] ?? null,
                            'bg_amount' => $row['bg_amount'] ?? null,
                            'contractor_fetch_reference_id' => $row['pcfr_id'] ?? null,
                        ];

                        $projectTrackRecordsRepeater = $proposals->projectTrackRecords()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['ptr_id']
                        ],$ptrRepeaterDetails);

                        if(isset($row['ptr_id'])) {
                            $contractorProjectTrackRecordsRepeater = tap(
                                $principles->projectTrackRecords()
                                    ->where('projecttrackrecordsable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['pcfr_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['pcfr_id']);
                                        });
                                    })
                                    ->first()
                            )->update($ptrRepeaterDetails);
                        } else {
                            $contractorProjectTrackRecordsRepeater = $principles->projectTrackRecords()->create($ptrRepeaterDetails);
                        }

                        // $contractorProjectTrackRecordsRepeater = $principles->projectTrackRecords()->updateOrCreate([
                        //     'id' => $row['pcfr_id'] ?? null,
                        //     // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['pcfr_id']
                        // ], $ptrRepeaterDetails);

                        // if(isset($row['autoFetch']) || !isset($row['ptr_id'])){
                        //     $contractorProjectTrackRecordsRepeater = $principles->projectTrackRecords()->create($ptrRepeaterDetails);
                        // }

                        // if(isset($row['ptr_id'])){
                        //     $contractorProjectTrackRecordsRepeater = $principles->projectTrackRecords()->updateOrCreate([
                        //         'id' => $row['pcfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['pcfr_id']
                        //     ], $ptrRepeaterDetails);

                        //     // $contractorProjectTrackRecordsRepeater = $proposals->contractor->projectTrackRecords()->update($ptrRepeaterDetails);
                        // }

                        if (isset($row['autoFetch']) && $row['autoFetch']) {
                            $project_track_records_principle_attachment = DMS::where(['dmsable_id'=>$row['ptr_id'],'dmsable_type'=>'ProjectTrackRecords'])->get();

                            foreach ($project_track_records_principle_attachment as $attachment) {
                                if(File::exists($attachment->attachment)) {
                                    $newFilepath = "uploads/proposal/{$proposals->code}/V{$proposals->version}/$proposal_id/{$attachment->file_name}";
                                    File::copy($attachment->attachment, $newFilepath);
                                    $projectTrackRecordsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);

                                    $contractorProjectTrackRecordsRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);
                                }
                            }
                        }

                        $dms_projectTrackRecords = ProjectTrackRecords::findOrFail($projectTrackRecordsRepeater->id);

                        $dms_contractorProjectTrackRecords = ProjectTrackRecords::findOrFail($contractorProjectTrackRecordsRepeater->id);

                        if (!isset($row['pcfr_id'])){
                            $projectTrackRecordsRepeater->update(['contractor_fetch_reference_id' => $projectTrackRecordsRepeater->id]);
                            $contractorProjectTrackRecordsRepeater->update(['contractor_fetch_reference_id' => $projectTrackRecordsRepeater->id]);
                        }

                        if (!empty($row['project_track_records_attachment'])) {
                            // $this->common->updateMultipleFiles($request, $row['project_track_records_attachment'], 'project_track_records_attachment', $dms_projectTrackRecords, $proposal_id, 'proposal');

                            // $this->common->storeMultipleFiles($request, $row['project_track_records_attachment'], 'project_track_records_attachment', $dms_contractorProjectTrackRecords, $proposals->contractor->id, 'principle');

                            foreach ($row['project_track_records_attachment'] as $item) {
                                $fileName = $item->getClientOriginalName();

                                $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                                if(!File::exists($contractorFilePath)) {
                                    File::makeDirectory($contractorFilePath, $mode = 0777, true, true);
                                }
                                copy($filePath1, $contractorFilePath . '/' . $fileName);

                                $filePath2 = $contractorFilePath . '/' . $fileName;

                                $dms_projectTrackRecords->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath1,
                                    'attachment_type' => 'project_track_records_attachment',
                                ]);

                                $dms_contractorProjectTrackRecords->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath2,
                                    'attachment_type' => 'project_track_records_attachment',
                                ]);
                            }
                        }
                    }
                }

                // Management Profiles Repeater

                $managementProfiles_id = collect($request->mp_items)->pluck('mp_id')->toArray();
                $existing_managementProfiles = $proposals->managementProfiles()->pluck('id')->toArray();
                $diff_managementProfiles = array_diff($existing_managementProfiles, $managementProfiles_id);

                $proposals->managementProfiles()->whereIn('id', $diff_managementProfiles)->get()->each(function ($mpItem) {
                    foreach ($mpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                        File::delete($deleteItem);
                    };
                    $mpItem->dMS()->delete();
                    $mpItem->delete();
                });

                // $proposals->contractor->managementProfiles()->whereNotIn('id', $managementProfiles_id)->get()->each(function ($cmpItem) {
                //     foreach ($cmpItem->dMS->flatten()->pluck('attachment') as $deleteItem) {
                //         File::delete($deleteItem);
                //     };
                //     $cmpItem->dMS()->delete();
                //     $cmpItem->delete();
                // });
                // $proposals->contractor->managementProfiles()->whereNotIn('id', $managementProfiles_id)->delete();

                $managementProfiles = $request->mp_items;

                if($proposals->contractor){
                    foreach ($managementProfiles as $row) {

                        $mpRepeaterDetails = [
                            'designation' => $row['designation'] ?? null,
                            'name' => $row['name'],
                            'qualifications' => $row['qualifications'],
                            'experience' => $row['experience'],
                            'contractor_fetch_reference_id' => $row['mcfr_id'] ?? null,
                        ];

                        $managementProfilesRepeater = $proposals->managementProfiles()->updateOrCreate([
                            'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['mp_id']
                        ], $mpRepeaterDetails);

                        if(isset($row['mp_id'])) {
                            $contractorManagementProfilesRepeater = tap(
                                $principles->managementProfiles()
                                    ->where('managementprofilesable_type', 'Principle')
                                    ->where(function($q) use($row) {
                                        $q->where('contractor_fetch_reference_id', $row['mcfr_id'])
                                        ->orWhere(function($p) use($row) {
                                            $p->where('id', $row['mcfr_id']);
                                        });
                                    })
                                    ->first()
                            )->update($mpRepeaterDetails);
                        } else {
                            $contractorManagementProfilesRepeater = $principles->managementProfiles()->create($mpRepeaterDetails);
                        }

                        // $contractorManagementProfilesRepeater = $principles->managementProfiles()->updateOrCreate([
                        //     'id' => $row['mcfr_id'] ?? null,
                        //     // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['mcfr_id']
                        // ], $mpRepeaterDetails);

                        // if(isset($row['autoFetch']) || !isset($row['mp_id'])){
                        //     $contractorManagementProfilesRepeater = $principles->managementProfiles()->create($mpRepeaterDetails);
                        // }

                        // if(isset($row['mp_id'])){
                        //     $contractorManagementProfilesRepeater = $principles->managementProfiles()->updateOrCreate([
                        //         'id' => $row['mcfr_id'] ?? null,
                        //         // 'id'=>isset($row['autoFetch']) && $row['autoFetch'] ? null : $row['mcfr_id']
                        //     ], $mpRepeaterDetails);

                        //     // $contractorManagementProfilesRepeater = $proposals->contractor->managementProfiles()->update($mpRepeaterDetails);
                        // }

                        if (isset($row['autoFetch']) && $row['autoFetch']) {
                            $management_profiles_principle_attachment = DMS::where(['dmsable_id'=>$row['mp_id'],'dmsable_type'=>'ManagementProfiles'])->get();

                            foreach ($management_profiles_principle_attachment as $attachment) {
                                if(File::exists($attachment->attachment)) {
                                    $newFilepath = "uploads/proposal/{$proposals->code}/V{$proposals->version}/$proposal_id/{$attachment->file_name}";
                                    File::copy($attachment->attachment, $newFilepath);
                                    $managementProfilesRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);

                                    $contractorManagementProfilesRepeater->dMS()->updateOrCreate([
                                        'file_name' => $attachment->file_name,
                                        'attachment' => $newFilepath ?? null,
                                        'attachment_type' => $attachment->attachment_type,
                                    ]);
                                }
                            }
                        }

                        $dms_managementProfiles = ManagementProfiles::findOrFail($managementProfilesRepeater->id);

                        $dms_contractorManagementProfiles = ManagementProfiles::findOrFail($contractorManagementProfilesRepeater->id);

                        if (!isset($row['mcfr_id'])){
                            $managementProfilesRepeater->update(['contractor_fetch_reference_id' => $managementProfilesRepeater->id]);
                            $contractorManagementProfilesRepeater->update(['contractor_fetch_reference_id' => $managementProfilesRepeater->id]);
                        }

                        if (!empty($row['management_profiles_attachment'])) {
                            // $this->common->updateMultipleFiles($request, $row['management_profiles_attachment'], 'management_profiles_attachment', $dms_managementProfiles, $proposal_id, 'proposal');

                            // $this->common->storeMultipleFiles($request, $row['management_profiles_attachment'], 'management_profiles_attachment', $dms_contractorManagementProfiles, $proposals->contractor->id, 'principle');

                            foreach ($row['management_profiles_attachment'] as $item) {
                                $fileName = $item->getClientOriginalName();

                                $filePath1 = $item->move('uploads/proposal/' . $proposals->code . '/V' . $proposals->version . '/' . $proposal_id, $fileName);

                                if(!File::exists($contractorFilePath)) {
                                    File::makeDirectory($contractorFilePath, $mode = 0777, true, true);
                                }
                                copy($filePath1, $contractorFilePath . '/' . $fileName);

                                $filePath2 = $contractorFilePath . '/' . $fileName;

                                $dms_managementProfiles->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath1,
                                    'attachment_type' => 'management_profiles_attachment',
                                ]);

                                $dms_contractorManagementProfiles->dMS()->create([
                                    'file_name' => $fileName,
                                    'attachment' => $filePath2,
                                    'attachment_type' => 'management_profiles_attachment',
                                ]);
                            }
                        }
                    }
                }
            } else {
                $update_is_amendment = ['is_amendment' => '1'];
                if($proposals->dMS->count() > 0){
                    foreach($proposals->dMS as $item){
                        $item->update($update_is_amendment);
                    }
                }

                foreach($proposals->proposalContractors as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->tradeSector as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->contractorItem as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->contactDetail as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->proposalBeneficiaryTradeSector as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->bankingLimits as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->orderBookAndFutureProjects as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->projectTrackRecords as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->managementProfiles as $item){
                    $item->update($update_is_amendment);
                }

                foreach($proposals->nbi as $item){
                    $item->update($update_is_amendment);
                }
            
                $proposals->update($update_is_amendment);

                // $this->common->updateBondPolicyIssueAndChecklist($proposals->id, $proposals->version);

                $version_code_amendment = $this->common->getVersion($proposals->id, true);

                $inputAmendment = $request->except(['id', '_token', '_method','tradeSector', 'contactDetail', 'beneficiaryTradeSector', 'pbl_items', 'obfp_items', 'ptr_items', 'mp_items', 'jvContractorDetails', 'spvContractorDetails', 'contractorDetails', 'company_details', 'company_technical_details', 'company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr', 'rfp_attachment', 'bond_attachment', 'bond_wording_file', 'contractor_trade_item_id', 'contact_item_id', 'jv_contractor', 'spv_contractor', 'jv_count', 'contractor_item_id', 'delete_pbl_id', 'delete_obfp_id', 'delete_ptr_id', 'delete_mp_id', 'beneficiary_trade_item_id', 'banking_limits_attachment', 'order_book_and_future_projects_attachment', 'project_track_records_attachment', 'management_profiles_attachment', 'contractor_tender_id', 'agency', 'series_number', 'auto_proposal_id', 'ratingDetail', 'rating_id', 'item_rating_date', 'contractor_country_name', 'contractor_bond_country_name', 'beneficiary_country_name', 'beneficiary_bond_country_name', 'spv_count']);

                if($inputAmendment['contract_type'] == 'JV'){
                    $inputAmendment['contractor_id'] = $request['jv_contractor'] ?? null;
                }

                if($inputAmendment['contract_type'] == 'SPV'){
                    // $inputAmendment['contractor_id'] = $request->spvContractorDetails[0]['spv_contractor_id'] ?? null;
                    $inputAmendment['contractor_id'] = $request['spv_contractor'] ?? null;
                }
                $inputAmendment['proposal_parent_id'] = $proposals->id;
                $proposalAmendment = Proposal::create($inputAmendment);
                $proposalAmendment->update(['code' => $proposals->code, 'version' => $version_code_amendment]);

                $proposal_id = $proposalAmendment->id;

                $tenderUpdate = [
                    'contract_value' => $request['tender_contract_value'],
                    'bond_value' => $request['tender_bond_value'],
                ];
                $proposalAmendment->tender->where('id', $request->tender_details_id)->update($tenderUpdate);

                $prev_dms_data = Proposal::findOrFail($prev_proposal_id);

                foreach (['company_details', 'company_technical_details','company_presentation', 'certificate_of_incorporation', 'memorandum_and_articles', 'gst_certificate', 'company_pan_no', 'last_three_years_itr', 'rfp_attachment', 'bond_attachment', 'bond_wording_file'] as $documentType_amendment) {
                    $existingDoc_amendment = $prev_dms_data->dMS()->where('attachment_type', $documentType_amendment)->get();

                    if($request->hasFile($documentType_amendment)) {
                        $this->common->storeMultipleFiles($request, $request[$documentType_amendment], $documentType_amendment, $proposalAmendment, $proposal_id, 'proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment . '/' . $proposal_id);

                    } else{
                        $prev_path_dir = 'uploads/proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment . '/' . $proposal_id;

                        if (!File::exists($prev_path_dir)) {
                            File::makeDirectory($prev_path_dir, 0775, true);
                        }

                        if(isset($existingDoc_amendment)){
                            foreach($existingDoc_amendment as $item){
                                $prev_path = $prev_path_dir . '/' . $item->file_name;
                                if (File::exists($item->attachment)) {
                                    File::copy($item->attachment, $prev_path);
                                }

                                $proposalAmendment->dMS()->create([
                                    'file_name' => $item->file_name,
                                    'attachment' => $prev_path,
                                    'attachment_type' => $documentType_amendment,
                                    'is_amendment' => '0',
                                ]);
                            }
                        }
                    }
                }

                if($request['contract_type'] == 'JV'){
                    $jvContractorDetails = $request->jvContractorDetails;
                    if (!empty($jvContractorDetails) && count($jvContractorDetails) > 0) {
                        // $jvCurrentIds = array_column($jvContractorDetails, 'jv_item_id');
                        // if(!empty($jvCurrentIds)){
                        //     RetentionBondContractor::where('retention_bond_id', $retention_bond_id)->whereNotIn('id', $jvCurrentIds)->delete();
                        // }
                        foreach($jvContractorDetails as $row) {
                            $jv_item_id = $row['jv_item_id'] ?? 0;
                            $jvDataArr = [
                                'proposal_id' => $proposal_id,
                                'proposal_contractor_type' => $request->contract_type,
                                'proposal_contractor_id' => $row['jv_contractor_id'],
                                'pan_no' => $row['jv_pan_no'],
                                'share_holding' => $row['jv_share_holding'],
                                // 'jv_spv_exposure' => $row['jv_exposure'],
                                // 'assign_exposure' => $row['jv_assign_exposure'],
                                // 'overall_cap' => $row['jv_overall_cap'],
                                // 'consumed' => $row['jv_consumed'],
                                // 'spare_capacity' => $row['jv_spare_capacity'],
                                // 'remaining_cap' => $row['jv_remaining_cap'],
                                'is_amendment' => '0',
                            ];
                            // if ($jv_item_id > 0) {
                            //     RetentionBondContractor::where('id', $jv_item_id)->update($jvDataArr);
                            // } else {
                                $proposalAmendment->proposalContractors()->create($jvDataArr);
                        // }
                        }
                    }
                }

                if($request['contract_type'] == 'SPV'){
                    $spvContractorDetails = $request->spvContractorDetails;
                    if (!empty($spvContractorDetails) && count($spvContractorDetails) > 0) {
                        // $spvCurrentIds = array_column($spvContractorDetails, 'spv_item_id');
                        // if(!empty($spvCurrentIds)){
                        //     RetentionBondContractor::where('retention_bond_id', $retention_bond_id)->delete();
                        // }
                        foreach($spvContractorDetails as $row) {
                            $spv_item_id = $row['spv_item_id'] ?? 0;
                            $spvDataArr =  [
                                'proposal_id' => $proposal_id,
                                'proposal_contractor_type' => $request->contract_type,
                                'proposal_contractor_id' => $row['spv_contractor_id'],
                                'pan_no' => $row['spv_pan_no'],
                                'share_holding' => $row['spv_share_holding'],
                                // 'jv_spv_exposure' => $row['spv_exposure'],
                                // 'assign_exposure' => $row['spv_assign_exposure'],
                                // 'overall_cap' => $row['spv_overall_cap'],
                                // 'consumed' => $row['spv_consumed'],
                                // 'spare_capacity' => $row['spv_spare_capacity'],
                                // 'remaining_cap' => $row['spv_remaining_cap'],
                                'is_amendment' => '0',
                            ];
                            // if ($spv_item_id > 0) {
                            //     RetentionBondContractor::where('id', $spv_item_id)->update($spvDataArr);
                            // } else {
                                $proposalAmendment->proposalContractors()->create($spvDataArr);
                            //}
                        }
                    }
                }

                $beneficiaryTradeSector = $request->beneficiaryTradeSector;
                if (!empty($beneficiaryTradeSector) && count($beneficiaryTradeSector) > 0) {
                    foreach ($beneficiaryTradeSector as $row) {
                        $beneficiaryTradeSectorArr = [
                            // 'beneficiary_id' => $beneficiary_id,
                            'trade_sector_id' => $row['beneficiary_trade_sector_id'] ?? NULL,
                            'from'=> $row['beneficiary_from'] ?? NULL,
                            'till'=> $row['beneficiary_till'] ?? NULL,
                            'is_main'=> $row['beneficiary_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pbt_item_id'] ?? null,
                        ];
                        $proposalAmendment->proposalBeneficiaryTradeSector()->create($beneficiaryTradeSectorArr);
                    }
                }

                // if($request['is_jv'] == 'Yes'){
                //     $contractorDetails = $request->contractorDetails;
                //     if (!empty($contractorDetails) && count($contractorDetails) > 0) {
                //         foreach ($contractorDetails as $row) {
                //             $contractorDetailArr = [
                //                 // 'principle_id' => $principle_id,
                //                 'contractor_id' => $row['contractor_id'] ?? NULL,
                //                 'pan_no'=> $row['contractor_pan_no'] ?? NULL,
                //                 'share_holding'=> $row['share_holding'] ?? NULL,
                //             ];
                //             $proposalAmendment->contractorItem()->create($contractorDetailArr);
                //         }
                //     }
                // }
                $tradeSector = $request->tradeSector;
                if (!empty($tradeSector) && count($tradeSector) > 0) {
                    foreach ($tradeSector as $row) {
                        $tradeSectorArr = [
                            // 'principle_id' => $principle_id,
                            'trade_sector_id' => $row['contractor_trade_sector'] ?? NULL,
                            'from'=> $row['contractor_from'] ?? NULL,
                            'till'=> $row['contractor_till'] ?? NULL,
                            'is_main'=> $row['contractor_is_main'] ?? 'No',
                            'contractor_fetch_reference_id' => $row['pct_item_id'] ?? null,
                        ];
                        $proposalAmendment->tradeSector()->create($tradeSectorArr);
                    }
                }

                $contactDetail = $request->contactDetail;
                if (!empty($contactDetail) && count($contactDetail) > 0) {
                    foreach ($contactDetail as $row) {
                        $contactDetailArr = [
                            'contact_person' => $row['contact_person'] ?? NULL,
                            'email'=> $row['email'] ?? NULL,
                            'phone_no'=> $row['phone_no'] ?? NULL,
                            'contractor_fetch_reference_id' => $row['proposal_contact_item_id'] ?? null,
                        ];
                        $contactDetailIsNull = empty(array_filter($contactDetailArr, function($value) {
                            return !is_null($value);
                        }));
                        // $contactDetailArr['principle_id'] = $principle_id;
                        if(!$contactDetailIsNull){
                            $proposalAmendment->contactDetail()->create($contactDetailArr);
                        }
                    }
                }

                // Rating

                $ratingDetail = $request->ratingDetail;
                if(isset($ratingDetail) && count($ratingDetail) > 0){
                    foreach ($ratingDetail as $row) {
                        $ratingDetailsArr = [
                            'agency_id' => $row['item_agency_id'] ?? null,
                            'rating_id' => $row['item_rating_id'] ?? null,
                            'rating' => $row['rating'] ?? null,
                            'remarks' => $row['rating_remarks'] ?? null,
                            'rating_date' => $row['rating_date'] ?? null,
                        ];

                        $ratingDetailsRepeater = $proposalAmendment->agencyRatingDetails()->create($ratingDetailsArr);
                    }
                }

                // Proposal Banking Limits Repeater

                $proposalBankingLimits = $request->pbl_items;

                foreach ($proposalBankingLimits as $row) {
                    $proposalBankingLimitsArr = [
                        'banking_category_id' => $row['banking_category_id'] ?? null,
                        'facility_type_id' => $row['facility_type_id'] ?? null,
                        'sanctioned_amount' => $row['sanctioned_amount'] ?? null,
                        'bank_name' => $row['bank_name'] ?? null,
                        'latest_limit_utilized' => $row['latest_limit_utilized'] ?? null,
                        'unutilized_limit' => $row['unutilized_limit'] ?? null,
                        'commission_on_pg' => $row['commission_on_pg'] ?? null,
                        'commission_on_fg' => $row['commission_on_fg'] ?? null,
                        'margin_collateral' => $row['margin_collateral'] ?? null,
                        'other_banking_details' => $row['other_banking_details'] ?? null,
                        'contractor_fetch_reference_id' => $row['cfr_id'] ?? null,
                    ];

                    $proposalBankingLimitsRepeater = $proposalAmendment->bankingLimits()->create($proposalBankingLimitsArr);

                    if (isset($row['id'])) {
                        $bankinglimit_principle_attachment = DMS::where(['dmsable_id'=>$row['id'],'dmsable_type'=>'BankingLimits'])->get();

                        foreach ($bankinglimit_principle_attachment as $attachment) {
                            if(File::exists($attachment->attachment)) {
                                $newFilepath = "uploads/proposal/{$proposal_id}/{$attachment->file_name}";
                                File::copy($attachment->attachment, $newFilepath);
                                $proposalBankingLimitsRepeater->dMS()->create([
                                    'file_name' => $attachment->file_name,
                                    'attachment' => $newFilepath ?? null,
                                    'attachment_type' => $attachment->attachment_type,
                                ]);
                            }
                        }
                    }

                    $dms_proposalBankingLimits = BankingLimit::findOrFail($proposalBankingLimitsRepeater->id);

                    if (!empty($row['proposal_banking_limits_attachment'])) {
                        $this->common->storeMultipleFiles($request, $row['proposal_banking_limits_attachment'], 'proposal_banking_limits_attachment', $dms_proposalBankingLimits, $proposal_id, 'proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment);
                    }
                }

                // Order Book and Future Projects Repeater

                $orderBookAndFutureProjects = $request->obfp_items;
                foreach($orderBookAndFutureProjects as $row){
                    $orderBookAndFutureProjectsArr = [
                        'project_name' => $row['project_name'] ?? null,
                        'project_cost' => $row['project_cost'] ?? null,
                        'project_description' => $row['project_description'] ?? null,
                        'project_start_date' => $row['project_start_date'] ?? null,
                        'project_end_date' => $row['project_end_date'] ?? null,
                        'project_tenor' => $row['project_tenor'] ?? null,
                        'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                        'project_share' => $row['project_share'] ?? null,
                        'guarantee_amount' => $row['guarantee_amount'] ?? null,
                        'current_status' => $row['current_status'] ?? null,
                        'contractor_fetch_reference_id' => $row['ocfr_id'] ?? null,
                    ];

                    $orderBookAndFutureProjectsRepeater = $proposalAmendment->orderBookAndFutureProjects()->create($orderBookAndFutureProjectsArr);

                    if (isset($row['id'])) {
                        $order_book_and_future_projects_principle_attachment = DMS::where(['dmsable_id'=>$row['id'],'dmsable_type'=>'OrderBookAndFutureProjects'])->get();

                        foreach ($order_book_and_future_projects_principle_attachment as $attachment) {
                            if(File::exists($attachment->attachment)) {
                                $newFilepath = "uploads/proposal/{$proposal_id}/{$attachment->file_name}";
                                File::copy($attachment->attachment, $newFilepath);
                                $orderBookAndFutureProjectsRepeater->dMS()->create([
                                    'file_name' => $attachment->file_name,
                                    'attachment' => $newFilepath ?? null,
                                    'attachment_type' => $attachment->attachment_type,
                                ]);
                            }
                        }
                    }

                    $dms_orderBookAndFutureProjects = OrderBookAndFutureProjects::findOrFail($orderBookAndFutureProjectsRepeater->id);

                    if (!empty($row['order_book_and_future_projects_attachment'])) {
                        $this->common->storeMultipleFiles($request, $row['order_book_and_future_projects_attachment'], 'order_book_and_future_projects_attachment', $dms_orderBookAndFutureProjects, $proposal_id, 'proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment);
                    }
                }

                // Project Track Records Repeater

                $projectTrackRecords = $request->ptr_items;
                // dd($projectTrackRecords);
                foreach($projectTrackRecords as $row){
                    $projectTrackRecordsArr = [
                        'project_name' => $row['project_name'] ?? null,
                        'project_cost' => $row['project_cost'] ?? null,
                        'project_description' => $row['project_description'] ?? null,
                        'project_start_date' => $row['project_start_date'] ?? null,
                        'project_end_date' => $row['project_end_date'] ?? null,
                        'project_tenor' => $row['project_tenor'] ?? null,
                        'bank_guarantees_details' => $row['bank_guarantees_details'] ?? null,
                        'actual_date_completion' => $row['actual_date_completion'] ?? null,
                        'bg_amount' => $row['bg_amount'] ?? null,
                        'contractor_fetch_reference_id' => $row['pcfr_id'] ?? null,
                    ];
                    $projectTrackRecordsRepeater = $proposalAmendment->projectTrackRecords()->create($projectTrackRecordsArr);

                    if (isset($row['id'])) {
                        $project_track_records_principle_attachment = DMS::where(['dmsable_id'=>$row['id'],'dmsable_type'=>'ProjectTrackRecords'])->get();

                        foreach ($project_track_records_principle_attachment as $attachment) {
                            if(File::exists($attachment->attachment)) {
                                $newFilepath = "uploads/proposal/{$proposal_id}/{$attachment->file_name}";
                                File::copy($attachment->attachment, $newFilepath);
                                $projectTrackRecordsRepeater->dMS()->create([
                                    'file_name' => $attachment->file_name,
                                    'attachment' => $newFilepath ?? null,
                                    'attachment_type' => $attachment->attachment_type,
                                ]);
                            }
                        }
                    }

                    $dms_projectTrackRecords = ProjectTrackRecords::findOrFail($projectTrackRecordsRepeater->id);

                    if (!empty($row['project_track_records_attachment'])) {
                        $this->common->storeMultipleFiles($request, $row['project_track_records_attachment'], 'project_track_records_attachment', $dms_projectTrackRecords, $proposal_id, 'proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment);
                    }
                }

                // Management Profiles Repeater

                $managementProfiles = $request->mp_items;
                foreach($managementProfiles as $row){
                    $managementProfilesArr = [
                        'designation' => $row['designation'] ?? null,
                        'name' => $row['name'],
                        'qualifications' => $row['qualifications'],
                        'experience' => $row['experience'],
                        'contractor_fetch_reference_id' => $row['mcfr_id'] ?? null,
                    ];
                    $managementProfilesRepeater = $proposalAmendment->managementProfiles()->create($managementProfilesArr);

                    if (isset($row['id'])) {
                        $management_profiles_principle_attachment = DMS::where(['dmsable_id'=>$row['id'],'dmsable_type'=>'ManagementProfiles'])->get();

                        foreach ($management_profiles_principle_attachment as $attachment) {
                            if(File::exists($attachment->attachment)) {
                                $newFilepath = "uploads/proposal/{$proposal_id}/{$attachment->file_name}";
                                File::copy($attachment->attachment, $newFilepath);
                                $managementProfilesRepeater->dMS()->create([
                                    'file_name' => $attachment->file_name,
                                    'attachment' => $newFilepath ?? null,
                                    'attachment_type' => $attachment->attachment_type,
                                ]);
                            }
                        }
                    }

                    $dms_managementProfiles = ManagementProfiles::findOrFail($managementProfilesRepeater->id);

                    if (!empty($row['management_profiles_attachment'])) {
                        $this->common->storeMultipleFiles($request, $row['management_profiles_attachment'], 'management_profiles_attachment', $dms_managementProfiles, $proposal_id, 'proposal/' . $proposalAmendment->code . '/V' . $version_code_amendment);
                    }
                }
            }


            DB::commit();
            return redirect()->route('proposals.index')->with('success', __('proposals.update_success'));
        } catch(\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        $proposals = Proposal::with('bankingLimits.dMS', 'orderBookAndFutureProjects.dMS', 'projectTrackRecords.dMS', 'managementProfiles.dMS', 'dMS','proposalContractors', 'tradeSector', 'contractorItem', 'contactDetail', 'proposalBeneficiaryTradeSector', 'agencyRatingDetails')->findOrFail($id);
        // dd($proposals);

        $dms_data = DMS::where('dmsable_id', $id);

        foreach ($dms_data->pluck('attachment') as $dms) {
            File::delete($dms);
        }

        if($proposals)
        {
            $dependency = $proposals->deleteValidate($id);
            if(!$dependency)
            {
                $this->common->deleteMultipleFileRepeater($proposals->bankingLimits);
                $this->common->deleteMultipleFileRepeater($proposals->orderBookAndFutureProjects);
                $this->common->deleteMultipleFileRepeater($proposals->projectTrackRecords);
                $this->common->deleteMultipleFileRepeater($proposals->managementProfiles);

                $dms_data->delete();
                $proposals->bankingLimits()->delete();
                $proposals->orderBookAndFutureProjects()->delete();
                $proposals->projectTrackRecords()->delete();
                $proposals->managementProfiles()->delete();
                $proposals->proposalContractors()->delete();
                $proposals->tradeSector()->delete();
                $proposals->contractorItem()->delete();
                $proposals->contactDetail()->delete();
                $proposals->proposalBeneficiaryTradeSector()->delete();
                $proposals->agencyRatingDetails()->delete();

                $proposals->delete();
            } else {
                return response()->json([
                    'success' => false,
                    'message' => __('proposals.dependency_error', ['dependency' => $dependency]),
                ], 200);
            }
        }
        return response()->json([
            'success' => true,
            'message' => __('common.delete_success'),
        ], 200);
    }
    public function change_status(Request $request, $id, $tender_evaluation_id = null)
    {
        // dd($request->all(), $id, $tender_evaluation_id);
        DB::beginTransaction();
        try{
            $new_status = $request->rejection_reason ? $new_status = 'Reject' : $request->new_status;
            $current_status = $request->rejection_reason ? $current_status = 'Confirm' : $request->current_status;
            Proposal::where('id', $id)->update(['status' => $new_status]);
            if($tender_evaluation_id){
                TenderEvaluation::where('proposal_id', $id)->orderBy('id','desc')->first()->update(['status' => $new_status]);
            }

            $logsArr = [
                'proposal_id'=>$id,
                'new_status'=>$new_status,
                'current_status'=>$current_status,
                'rejection_reason' => $request->rejection_reason ?? null,
                'remarks'=>$request->description ?? Null,
                'tender_evaluation_id'=>$request->tender_evaluation_id ?? Null,
            ];
            ProposalLog::Create($logsArr);
            $message = 'This Proposal has been '.strtolower($new_status).' succesfully.';
            DB::commit();

            return redirect()->route('proposals.show',[encryptId($id)])->with('success', 'This Proposal has been '.$new_status.' succesfully.');
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
        }
    }
    public function tenderEvaluation(Request $request, $proposal_id){
        $id = $request->get('id', false);
        $proposal =  Proposal::with(['createdBy', 'beneficiary', 'contractor','tender','tenderEvaluation'])->findOrFail($proposal_id);
        // $proposal_evaluation =$proposal->tenderEvaluation->sortByDesc('id')->first();
        // $evaluation_last_id =$proposal_evaluation->id ?? '';
        // $last_id =$proposal->tenderEvaluation->sortByDesc('id');
        $tenderEvaluation =  TenderEvaluation::with(['contractor','beneficiary','productAllowed','work_type','location'])->find($id);
        $this->data['title'] = __('proposals.tender_evaluation');
        $this->data['proposal'] = $proposal;
        $this->data['tenderEvaluation'] = $tenderEvaluation;
        $this->data['proposal_id'] = $proposal_id;
        $this->data['bondTypes'] = $this->common->getBondTypes();
        $this->data['projectTypes'] = $this->common->getProjectType();
        // $this->data['tenures'] = $this->common->getTenure();
        $this->data['id'] = $id;
        // $allow_save = true;
        // if($id > 0){
        //     $allow_save = ($evaluation_last_id == $id && in_array($proposal->status, ['Confirm'])) ? true : false;
        // }
        //$this->data['allow_save'] = $allow_save;
        $users = User::get();
        $user_data = [];
        if($users->count() > 0){
            foreach ($users as $key => $user) {
                $user_id = $user->id;
                $check_user = Sentinel::findById($user_id);
                if($check_user->hasAnyAccess(['proposals.approve_tender_evaluation'])){
                    $full_name = $user->first_name . " " . $user->last_name;
                    $user_data[$user_id] = $full_name;
                }
            }
        }
        $this->data['users'] = $user_data;
        $this->data['worktypes'] = $this->common->getWorkType();
        $this->data['states'] = $this->common->getStates();
        return view('proposals.form.tender-evaluation', $this->data);
    }
    public function tenderEvaluationStore(TenderEvaluationRequest $request){
        DB::beginTransaction();
        try{
            // dd($request->all());
            $id = $request->id ?? '';
            $proposal_id = $request->proposal_id;
            if($id > 0){
                $tender_evaluation_data=[
                    'user_id'=>$request->user_id ?? null,
                ];
                TenderEvaluation::where('id', $id)->update($tender_evaluation_data);
                DB::commit();
                $message = 'This tender evaluation has been updated succesfully.';
                return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('success',$message);
            }else{
                $check_entry = TenderEvaluation::latest()->first();
                $finishTime = Carbon::now();
                $totalDuration = 10;
                if (!empty($check_entry)) {
                    $totalDuration = $finishTime->diffInSeconds($check_entry->created_at);
                }
                if (!empty($check_entry) && (Sentinel::getUser()->id == $check_entry->created_by && $totalDuration <= 5)) {
                    return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('success', 'Please Check into list entry added succesfully you submit form multiple time!!');
                }
                $product_allowed = $request->product_allowed ?? [];
                $work_type = $request->work_type ?? [];
                $locations = $request->locations ?? [];
                $attachmentPath = uploadFile($request, 'proposal/' . $proposal_id, 'attachment');
                $tender_evaluation_data=[
                    'proposal_id'=>$proposal_id,
                    'contractor_id'=>$request->contractor_id,
                    'rating_score'=>$request->rating_score ?? null,
                    'tender_id'=>$request->tender_id ?? null,
                    'project_description'=>$request->project_description ?? null,
                    'beneficiary_id'=>$request->beneficiary_id ?? null,
                    'project_value'=>$request->project_value ?? null,
                    'bond_value'=>$request->bond_value ?? null,
                    'overall_capacity'=>$request->overall_capacity ?? null,
                    'individual_capacity'=>$request->individual_capacity ?? null,
                    'old_contract_running_contract'=>$request->old_contract_running_contract ?? null,
                    'replacement_bg_for_existing_contract'=>$request->replacement_bg_for_existing_contract ?? null,
                    'experience_of_similar_contract_size'=>$request->experience_of_similar_contract_size ?? null,
                    'complexity_of_project_allowed'=>$request->complexity_of_project_allowed ?? null,
                    'type_of_projects_allowed'=>$request->type_of_projects_allowed ?? null,
                    'type_of_bond_allowed'=>$request->type_of_bond_allowed ?? null,
                    // 'tenure_id'=>$request->tenure ?? null,
                    'strategic_nature_of_the_project'=>$request->strategic_nature_of_the_project ?? null,
                    'user_id'=>$request->user_id ?? null,
                    'bond_start_date'=>custom_date_format($request->bond_start_date,'Y-m-d'),
                    'bond_end_date'=>custom_date_format($request->bond_end_date,'Y-m-d'),
                    'bond_period'=>$request->bond_period,
                    'other_work_type'=>$request->other_work_type ?? null,
                    'attachment'=>$attachmentPath,
                    'remarks'=>$request->remarks ?? null,
                ];
                $model = TenderEvaluation::create($tender_evaluation_data);
                $tender_evaluation_id = $model->id;
                if(!empty($product_allowed) && count($product_allowed) > 0){
                    foreach ($product_allowed as $pa_key => $pa_value) {
                        $product_allowed_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'project_type_id'=>$pa_value,
                        ];
                        TenderEvaluationProductAllowed::create($product_allowed_data);
                    }
                }
                if(!empty($work_type) && count($work_type) > 0){
                    foreach ($work_type as $wt_key => $wt_value) {
                        $work_type_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'work_type'=>$wt_value,
                        ];
                        TenderEvaluationWorkType::create($work_type_data);
                    }
                }
                if(!empty($locations) && count($locations) > 0){
                    foreach ($locations as $l_key => $l_row) {
                        $location_data = [
                            'tender_evaluation_id'=>$tender_evaluation_id,
                            'proposal_id'=>$proposal_id,
                            'state_id'=>$l_row['state_id'] ?? null,
                            'location'=>$l_row['location'] ?? null,
                        ];
                        TenderEvaluationLocation::create($location_data);
                    }
                }
                DB::table('proposals')->where('id',$proposal_id)->update(['tender_evaluation'=>'Yes','status'=>'Confirm']);
                DB::commit();
                $message = 'This proposal has been confirm succesfully.';
                return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('success',$message);
            }
        }catch(\Exception $e){
            DB::rollback();
            throw $e;
            return redirect()->route('proposals.show',[encryptId($proposal_id)])->with('error', __('common.something_went_wrong_please_try_again'));
        }
    }
    public function getTenderData(Request $request)
    {
        $tender_id = $request->tender_details_id;
        $field = [
            'tenders.id',
            'tenders.tender_id',
            'tenders.tender_header',
            'tenders.beneficiary_id as tender_beneficiary_id',
            'tenders.contract_value',
            'tenders.period_of_contract',
            'tenders.location',
            'tenders.project_type',
            'tenders.bond_value as tender_bond_value',
            'tenders.bond_type_id',
            'tenders.rfp_date',
            'tenders.type_of_contracting',
            'tenders.tender_description',
            'tenders.project_description',
            'tenders.project_details',
            // 'tenders.pd_project_name',
            // 'tenders.pd_project_description',
            // 'tenders.pd_project_value',
            // 'tenders.pd_project_start_date',
            // 'tenders.pd_project_end_date',
            // 'tenders.pd_period_of_project',
            // 'tenders.pd_beneficiary',
            // 'tenders.pd_type_of_project',
            'dms.attachment',
            'dms.file_name',
            'dms.attachment_type',
        ];
        // if($tender_id){
        //     $tenderData = Tender::with('dMS')->where('id',$tender_id)->first();
        //     // dd($tenderData);
        //     return $tenderData;
        // }

        if($tender_id){
            $tenderData = Tender::with('dMS')->select($field)
            ->where('tenders.id',$tender_id)
            ->leftJoin('dms', function($join) use($tender_id){
                $join->on('tenders.id', '=', 'dms.dmsable_id')
                // ->where('tenders.id',$tender_id)
                ->where('attachment_type', 'rfp_attachment')
                ->whereNull('dms.deleted_at');
            })->first();
            // dd($tenderData);
            $documentCount = $tenderData->dMS->countBy('attachment_type');
            $this->dmsData['dmsData'] = $tenderData->dMS->groupBy('attachment_type');

            $response = [
                'tenderData' => $tenderData,
                'documentCount' => $documentCount,
                'dmsData' => view('proposals.autofield.dmsDocumentShow',$this->dmsData)->render(),
            ];

            return $response;
        }
    }

    public function getProjectDetails(Request $request){
        $project_details_id = $request->project_details_id;
        // dd($project_details_id);

        $fields = [
            'project_details.project_name as pd_project_name',
            'project_details.project_description as pd_project_description',
            'project_details.project_value as pd_project_value',
            'project_details.project_start_date as pd_project_start_date',
            'project_details.project_end_date as pd_project_end_date',
            'project_details.period_of_project as pd_period_of_project',
            'project_details.beneficiary_id as pd_beneficiary',
            'project_details.type_of_project as pd_type_of_project',
        ];

        if($project_details_id){
            $projectDetails = ProjectDetail::select($fields)->where('id',$project_details_id)->first();
            // dd($projectDetails);
            return $projectDetails;
        }
    }

    public function getContractorData(Request $request){
        $contractor_id = $request->contractor_id;

        $parent = GroupContractor::with(['group'])->where('contractor_id', $contractor_id)->first()->contractor_id ?? null;

        if(isset($parent)){
            $field = [
                'principles.id',
                'principles.pan_no',
                'principles.address as register_address',
                // DB::raw('CASE WHEN groups.contractor_id IS NOT NULL THEN (SELECT company_name FROM principles WHERE principles.id = groups.contractor_id) ELSE principles.company_name END as company_name'),
                DB::raw('(SELECT company_name FROM principles WHERE principles.id = groups.contractor_id) as parent_group_name'),
                'principles.company_name as contractor_company_name',
                'principles.date_of_incorporation',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'principles.is_active',
                'principles.is_bank_guarantee_provided',
                'principles.circumstance_short_notes',
                'principles.is_action_against_proposer',
                'principles.action_details',
                'principles.contractor_failed_project_details',
                'principles.completed_rectification_details',
                'principles.performance_security_details',
                'principles.relevant_other_information',
                'principles.registration_no',
                'principles.company_name',
                'principles.website as contractor_website',
                'principles.city as contractor_city',
                'principles.country_id',
                'principles.state_id',
                'principles.pincode as contractor_pincode',
                'principles.pan_no as contractor_pan_no',
                'principles.gst_no as contractor_gst_no',
                'users.email as contractor_email',
                'users.mobile as contractor_mobile',
                'principles.principle_type_id',
                // 'principles.is_jv',
                'principles.agency_id',
                'principles.agency_rating_id',
                'principles.rating_remarks',
                'dms.attachment',
                'dms.file_name',
                'dms.attachment_type',
                'principles.entity_type_id as contractor_entity_type_id',
                // 'principles.inception_date as contractor_inception_date',
                'principles.staff_strength as contractor_staff_strength',
                // 'principles.rating_date',
            ];
        } else {
            $field = [
                'principles.id',
                'principles.pan_no',
                'principles.company_name as parent_group_name',
                'principles.company_name as contractor_company_name',
                'principles.address as register_address',
                'principles.date_of_incorporation',
                'users.first_name as first_name',
                'users.middle_name as middle_name',
                'users.last_name as last_name',
                'principles.is_active',
                'principles.is_bank_guarantee_provided',
                'principles.circumstance_short_notes',
                'principles.is_action_against_proposer',
                'principles.action_details',
                'principles.contractor_failed_project_details',
                'principles.completed_rectification_details',
                'principles.performance_security_details',
                'principles.relevant_other_information',
                'principles.registration_no',
                'principles.company_name',
                'principles.website as contractor_website',
                'principles.city as contractor_city',
                'principles.country_id',
                'principles.state_id',
                'principles.pincode as contractor_pincode',
                'principles.pan_no as contractor_pan_no',
                'principles.gst_no as contractor_gst_no',
                'users.email as contractor_email',
                'users.mobile as contractor_mobile',
                'principles.principle_type_id',
                // 'principles.is_jv',
                'principles.agency_id',
                'principles.agency_rating_id',
                'principles.rating_remarks',
                'dms.attachment',
                'dms.file_name',
                'dms.attachment_type',
                'principles.entity_type_id as contractor_entity_type_id',
                // 'principles.inception_date as contractor_inception_date',
                'principles.staff_strength as contractor_staff_strength',
                // 'principles.rating_date',
            ];
        }

        if ($contractor_id) {
            $contractor_data = Principle::with('bankingLimits','orderBookAndFutureProjects','projectTrackRecords','managementProfiles', 'dMS', 'tradeSector', 'contactDetail',  'contractorItem', 'contractorAdverseInformation', 'contractorBlacklistInformation')->select($field)
                ->join('users', function ($join) use ($contractor_id) {
                    $join->on('principles.user_id', '=', 'users.id')
                        ->where('principles.id', $contractor_id)
                        ->whereNull('users.deleted_at');
                })
                ->when($parent != null, function ($query) {
                    $query->join('group_contractors', function ($join) {
                            $join->on('principles.id', '=', 'group_contractors.contractor_id');
                        })
                        ->join('groups', function ($join) {
                            $join->on('group_contractors.group_id', '=', 'groups.id');
                        });
                })
                ->leftJoin('dms', function($join) use($contractor_id){
                    $join->on('principles.id', '=', 'dms.dmsable_id')
                    ->where('principles.id',$contractor_id)
                    ->whereNull('dms.deleted_at');
                })
                ->first();

                $this->banking_limits['facility_types'] = $this->common->getFacilityType();
                $this->banking_limits['banking_limit_category'] = $this->common->getBankingLimitCategory();
                $this->banking_limits['proposal_banking_limits'] =$contractor_data->bankingLimits;

                $this->order_book_and_future_projects['order_book_and_future_projects'] = $contractor_data->orderBookAndFutureProjects;
                $this->order_book_and_future_projects['current_status'] = Config('srtpl.current_status');
                $this->order_book_and_future_projects['project_type'] = $this->common->getProjectType();


                $this->project_track_records['project_type'] = $this->common->getProjectType();
                $this->project_track_records['completion_status'] = Config('srtpl.completion_status');
                $this->project_track_records['project_track_records'] = $contractor_data->projectTrackRecords;

                $this->management_profiles['management_profiles'] = $contractor_data->managementProfiles;
                $this->management_profiles['designation'] = $this->common->getDesignation();

                $this->contact_detail['contact_detail'] = $contractor_data->contactDetail;
                $this->contractor_trade_sector['trade_sector'] = $contractor_data->tradeSector;
                $this->contractor_trade_sector['trade_sector_id'] = $this->common->getTradeSector();

                $this->contractor_spv_details['jv_details'] = $contractor_data->contractorItem;
                $this->contractor_spv_details['proposal_contractor'] = $this->common->getContractor();
                $this->agencyData['agencyData'] =$contractor_data->agencyRatingDetails;
                // dd($this->agencyData['agencyData']);

                $this->dmsData['dmsData'] = $contractor_data->dMS->groupBy('attachment_type');
                // dd($this->dmsData['dmsData']);
                $documentCount = $contractor_data->dMS->countBy('attachment_type');

                $this->states['states'] = $this->common->getStates($contractor_data->country_id);
                // dd($this->states);

                $this->stand_alone_adverse_information['stand_alone_adverse_information'] = $contractor_data->contractorAdverseInformation->where('is_active', 'Yes');
                $this->stand_alone_blacklist_information['stand_alone_blacklist_information'] = $contractor_data->contractorBlacklistInformation->where('is_active', 'Yes');
                // $this->blacklist_information['blacklist_information'] = $contractor_data->blackListInformation;
                // foreach($contractor_data->contractorAdverseInformation as $item){
                //     // dd($item);
                //     // $route = route('adverse-information.show',[encryptId($item->id)]);
                //     $this->adverse_information[] = "<a href='' data-target='#adverseInformation_{{ $item->id }}'>{$item->code}</a>";
                // }

                if($contractor_data->contractorItem) {
                    foreach($contractor_data->contractorItem as $item){
                        $this->adverse_information[] = $item->contractor;
                    }
                } else {
                    $this->adverse_information= [];
                }

                if($contractor_data->contractorItem) {
                    foreach($contractor_data->contractorItem as $item){
                        $this->blacklist_information[] = $item->contractor;
                    }
                } else {
                    $this->blacklist_information = [];
                }

                $response = [
                    // 'dmsData' => view('proposals.autofield.dmsDocumentShow',['contractor_doc' => $this->dmsData, 'pbl_doc' => $aaa])->render(),
                    'contractor_detail'=>$contractor_data,
                    'banking_limits' => view('proposals.autofield.banking_limits',$this->banking_limits)->render(),
                    'order_book_and_future_projects'=>view('proposals.autofield.order_book_and_future_projects',$this->order_book_and_future_projects)->render(),
                    'project_track_records'=>view('proposals.autofield.project_track_records',$this->project_track_records)->render(),
                    'management_profiles'=>view('proposals.autofield.management_profiles',$this->management_profiles)->render(),
                    'contact_detail' => view('proposals.autofield.contractor_contact_details', $this->contact_detail)->render(),

                    'trade_sector' => view('proposals.autofield.contractor_trade_sector', $this->contractor_trade_sector)->render(),

                    // 'jv_details' => view('proposals.autofield.contractor_spv_details',$this->contractor_spv_details)->render(),

                    'agencyData' => view('proposals.autofield.contractor_agency_details',$this->agencyData)->render(),

                    'states' => $this->states,
                    'documentCount' => $documentCount,
                    'stand_alone_adverse_information' => view('proposals.autofield.stand_alone_adverse_information',$this->stand_alone_adverse_information)->render(),
                    'stand_alone_blacklist_information' => view('proposals.autofield.stand_alone_blacklist_information',$this->stand_alone_blacklist_information)->render(),

                    // 'blacklist_information' => $this->blacklist_information,

                    'adverse_information' => array_map(function($item) {
                        return view('proposals.autofield.venture_adverse_information', ['adverse_information' => $item->contractorAdverseInformation->where('is_active', 'Yes')])->render();
                    }, $this->adverse_information ?? []),
                    'blacklist_information' => array_map(function($item) {
                        return view('proposals.autofield.venture_blacklist_information', ['blacklist_information' => $item->contractorBlacklistInformation->where('is_active', 'Yes')])->render();
                    }, $this->blacklist_information ?? []),
                ];

            return $response;
        }
    }

    public function getBeneficiaryData(Request $request)
    {
        $beneficiary_id = $request->beneficiary_id;
        $field = [
            'beneficiaries.id',
            'beneficiaries.registration_no as beneficiary_registration_no',
            'beneficiaries.company_name as beneficiary_company_name',
            'users.email as beneficiary_email',
            'users.mobile as beneficiary_phone_no',
            'beneficiaries.address as beneficiary_address',
            'beneficiaries.website as beneficiary_website',
            'beneficiaries.country_id',
            'beneficiaries.state_id',
            'beneficiaries.city as beneficiary_city',
            'beneficiaries.pincode as beneficiary_pincode',
            'beneficiaries.gst_no as beneficiary_gst_no',
            'beneficiaries.pan_no as beneficiary_pan_no',
            'beneficiaries.beneficiary_type',
            'beneficiaries.establishment_type_id',
            'beneficiaries.ministry_type_id',
            'beneficiaries.bond_wording as beneficiary_bond_wording',
            'dms.attachment',
            'dms.file_name',
            'dms.attachment_type',
        ];

        if($beneficiary_id){
            $beneficiaryData = Beneficiary::with('proposalBeneficiaryTradeSector', 'dMS')->select($field)
            ->join('users', function ($join) use ($beneficiary_id) {
                $join->on('beneficiaries.user_id', '=', 'users.id')
                    ->where('beneficiaries.id', $beneficiary_id)
                    ->whereNull('users.deleted_at');
            })
            ->leftJoin('dms', function($join) use($beneficiary_id){
                $join->on('beneficiaries.id', '=', 'dms.dmsable_id')
                ->where('beneficiaries.id',$beneficiary_id)
                ->where('attachment_type', 'bond_attachment')
                ->whereNull('dms.deleted_at');
            })->first();
            // dd($beneficiaryData);

            $this->beneficiary_trade_sector['beneficiary_trade_sector'] = $beneficiaryData->proposalBeneficiaryTradeSector;
            $this->beneficiary_trade_sector['trade_sector_id'] = $this->common->getTradeSector();
            // dd($this->trade_sector['trade_sector']);
            $this->states['beneficiary_states'] = $this->common->getStates($beneficiaryData->country_id);
            $documentCount = $beneficiaryData->dMS->countBy('attachment_type');
            $this->dmsData['dmsData'] = $beneficiaryData->dMS->groupBy('attachment_type');

            $response = [
                'beneficiaryData' => $beneficiaryData,
                'beneficiary_trade_sector' => view('proposals.autofield.beneficiary_trade_sector',$this->beneficiary_trade_sector)->render(),
                'beneficiary_states' => $this->states,
                'documentCount' => $documentCount,
                'dmsData' => view('proposals.autofield.dmsDocumentShow',$this->dmsData)->render(),
            ];

            return $response;
        }
    }

    public function proposalRejectionReason(Request $request, $proposal_id, $tender_evaluation_id = null)
    {
        $this->data['proposal_id'] = $proposal_id;
        $this->data['tender_evaluation_id'] = $tender_evaluation_id ?? null;
        $this->data['rejection_reason'] = $this->common->getRejectionReason();
        return response()->json(['html' => view('proposals.proposal_rejection', $this->data)->render()]);
    }

    public function getRejectionReasonData(Request $request)
    {
       $rejection_reason_id = $request->rejection_reason;
       if($rejection_reason_id){
            $rejectionReasonData = RejectionReason::where('id',$rejection_reason_id)->first();
            return $rejectionReasonData;
       }
    }

    public function getTenderEvaluationRejectionData(Request $request)
    {
        $tender_evaluation_id = $request->input('tender_evaluation_id');

        $rejectionReasonData = ProposalLog::where('tender_evaluation_id', $tender_evaluation_id)->first();
        $rejection_reason = RejectionReason::where('id', $rejectionReasonData->rejection_reason)->first()->reason ?? 'Other';

        if ($rejectionReasonData) {
            return response()->json([
                'rejection_reason' => $rejection_reason,
                'remarks' => $rejectionReasonData->remarks,
            ]);
        }

        return response()->json([
            'remarks' => 'No rejection reason available.'
        ]);
    }

    public function proposalCaseCreate(Request $request){
        // dd($request->all());
        $proposal_id = $request->proposal_id;
        // $underwriter_id = $request->underwriter_id;
        if($proposal_id){
            $proposalData = Proposal::where('id',$proposal_id)->first();
            // $bondValue = $request->status == 'Cancel' ? 0 : $proposalData->bond_value;
            $bondValue = $proposalData->bond_value;

            // Cases::where('proposal_id',$proposalData->proposal_parent_id)->update([
            //         'is_amendment'=>1
            // ]);
            if($request->status == 'Cancel'){
                Proposal::where('id', $proposalData->proposal_parent_id)->update(['is_amendment' => 0]);
            }

            $previourCase = Cases::Completed()->with('casesDecision:cases_id,bond_value')->orderByDesc('id')->firstWhere('proposal_code',$proposalData->code);

            $casesData = $proposalData->cases()->create([
                'case_type'=>'Application',                   
                'beneficiary_id' => $proposalData->beneficiary_id,                   
                'contractor_id' => $proposalData->contractor_id,
                'proposal_code'=>$proposalData->code,                   
                'proposal_id' => $proposal_id,
                'proposal_parent_id'=>$proposalData->proposal_parent_id,
                'previous_bond_value'=>$previourCase->casesDecision->bond_value ?? 0,
                // 'underwriter_id'=>$underwriter_id,                   
                'tender_id' => $proposalData->tender_details_id,                   
                'bond_type_id' => $proposalData->bond_type,                   
                'bond_start_date' => $proposalData->bond_start_date,                   
                'bond_end_date' => $proposalData->bond_end_date,                   
                'bond_period' => $proposalData->bond_period,                   
                'bond_value' => $bondValue,                   
                'contract_value' => $proposalData->contract_value,
                'is_amendment'=>0                   
            ]);
            $proposalData->cases_id = $casesData->id;
            $proposalData->save();

            $proposalData->update([
                'status' => $request->status ?? null,
                'rejection_reason_id'=>$request->rejection_reason_id ?? null,
                'is_amendment' => $request->status == 'Cancel' ? 1 : 0,
            ]);

            $redirectUrl = '';
            if($casesData->id && $this->user->hasAnyAccess('users.superadmin', 'cases.list')){
                // $redirectUrl = route('cases.show',$casesData->id);
                return route('cases.index');
            } else {
                return route('proposals.show', [encryptId($proposalData->id)]);
            }
            // return $redirectUrl ; 
        }
    }

    // public function getRatingRemarks(Request $request)
    // {
    //     $agency_rating_id = $request->agency_rating_id;
    //     if($agency_rating_id){
    //          $agencyData = Rating::where('id',$agency_rating_id)->select('remarks')->first();
    //          return $agencyData;
    //     }
    // }

    public function pdfExport(Request $request, $id){
        $proposal = Proposal::findOrFail($id);
        $this->data['bondIssue'] = BondPoliciesIssue::where('proposal_id', $id)->where('status', 'Approved')->first();
        // dd($bondIssue);
        $this->data['nbi'] = $proposal->nbi->where('status', 'Approved')->first();
        $this->data['issuingOfficeBranch'] = $this->data['nbi']->issuingOfficeBranch;
        $this->data['proposal'] = $proposal;
        $this->data['bondIssueChecklist'] = BondPoliciesIssueChecklist::where('proposal_id', $id)->first();
        $settings = Setting::get();
        $this->data['settings'] = $settings;
        $logo_setting = $settings->where('name', 'print_logo')->first();
        $this->data['favicon'] = $this->getSettingVal($settings,'favicon');
        $this->data['print_logo'] = $this->getSettingVal($settings,'print_logo');
        $this->data['company_name'] = $this->getSettingVal($settings,'company_name');
        $this->data['company_address'] = $this->getSettingVal($settings,'company_address');
        $this->data['company_gst_no'] = $this->getSettingVal($settings,'gst_no');
        $this->data['subtitle'] = $this->getSettingVal($settings,'subtitle');
        $this->data['print_company_address_title'] = $this->getSettingVal($settings,'print_company_address_title');
        $this->data['print_company_address'] = $this->getSettingVal($settings,'print_company_address');
        $this->data['terms_conditions'] = $this->getSettingVal($settings,'terms_conditions');
        $this->data['issue_bond_note'] = $this->getSettingVal($settings,'issue_bond_note');
        $this->data['issue_bond_footer'] = $this->getSettingVal($settings,'issue_bond_footer');
        $this->data['issue_bond_declaration'] = $this->getSettingVal($settings,'issue_bond_declaration');
        $print_description = $this->getSettingVal($settings,'print_description');
        $this->data['print_description'] = ($print_description) ? json_decode($print_description) : [];
        // return view('nbi.pdf', $this->data);
        
        $pdf = PDF::loadView('proposals.issue_bond_pdf', $this->data);
        $pdf->setOrientation('portrait');
        $pdf->setOptions(['footer-right' => '[page] / [topage]']);
        $pdf->setOption('margin-right', 9);
        $pdf->setOption('margin-bottom', 10);
        $pdf->setOption('margin-left', 8);
        $pdf->setOption('title', __('bond_policies_issue.title').' | PDF');
        $pdf->stream();
        return $pdf->inline('issue_bond' . '.pdf');
    }
    function getSettingVal($settings,$field){
        $row = $settings->where('name', $field)->first();
        return $row->value ?? '';
    }

    public function getRatingDetails(Request $request)
    {
        $agency_id = $request->agency_id;
        if($agency_id){
            $agencyData = AgencyRating::where('agency_id',$agency_id)->pluck('rating', 'id')->toArray();
            // dd($agencyData->toArray());

            // $response = [
            //   'html' => view('principle.autofetch.contractor_agency_details',  $this->agencyData)->render(),
            // ];
            return $agencyData;
        }
    }

    public function getRatingRemarks(Request $request)
    {
        // dd($request->all());
        $select = [
            'agency_ratings.agency_id',
            'agency_ratings.rating',
            'agency_ratings.remarks',
            'agencies.agency_name',
            'agency_ratings.id as rating_id',
        ];
        $rating_id = $request->rating_id;
        if($rating_id){
            $ratingDetails = AgencyRating::where('agency_ratings.id', $rating_id)->select($select)
            ->leftJoin('agencies', function($join){
                $join->on('agency_ratings.agency_id', '=', 'agencies.id');
            })
            ->first();
            // dd($ratingDetails);
            $result = [
                'ratingDetails' => $ratingDetails,
            ];
            return $result;
        }
    }
    public function sendIntermediaryLatterForSign(IntermediaryLatterForSignRequest $request,LeegalityService $leegalityService){
        
        $proposal_id = $request->proposal_id;

        $proposal =  Proposal::firstWhere('id',$proposal_id);

        try {
            
             if ($request->indemnity_letter_type === 'Leegality') {
            

                $fields = [
                        'bond_policy_no'=>$seriesNumber ?? '',
                        'bond_type'=>$proposal->getBondType->name,
                        'bond_start_date'=>custom_date_format($proposal->bond_start_date,'d/m/Y'),
                        'bond_end_date'=>custom_date_format($proposal->bond_end_date,'d/m/Y'),
                        'bond_period'=>$proposal->bond_period,
                        'project_value'=>format_amount($proposal->project_value,0),
                        'contract_value'=>format_amount($proposal->contract_value,0),
                        'bond_value'=>format_amount($proposal->bond_value,0),
                        'project_description'=>$proposal->project_description ?? '',
                        'bond_issue_date'=>custom_date_format(now(),'d/m/Y'),
                        'insurer'=>$proposal->contractor_company_name ?? ''
                    ];

                    $leegalityService->setDocumentFieldJson($fields);

                    $document_response =  $leegalityService->sendDocumentForeSigning($proposal->contractor_company_name,$request->indemnity_signing_through,$proposal->contractor_email,$proposal->contractor_mobile);

                    if (!$document_response->json('status')) {

                        DB::rollback();

                        return redirect()->route('proposals.show', encryptId($request->proposal_id))->with('error', __('common.something_went_wrong_please_try_again'));
                        
                    }

                   $leegality_document_record_id =  $leegalityService->setLeegalityDocumentRecord($proposal->id,$proposal->contractor_id,$document_response->json('data'));

                   $proposal->update([
                        'leegality_document_id'=>$leegality_document_record_id ?? ''
                   ]);
                 

            }

            if ($request->indemnity_letter_type === 'Manually') {
                
                if ($request->hasFile('indemnity_letter_document')) {
                   $indemnity_letter_path = uploadFile($request,"indemnity_letter/{$proposal->code}/V{$proposal->version}/",'indemnity_letter_document');

                   $indemnity_letter_name = basename($indemnity_letter_path);

                    $proposal->dMS()->create([
                        'file_name' => $indemnity_letter_name,
                        'attachment' => $indemnity_letter_path,
                        'attachment_type' =>'indemnity_letter_document',
                    ]);

                }

            }

            DB::commit();

            return back()->with('success','');

        } catch (\Throwable $th) {

            DB::rollBack();
            return back()->with('error',__('common.something_went_wrong_please_try_again'));
        }

    }
}
