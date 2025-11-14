<table class="table jsexport_error_table">
    <thead class="thead-light thead">
        <tr>
            <th>No.</th>
            <th class="min-width-180">Branch Name</th>
            <th class="min-width-180">Branch Code</th>
            <th class="min-width-180">Address</th>
            <th class="min-width-180">Country</th>
            <th class="min-width-180">State</th>
            <th class="min-width-180">City</th>
            <th class="min-width-180">GST No</th>
            <th class="min-width-180">OO/CBO/BO/KBO</th>
            <th class="min-width-180">Bank</th>
            <th class="min-width-180">Bank Branch</th>
            <th class="min-width-180">A/C No</th>
            <th class="min-width-180">IFSC</th>
            <th class="min-width-180">MICR</th>
            <th class="min-width-180">Mode</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($excel_error) && count($excel_error) > 0)
            @foreach ($excel_error as $key => $error)
                <tr>
                    <td>{{$key ?? ''}}</td>

                    <td class="{{in_array('branch_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['branch_name'] ?? ''}}">{{$error['values']['branch_name'] ?? ''}}</td>

                    <td class="{{in_array('branch_code',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['branch_code'] ?? ''}}">{{$error['values']['branch_code'] ?? ''}}</td>

                    <td class="{{in_array('address',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['address'] ?? ''}}">{{$error['values']['address'] ?? ''}}</td>

                    <td class="{{in_array('country',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['country'] ?? ''}}">{{$error['values']['country'] ?? ''}}</td>

                    <td class="{{in_array('state',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['state'] ?? ''}}">{{$error['values']['state'] ?? ''}}</td>

                    <td class="{{in_array('city',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['city'] ?? ''}}">{{$error['values']['city'] ?? ''}}</td>

                    <td class="{{in_array('gst_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['gst_no'] ?? ''}}">{{$error['values']['gst_no'] ?? ''}}</td>

                    <td class="{{in_array('oo_cbo_bo_kbo',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['oo_cbo_bo_kbo'] ?? ''}}">{{$error['values']['oo_cbo_bo_kbo'] ?? ''}}</td>

                    <td class="{{in_array('bank',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bank'] ?? ''}}">{{$error['values']['bank'] ?? ''}}</td>

                    <td class="{{in_array('bank_branch',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bank_branch'] ?? ''}}">{{$error['values']['bank_branch'] ?? ''}}</td>

                    <td class="{{in_array('account_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['account_no'] ?? ''}}">{{$error['values']['account_no'] ?? ''}}</td>

                    <td class="{{in_array('ifsc',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['ifsc'] ?? ''}}">{{$error['values']['ifsc'] ?? ''}}</td>

                    <td class="{{in_array('micr',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['micr'] ?? ''}}">{{$error['values']['micr'] ?? ''}}</td>

                    <td class="{{in_array('mode',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['mode'] ?? ''}}">{{$error['values']['mode'] ?? ''}}</td>
                </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="17">No errors were found.</td>
        </tr>
        @endif
    </tbody>
</table>