@foreach ($project_details_wise_data as $iteration)
    <tr>
        <td>{{ ($project_details_wise_data->currentPage() - 1) * $project_details_wise_data->perPage() + $loop->iteration }}</td>
        @if (in_array('project_id',$checked_fields))
            <td class="min-width-100">{{ $iteration->project_id ?? '' }}</td>
        @endif
        @if (in_array('project_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->project_name ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_name',$checked_fields))
            <td class="min-width-300">{{ $iteration->beneficiary_name ?? '' }}</td>
        @endif
        @if (in_array('beneficiary_pan_no',$checked_fields))
            <td class="min-width-150">{{ $iteration->beneficiary_pan_no ?? '' }}</td>
        @endif
        @if (in_array('project_value',$checked_fields))
            <td class="min-width-200 text-right">{{ numberFormatPrecision($iteration->project_value, 0) ?? '' }}</td>
        @endif
        @if (in_array('type_of_project',$checked_fields))
            <td class="min-width-200">{{ $iteration->type_of_project ?? '' }}</td>
        @endif
        @if (in_array('project_start_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->project_start_date) ? custom_date_format($iteration->project_start_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('project_end_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->project_end_date) ? custom_date_format($iteration->project_end_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('period_of_project',$checked_fields))
            <td class="min-width-100">{{ $iteration->period_of_project ?? '' }}</td>
        @endif
        @if (in_array('type_of_contracting',$checked_fields))
            <td class="min-width-150">{{ $iteration->type_of_contracting ?? '' }}</td>
        @endif
        @if (in_array('rfp_date',$checked_fields))
            <td class="min-width-150">{{ isset($iteration->rfp_date) ? custom_date_format($iteration->rfp_date, 'd/m/Y') : '' }}</td>
        @endif
        @if (in_array('tender_under_project',$checked_fields))
            <td class="min-width-300">
                <ol class="pl-4">
                    @foreach(explode(',', $iteration->tender_under_project) as $item)
                        @if($item)
                            <li>{{ $item }}</li>
                        @endif
                    @endforeach
                </ol>
            </td>
        @endif
    </tr>
@endforeach