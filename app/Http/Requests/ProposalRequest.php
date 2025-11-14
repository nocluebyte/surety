<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\{
    DMS,
    ProposalBankingLimits,
    OrderBookAndFutureProjects,
    ProjectTrackRecords,
    ManagementProfiles,
    Country,
};
use App\Rules\{
    AlphabetsV1,
    AlphabetsAndNumbersV3,
    AlphabetsAndNumbersV1,
    Numbers,
    PanNo,
    MobileNo,
    Remarks,
    GstNo,
    PinCode,
    DecimalV2,
    MultipleFile,
    AlphabetsAndNumbersV8,
    AlphabetsAndNumbersV9,
    PinCodeV2,
    AlphabetsAndNumbersV2,
    PercentageV1,
    ValidateExtensions,
};
use Illuminate\Support\Str;

class ProposalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function dmsAttachment($dmsItem) {
        $isUploaded = DMS::where('dmsable_id', $this->get('id'))->where('attachment_type', $dmsItem)->where('deleted_at', NULL)->pluck('attachment')->first();
        return $isUploaded;
    }

    public function repeaterDmsAttachment($dmsItem, $field) {
        $items_uploaded = [];
        $isManual = request()->is_manual_entry;
        $result4 = false;
        $i = 0;
        foreach ($this->$dmsItem as $item) {
            $itemId = array_shift($item);

            if ($isManual == 'No') {
                $result4 = false;
            } else if ($isManual == 'Yes' && $itemId != NULL) {
                $result4 = false;
            } else if ($isManual == 'Yes' && $itemId == NULL) {
                $result4 = true;
            }

            $items_uploaded[$i] = $result4;
            $i++;
        }

        return $items_uploaded;
    }

    // public function prepareForValidation() {
    //     // dd(request()->all());

    //     $isManual = request()->is_manual_entry;

    //     $finalDocList = [];

    //     if($this->dmsAttachment("proposal_attachment") != NULL && in_array($isManual, ['No', 'Yes'])){
    //         $result = false;
    //     } else if($this->dmsAttachment("proposal_attachment") == NULL && $isManual == 'Yes') {
    //         $result = false;
    //     } else {
    //         $result = true;
    //     }

    //     $finalDocList['proposal_attachment_uploaded'] = $result;

    //     $categoryOne = [
    //         'project_attachment',
    //         'feasibility_attachment',
    //     ];

    //     $radioOne = [
    //         'is_project_agreement',
    //         'is_feasibility_attachment',
    //     ];

    //     foreach ($categoryOne as $item1) {
    //         $attachmentExists = $this->dmsAttachment($item1) == NULL;
    //         $radioResponse = request()->input($radioOne[array_search($item1, $categoryOne)]);

    //         if (!$attachmentExists && in_array($radioResponse, ['No', 'Yes'])) {
    //             $result1 = false;
    //         } elseif ($attachmentExists && $radioResponse == 'Yes') {
    //             $result1 = true;
    //         } else {
    //             $result1 = false;
    //         }
    //         $finalDocList[$item1 . '_uploaded'] = $result1;
    //     }

    //     $categoryTwo = [
    //         'latest_sanction_attachment',
    //         'last_3_years_itr',
    //         'analysis_of_partner',
    //         'group_structure_diagram',
    //         'last_5_years_completed_projects_file',
    //     ];
    //     foreach($categoryTwo as $item2){
    //         if($this->dmsAttachment($item2) == NULL && $isManual == 'No'){
    //             $result2 = false;
    //         } else if ($this->dmsAttachment($item2) != NULL && $isManual == 'Yes') {
    //             $result2 = false;
    //         } else if ($this->dmsAttachment($item2) == NULL && $isManual == 'Yes') {
    //             $result2 = true;
    //         } else{
    //             $result2 = false;
    //         }
    //         $finalDocList[$item2 . '_uploaded'] = $result2;
    //     }

    //     $categoryThree = [
    //         'audited_financials_attachment',
    //         'latest_presentation_attachment',
    //         'rating_rationale_attachment',
    //     ];
    //     $radioTwo = [
    //         'audited_financials_public_domain',
    //         'latest_presentation_domain',
    //         'rating_rationale_domain',
    //     ];
    //     foreach ($categoryThree as $item3) {
    //         $attachmentExists = $this->dmsAttachment($item3) == NULL;
    //         $radioResponse = request()->input($radioTwo[array_search($item3, $categoryThree)]);
    //         $result3 = false;
    //         if (!$attachmentExists) {
    //             $result3 = false;
    //         } else if ($attachmentExists && $radioResponse == 'Yes') {
    //             $result3 = false;
    //         } else if ($attachmentExists && $isManual == 'Yes' && $radioResponse == 'No') {
    //             $result3 = true;
    //         }
    //         $finalDocList[$item3 . '_uploaded'] = $result3;
    //     }

    //     $pblItems = $this->repeaterDmsAttachment('pbl_items', 'proposal_banking_limits_attachment');
    //     $obfpItems = $this->repeaterDmsAttachment('obfp_items', 'order_book_and_future_projects_attachment');
    //     $ptrItems = $this->repeaterDmsAttachment('ptr_items', 'project_track_records_attachment');
    //     $mpItems = $this->repeaterDmsAttachment('mp_items', 'management_profiles_attachment');

    //     $this->merge($finalDocList);
    //     $this->merge([
    //         'uploaded_pbl_items' => $pblItems,
    //         'uploaded_obfp_items' => $obfpItems,
    //         'uploaded_ptr_items' => $ptrItems,
    //         'uploaded_mp_items' => $mpItems,
    //     ]);
    // }

    public function prepareForValidation(){
        // dd(request()->all());
        $contractor_country_id = request()->contractor_country_id;
        if($contractor_country_id) {
            $contractor_country_name = Str::lower(Country::select('name')->where('id', $contractor_country_id)->pluck('name')->first());
        }

        $contractor_bond_country_id = request()->contractor_bond_country_id;
        if($contractor_bond_country_id) {
            $contractor_bond_country_name = Str::lower(Country::select('name')->where('id', $contractor_bond_country_id)->pluck('name')->first());
        }

        $beneficiary_country_id = request()->beneficiary_country_id;
        if($beneficiary_country_id) {
            $beneficiary_country_name = Str::lower(Country::select('name')->where('id', $beneficiary_country_id)->pluck('name')->first());
        }

        $beneficiary_bond_country_id = request()->beneficiary_bond_country_id;
        if($beneficiary_bond_country_id) {
            $beneficiary_bond_country_name = Str::lower(Country::select('name')->where('id', $beneficiary_bond_country_id)->pluck('name')->first());
        }

        $this->merge([
            'contractor_country_name'=>$contractor_country_name ?? null,
            'contractor_bond_country_name' => $contractor_bond_country_name ?? null,
            'beneficiary_country_name' => $beneficiary_country_name ?? null,
            'beneficiary_bond_country_name' => $beneficiary_bond_country_name ?? null,
        ]);
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // dd(request()->all());
        $proposal_id = $this->get('id');

        $is_required = isset($proposal_id) ? "file|mimes:doc,png,jpg,jpeg,webp,pdf,docx,xlsx,txt,xml|max:2048" : "required_if:is_manual_entry,Yes|file|mimes:doc,png,jpg,jpeg,webp,pdf,docx,xlsx,txt,xml|max:2048|nullable";

        $validPincodeContractor = $this->contractor_country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];
        $validPincodeContractorBond = $this->contractor_bond_country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];
        $validPincodeBeneficiary = $this->beneficiary_country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];
        $validPincodeBeneficiaryBond = $this->beneficiary_bond_country_name === 'india' ? ['required', new PinCode] : ['nullable', new PinCodeV2];

        if(!isset(request()->is_autosave)){
            return [
                "contract_type" => "required", //*

                "spvContractorDetails.*.spv_share_holding" => ["required_if:contractor_type,SPV", new PercentageV1, "nullable"],
                // "spvContractorDetails.*.spv_exposure" => ["required_if:contractor_type,SPV", new Numbers, "nullable"],
                // "spvContractorDetails.*.spv_assign_exposure" => ["required_if:contractor_type,SPV", new Numbers, "lte:100", "gt:0", "nullable"],
                // "spvContractorDetails.*.spv_overall_cap" => ["required_if:contractor_type,SPV", new Numbers, "nullable"],
                // "spvContractorDetails.*.spv_consumed" => ["required_if:contractor_type,SPV", new Numbers, "nullable"],
                // "spvContractorDetails.*.spv_spare_capacity" => ["required_if:contractor_type,SPV", new Numbers, "nullable"],
                // "spvContractorDetails.*.spv_remaining_cap" => ["required_if:contractor_type,SPV", new Numbers, "nullable"],

                "contractor_id" => "required_if:contractor_type,Stand Alone", //*
                "pan_no" => "nullable", //*

                "jvContractorDetails.*.jv_share_holding" => ["required_if:contractor_type,JV", new PercentageV1, "nullable"],
                // "jvContractorDetails.*.jv_exposure" => ["required_if:contractor_type,JV", new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_assign_exposure" => ["required_if:contractor_type,JV", new Numbers, "lte:100", "gt:0", "nullable"],
                // "jvContractorDetails.*.jv_overall_cap" => ["required_if:contractor_type,JV", new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_consumed" => ["required_if:contractor_type,JV", new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_spare_capacity" => ["required_if:contractor_type,JV", new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_remaining_cap" => ["required_if:contractor_type,JV", new Numbers, "nullable"],

                "register_address" => ["required", new AlphabetsAndNumbersV3], //*
                "parent_group" => ["required", new AlphabetsAndNumbersV8], //*
                "date_of_incorporation" => "required", //*
                "registration_no" => ["required_if:contract_type,Stand Alone", new AlphabetsAndNumbersV2, "nullable"],
                "contractor_company_name" => ["required", new AlphabetsAndNumbersV8],
                "contractor_website" => "nullable",
                "contractor_country_id" => "required",
                "contractor_state_id" => "required",
                "contractor_city" => ["required", new AlphabetsV1],
                "contractor_pincode" => $validPincodeContractor,
                "contractor_gst_no" => ["required_if:contract_type,Stand Alone", new GstNo, "nullable"],
                "contractor_pan_no" => ["nullable", new PanNo],
                "contractor_email" => "required",
                "contractor_mobile" => ["required", new MobileNo],
                "contractor_bond_country_id" => "required",
                "contractor_bond_state_id" => "required",
                "contractor_bond_city" => ["required", new AlphabetsV1],
                "contractor_bond_pincode" => $validPincodeContractorBond,
                "contractor_bond_gst_no" => ["required_if:contract_type,Stand Alone", new GstNo, "nullable"],
                "contractor_bond_address" => ["required", new AlphabetsAndNumbersV3],
                "principle_type_id" => "required",
                "are_you_blacklisted" => "nullable",
                "contractor_entity_type_id" => "required",
                // "contractor_inception_date" => "required",
                "contractor_staff_strength" => "nullable",

                "tradeSector.*.contractor_trade_sector" => "required",
                "tradeSector.*.contractor_from" => "required|date|before_or_equal:today",
                "tradeSector.*.contractor_till" => "nullable|date|after_or_equal:tradeSector.*.from",

                "contactDetail.*.contact_person" => ["nullable", new AlphabetsV1],
                "contactDetail.*.email" => "nullable|email",
                "contactDetail.*.phone_no" => ["nullable", new MobileNo],

                "company_details.*" => [
                    "nullable",
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls",
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_technical_details.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5), 
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_presentation.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5), 
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "certificate_of_incorporation.*" => [
                    "required_if:id,NULL", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "memorandum_and_articles.*" => [
                    "required_if:id,NULL", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "gst_certificate.*" => [
                    "required_if:contract_type,Stand Alone", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5), 
                    "nullable",
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_pan_no.*" => [
                    "required_if:contract_type,Stand Alone", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5), 
                    "nullable",
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "last_three_years_itr.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                "attachment_count.company_details_count" => "lte:5",
                "attachment_count.company_technical_details_count" => "lte:5",
                "attachment_count.company_presentation_count" => "lte:5",
                "attachment_count.certificate_of_incorporation_count" => "lte:5|not_in:0",
                "attachment_count.memorandum_and_articles_count" => "lte:5|not_in:0",
                "attachment_count.gst_certificate_count" => "lte:5",
                "attachment_count.company_pan_no_count" => "lte:5",
                "attachment_count.last_three_years_itr_count" => "lte:5",

                // Tender Details

                "tender_details_id" => "required",
                "tender_id" => "required", //*
                "tender_header" => ["required", new AlphabetsAndNumbersV8],
                "contract_value" => ["required", new Numbers],
                "period_of_contract" => "required",
                "location" => ["required", new AlphabetsV1],
                "project_type" => "nullable",
                "tender_bond_value" => ["required", new Numbers],
                "bond_type_id" => "required",
                "rfp_date" => "required",
                "type_of_contracting" => "required",
                "tender_description" => "required",
                "project_description" => "required",
                "project_details" => "required",
                "pd_beneficiary" => "required",
                "pd_project_name" => ["required", new AlphabetsAndNumbersV8],
                "pd_project_description" => ["required", new Remarks],
                "pd_project_value" => ["required", new Numbers],
                "pd_type_of_project" => "required",
                "pd_project_start_date" => "required",
                "pd_project_end_date" => "required",
                "pd_period_of_project" => "required",

                // Beneficiary Details

                "beneficiary_id" => "required",   //*
                "beneficiary_registration_no" => "required",
                "beneficiary_company_name" => ["required", new AlphabetsAndNumbersV8],
                "beneficiary_email" => "nullable",
                "beneficiary_phone_no" => ["nullable", new MobileNo],
                "beneficiary_address" => ["required", new AlphabetsAndNumbersV3], //*
                "beneficiary_website" => "nullable",
                "beneficiary_country_id" => "required",
                "beneficiary_state_id" => "nullable",
                "beneficiary_city" => ["required", new AlphabetsV1],
                "beneficiary_pincode" => $validPincodeBeneficiary,
                "beneficiary_gst_no" => ["nullable", new GstNo],
                "beneficiary_pan_no" => ["nullable", new PanNo],
                "beneficiary_bond_address" => ["required", new AlphabetsAndNumbersV3],
                "beneficiary_bond_country_id" => "required",
                "beneficiary_bond_state_id" => "nullable",
                "beneficiary_bond_city" => ["required", new AlphabetsV1],
                "beneficiary_bond_pincode" => $validPincodeBeneficiaryBond,
                "beneficiary_type" => "required", //*
                "establishment_type_id" => "required",
                "beneficiary_bond_gst_no" => ["nullable", new GstNo],
                "ministry_type_id" => "nullable",
                "beneficiary_bond_wording" => ["nullable", new AlphabetsAndNumbersV3],
                "beneficiaryTradeSector.*.beneficiary_trade_sector_id" => "nullable",
                "beneficiaryTradeSector.*.beneficiary_from" => "nullable|date|before_or_equal:today",
                "beneficiaryTradeSector.*.beneficiary_till" => "nullable|date|after_or_equal:tradeSector.*.from",

                // Bond Details

                "bond_type" => "required",
                "bond_start_date" => "required", //*
                "bond_end_date" => "required", //*
                "bond_period" => "required", //*
                "project_value" => ["required", new Numbers],
                "bond_value" => ["required", new Numbers], //*
                "bond_triggers" => "required",
                "bid_requirement" => "required", //*
                "main_obligation" => ["required", new Remarks],
                "relevant_conditions" => ["required", new Remarks], //*
                "bond_period_description" => ["nullable", new Remarks],
                "bond_required" => "required",
                "bond_wording" => ["required", new Remarks],
                "bond_collateral" => ["nullable", new Remarks],
                "distribution" => ["nullable", new Remarks],

                // Additional Details for Assessment

                "is_bank_guarantee_provided" => "nullable", //*
                "circumstance_short_notes" => ["nullable", new AlphabetsAndNumbersV3], //*
                "is_action_against_proposer" => "nullable", //*
                "action_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "contractor_failed_project_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "completed_rectification_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "performance_security_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "relevant_other_information" => ["nullable", new AlphabetsAndNumbersV3], //*

                // Proposal Banking Limits

                "pbl_items.*.banking_category_id" => "nullable",
                "pbl_items.*.facility_type_id" => "nullable",
                "pbl_items.*.sanctioned_amount" => ["nullable", new Numbers],
                "pbl_items.*.bank_name" => ["nullable", new AlphabetsV1],
                "pbl_items.*.latest_limit_utilized" => ["nullable", new Numbers],
                "pbl_items.*.unutilized_limit" => ["nullable", new Numbers],
                "pbl_items.*.commission_on_pg" => ["nullable", new Numbers],
                "pbl_items.*.commission_on_fg" => ["nullable", new Numbers],
                "pbl_items.*.margin_collateral" => ["nullable", new Numbers],
                "pbl_items.*.other_banking_details" => ["nullable", new AlphabetsAndNumbersV3],
                "pbl_items.*.banking_limits_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Order Book and Future Projects

                "obfp_items.*.project_name" => ["nullable", new AlphabetsAndNumbersV8],
                "obfp_items.*.project_cost" => ["nullable", new Numbers],
                "obfp_items.*.project_description" => ["nullable", new Remarks],
                "obfp_items.*.project_start_date" => "nullable",
                "obfp_items.*.project_end_date" => "nullable",
                "obfp_items.*.project_tenor" => ["nullable", new Numbers],
                "obfp_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
                "obfp_items.*.project_share" => ["nullable", new Numbers],
                "obfp_items.*.guarantee_amount" => ["nullable", new Numbers],
                "obfp_items.*.current_status" => "nullable",
                "obfp_items.*.order_book_and_future_projects_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Project Track Records

                "ptr_items.*.project_name" => ["nullable", new AlphabetsAndNumbersV8],
                "ptr_items.*.project_cost" => ["nullable", new Numbers],
                "ptr_items.*.project_description" => ["nullable", new Remarks],
                "ptr_items.*.project_start_date" => "nullable",
                "ptr_items.*.project_end_date" => "nullable",
                "ptr_items.*.project_tenor" => ["nullable", new Numbers],
                "ptr_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
                "ptr_items.*.actual_date_completion" => "nullable",
                "ptr_items.*.bg_amount" => ["nullable", new Numbers],
                "ptr_items.*.project_track_records_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Management Profiles

                "mp_items.*.designation" => "nullable",
                "mp_items.*.name" =>["nullable", new AlphabetsV1],
                "mp_items.*.qualifications" => ["nullable", new AlphabetsAndNumbersV9],
                "mp_items.*.experience" => ["nullable", new DecimalV2],
                "mp_items.*.management_profiles_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
            ];
        } else {
            return [
                "contract_type" => "nullable", //*

                "spvContractorDetails.*.spv_share_holding" => ["nullable", new PercentageV1],
                // "spvContractorDetails.*.spv_exposure" => ["nullable", new Numbers],
                // "spvContractorDetails.*.spv_assign_exposure" => ["nullable", new Numbers, "lte:100", "gt:0"],
                // "spvContractorDetails.*.spv_overall_cap" => ["nullable", new Numbers],
                // "spvContractorDetails.*.spv_consumed" => ["nullable", new Numbers],
                // "spvContractorDetails.*.spv_spare_capacity" => ["nullable", new Numbers],
                // "spvContractorDetails.*.spv_remaining_cap" => ["nullable", new Numbers],

                "contractor_id" => "nullable", //*
                "pan_no" => "nullable", //*

                "jvContractorDetails.*.jv_share_holding" => [new PercentageV1, "nullable"],
                // "jvContractorDetails.*.jv_exposure" => [new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_assign_exposure" => [new Numbers, "lte:100", "gt:0", "nullable"],
                // "jvContractorDetails.*.jv_overall_cap" => [new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_consumed" => [new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_spare_capacity" => [new Numbers, "nullable"],
                // "jvContractorDetails.*.jv_remaining_cap" => [new Numbers, "nullable"],

                "register_address" => ["nullable", new AlphabetsAndNumbersV3], //*
                "parent_group" => ["nullable", new AlphabetsAndNumbersV8], //*
                "date_of_incorporation" => "nullable", //*
                "registration_no" => ["nullable", new AlphabetsAndNumbersV2],
                "contractor_company_name" => ["nullable", new AlphabetsAndNumbersV8],
                "contractor_website" => "nullable",
                "contractor_country_id" => "nullable",
                "contractor_state_id" => "nullable",
                "contractor_city" => ["nullable", new AlphabetsV1],
                "contractor_pincode" => $validPincodeContractor,
                "contractor_gst_no" => ["nullable", new GstNo],
                "contractor_pan_no" => ["nullable", new PanNo],
                "contractor_email" => "nullable",
                "contractor_mobile" => ["nullable", new MobileNo],
                "contractor_bond_country_id" => "nullable",
                "contractor_bond_state_id" => "nullable",
                "contractor_bond_city" => ["nullable", new AlphabetsV1],
                "contractor_bond_pincode" => $validPincodeContractorBond,
                "contractor_bond_gst_no" => ["nullable", new GstNo],
                "contractor_bond_address" => ["nullable", new AlphabetsAndNumbersV3],
                "principle_type_id" => "nullable",
                "are_you_blacklisted" => "nullable",
                "contractor_entity_type_id" => "nullable",
                // "contractor_inception_date" => "nullable",
                "contractor_staff_strength" => "nullable",

                "tradeSector.*.contractor_trade_sector" => "nullable",
                "tradeSector.*.contractor_from" => "nullable|date|before_or_equal:today",
                "tradeSector.*.contractor_till" => "nullable|date|after_or_equal:tradeSector.*.from",

                "contactDetail.*.contact_person" => ["nullable", new AlphabetsV1],
                "contactDetail.*.email" => "nullable|email",
                "contactDetail.*.phone_no" => ["nullable", new MobileNo],

                "company_details.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_technical_details.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_presentation.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "certificate_of_incorporation.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "memorandum_and_articles.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "gst_certificate.*" => [
                    "nullable", 
                    "file", 
                    "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "company_pan_no.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
                "last_three_years_itr.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                "attachment_count.company_details_count" => "lte:5",
                "attachment_count.company_technical_details_count" => "lte:5",
                "attachment_count.company_presentation_count" => "lte:5",
                "attachment_count.certificate_of_incorporation_count" => "lte:5|not_in:0",
                "attachment_count.memorandum_and_articles_count" => "lte:5|not_in:0",
                "attachment_count.gst_certificate_count" => "lte:5",
                "attachment_count.company_pan_no_count" => "lte:5",
                "attachment_count.last_three_years_itr_count" => "lte:5",

                // Tender Details

                "tender_details_id" => "nullable",
                "tender_id" => "nullable", //*
                "tender_header" => ["nullable", new AlphabetsAndNumbersV8],
                "contract_value" => ["nullable", new Numbers],
                "period_of_contract" => "nullable",
                "location" => ["nullable", new AlphabetsV1],
                "project_type" => "nullable",
                "tender_bond_value" => ["nullable", new Numbers],
                "bond_type_id" => "nullable",
                "rfp_date" => "nullable",
                "type_of_contracting" => "nullable",
                "tender_description" => "nullable",
                "project_description" => "nullable",
                "project_details" => "nullable",
                "pd_beneficiary" => "nullable",
                "pd_project_name" => ["nullable", new AlphabetsAndNumbersV8],
                "pd_project_description" => ["nullable", new Remarks],
                "pd_project_value" => ["nullable", new Numbers],
                "pd_type_of_project" => "nullable",
                "pd_project_start_date" => "nullable",
                "pd_project_end_date" => "nullable",
                "pd_period_of_project" => "nullable",

                // Beneficiary Details

                "beneficiary_id" => "nullable",   //*
                "beneficiary_registration_no" => "nullable",
                "beneficiary_company_name" => ["nullable", new AlphabetsAndNumbersV8],
                "beneficiary_email" => "nullable",
                "beneficiary_phone_no" => ["nullable", new MobileNo],
                "beneficiary_address" => ["nullable", new AlphabetsAndNumbersV3], //*
                "beneficiary_website" => "nullable",
                "beneficiary_country_id" => "nullable",
                "beneficiary_state_id" => "nullable",
                "beneficiary_city" => ["nullable", new AlphabetsV1],
                "beneficiary_pincode" => $validPincodeBeneficiary,
                "beneficiary_gst_no" => ["nullable", new GstNo],
                "beneficiary_pan_no" => ["nullable", new PanNo],
                "beneficiary_bond_address" => ["nullable", new AlphabetsAndNumbersV3],
                "beneficiary_bond_country_id" => "nullable",
                "beneficiary_bond_state_id" => "nullable",
                "beneficiary_bond_city" => ["nullable", new AlphabetsV1],
                "beneficiary_bond_pincode" => $validPincodeBeneficiaryBond,
                "beneficiary_type" => "nullable", //*
                "establishment_type_id" => "nullable",
                "beneficiary_bond_gst_no" => ["nullable", new GstNo],
                "ministry_type_id" => "nullable",
                "beneficiary_bond_wording" => ["nullable", new AlphabetsAndNumbersV3],
                "beneficiaryTradeSector.*.beneficiary_trade_sector_id" => "nullable",
                "beneficiaryTradeSector.*.beneficiary_from" => "nullable|date|before_or_equal:today",
                "beneficiaryTradeSector.*.beneficiary_till" => "nullable|date|after_or_equal:tradeSector.*.from",

                // Bond Details

                "bond_type" => "nullable",
                "bond_start_date" => "nullable", //*
                "bond_end_date" => "nullable", //*
                "bond_period" => "nullable", //*
                "project_value" => ["nullable", new Numbers],
                "bond_value" => ["nullable", new Numbers], //*
                "bond_triggers" => "nullable",
                "bid_requirement" => "nullable", //*
                "main_obligation" => ["nullable", new Remarks],
                "relevant_conditions" => ["nullable", new Remarks], //*
                "bond_period_description" => ["nullable", new Remarks],
                "bond_required" => "nullable",
                "bond_wording" => ["nullable", new Remarks],
                "bond_collateral" => ["nullable", new Remarks],
                "distribution" => ["nullable", new Remarks],

                // Additional Details for Assessment

                "is_bank_guarantee_provided" => "nullable", //*
                "circumstance_short_notes" => ["nullable", new AlphabetsAndNumbersV3], //*
                "is_action_against_proposer" => "nullable", //*
                "action_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "contractor_failed_project_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "completed_rectification_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "performance_security_details" => ["nullable", new AlphabetsAndNumbersV3], //*
                "relevant_other_information" => ["nullable", new AlphabetsAndNumbersV3], //*

                // Proposal Banking Limits

                "pbl_items.*.banking_category_id" => "nullable",
                "pbl_items.*.facility_type_id" => "nullable",
                "pbl_items.*.sanctioned_amount" => ["nullable", new Numbers],
                "pbl_items.*.bank_name" => ["nullable", new AlphabetsV1],
                "pbl_items.*.latest_limit_utilized" => ["nullable", new Numbers],
                "pbl_items.*.unutilized_limit" => ["nullable", new Numbers],
                "pbl_items.*.commission_on_pg" => ["nullable", new Numbers],
                "pbl_items.*.commission_on_fg" => ["nullable", new Numbers],
                "pbl_items.*.margin_collateral" => ["nullable", new Numbers],
                "pbl_items.*.other_banking_details" => ["nullable", new AlphabetsAndNumbersV3],
                "pbl_items.*.banking_limits_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Order Book and Future Projects

                "obfp_items.*.project_name" => ["nullable", new AlphabetsAndNumbersV8],
                "obfp_items.*.project_cost" => ["nullable", new Numbers],
                "obfp_items.*.project_description" => ["nullable", new Remarks],
                "obfp_items.*.project_start_date" => "nullable",
                "obfp_items.*.project_end_date" => "nullable",
                "obfp_items.*.project_tenor" => ["nullable", new Numbers],
                "obfp_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
                "obfp_items.*.project_share" => ["nullable", new Numbers],
                "obfp_items.*.guarantee_amount" => ["nullable", new Numbers],
                "obfp_items.*.current_status" => "nullable",
                "obfp_items.*.order_book_and_future_projects_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Project Track Records

                "ptr_items.*.project_name" => ["nullable", new AlphabetsAndNumbersV8],
                "ptr_items.*.project_cost" => ["nullable", new Numbers],
                "ptr_items.*.project_description" => ["nullable", new Remarks],
                "ptr_items.*.project_start_date" => "nullable",
                "ptr_items.*.project_end_date" => "nullable",
                "ptr_items.*.project_tenor" => ["nullable", new Numbers],
                "ptr_items.*.bank_guarantees_details" => ["nullable", new AlphabetsAndNumbersV3],
                "ptr_items.*.actual_date_completion" => "nullable",
                "ptr_items.*.bg_amount" => ["nullable", new Numbers],
                "ptr_items.*.project_track_records_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],

                // Management Profiles

                "mp_items.*.designation" => "nullable",
                "mp_items.*.name" =>["nullable", new AlphabetsV1],
                "mp_items.*.qualifications" => ["nullable", new AlphabetsAndNumbersV9],
                "mp_items.*.experience" => ["nullable", new DecimalV2],
                "mp_items.*.management_profiles_attachment.*" => [
                    "nullable", 
                    "file", "mimes:doc,png,jpg,jpeg,pdf,docx,xlsx,xls", 
                    new MultipleFile(52428800, 5),
                    new ValidateExtensions(['doc', 'png', 'jpg', 'jpeg', 'pdf', 'docx', 'xlsx', 'xls']),
                ],
            ];
        }
    }

    public function messages(): array
    {
        return[
            "bond_start_date.after_or_equal" => "Bond Start Date must be greater than or equal to Bond Issued Date",
            "bond_end_date.after_or_equal" => "Bond End Date must be greater than or equal to Bond Start Date",

            "attachment_count.company_details_count.lte" => "The number of files for Company Details must not exceed (5)",
            "attachment_count.company_technical_details_count.lte" => "The number of files for Company Technical Details must not exceed (5)",
            "attachment_count.company_presentation_count.lte" => "The number of files for Company Presentation must not exceed (5)",
            "attachment_count.certificate_of_incorporation_count.lte" => "The number of files for Certificate of Incorporation must not exceed (5)",
            "attachment_count.memorandum_and_articles_count.lte" => "The number of files for Memorandum and Articles must not exceed (5)",
            "attachment_count.gst_certificate_count.lte" => "The number of files for GST Certificate must not exceed (5)",
            "attachment_count.company_pan_no_count.lte" => "The number of files for Company PAN No must not exceed (5)",
            "attachment_count.last_three_years_itr_count.lte" => "The number of files for Last 3 years ITR must not exceed (5)",

            "attachment_count.certificate_of_incorporation_count.not_in" => "Certificate of Incorporation field is required.",
            "attachment_count.memorandum_and_articles_count.not_in" => "Memorandum and Articles field is required.",
            "attachment_count.gst_certificate_count.not_in" => "GST Certificate field is required.",
            "attachment_count.company_pan_no_count.not_in" => "Company PAN No file upload field is required.",

            // Proposal Banking Limits

            "pbl_items.*.banking_category_id" => "Banking Limits -> Banking Category required",
            "pbl_items.*.facility_type_id" => "Banking Limits -> Facility Type required",
            "pbl_items.*.sanctioned_amount.required" => "Banking Limits -> Sanctioned Amount required",
            "pbl_items.*.bank_name.required" => "Banking Limits -> Bank Name required",
            "pbl_items.*.latest_limit_utilized.required" => "Banking Limits -> Latest Limit Utilized required",
            "pbl_items.*.unutilized_limit.required" => "Banking Limits -> Unutilized Limit required",
            // "pbl_items.*.commission_on_pg" => "Banking Limits -> Commission on PG required",
            // "pbl_items.*.commission_on_fg" => "Banking Limits -> Commission on FG required",
            "pbl_items.*.margin_collateral.required" => "Banking Limits -> Margin Collateral required",
            // "pbl_items.*.proposal_banking_limits_attachment.required" => "Proposal Banking Limits Attachment required when 'Is Manual' is Yes",

            // Order Book and Future Projects

            // "obfp_items.*.project_scope" => "Order Book and Future Projects -> Project Scope required",
            // "obfp_items.*.principal_name" => "Order Book and Future Projects -> Principal Name required",
            // "obfp_items.*.project_location" => "Order Book and Future Projects -> Project Location required",
            // "obfp_items.*.type_of_project" => "Order Book and Future Projects -> Project Type required",
            // "obfp_items.*.contract_value" => "Order Book and Future Projects -> Contract Value required",
            // "obfp_items.*.anticipated_date" => "Order Book and Future Projects -> Anticipated Date required",
            // "obfp_items.*.tenure" => "Order Book and Future Projects -> Tenure required",
            // "obfp_items.*.project_share" => "Order Book and Future Projects -> Project Share required",
            // "obfp_items.*.guarantee_amount" => "Order Book and Future Projects -> Guarantee Amount required",
            // "obfp_items.*.current_status" => "Order Book and Future Projects -> Current Status required",
            // "obfp_items.*.order_book_and_future_projects_attachment" => "Order Book and Future Projects Attachment required when 'Is Manual' is Yes",

            // Project Track Records

            // "ptr_items.*.project_name" => "Project Track Records -> Project Name required",
            // "ptr_items.*.description" => "Project Track Records -> Description required",
            // "ptr_items.*.project_cost" => "Project Track Records -> Project Cost required",
            // "ptr_items.*.project_tenor" => "Project Track Records -> Project Tenor required",
            // "ptr_items.*.project_start_date" => "Project Track Records -> Project Start Date required",
            // "ptr_items.*.principal_name" => "Project Track Records -> Principal Name required",
            // "ptr_items.*.estimated_date_of_completion" => "Project Track Records -> Estimated Date of Completion required",
            // "ptr_items.*.estimated_date_of_completion.after" => "Project Track Records -> Estimated Date of Completion must be greater than Project Start Date",
            // "ptr_items.*.type_of_project_track" => "Project Track Records -> Type of Project Track required",
            // "ptr_items.*.project_share_track" => "Project Track Records -> Project Share Track required",
            // "ptr_items.*.actual_date_completion" => "Project Track Records -> Actual Date of Completion required",
            // "ptr_items.*.actual_date_completion.after" => "Project Track Records -> Actual Date of Completion must be greater than Project Start Date",
            // "ptr_items.*.amount_margin" => "Project Track Records -> Amount of Margin required",
            // "ptr_items.*.completion_status" => "Project Track Records -> Completion Status required",
            // "ptr_items.*.bg_amount" => "Project Track Records -> Amount of BG Invoked required",
            // "ptr_items.*.project_track_records_attachment" => "Project Track Records Attachment required when 'Is Manual' is Yes",

            // Management Profiles

            // "mp_items.*.designation" => "Management Profiles -> Designation required",
            // "mp_items.*.name" => "Management Profiles -> Name required",
            // "mp_items.*.qualifications" => "Management Profiles -> Qualifications required",
            // "mp_items.*.experience" => "Management Profiles -> Experience required",
            // "bond_start_date" => "Bond start date required",
            // "bond_end_date" => "Bond end date required",
            // "mp_items.*.management_profiles_attachment" => "Management Profiles Attachment required when 'Is Manual' is Yes",

            // JV, SPV, Stand Alone

            "spvContractorDetails.*.spv_exposure" => "SPV Exposure required when Contractor Type is SPV",
            "spvContractorDetails.*.spv_assign_exposure" => "Assign Exposure required when Contractor Type is SPV",
            "spvContractorDetails.*.spv_overall_cap" => "Overall Cap required when Contractor Type is SPV",
            "spvContractorDetails.*.spv_consumed" => "SPV Consumed required when Contractor Type is SPV",
            "spvContractorDetails.*.spv_spare_capacity" => "Spare Capacity required when Contractor Type is SPV",
            "spvContractorDetails.*.spv_remaining_cap" => "Remaining Cap required when Contractor Type is SPV",

            "jvContractorDetails.*.jv_exposure" => "JV Exposure required when Contractor Type is JV",
            "jvContractorDetails.*.jv_assign_exposure" => "Assign Exposure required when Contractor Type is JV",
            "jvContractorDetails.*.jv_overall_cap" => "Overall Cap required when Contractor Type is JV",
            "jvContractorDetails.*.jv_consumed" => "SPV Consumed required when Contractor Type is JV",
            "jvContractorDetails.*.jv_spare_capacity" => "Spare Capacity required when Contractor Type is JV",
            "jvContractorDetails.*.jv_remaining_cap" => "Remaining Cap required when Contractor Type is JV",
        ];
    }
}
