<table class="table" id="projectDetailsWiseReport" style="width: 100% !important">
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
        @if (isset($project_details))
            @foreach ($project_details as $key => $item)
                <tr>
                    <td>{{ ++$key }}</td>
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
                    @if(isset($checkedFields) && in_array('project_value', $checkedFields))
                    <td class="{{ in_array('project_value', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->project_value ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('type_of_project', $checkedFields))
                    <td class="{{ in_array('type_of_project', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->type_of_project ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_start_date', $checkedFields))
                    <td class="{{ in_array('project_start_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->project_start_date) ? custom_date_format($item->project_start_date, 'd/m/Y') : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('project_end_date', $checkedFields))
                    <td class="{{ in_array('project_end_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->project_end_date) ? custom_date_format($item->project_end_date, 'd/m/Y') : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('period_of_project', $checkedFields))
                    <td class="{{ in_array('period_of_project', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->period_of_project ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('type_of_contracting', $checkedFields))
                    <td class="{{ in_array('type_of_contracting', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ $item->type_of_contracting ?? '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('rfp_date', $checkedFields))
                    <td class="{{ in_array('rfp_date', $checkedFields) ? ' ' : 'd-none' }}">
                        {{ isset($item->rfp_date) ? custom_date_format($item->rfp_date, 'd/m/Y') : '-' }}
                    </td>
                    @endif
                    @if(isset($checkedFields) && in_array('tender_under_project', $checkedFields))
                    <td class="{{ in_array('tender_under_project', $checkedFields) ? ' ' : 'd-none' }}">
                        {{$item->tender_under_project ?? '-'}}
                    </td>
                    @endif
                </tr>
            @endforeach
        @endif
    </tbody>
</table>