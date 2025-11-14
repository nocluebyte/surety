@foreach ($contractor_wise_data as $iteration)

<tr>
    <td>{{ ($contractor_wise_data->currentPage() - 1) * $contractor_wise_data->perPage() + $loop->iteration }}</td>
    @if (in_array('application_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->application_date) ? custom_date_format($iteration->application_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('proposal_id',$checked_fields))
        <td class="min-width-100">{{ isset($iteration->proposal_id) ? $iteration->proposal_id . '/V' . $iteration->version : '-' }}</td>
    @endif
    @if (in_array('contractor_id',$checked_fields))
        <td class="min-width-100">{{ $iteration->contractor_id ?? '-' }}</td>
    @endif
    @if (in_array('contractor_name',$checked_fields))
        <td class="min-width-300">{{ $iteration->contractor_name ?? '-' }}</td>
    @endif
    @if (in_array('contractor_pan_no',$checked_fields))
        <td class="min-width-150">{{ $iteration->contractor_pan_no ?? '-' }}</td>
    @endif
    @if (in_array('state',$checked_fields))
        <td class="min-width-100">{{ $iteration->state ?? '-' }}</td>
    @endif
    @if (in_array('country',$checked_fields))
        <td class="min-width-100">{{ $iteration->country ?? '-' }}</td>
    @endif
    @if (in_array('parent_group',$checked_fields))
        <td class="min-width-300">{{ $iteration->parent_group ?? '-' }}</td>
    @endif
    @if (in_array('trade_sector',$checked_fields))
        <td class="min-width-150">{{ $iteration->trade_sector ?? '-' }}</td>
    @endif
    @if (in_array('principle_type',$checked_fields))
        <td class="min-width-150">{{ $iteration->principle_type ?? '-' }}</td>
    @endif
    @if (in_array('contractor_rating',$checked_fields))
        <td class="min-width-100">{{ $iteration->contractor_rating ?? '-' }}</td>
    @endif
    @if (in_array('credit_rating_agency_and_grade',$checked_fields))
        <td class="min-width-300">
            <ol class="pl-4">
                @foreach(explode(',', $iteration->credit_rating_agency_and_grade) as $item)
                    @if($item)
                        <li>{{ $item ?? '-' }}</li>
                    @endif
                @endforeach
            </ol>
        </td>
    @endif
    @if (in_array('re_insurance_grouping',$checked_fields))
        <td class="min-width-200">{{ $iteration->re_insurance_grouping ?? '-' }}</td>
    @endif
    @if (in_array('credit_insurance_exposure',$checked_fields))
        <td class="text-right min-width-200">0</td>
    @endif
    @if (in_array('cash_margin',$checked_fields))
        <td class="min-width-100">{{ $iteration->cash_margin ?? '-' }}</td>
    @endif
    @if (in_array('cash_margin_inr',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->cash_margin_inr, 0) ?? '-' }}</td>
    @endif
    @if (in_array('beneficiary_id',$checked_fields))
        <td class="min-width-100">{{ $iteration->beneficiary_id ?? '-' }}</td>
    @endif
    @if (in_array('beneficiary_name',$checked_fields))
        <td class="min-width-300">{{ $iteration->beneficiary_name ?? '-' }}</td>
    @endif
    @if (in_array('beneficiary_pan_no',$checked_fields))
        <td class="min-width-150">{{ $iteration->beneficiary_pan_no ?? '-' }}</td>
    @endif
    @if (in_array('project_id',$checked_fields))
        <td class="min-width-100">{{ $iteration->project_id ?? '-' }}</td>
    @endif
    @if (in_array('project_title',$checked_fields))
        <td class="min-width-300">{{ $iteration->project_title ?? '-' }}</td>
    @endif
    @if (in_array('project_value',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->project_value, 0) ?? '-' }}</td>
    @endif
    @if (in_array('project_start_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->project_start_date) ? custom_date_format($iteration->project_start_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('project_end_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->project_end_date) ? custom_date_format($iteration->project_end_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('tender_id',$checked_fields))
        <td class="min-width-100">{{ $iteration->tender_id ?? '-' }}</td>
    @endif
    @if (in_array('tender_header',$checked_fields))
        <td class="min-width-300">{{ $iteration->tender_header ?? '-' }}</td>
    @endif
    @if (in_array('contract_value',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->contract_value, 0) ?? '-' }}</td>
    @endif
    @if (in_array('bond_type',$checked_fields))
        <td class="min-width-200">{{ $iteration->bond_type ?? '-' }}</td>
    @endif
    @if (in_array('bond_value',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->bond_value, 0) ?? '-' }}</td>
    @endif
    @if (in_array('bond_start_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->bond_start_date) ? custom_date_format($iteration->bond_start_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('bond_end_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->bond_end_date) ? custom_date_format($iteration->bond_end_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('net_premium_paid',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->net_premium_paid, 0) ?? '-' }}</td>
    @endif
    @if (in_array('gross_premium_paid',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->gross_premium_paid, 0) ?? '-' }}</td>
    @endif
    @if (in_array('premium_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->premium_date) ? custom_date_format($iteration->premium_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('bond_number',$checked_fields))
        <td class="min-width-100">{{ $iteration->bond_number ?? '-' }}</td>
    @endif
    @if (in_array('insurer_bond_number',$checked_fields))
        <td class="min-width-200">{{ $iteration->insurer_bond_number ?? '-' }}</td>
    @endif
    @if (in_array('status',$checked_fields))
        <td class="min-width-100">{{ $iteration->status ?? '-' }}</td>
    @endif
    @if (in_array('remarks',$checked_fields))
        <td class="min-width-300">{{ $iteration->remarks ?? '-' }}</td>
    @endif
    @if (in_array('application_date_two',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->application_date) ? custom_date_format($iteration->application_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('decision_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->decision_date) ? custom_date_format($iteration->decision_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('decision_remarks',$checked_fields))
        <td class="min-width-300">{{ $iteration->decision_remarks ?? '-' }}</td>
    @endif
    @if (in_array('individual_cap',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->individual_cap, 0) ?? '-' }}</td>
    @endif
    @if (in_array('overall_cap',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->overall_cap, 0) ?? '-' }}</td>
    @endif
    @if (in_array('group_cap',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->group_cap, 0) ?? '-' }}</td>
    @endif
    @if (in_array('total_approved_limit',$checked_fields))
        <td class="text-right min-width-200">0</td>
    @endif
    @if (in_array('spare_capacity',$checked_fields))
        <td class="text-right min-width-200">0</td>
    @endif
    @if (in_array('last_review_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->last_review_date) ? custom_date_format($iteration->last_review_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('regular_review_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->regular_review_date) ? custom_date_format($iteration->regular_review_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('balance_Sheet_date',$checked_fields))
        <td class="min-width-150">{{ isset($iteration->balance_Sheet_date) ? custom_date_format($iteration->balance_Sheet_date, 'd/m/Y') : '-' }}</td>
    @endif
    @if (in_array('assigned_underwriter_name',$checked_fields))
        <td class="min-width-200">{{ $iteration->assigned_underwriter_name ?? '-' }}</td>
    @endif
    @if (in_array('any_adverse_information',$checked_fields))
        <td class="min-width-100">{{ $iteration->any_adverse_information ?? '' }}</td>
    @endif
    @if (in_array('adverse_information_details',$checked_fields))
        <td class="min-width-300">
            <ol class="pl-4">
                @foreach(explode(',', $iteration->adverse_information_details) as $item)
                    @if($item)
                        <li>{!! $item ?? '-' !!}</li>
                    @endif
                @endforeach
            </ol>
        </td>
    @endif
    @if (in_array('any_blacklisted_details',$checked_fields))
        <td class="min-width-100">{{ $iteration->any_blacklisted_details ?? '' }}</td>
    @endif
    @if (in_array('blacklisted_details',$checked_fields))
        <td class="min-width-300">
            <ol class="pl-4">
                @foreach(explode(',', $iteration->blacklisted_details) as $item)
                    @if($item)
                        <li>{!! $item ?? '-' !!}</li>
                    @endif
                @endforeach
            </ol>
        </td>
    @endif
    @if (in_array('expiring_bond',$checked_fields))
        <td class="min-width-100">{{ $iteration->expiring_bond ?? '-' }}</td>
    @endif
    @if (in_array('expired_bond',$checked_fields))
        <td class="min-width-100">{{ $iteration->expired_bond ?? '-' }}</td>
    @endif
    {{-- @if (in_array('total_premium_earnings',$checked_fields))
        <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->total_premium_earnings, 0) ?? '' }}</td>
    @endif --}}
</tr>


@endforeach

@if($contractor_wise_data->count() > 0)
    <tr>
        <td></td>
        @foreach ($checked_fields as $key => $value)
            @if ($value == 'net_premium_paid')
                <td class="min-width-200 text-right"><strong>Total</strong> : {{ numberFormatPrecision($sum_net_premium, 0) ?? 0}}</td>
            @elseif($value == 'gross_premium_paid')
                <td class="min-width-200 text-right"><strong>Total</strong> : {{ numberFormatPrecision($sum_gross_premium, 0) ?? 0}}</td>
            @else
                <td></td>
            @endif
        @endforeach
    </tr>
@endif