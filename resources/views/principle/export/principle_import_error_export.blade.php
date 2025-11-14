<table class="table jsexport_error_table">
    <thead class="thead-light thead">
        <tr>
            <th>No.</th>
            <th class="min-width-180">Registration No</th>
            <th class="min-width-180">Company Name</th>
            <th class="min-width-180">First Name</th>
            <th class="min-width-180">Middle Name</th>
            <th class="min-width-180">Last Name</th>
            <th class="min-width-180">Address</th>
            <th class="min-width-180">Website</th>
            <th class="min-width-180">Country</th>
            <th class="min-width-180">State</th>
            <th class="min-width-180">City</th>
            <th class="min-width-180">PinCode</th>
            <th class="min-width-180">Email</th>
            <th class="min-width-180">GST No</th>
            <th class="min-width-180">PanNo</th>
            <th class="min-width-180">Date of Incorporation</th>
            <th class="min-width-180">Principle Type</th>
            <th class="min-width-180">Phone No</th>
            <th class="min-width-180">Is JV</th>
            <th class="min-width-180">Contractor</th>
            <th class="min-width-180">Share Holding</th>
            <th class="min-width-180">Trade Sector</th>
            <th class="min-width-180">From</th>
            <th class="min-width-180">Till</th>
            <th class="min-width-180">Is Main</th>
            <th class="min-width-180">Contact Person</th>
            <th class="min-width-180">Contact Person Email</th>
            <th class="min-width-180">Contact Person Phone No.</th>
            <th class="min-width-180">Are You Blacklisted?</th>
            <th class="min-width-180">Agency Name</th>
            <th class="min-width-180">Rating</th>
            <th class="min-width-180">Banking Limits Category</th>
            <th class="min-width-180">Facility Type</th>
            <th class="min-width-180">Sanctioned Amount</th>
            <th class="min-width-180">Bank Name</th>
            <th class="min-width-180">Latest Limit Utilized</th>
            <th class="min-width-180">Unutilized Limit</th>
            <th class="min-width-180">Commission on PG</th>
            <th class="min-width-180">Commission on FG</th>
            <th class="min-width-180">Margin Collateral</th>
            <th class="min-width-180">Other Banking Details</th>
            <th class="min-width-180">Project Name</th>
            <th class="min-width-180">Project Cost</th>
            <th class="min-width-180">Project Description</th>
            <th class="min-width-180">Project Start Date</th>
            <th class="min-width-180">Project End Date</th>
            <th class="min-width-180">Bank Guarantees Details</th>
            <th class="min-width-180">Actual Date Completion</th>
            <th class="min-width-180">BG Amount</th>
            <th class="min-width-180">Order Book and Future Projects->Project Name</th>
            <th class="min-width-180">Order Book and Future Projects->Project Cost</th>
            <th class="min-width-180">Order Book and Future Projects->Project Description</th>
            <th class="min-width-180">Order Book and Future Projects->Project Start Date</th>
            <th class="min-width-180">Order Book and Future Projects->Project End Date</th>
            <th class="min-width-180">Order Book and Future Projects->Bank Guarantees Details</th>
            <th class="min-width-180">Order Book and Future Projects->Project Share</th>
            <th class="min-width-180">Order Book and Future Projects->Guarantees Amount</th>
            <th class="min-width-180">Order Book and Future Projects->Current Status</th>
            <th class="min-width-180">Designation</th>
            <th class="min-width-180">Name</th>
            <th class="min-width-180">Qualifications</th>
            <th class="min-width-180">Experience</th>
            <th class="min-width-180">Is Bank Guarantee Provided</th>
            <th class="min-width-180">Circumstance Short Notes</th>
            <th class="min-width-180">Is Action Against Proposer</th>
            <th class="min-width-180">Action Details</th>
            <th class="min-width-180">Contractor Failed Project Details</th>
            <th class="min-width-180">Completed Rectification Details</th>
            <th class="min-width-180">Performance Security Details</th>
            <th class="min-width-180">Relevant Other Information</th>
        </tr>
    </thead>
    <tbody>
        @if (isset($excel_error) && count($excel_error) > 0)
            @foreach ($excel_error as $key => $error)
                <tr>
                    <td>{{$key ?? ''}}</td>

                    <td class="{{in_array('registration_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['registration_no'] ?? ''}}">{{$error['values']['registration_no'] ?? ''}}</td>

                    <td class="{{in_array('company_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['company_name'] ?? ''}}">{{$error['values']['company_name'] ?? ''}}</td>

                    <td class="{{in_array('first_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['first_name'] ?? ''}}">{{$error['values']['first_name'] ?? ''}}</td>

                    <td class="{{in_array('middle_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['middle_name'] ?? ''}}">{{$error['values']['middle_name'] ?? ''}}</td>

                    <td class="{{in_array('last_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['last_name'] ?? ''}}">{{$error['values']['last_name'] ?? ''}}</td>

                    <td class="{{in_array('address',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['address'] ?? ''}}">{{$error['values']['address'] ?? ''}}</td>

                    <td class="{{in_array('website',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['website'] ?? ''}}">{{$error['values']['website'] ?? ''}}</td>

                    <td class="{{in_array('country',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-placement="left" data-theme="dark" title="{{$error['error']['country'] ?? ''}}">{{$error['values']['country'] ?? ''}}</td>

                    <td class="{{in_array('state',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['state'] ?? ''}}">{{$error['values']['state'] ?? ''}}</td>

                    <td class="{{in_array('city',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['city'] ?? ''}}">{{$error['values']['city'] ?? ''}}</td>

                    <td class="{{in_array('pincode',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['pincode'] ?? ''}}">{{$error['values']['pincode'] ?? ''}}</td>

                    <td class="{{in_array('email',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['email'] ?? ''}}">{{$error['values']['email'] ?? ''}}</td>

                    <td class="{{in_array('gst_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['gst_no'] ?? ''}}">{{$error['values']['gst_no'] ?? ''}}</td>

                    <td class="{{in_array('pan_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['pan_no'] ?? ''}}">{{$error['values']['pan_no'] ?? ''}}</td>

                    <td class="{{in_array('date_of_incorporation',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['date_of_incorporation'] ?? ''}}">{{custom_date_format($error['values']['date_of_incorporation'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('principle_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['principle_type'] ?? ''}}">{{$error['values']['principle_type'] ?? ''}}</td>

                    <td class="{{in_array('mobile',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['mobile'] ?? ''}}">{{$error['values']['mobile'] ?? ''}}</td>

                    <td class="{{in_array('is_jv',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['is_jv'] ?? ''}}">{{$error['values']['is_jv'] ?? ''}}</td>

                    <td class="{{in_array('contractor',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contractor'] ?? ''}}">{{$error['values']['contractor'] ?? ''}}</td>

                    <td class="{{in_array('share_holding',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['share_holding'] ?? ''}}">{{$error['values']['share_holding'] ?? ''}}</td>

                    <td class="{{in_array('trade_sector',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['trade_sector'] ?? ''}}">{{$error['values']['trade_sector'] ?? ''}}</td>

                    <td class="{{in_array('from',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['from'] ?? ''}}">{{custom_date_format($error['values']['from'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('till',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['till'] ?? ''}}">{{custom_date_format($error['values']['till'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('is_main',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['is_main'] ?? ''}}">{{$error['values']['is_main'] ?? ''}}</td>

                    <td class="{{in_array('contact_person',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contact_person'] ?? ''}}">{{$error['values']['contact_person'] ?? ''}}</td>

                    <td class="{{in_array('contact_person_email',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contact_person_email'] ?? ''}}">{{$error['values']['contact_person_email'] ?? ''}}</td>

                    <td class="{{in_array('contact_person_phone_no',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contact_person_phone_no'] ?? ''}}">{{$error['values']['contact_person_phone_no'] ?? ''}}</td>

                    <td class="{{in_array('are_you_blacklisted',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['are_you_blacklisted'] ?? ''}}">{{$error['values']['are_you_blacklisted'] ?? ''}}</td>

                    <td class="{{in_array('agency_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['agency_name'] ?? ''}}">{{$error['values']['agency_name'] ?? ''}}</td>

                    <td class="{{in_array('rating',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['rating'] ?? ''}}">{{$error['values']['rating'] ?? ''}}</td>

                    <td class="{{in_array('banking_limits_category',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['banking_limits_category'] ?? ''}}">{{$error['values']['banking_limits_category'] ?? ''}}</td>

                    <td class="{{in_array('facility_type',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['facility_type'] ?? ''}}">{{$error['values']['facility_type'] ?? ''}}</td>

                    <td class="{{in_array('sanctioned_amount',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['sanctioned_amount'] ?? ''}}">{{$error['values']['sanctioned_amount'] ?? ''}}</td>

                    <td class="{{in_array('bank_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bank_name'] ?? ''}}">{{$error['values']['bank_name'] ?? ''}}</td>

                    <td class="{{in_array('latest_limit_utilized',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['latest_limit_utilized'] ?? ''}}">{{$error['values']['latest_limit_utilized'] ?? ''}}</td>

                    <td class="{{in_array('unutilized_limit',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['unutilized_limit'] ?? ''}}">{{$error['values']['unutilized_limit'] ?? ''}}</td>

                    <td class="{{in_array('commission_on_pg',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['commission_on_pg'] ?? ''}}">{{$error['values']['commission_on_pg'] ?? ''}}</td>

                    <td class="{{in_array('commission_on_fg',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['commission_on_fg'] ?? ''}}">{{$error['values']['commission_on_fg'] ?? ''}}</td>

                    <td class="{{in_array('margin_collateral',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['margin_collateral'] ?? ''}}">{{$error['values']['margin_collateral'] ?? ''}}</td>

                    <td class="{{in_array('other_banking_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['other_banking_details'] ?? ''}}">{{$error['values']['other_banking_details'] ?? ''}}</td>

                    <td class="{{in_array('project_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_name'] ?? ''}}">{{$error['values']['project_name'] ?? ''}}</td>

                    <td class="{{in_array('project_cost',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_cost'] ?? ''}}">{{$error['values']['project_cost'] ?? ''}}</td>

                    <td class="{{in_array('project_description',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_description'] ?? ''}}">{{$error['values']['project_description'] ?? ''}}</td>

                    <td class="{{in_array('project_start_date',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_start_date'] ?? ''}}">{{custom_date_format($error['values']['project_start_date'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('project_end_date',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['project_end_date'] ?? ''}}">{{custom_date_format($error['values']['project_end_date'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('bank_guarantees_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bank_guarantees_details'] ?? ''}}">{{$error['values']['bank_guarantees_details'] ?? ''}}</td>

                    <td class="{{in_array('actual_date_completion',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['actual_date_completion'] ?? ''}}">{{custom_date_format($error['values']['actual_date_completion'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('bg_amount',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['bg_amount'] ?? ''}}">{{$error['values']['bg_amount'] ?? ''}}</td>

                    <td class="{{in_array('obfp_project_name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_name'] ?? ''}}">{{$error['values']['obfp_project_name'] ?? ''}}</td>

                    <td class="{{in_array('obfp_project_cost',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_cost'] ?? ''}}">{{$error['values']['obfp_project_cost'] ?? ''}}</td>

                    <td class="{{in_array('obfp_project_description',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_description'] ?? ''}}">{{$error['values']['obfp_project_description'] ?? ''}}</td>

                    <td class="{{in_array('obfp_project_start_date',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_start_date'] ?? ''}}">{{custom_date_format($error['values']['obfp_project_start_date'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('obfp_project_end_date',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_end_date'] ?? ''}}">{{custom_date_format($error['values']['obfp_project_end_date'], 'd/m/Y') ?? ''}}</td>

                    <td class="{{in_array('obfp_bank_guarantees_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_bank_guarantees_details'] ?? ''}}">{{$error['values']['obfp_bank_guarantees_details'] ?? ''}}</td>

                    <td class="{{in_array('obfp_project_share',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_project_share'] ?? ''}}">{{$error['values']['obfp_project_share'] ?? ''}}</td>

                    <td class="{{in_array('obfp_guarantee_amount',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_guarantee_amount'] ?? ''}}">{{$error['values']['obfp_guarantee_amount'] ?? ''}}</td>

                    <td class="{{in_array('obfp_current_status',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['obfp_current_status'] ?? ''}}">{{$error['values']['obfp_current_status'] ?? ''}}</td>

                    <td class="{{in_array('designation',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['designation'] ?? ''}}">{{$error['values']['designation'] ?? ''}}</td>

                    <td class="{{in_array('name',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['name'] ?? ''}}">{{$error['values']['name'] ?? ''}}</td>

                    <td class="{{in_array('qualifications',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['qualifications'] ?? ''}}">{{$error['values']['qualifications'] ?? ''}}</td>

                    <td class="{{in_array('experience',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['experience'] ?? ''}}">{{$error['values']['experience'] ?? ''}}</td>

                    <td class="{{in_array('is_bank_guarantee_provided',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['is_bank_guarantee_provided'] ?? ''}}">{{$error['values']['is_bank_guarantee_provided'] ?? ''}}</td>

                    <td class="{{in_array('circumstance_short_notes',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['circumstance_short_notes'] ?? ''}}">{{$error['values']['circumstance_short_notes'] ?? ''}}</td>

                    <td class="{{in_array('is_action_against_proposer',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['is_action_against_proposer'] ?? ''}}">{{$error['values']['is_action_against_proposer'] ?? ''}}</td>

                    <td class="{{in_array('action_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['action_details'] ?? ''}}">{{$error['values']['action_details'] ?? ''}}</td>

                    <td class="{{in_array('contractor_failed_project_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['contractor_failed_project_details'] ?? ''}}">{{$error['values']['contractor_failed_project_details'] ?? ''}}</td>

                    <td class="{{in_array('completed_rectification_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['completed_rectification_details'] ?? ''}}">{{$error['values']['completed_rectification_details'] ?? ''}}</td>

                    <td class="{{in_array('performance_security_details',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['performance_security_details'] ?? ''}}">{{$error['values']['performance_security_details'] ?? ''}}</td>

                    <td class="{{in_array('relevant_other_information',$error['attribute']) ? 'bg-light-danger' : '' }}" data-toggle="tooltip" data-theme="dark" data-placement="left" title="{{$error['error']['relevant_other_information'] ?? ''}}">{{$error['values']['relevant_other_information'] ?? ''}}</td>
                </tr>
            @endforeach
        @else
        <tr>
            <td class="text-center" colspan="17">No errors were found.</td>
        </tr>
        @endif
    </tbody>
</table>