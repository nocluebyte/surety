@foreach ($tender_wise_data as $iteration)
    <tr>
        <td>{{ ($tender_wise_data->currentPage() - 1) * $tender_wise_data->perPage() + $loop->iteration }}</td>
        @if (in_array('tender_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->tender_id ?? '' }}</td>
        @endif
        @if (in_array('tender_header',$checked_fields))
            <td class="min-width-300">{{ $iteration->tender_header ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_id',$checked_fields))
            <td class="min-width-300">{{ $iteration->beneficiary_id ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_pan_no',$checked_fields))
            <td class="min-width-150">{{ $iteration->beneficiary_pan_no ?? '' }}</td>
        @endif
        @if (in_array('project_id',$checked_fields))
            <td class="min-width-300">{{ $iteration->project_id ?? '' }}</td>
        @endif
        @if (in_array('project_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->project_name ?? '' }}</td>
        @endif
        @if (in_array('location',$checked_fields))
            <td class="min-width-300">{{ $iteration->location ?? '' }}</td>
        @endif
        @if (in_array('tender_project_type',$checked_fields))
            <td class="min-width-300">{{ $iteration->tender_project_type ?? '' }}</td>
        @endif
        @if (in_array('tender_contract_value',$checked_fields))
            <td class="min-width-200 text-right">{{ numberFormatPrecision($iteration->tender_contract_value) ?? '' }}</td>
        @endif
        @if (in_array('application_bond_type',$checked_fields))
            <td class="min-width-200">{{ $iteration->application_bond_type ?? '' }}</td>
        @endif
        @if (in_array('bond_start_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->bond_start_date) ? custom_date_format($iteration->bond_start_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('bond_end_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->bond_end_date) ? custom_date_format($iteration->bond_end_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('application_bond_value',$checked_fields))
            <td class="min-width-200 text-right">{{ numberFormatPrecision($iteration->application_bond_value, 0) ?? '' }}</td>
        @endif
        @if (in_array('list_of_contractors_applied',$checked_fields))
            <td class="min-width-300">
                <ol class="pl-4">
                    @foreach(explode(',', $iteration->list_of_contractors_applied) as $item)
                        @if($item)
                            <li>{{ $item }}</li>
                        @endif
                    @endforeach
                </ol>
            </td>
        @endif
        @if (in_array('bond_total_risk_exposure',$checked_fields))
            <td class="min-width-200 text-right">{{ numberFormatPrecision($iteration->bond_total_risk_exposure, 0) ?? '' }}</td>
        @endif
    </tr>
@endforeach