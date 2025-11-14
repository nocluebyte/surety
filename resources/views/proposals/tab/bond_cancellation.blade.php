@if (isset($bond_cancellation))
    <div class="card-body pl-12">
        <table style="width:100%">
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_notification.reference_no') }}
                </td>
                <td class="width_15em text-black">
                    {{ isset($bond_policy_issue) ? $bond_policy_issue->reference_no : '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_number') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->bond_number ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.contractor') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->proposal->contractor->company_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.beneficiary') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->proposal->beneficiary->company_name ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.project_details') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->proposal->projectDetails->project_name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.tender') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->proposal->tender->tender_id ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_type') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->proposal->getBondType->name ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_start_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_cancellation->bond_start_date, 'd/m/Y') ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_end_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_cancellation->bond_end_date, 'd/m/Y') ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_conditionality') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->bond_conditionality ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.premium_amount') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_cancellation->premium_amount, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.cancellation_date') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_cancellation->cancellation_date, 'd/m/Y') ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.bond_cancellation_attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a type="button" data-toggle="modal" data-target="#bond_cancellation_attachment_modal">
                        <i class="fas fa-file"></i>
                    </a>
                    <div class="modal fade" id="bond_cancellation_attachment_modal" tabindex="-1" role="dialog"
                        aria-labelledby="staticBackdrop" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Proof of ForeClosure
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i aria-hidden="true" class="ki ki-close"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div data-scroll="true" data-height="100">
                                        @if (isset($bond_cancellation_dms) &&
                                                isset($bond_cancellation_dms['bond_cancellation_attachment']) &&
                                                count($bond_cancellation_dms['bond_cancellation_attachment']) > 0)
                                            @foreach ($bond_cancellation_dms['bond_cancellation_attachment'] as $document)
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
                    {{ __('bond_cancellation.remarks') }}
                </td>
                <td class="width_15em text-black" colspan="3">
                    {{ $bond_cancellation->remarks ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.refund') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->is_refund ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            @if ($bond_cancellation->is_refund == 'Yes')
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_cancellation.refund_remarks') }}
                    </td>
                    <td class="width_15em text-black" colspan="3">
                        {{ $bond_cancellation->refund_remarks ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            @endif

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.original_bond_received') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->is_original_bond_received ?? '-' }}
                </td>

                @if ($bond_cancellation->is_original_bond_received == 'Yes')
                    <td class="width_15em text-light-grey">
                        {{ __('bond_cancellation.attachment') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#original_bond_received_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="original_bond_received_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Original Bond Received Attachment
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($bond_cancellation_dms) &&
                                                    isset($bond_cancellation_dms['original_bond_received_attachment']) &&
                                                    count($bond_cancellation_dms['original_bond_received_attachment']) > 0)
                                                @foreach ($bond_cancellation_dms['original_bond_received_attachment'] as $document)
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
                @endif
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.confirming_foreclosure') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->is_confirming_foreclosure ?? '-' }}
                </td>

                @if ($bond_cancellation->is_confirming_foreclosure == 'Yes')
                    <td class="width_15em text-light-grey">
                        {{ __('bond_cancellation.attachment') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#confirming_foreclosure_attachment_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="confirming_foreclosure_attachment_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Confirming ForeClosure Attachment
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($bond_cancellation_dms) &&
                                                    isset($bond_cancellation_dms['confirming_foreclosure_attachment']) &&
                                                    count($bond_cancellation_dms['confirming_foreclosure_attachment']) > 0)
                                                @foreach ($bond_cancellation_dms['confirming_foreclosure_attachment'] as $document)
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
                @endif
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_cancellation.any_other_proof') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_cancellation->is_any_other_proof ?? '-' }}
                </td>

                @if ($bond_cancellation->is_any_other_proof == 'Yes')
                    <td class="width_15em text-light-grey">
                        {{ __('bond_cancellation.attachment') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#any_other_proof_attachment_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="any_other_proof_attachment_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Any Other Proof Attachment
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($bond_cancellation_dms) &&
                                                    isset($bond_cancellation_dms['any_other_proof_attachment']) &&
                                                    count($bond_cancellation_dms['any_other_proof_attachment']) > 0)
                                                @foreach ($bond_cancellation_dms['any_other_proof_attachment'] as $document)
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
                @endif
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
