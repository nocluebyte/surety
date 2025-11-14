<table class="table" id="tenderWiseReport" style="width: 100% !important">
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
        @if (isset($tender))
            @foreach ($tender as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
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
                    @if(isset($checkedFields) && in_array('beneficiary_id', $checkedFields))
                    <td class="{{ in_array('beneficiary_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->beneficiary_id ?? '-' }}
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
                    @if(isset($checkedFields) && in_array('project_name', $checkedFields))
                    <td class="{{ in_array('project_name', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_name ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('location', $checkedFields))
                    <td class="{{ in_array('location', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->location ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('tender_project_type', $checkedFields))
                    <td class="{{ in_array('tender_project_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->tender_project_type ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('tender_contract_value', $checkedFields))
                    <td class="{{ in_array('tender_contract_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->tender_contract_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('application_bond_type', $checkedFields))
                    <td class="{{ in_array('application_bond_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->application_bond_type ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_start_date', $checkedFields))
                    <td class="{{ in_array('bond_start_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->bond_start_date) ? custom_date_format($item->bond_start_date, 'd/m/Y') : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_end_date', $checkedFields))
                    <td class="{{ in_array('bond_end_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->bond_end_date) ? custom_date_format($item->bond_end_date, 'd/m/Y') : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('application_bond_value', $checkedFields))
                    <td class="{{ in_array('application_bond_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->application_bond_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('list_of_contractors_applied', $checkedFields))
                    <td class="{{ in_array('list_of_contractors_applied', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->list_of_contractors_applied ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('bond_total_risk_exposure', $checkedFields))
                    <td class="{{ in_array('bond_total_risk_exposure', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_total_risk_exposure ?? '-' }}
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>