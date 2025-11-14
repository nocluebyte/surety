<table class="table jsexport_error_table">
    <thead class="thead-light thead">
        <tr>
            <th>No.</th>
            <th class="min-width-180">Registration No</th>
            <th class="min-width-180">Company Name</th>
            <th class="min-width-180">Email</th>
            <th class="min-width-180">Phone No</th>
            <th class="min-width-180">Address</th>
            <th class="min-width-180">Country</th>
            <th class="min-width-180">State</th>
            <th class="min-width-180">City</th>
            <th class="min-width-180">GST No</th>
            <th class="min-width-180">PanNo</th>
            <th class="min-width-180">Beneficiary Type</th>
            <th class="min-width-180">Establishment Type</th>
            <th class="min-width-180">Ministry Type</th>
            <th class="min-width-180">Bond Wording</th>
            <th class="min-width-180">Website</th>
            <th class="min-width-180">PinCode</th>
            <th class="min-width-180">Trade Sector</th>
            <th class="min-width-180">From</th>
            <th class="min-width-180">Till</th>
            <th class="min-width-180">Is Main</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($excel_error) && count($excel_error) > 0)
            @foreach ($excel_error as $key => $error)
                <tr>
                    <td>{{$key ?? ''}}</td>

                    <td class="{{in_array('registration_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['registration_no'] ?? ''}}">{{$error['values']['registration_no'] ?? ''}}</td>

                    <td class="{{in_array('company_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['company_name'] ?? ''}}">{{$error['values']['company_name'] ?? ''}}</td>

                    <td class="{{in_array('email',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['email'] ?? ''}}">{{$error['values']['email'] ?? ''}}</td>

                    <td class="{{in_array('mobile',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['mobile'] ?? ''}}">{{$error['values']['mobile'] ?? ''}}</td>

                    <td class="{{in_array('address',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['address'] ?? ''}}">{{$error['values']['address'] ?? ''}}</td>

                    <td class="{{in_array('country',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['country'] ?? ''}}">{{$error['values']['country'] ?? ''}}</td>

                    <td class="{{in_array('state',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['state'] ?? ''}}">{{$error['values']['state'] ?? ''}}</td>

                    <td class="{{in_array('city',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['city'] ?? ''}}">{{$error['values']['city'] ?? ''}}</td>

                    <td class="{{in_array('gst_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['gst_no'] ?? ''}}">{{$error['values']['gst_no'] ?? ''}}</td>

                    <td class="{{in_array('pan_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['pan_no'] ?? ''}}">{{$error['values']['pan_no'] ?? ''}}</td>

                    <td class="{{in_array('beneficiary_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['beneficiary_type'] ?? ''}}">{{$error['values']['beneficiary_type'] ?? ''}}</td>

                    <td class="{{in_array('establishment_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['establishment_type'] ?? ''}}">{{$error['values']['establishment_type'] ?? ''}}</td>

                    <td class="{{in_array('ministry_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['ministry_type'] ?? ''}}">{{$error['values']['ministry_type'] ?? ''}}</td>

                    <td class="{{in_array('bond_wording',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bond_wording'] ?? ''}}">{{$error['values']['bond_wording'] ?? ''}}</td>

                    <td class="{{in_array('website',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['website'] ?? ''}}">{{$error['values']['website'] ?? ''}}</td>

                    <td class="{{in_array('pincode',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['pincode'] ?? ''}}">{{$error['values']['pincode'] ?? ''}}</td>

                    <td class="{{in_array('trade_sector',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['trade_sector'] ?? ''}}">{{$error['values']['trade_sector'] ?? ''}}</td>

                    <td class="{{in_array('from',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['from'] ?? ''}}">{{custom_date_format($error['values']['from'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('till',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['till'] ?? ''}}">{{custom_date_format($error['values']['till'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('is_main',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['is_main'] ?? ''}}">{{$error['values']['is_main'] ?? ''}}</td>
                </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="17">No errors were found.</td>
        </tr>
        @endif
    </tbody>
</table>