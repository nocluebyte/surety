@foreach ($beneficiary_wise_data as $iteration)
    <tr>
        <td>{{ ($beneficiary_wise_data->currentPage() - 1) * $beneficiary_wise_data->perPage() + $loop->iteration }}</td>
        @if (in_array('proposal_id',$checked_fields))
            <td class="min-width-100">{{ isset($iteration->proposal_id) ? $iteration->proposal_id . '/V' . $iteration->version : '-' }}</td>
        @endif
        @if (in_array('beneficiary_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->beneficiary_id ?? '-' }}</td>
        @endif
        @if (in_array('beneficiary_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->beneficiary_name ?? '-' }}</td>
        @endif
        @if (in_array('beneficiary_pan_no',$checked_fields))
            <td class="min-width-200">{{ $iteration->beneficiary_pan_no ?? '-' }}</td>
        @endif
        @if (in_array('beneficiary_type',$checked_fields))
            <td class="min-width-200">{{ $iteration->beneficiary_type ?? '-' }}</td>
        @endif
        @if (in_array('contractor_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->contractor_id ?? '-' }}</td>
        @endif
        @if (in_array('contractor_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->contractor_name ?? '-' }}</td>
        @endif
        {{-- @if (in_array('contractor_pan_no',$checked_fields))
            <td>{{ $iteration->contractor_pan_no ?? '' }}</td>
        @endif --}}
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
        @if (in_array('tender_details_id',$checked_fields))
            <td class="min-width-300">{{ $iteration->tender_details_id ?? '-' }}</td>
        @endif
        @if (in_array('tender_id',$checked_fields))
            <td class="min-width-300">{{ $iteration->tender_id ?? '-' }}</td>
        @endif
        @if (in_array('tender_header',$checked_fields))
            <td class="min-width-500">{{ $iteration->tender_header ?? '-' }}</td>
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
        {{-- @if (in_array('bond_period',$checked_fields))
            <td>{{ $iteration->bond_period ?? '' }}</td>
        @endif --}}
        @if (in_array('sys_gen_bond_number',$checked_fields))
            <td class="min-width-150">{{ $iteration->sys_gen_bond_number ?? '-' }}</td>
        @endif
        @if (in_array('insurer_bond_number',$checked_fields))
            <td class="min-width-200">{{ $iteration->insurer_bond_number ?? '-' }}</td>
        @endif
        {{-- @if (in_array('bond_issue_number',$checked_fields))
            <td>{{ $iteration->bond_issue_number ?? '' }}</td>
        @endif --}}
        {{-- @if (in_array('premium_amount',$checked_fields))
            <td class="text-right">{{ numberFormatPrecision($iteration->premium_amount, 0) ?? '' }}</td>
        @endif
        @if (in_array('premium_date',$checked_fields))
            <td>{{ isset($iteration->premium_date) ? custom_date_format($iteration->premium_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('re_insurance_grouping',$checked_fields))
            <td>{{ $iteration->re_insurance_grouping ?? '' }}</td>
        @endif
        @if (in_array('agency_rating',$checked_fields))
            <td>{{ $iteration->agency_rating ?? '' }}</td>
        @endif
        @if (in_array('credit_insurance_total_exposure',$checked_fields))
            <td>{{ $iteration->credit_insurance_total_exposure ?? '' }}</td>
        @endif --}}
        @if (in_array('status',$checked_fields))
            <td>{{ $iteration->status ?? '-' }}</td>
        @endif
    </tr>
@endforeach