@if (isset($bond_policy_issue))
    <div class="card-body pl-12">
        <div class="text-right">
            <a href="{{ route('issue-bond-pdf', encryptId($proposals->id)) }}" target="_blank" class="btn btn-bg-blue btn-icon-info btn-hover-primary btn-icon mr-3 my-2 my-lg-0">
                <i class="flaticon2-print icon-md"></i>
            </a>
            <span class="h4">{{ $bond_policy_issue->reference_no ?? '' }}</span>
        </div>
        <table style="width:100%">
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.insured_name') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->insured_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.insured_address') }}
                </td>
                <td class="width_15em text-black">
                    {{ $proposals->contractor_bond_address ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_number') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->bond_number ?? '-' }}
                    @if($current_user->hasAnyAccess(['users.superadmin','bond_policies_issue.bond_number']) && $proposals->is_bond_foreclosure == 0 && $proposals->is_bond_cancellation == 0 && $proposals->is_invocation_notification == 0)
                        <i class="fas fa-edit cursor-pointer" data-toggle="modal" data-target="#bondNumberModal" title="Edit Bond Number & Stamp Paper" ></i>
                    @endif
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_stamp_paper') }}
                </td>
                <td class="width_15em text-black">
                    <a type="button" data-toggle="modal" data-target="#view_bond_stamp_paper_modal">
                        <i class="fas fa-file"></i>
                    </a>
                    <div class="modal fade" id="view_bond_stamp_paper_modal" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Bond Stamp Paper
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div data-scroll="true" data-height="100">
                                        @if (isset($bond_policy_issue_dms) && isset($bond_policy_issue_dms['bond_stamp_paper']) && count($bond_policy_issue_dms['bond_stamp_paper']) > 0)
                                            @foreach ($bond_policy_issue_dms['bond_stamp_paper'] as $document)
                                                <div class="row">
                                                    <div class="col">
                                                        {{ $loop->iteration }}.
                                                        {{ $document->file_name }}
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <a target="_blank"
                                                            href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}" download><i
                                                                class="fa fa-download text-black"></i></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.project_details') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->project_details ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.beneficiary') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->beneficiary->company_name ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_type') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->bondType->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.beneficiary_address') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->beneficiary_address ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.beneficiary_phone_no') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->beneficiary_phone_no ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_conditionality') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->bond_conditionality ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.contract_value') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->contract_value, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.contract_currency') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->currency->short_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr class="tr">
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_value') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->bond_value, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.cash_margin') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->cash_margin ?? '-' }} %
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.tender_id') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->tender_id ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_period_start_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_policy_issue->bond_period_start_date, 'd/m/Y') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_period_end_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_policy_issue->bond_period_end_date, 'd/m/Y') ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.bond_period') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->bond_period ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.rate') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->rate ?? '-' }} %
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.net_premium') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->net_premium, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.gst') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->gst ?? '-' }} %
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.gst_amount') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->gst_amount, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.gross_premium') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->gross_premium, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.stamp_duty_charges') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->stamp_duty_charges, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.total_premium') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->total_premium, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.intermediary_name') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->intermediary_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.intermediary_code') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue->intermediary_code ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.premium_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_policy_issue->premium_date, 'd/m/Y') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.premium_amount') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->premium_amount, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.additional_premium') }} {{ $currencySymbol }}
                </td>

                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue->additional_premium, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.special_condition') }}
                </td>
                <td class="width_15em text-black" colspan="3">
                    {{ $bond_policy_issue->special_condition ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
        </table>
    </div>
@else
    <div class="text-center mt-5">
        <strong>{{ __('common.no_records_found') }}</strong>
    </div>
@endif
@include('proposals.editBondNumber')