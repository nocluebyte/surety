<table class="table jsexport_error_table">
    <thead class="thead-light thead">
        <tr>
            <th>No.</th>
            <th class="min-width-180">Tender ID</th>
            <th class="min-width-180">Tender Header</th>
            <th class="min-width-180">Tender Description</th>
            <th class="min-width-180">Location</th>
            <th class="min-width-180">Project Type</th>
            <th class="min-width-180">Beneficiary</th>
            <th class="min-width-180">Contract Value</th>
            <th class="min-width-180">Period of Contract</th>
            <th class="min-width-180">Bond Value</th>
            <th class="min-width-180">Bond Type</th>
            <th class="min-width-180">Type of Contracting</th>
            <th class="min-width-180">RFP Date</th>
            <th class="min-width-180">Purpose/Project Brief</th>
            <th class="min-width-180">Project Details</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($excel_error) && count($excel_error) > 0)
            @foreach ($excel_error as $key => $error)
                <tr>
                    <td>{{$key ?? ''}}</td>

                    <td class="{{in_array('tender_id',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['tender_id'] ?? ''}}">{{$error['values']['tender_id'] ?? ''}}</td>

                    <td class="{{in_array('tender_header',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['tender_header'] ?? ''}}">{{$error['values']['tender_header'] ?? ''}}</td>

                    <td class="{{in_array('tender_description',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['tender_description'] ?? ''}}">{{$error['values']['tender_description'] ?? ''}}</td>

                    <td class="{{in_array('location',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['location'] ?? ''}}">{{$error['values']['location'] ?? ''}}</td>

                    <td class="{{in_array('project_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['project_type'] ?? ''}}">{{$error['values']['project_type'] ?? ''}}</td>

                    <td class="{{in_array('beneficiary',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['beneficiary'] ?? ''}}">{{$error['values']['beneficiary'] ?? ''}}</td>

                    <td class="{{in_array('contract_value',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contract_value'] ?? ''}}">{{$error['values']['contract_value'] ?? ''}}</td>

                    <td class="{{in_array('period_of_contract',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['period_of_contract'] ?? ''}}">{{$error['values']['period_of_contract'] ?? ''}}</td>

                    <td class="{{in_array('bond_value',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bond_value'] ?? ''}}">{{$error['values']['bond_value'] ?? ''}}</td>

                    <td class="{{in_array('bond_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bond_type'] ?? ''}}">{{$error['values']['bond_type'] ?? ''}}</td>

                    <td class="{{in_array('type_of_contracting',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['type_of_contracting'] ?? ''}}">{{$error['values']['type_of_contracting'] ?? ''}}</td>

                    <td class="{{in_array('rfp_date',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['rfp_date'] ?? ''}}">{{custom_date_format($error['values']['rfp_date'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('project_description',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_description'] ?? ''}}">{{$error['values']['project_description'] ?? ''}}</td>

                    <td class="{{in_array('project_details_id',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_details_id'] ?? ''}}">{{$error['values']['project_details_id'] ?? ''}}</td>
                </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="17">No errors were found.</td>
        </tr>
        @endif
    </tbody>
</table>