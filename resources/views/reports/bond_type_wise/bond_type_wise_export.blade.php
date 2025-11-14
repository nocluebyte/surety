<table class="table" id="bondTypeWiseReport" style="width: 100% !important">
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
        @if (isset($bond_data))
            @foreach ($bond_data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
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
                    @if(isset($checkedFields) && in_array('bond_conditionality', $checkedFields))
                    <td class="{{ in_array('bond_conditionality', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_conditionality ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('intermediary_detail_type', $checkedFields))
                    <td class="{{ in_array('intermediary_detail_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->intermediary_detail_type ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('intermediary_detail_name', $checkedFields))
                    <td class="{{ in_array('intermediary_detail_name', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->intermediary_detail_name ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('intermediary_detail_mobile', $checkedFields))
                    <td class="{{ in_array('intermediary_detail_mobile', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->intermediary_detail_mobile ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('intermediary_detail_address', $checkedFields))
                    <td class="{{ in_array('intermediary_detail_address', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->intermediary_detail_address ?? '-' }}
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
                    @if(isset($checkedFields) && in_array('project_id', $checkedFields))
                    <td class="{{ in_array('project_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_id ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_value', $checkedFields))
                    <td class="{{ in_array('project_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_value ?? '-' }}
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
                    @if(isset($checkedFields) && in_array('contract_value', $checkedFields))
                    <td class="{{ in_array('contract_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contract_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_exposure', $checkedFields))
                    <td class="{{ in_array('bond_exposure', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_exposure ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('expired_bond', $checkedFields))
                    <td class="{{ in_array('expired_bond', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->expired_bond ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('expiring_bond', $checkedFields))
                    <td class="{{ in_array('expiring_bond', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->expiring_bond ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_status', $checkedFields))
                    <td class="{{ in_array('bond_status', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_status ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('list_of_contractors_applied', $checkedFields))
                    <td class="{{ in_array('list_of_contractors_applied', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->list_of_contractors_applied ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('re_insurance_grouping', $checkedFields))
                    <td class="{{ in_array('re_insurance_grouping', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->re_insurance_grouping ?? '-' }}
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>