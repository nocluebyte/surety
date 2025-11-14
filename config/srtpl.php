<?php

return [
    'month' => [
        '1' => 'January',
        '2' => 'February',
        '3' => 'March',
        '4' => 'April',
        '5' => 'May',
        '6' => 'June',
        '7' => 'July',
        '8' => 'August',
        '9' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ],
    'type' => [
        'equal' => '=',
        'not_equal' => '!=',
        'less_than' => '<',
        'greater_than' => '>',
        'less_equal' => '<=',
        'greater_equal' => '>=',
        'like' => 'like',
        'not_like' => 'not like',
    ],
    'pagination' => 25,

    'project_name' => "Nsure Surety",
    'page-width' => '75',
    'page-height' => '55',
    'margin-top' => '5',
    'margin-right' => '2',
    'margin-bottom' => '5',
    'margin-left' => '2',

    'pdf' => 'limitless.pdf',
    'gst_codes' => [
        '1' => "JAMMU AND KASHMIR",
        '2'  => 'HIMACHAL PRADESH',
        '3'  => 'PUNJAB',
        '4'  => 'CHANDIGARH',
        '5'  => 'UTTARAKHAND',
        '6'  => 'HARYANA',
        '7'  => 'DELHI',
        '8'  => 'RAJASTHAN',
        '9'  => 'UTTAR PRADESH',
        '10' => 'BIHAR',
        '11' => 'SIKKIM',
        '12' => 'ARUNACHAL PRADESH',
        '13' => 'NAGALAND',
        '14' => 'MANIPUR',
        '15' => 'MIZORAM',
        '16' => 'TRIPURA',
        '17' => 'MEGHLAYA',
        '18' => 'ASSAM',
        '19' => 'WEST BENGAL',
        '20' => 'JHARKHAND',
        '21' => 'ODISHA',
        '22' => 'CHHATTISGARH',
        '23' => 'MADHYA PRADESH',
        '24' => 'GUJARAT',
        '25' => 'DAMAN AND DIU',
        '26' => 'DADRA AND NAGAR HAVELI',
        '27' => 'MAHARASHTRA',
        '28' => 'ANDHRA PRADESH(BEFORE DIVISION)',
        '29' => 'KARNATAKA',
        '30' => 'GOA',
        '31' => 'LAKSHWADEEP',
        '32' => 'KERALA',
        '33' => 'TAMIL NADU',
        '34' => 'PUDUCHERRY',
        '35' => 'ANDAMAN AND NICOBAR ISLANDS',
        '36' => 'TELANGANA',
        '37' => 'ANDHRA PRADESH (NEW)',
        '38' => 'Ladakh',
        '97' => 'OTHER TERRITORY',
        '96' => 'OTHER COUNTRY'
    ],
    'report_per_page' => '2500',

    'sales_invoice_sales_types' => [
        'Sale' => 'Sale',
    ],

    'week_days' => [
        'Monday' => "Monday",
        'Tuesday' => "Tuesday",
        'Wednesday' => "Wednesday",
        'Thursday' => "Thursday",
        'Friday' => "Friday",
        'Saturday' => "Saturday",
        'Sunday' => "Sunday",
    ],

    'bg_color' => [
        'bg-primary-400', 'bg-danger-400', 'bg-success-400', 'bg-warning-400', 'bg-info-400', 'bg-pink-400',
        'bg-violet-400', 'bg-purple-400', 'bg-indigo-400', 'bg-blue-400', 'bg-teal-400', 'bg-green-400',
        'bg-orange-400', 'bg-orange-400', 'bg-brown-400', 'bg-grey-400', 'bg-slate-400'
    ],

    /* Check Points for QC is */
    'qc_input_types' => [
        // 'number' => "Number",
        // 'checkbox' => "Check Box",
        'text' => "Text Box",
        'select' => "Select"
    ],

    'currencies' => [
        // 'AUD' => 'Australian Dollar',
        'USD' => 'United States dollar',
        'EUR' => 'Euro',
        'GBP' => 'Pound sterling',
        'CAD' => 'Canadian dollar',
        'ZAR' => 'South African Rand',
        'AUD' => 'Australian Dollar',
        'AED' => 'United Arab Emirates Dirham',
        'INR' => 'Indian rupee'
    ],

    'variation' => [
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6',
        '7' => '7',
        '8' => '8',
        '9' => '9',
        '10' => '10',
        '11' => '11',
        '12' => '12',
        '13' => '13',
        '14' => '14',
        '15' => '15',
    ],

    'curr_symbols' => [
        'USD' => "$",
        'EUR' => "€",
        'GBP' => "£",
        "CAD" => "C$",
        "ZAR" => "R",
        'AUD' => "A$",
        'AED' => 'DH',
        "JPY" => "¥",
        "INR" => "₹"
    ],
    
    'curr_values' => [
        '' => ["Rupees", "Paise"],
        'INR' => ["Rupees", "Paise"],
        'USD' => ["Dollar", "Cents"],
        'EUR' => ["Euro", "Cents"],
        'GBP' => ["Pounds", "Pence"],
        'CAD' => ["Dollar", "Cents"],
        "ZAR" => ["Rands", "Cents"],
        'AUD' => ["Dollar", "Cents"],
        'AED' => ["Dirham", "Fils"],
    ],

    'document_type' => [
        'Application' => 'Application',
        'General' => 'General',
    ],

    'trade_sector' => [
        'high risk' => 'High Risk',
        'low risk' => 'Low Risk',
        'medium risk' => 'Medium Risk',
        'excluded sector' => 'Excluded Sector',
    ],

    'banking_limit_categories' => [
        'Fund Based' => 'Fund Based',
        'Non Fund Based' => 'Non Fund Based',
    ],

    'project_status' => [
        'On Time' => 'On Time',
        'Advance' => 'Advance',
        'Delayed' => 'Delayed',
    ],

    'current_status' => [
        'Pending' => 'Pending',
        'In progress' => 'In progress',
        'Completed' => 'Completed',
    ],

    'completion_status' => [
        'On Time' => 'On Time',
        'Advance' => 'Advance',
        'Delayed' => 'Delayed',
    ],

    'type_of_contracting' => [
        'Sub contracting' => 'Sub contracting',
        'Main contracting' => 'Main contracting',
    ],

    'mail_template'=>[
        'login_details' => 'Login Details',
        'sales_invoice'=>'Sales Invoice',
        'forgot_password'=>'Forgot Password',
        'open_query'=>'Open Query'
    ],
    'project_horizon' => [
        'Short term' => 'Short term',
        'Short and long-term' => 'Short and Long-term',
        'Long terms only' => 'Long terms only',
    ],
    'contractor_type' => [
        'Stand Alone' => 'Stand Alone',
        'JV' => 'JV',
        'SPV' => 'SPV',
    ],
    'group_type' => [
        'SUBS' => 'SUBS',
        'JV' => 'JV',
        'Other' => 'Other',
    ],

    'gst_tax_slab' => [
        '0' => '0%',
        '5' => '5%',
        '12' => '12%',
        '18' => '18%',
        '28' => '28%',
    ],

    'msme_types' => [
        'Micro' => 'Micro',
        'Small' => 'Small',
        'Medium' => 'Medium',
    ],

    'filters' => [
        'cases_filter' => [
            'case_type' => [
                'Application' => 'Application',
                'Review' => 'Review',
            ],

            'generated_from' => [
                'Beneficiary' => 'Beneficiary',
                'Principle' => 'Principle/Contractor',
                'PerformanceBond' => 'Performance Bond',
                'BidBond' => 'Bid Bond',
                'AdvancePaymentBond' => 'Advance Payment Bond',
                'RetentionBond' => 'Retention Bond',
                'MaintenanceBond' => 'Maintenance Bond',
            ],
        ],

        'bond_filter' => [
            'source' => [
                'Agent' => 'Agent',
                'Broker' => 'Broker',
                'Direct' => 'Direct',
            ],

            'beneficiary_type' => [
                'Public' => 'Public',
                'Private' => 'Private',
            ],

            'contractor_type' => [
                'Stand Alone' => 'Stand Alone',
                'JV' => 'JV',
                'SPV' => 'SPV',
            ],
        ],

        'underwriter_filter' => [
            'underwriter_type' => [
                'Risk Underwriter' => 'Risk Underwriter',
                'Commercial Underwriter' => 'Commercial Underwriter'
            ],

            'underwriter_status' => [
                'Yes' => 'Activated',
                'No' => 'Deactivated',
            ],
        ],            

        'issuing_office_branch_filter' => [
            'mode' => [
                'Cheque' => 'Cheque',
                'NEFT' => 'NEFT',
                'RTGS' => 'RTGS',
            ],
        ],

        'proposal_status_filter' => [
            'Pending' => 'Pending',
            'Approved' => 'Approved',
            'Rejected' => 'Rejected',
            'Confirm' => 'Confirm',
            'Cancel' => 'Cancel',
            'Issued' => 'Issued',
            'Cancelled' => 'Cancelled',
            'Forclosed' => 'Forclosed',
            'Invoked' => 'Invoked',
            'Terminated' => 'Terminated',
        ],

        'nbi_status_filter' => [
            'Approved' => 'Approved',
            'Rejected' => 'Rejected',
            'Cancelled' => 'Cancelled',
        ],

        'active_status' => [
            'Yes' => 'Active',
            'No' => 'Inactive',
        ],

        'beneficiary_type_filter' => [
            'Government' => 'Government',
            'Non-Government' => 'Non-Government',
        ],

        'bond_conditionality' => [
            'Conditional' => 'Conditional',
            'Unconditional' => 'Unconditional',
        ]
    ],

    'report_filter'=>[
        'bond_type_wise_report'=>[
            'status'=>[
                'Issued'=>'Issued', 
                'Cancelled'=>'Cancelled',
                'Foreclosed'=>'Foreclosed',
                'Invoked'=>'Invoked' 
            ]
        ]
    ],

    'claim_status' => [
        'On Hold' => 'On Hold',
        'Arbitration In Process' => 'Arbitration In Process',
        'Documentation Pending' => 'Documentation Pending',
        'Rejected' => 'Rejected',
        'Approved' => 'Approved',
        'Partially Approved' => 'Partially Approved',
    ],

    'sources' => [
        'Email' => 'Email',
        'News' => 'News',
    ],

    'users_form_role_except'=>[
        'Agent',
        'Broker',
        'Risk Underwriter',
        'Commercial Underwriter',
        'Employee', 
        'RM-Agent', 
        'RM-Broker', 
        'RM-Contractor', 
        'Contractor',
        'Beneficiary', 
        'Relationship Manager',
        'Claim Examiner',
        'RM-Beneficiary',
    ],

    'proposal_required_fields' => [
        // 'contract_type',
        // 'parent_group',
        // 'registration_no',
        'contractor_company_name',
        // 'register_address',
        'contractor_country_id',
        'contractor_state_id',
        'contractor_city',
        // 'contractor_pincode',
        // 'contractor_email',
        // 'contractor_same_as_above',
        // 'date_of_incorporation',
        // 'principle_type_id',
        // 'contractor_mobile',
        'contractor_entity_type_id',
        // 'contractor_inception_date',
        'beneficiary_id',
        // 'beneficiary_registration_no',
        'beneficiary_company_name',
        'beneficiary_address',
        'beneficiary_country_id',
        'beneficiary_state_id',
        'beneficiary_city',
        // 'beneficiary_pincode',
        // 'beneficiary_same_as_above',
        'establishment_type_id',
        // 'project_details',
        'pd_project_name',
        // 'pd_project_description',
        'pd_project_value',
        'pd_type_of_project',
        'pd_project_start_date',
        'pd_project_end_date',
        'pd_period_of_project',
        'tender_details_id',
        'tender_id',
        // 'tender_header',
        // 'tender_description',
        // 'location',
        'contract_value',
        'period_of_contract',
        'tender_bond_value',
        'bond_type_id',
        // 'type_of_contracting',
        // 'rfp_date',
        // 'project_description',
        'bond_type',
        'bond_start_date',
        'bond_end_date',
        'bond_period',
        'project_value',
        // 'bond_triggers',
        // 'bid_requirement',
        // 'main_obligation',
        // 'relevant_conditions',
        // 'bond_required',
        // 'bond_wording',
    ],

    'settings' => [
        'page_show_entries' => [
            '25',
            '50',
            '100',
            '250',
        ],
    ],
];
