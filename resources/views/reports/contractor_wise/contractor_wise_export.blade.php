<table class="table" id="contractorWiseReport" style="width: 100% !important">
    <thead>
        <tr>
            <th>No.</th>
            @foreach ($fields as $key => $value)
                @if (in_array($value,$checkedFields))
                    <th>{{ $key }}</th>
                @endif
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if (isset($contractor_data))
            @foreach ($contractor_data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    @if(isset($checkedFields) && in_array('application_date', $checkedFields))
                    <td class="{{ in_array('application_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->application_date)  ? date('d/m/Y', strtotime($item->application_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('proposal_id', $checkedFields))
                    <td class="{{ in_array('proposal_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->proposal_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('contractor_id', $checkedFields))
                    <td class="{{ in_array('contractor_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contractor_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('contractor_name', $checkedFields))
                    <td class="{{ in_array('contractor_name', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contractor_name ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('contractor_pan_no', $checkedFields))
                    <td class="{{ in_array('contractor_pan_no', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contractor_pan_no ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('state', $checkedFields))
                    <td class="{{ in_array('state', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->state ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('country', $checkedFields))
                    <td class="{{ in_array('country', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->country ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('parent_group', $checkedFields))
                    <td class="{{ in_array('parent_group', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->parent_group ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('trade_sector', $checkedFields))
                    <td class="{{ in_array('trade_sector', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->trade_sector ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('principle_type', $checkedFields))
                    <td class="{{ in_array('principle_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->principle_type ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('contractor_rating', $checkedFields))
                    <td class="{{ in_array('contractor_rating', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contractor_rating ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('credit_rating_agency_and_grade', $checkedFields))
                    <td class="{{ in_array('credit_rating_agency_and_grade', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->credit_rating_agency_and_grade ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('re_insurance_grouping', $checkedFields))
                    <td class="{{ in_array('re_insurance_grouping', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->re_insurance_grouping ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('credit_insurance_exposure', $checkedFields))
                    <td class="{{ in_array('credit_insurance_exposure', $checkedFields) ? ' ' : 'd-none' }}">
                        0
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('cash_margin', $checkedFields))
                    <td class="{{ in_array('cash_margin', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->cash_margin ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('cash_margin_inr', $checkedFields))
                    <td class="{{ in_array('cash_margin_inr', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->cash_margin_inr ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('beneficiary_id', $checkedFields))
                    <td class="{{ in_array('beneficiary_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->beneficiary_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('beneficiary_name', $checkedFields))
                    <td class="{{ in_array('beneficiary_name', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->beneficiary_name ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('beneficiary_pan_no', $checkedFields))
                    <td class="{{ in_array('beneficiary_pan_no', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->beneficiary_pan_no ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_id', $checkedFields))
                    <td class="{{ in_array('project_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_title', $checkedFields))
                    <td class="{{ in_array('project_title', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_title ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_value', $checkedFields))
                    <td class="{{ in_array('project_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_start_date', $checkedFields))
                    <td class="{{ in_array('project_start_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->project_start_date)  ? date('d/m/Y', strtotime($item->project_start_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_end_date', $checkedFields))
                    <td class="{{ in_array('project_end_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->project_end_date)  ? date('d/m/Y', strtotime($item->project_end_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('tender_id', $checkedFields))
                    <td class="{{ in_array('tender_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->tender_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('tender_header', $checkedFields))
                    <td class="{{ in_array('tender_header', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->tender_header ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('contract_value', $checkedFields))
                    <td class="{{ in_array('contract_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contract_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_type', $checkedFields))
                    <td class="{{ in_array('bond_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_type ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_value', $checkedFields))
                    <td class="{{ in_array('bond_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_start_date', $checkedFields))
                    <td class="{{ in_array('bond_start_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->bond_start_date)  ? date('d/m/Y', strtotime($item->bond_start_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_end_date', $checkedFields))
                    <td class="{{ in_array('bond_end_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->bond_end_date)  ? date('d/m/Y', strtotime($item->bond_end_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('net_premium_paid', $checkedFields))
                    <td class="{{ in_array('net_premium_paid', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->net_premium_paid ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('gross_premium_paid', $checkedFields))
                    <td class="{{ in_array('gross_premium_paid', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->gross_premium_paid ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('premium_date', $checkedFields))
                    <td class="{{ in_array('premium_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->premium_date)  ? date('d/m/Y', strtotime($item->premium_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_number', $checkedFields))
                    <td class="{{ in_array('bond_number', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_number ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('insurer_bond_number', $checkedFields))
                    <td class="{{ in_array('insurer_bond_number', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->insurer_bond_number ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('status', $checkedFields))
                    <td class="{{ in_array('status', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->status ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('remarks', $checkedFields))
                    <td class="{{ in_array('remarks', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->remarks ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('application_date_two', $checkedFields))
                    <td class="{{ in_array('application_date_two', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->application_date)  ? date('d/m/Y', strtotime($item->application_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('decision_date', $checkedFields))
                    <td class="{{ in_array('decision_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->decision_date)  ? date('d/m/Y', strtotime($item->decision_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('decision_remarks', $checkedFields))
                    <td class="{{ in_array('decision_remarks', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->decision_remarks ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('individual_cap', $checkedFields))
                    <td class="{{ in_array('individual_cap', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->individual_cap ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('overall_cap', $checkedFields))
                    <td class="{{ in_array('overall_cap', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->overall_cap ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('group_cap', $checkedFields))
                    <td class="{{ in_array('group_cap', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->group_cap ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('total_approved_limit', $checkedFields))
                    <td class="{{ in_array('total_approved_limit', $checkedFields) ? ' ' : 'd-none' }}">
                        0
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('spare_capacity', $checkedFields))
                    <td class="{{ in_array('spare_capacity', $checkedFields) ? ' ' : 'd-none' }}">
                        0
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('last_review_date', $checkedFields))
                    <td class="{{ in_array('last_review_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->last_review_date)  ? date('d/m/Y', strtotime($item->last_review_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('regular_review_date', $checkedFields))
                    <td class="{{ in_array('regular_review_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->regular_review_date)  ? date('d/m/Y', strtotime($item->regular_review_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('balance_Sheet_date', $checkedFields))
                    <td class="{{ in_array('balance_Sheet_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->balance_Sheet_date)  ? date('d/m/Y', strtotime($item->balance_Sheet_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('assigned_underwriter_name', $checkedFields))
                    <td class="{{ in_array('assigned_underwriter_name', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->assigned_underwriter_name ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('any_adverse_information', $checkedFields))
                    <td class="{{ in_array('any_adverse_information', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->any_adverse_information ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('adverse_information_details', $checkedFields))
                    <td class="{{ in_array('adverse_information_details', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ strip_tags($item->adverse_information_details) ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('any_blacklisted_details', $checkedFields))
                    <td class="{{ in_array('any_blacklisted_details', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->any_blacklisted_details ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('blacklisted_details', $checkedFields))
                    <td class="{{ in_array('blacklisted_details', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ strip_tags($item->blacklisted_details) ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('expiring_bond', $checkedFields))
                    <td class="{{ in_array('expiring_bond', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->expiring_bond ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('expired_bond', $checkedFields))
                    <td class="{{ in_array('expired_bond', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->expired_bond ?? '-' }}
                    </td>
                    @endif
                    {{-- @if(isset($checkedFields) && in_array('total_premium_earnings', $checkedFields))
                    <td class="{{ in_array('total_premium_earnings', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->total_premium_earnings ?? '-' }}
                    </td>
                    @endif --}}
                </tr>
            @endforeach
        @endif

        @if($contractor_data->count() > 0)
            <tr>
                <td></td>
                @foreach ($checkedFields as $key => $value)
                    @if ($value == 'net_premium_paid')
                        <td class="min-width-200 text-right"><strong>Total</strong> : {{ $sum_net_premium ?? 0}}</td>
                    @elseif($value == 'gross_premium_paid')
                        <td class="min-width-200 text-right"><strong>Total</strong> : {{ $sum_gross_premium ?? 0}}</td>
                    @else
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endif
    </tbody>
</table>