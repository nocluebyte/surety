<table class="table" id="beneficiaryTypeWiseReport" style="width: 100% !important">
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
        @if (isset($beneficiary_data))
            @foreach ($beneficiary_data as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
                    @if(isset($checkedFields) && in_array('proposal_id', $checkedFields))
                    <td class="{{ in_array('proposal_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->proposal_id) ? $item->proposal_id . '/V' . $item->version : '-' }}
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
                    @if(isset($checkedFields) && in_array('beneficiary_type', $checkedFields))
                    <td class="{{ in_array('beneficiary_type', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->beneficiary_type ?? '-' }}
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
                    {{-- @if(isset($checkedFields) && in_array('contractor_pan_no', $checkedFields))
                    <td class="{{ in_array('contractor_pan_no', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->contractor_pan_no ?? '-' }}
                    </td>
                    @endif --}}
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
                    @if(isset($checkedFields) && in_array('tender_details_id', $checkedFields))
                    <td class="{{ in_array('tender_details_id', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->tender_details_id ?? '-' }}
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
                    <td class="text-right {{ in_array('bond_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{$item->bond_value ?? '-'}}
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
                    {{-- @if(isset($checkedFields) && in_array('bond_period', $checkedFields))
                    <td class="{{ in_array('bond_period', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_period ?? 0 }}
                    </td>
                    @endif --}}
                    @if(isset($checkedFields) && in_array('sys_gen_bond_number', $checkedFields))
                    <td class="{{ in_array('sys_gen_bond_number', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->sys_gen_bond_number ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('insurer_bond_number', $checkedFields))
                    <td class="{{ in_array('insurer_bond_number', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->insurer_bond_number ?? '-' }}
                    </td>
                    @endif
                    {{-- @if(isset($checkedFields) && in_array('bond_issue_number', $checkedFields))
                    <td class="{{ in_array('bond_issue_number', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->bond_issue_number ?? 0 }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('premium_amount', $checkedFields))
                    <td class="text-right {{ in_array('premium_amount', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->premium_amount ?? 0}}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('premium_date', $checkedFields))
                    <td class="{{ in_array('premium_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->premium_date)  ? date('d/m/Y', strtotime($item->premium_date)) : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('re_insurance_grouping', $checkedFields))
                    <td class="text-right {{ in_array('re_insurance_grouping', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->re_insurance_grouping ?? '-'}}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('agency_rating', $checkedFields))
                    <td class="text-right {{ in_array('agency_rating', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->agency_rating ?? '-'}}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('credit_insurance_total_exposure', $checkedFields))
                    <td class="text-right {{ in_array('credit_insurance_total_exposure', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->credit_insurance_total_exposure ?? '-'}}
                    </td>
                    @endif --}}
                    @if(isset($checkedFields) && in_array('status', $checkedFields))
                        <td class="{{ in_array('status', $checkedFields) ? ' ' : 'd-none' }} text-center">{!! $item->status ?? '-' !!}</td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>