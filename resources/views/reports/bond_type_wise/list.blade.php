@foreach ($bond_type_wise_data as $iteration)
    <tr>
        <td>{{ ($bond_type_wise_data->currentPage() - 1) * $bond_type_wise_data->perPage() + $loop->iteration }}</td>
        @if (in_array('bond_number',$checked_fields))
            <td class="min-width-100">{{ $iteration->bond_number ?? '' }}</td>
        @endif
        @if (in_array('insurer_bond_number',$checked_fields))
            <td class="min-width-200">{{ $iteration->insurer_bond_number ?? '' }}</td>
        @endif
        @if (in_array('bond_type',$checked_fields))
            <td class="min-width-200">{{ $iteration->bond_type ?? '' }}</td>
        @endif
        @if (in_array('bond_value',$checked_fields))
            <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->bond_value, 0) ?? '' }}</td>
        @endif
        @if (in_array('bond_start_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->bond_start_date) ? custom_date_format($iteration->bond_start_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('bond_end_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->bond_end_date) ? custom_date_format($iteration->bond_end_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('bond_conditionality',$checked_fields))
            <td class="min-width-150">{{ $iteration->bond_conditionality ?? '' }}</td>
        @endif
        @if (in_array('intermediary_detail_type',$checked_fields))
            <td class="min-width-150">{{ $iteration->intermediary_detail_type ?? '' }}</td>
        @endif
        @if (in_array('intermediary_detail_name',$checked_fields))
            <td class="min-width-150">{{ $iteration->intermediary_detail_name ?? '' }}</td>
        @endif
        @if (in_array('intermediary_detail_mobile',$checked_fields))
            <td class="min-width-150">{{ $iteration->intermediary_detail_mobile ?? '' }}</td>
        @endif
        @if (in_array('intermediary_detail_address',$checked_fields))
            <td class="min-width-150">{{ $iteration->intermediary_detail_address ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->beneficiary_id ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->beneficiary_name ?? '' }}</td>
        @endif
        @if (in_array('project_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->project_id ?? '' }}</td>
        @endif
        @if (in_array('project_value',$checked_fields))
            <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->project_value, 0) ?? '' }}</td>
        @endif
        @if (in_array('contractor_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->contractor_name ?? '' }}</td>
        @endif
        @if (in_array('contractor_pan_no',$checked_fields))
            <td class="min-width-200">{{ $iteration->contractor_pan_no ?? '' }}</td>
        @endif
        @if (in_array('contract_value',$checked_fields))
            <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->contract_value, 0) ?? '' }}</td>
        @endif
        @if (in_array('bond_exposure',$checked_fields))
            <td class="text-right min-width-200">{{ numberFormatPrecision($iteration->bond_exposure, 0) ?? '' }}</td>
        @endif
        @if (in_array('expired_bond',$checked_fields))
            <td class="min-width-100">{{ $iteration->expired_bond ?? '' }}</td>
        @endif
        @if (in_array('expiring_bond',$checked_fields))
            <td class="min-width-100">{{ $iteration->expiring_bond ?? '' }}</td>
        @endif
        @if (in_array('bond_status',$checked_fields))
            <td class="min-width-100">{{ $iteration->bond_status ?? '' }}</td>
        @endif
        @if (in_array('list_of_contractors_applied',$checked_fields))
            <td class="min-width-300">{{ $iteration->list_of_contractors_applied ?? '' }}</td>
        @endif
        @if (in_array('re_insurance_grouping',$checked_fields))
            <td class="min-width-300">{{ $iteration->re_insurance_grouping ?? '' }}</td>
        @endif
    </tr>
@endforeach