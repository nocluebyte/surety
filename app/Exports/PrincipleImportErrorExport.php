<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PrincipleImportErrorExport implements FromView, ShouldAutoSize
{
    public function __construct($data){
        $this->data['excel_error'] = $data;
    }

    public function view(): View
    {
       return view('principle.export.principle_import_error_export', $this->data);
    }

    public function headings(): array
    {
        return [
            'registration_no',
            'company_name',
            'first_name',
            'middle_name',
            'last_name',
            'address',
            'website',
            'country',
            'state',
            'city',
            'pincode',
            'email',
            'gst_no',
            'pan_no',
            'date_of_incorporation',
            'principle_type',
            'mobile',
            'is_jv',
            'contractor',
            'share_holding',
            'trade_sector',
            'from',
            'till',
            'is_main',
            'contact_person',
            'contact_person_email',
            'contact_person_phone_no',
            'are_you_blacklisted',
            'banking_limits_category',
            'facility_type',
            'sanctioned_amount',
            'bank_name',
            'latest_limit_utilized',
            'unutilized_limit',
            'commission_on_pg',
            'commission_on_fg',
            'margin_collateral',
            'other_banking_details',
            'project_name',
            'project_cost',
            'project_description',
            'project_start_date',
            'project_end_date',
            'bank_guarantees_details',
            'actual_date_completion',
            'bg_amount',
            'obfp_project_name',
            'obfp_project_cost',
            'obfp_project_description',
            'obfp_project_start_date',
            'obfp_project_end_date',
            'obfp_bank_guarantees_details',
            'obfp_project_share',
            'obfp_guarantee_amount',
            'obfp_current_status',
            'designation',
            'name',
            'qualifications',
            'experience',
            'is_bank_guarantee_provided',
            'circumstance_short_notes',
            'is_action_against_proposer',
            'action_details',
            'contractor_failed_project_details',
            'completed_rectification_details',
            'performance_security_details',
            'relevant_other_information',
        ];
    }
}