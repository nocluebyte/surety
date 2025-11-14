@if (isset($bond_policy_issue_checklist))
    <div class="card-body pl-12">
        <table style="width:100%">
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.premium_amount') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue_checklist->premium_amount, 0) ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.past_premium') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue_checklist->past_premium, 0) ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.net_premium') }} {{ $currencySymbol }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($bond_policy_issue_checklist->net_premium, 0) ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.utr_neft_details') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue_checklist->utr_neft_details ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.date_of_receipt') }}
                </td>
                <td class="width_15em text-black">
                    {{ custom_date_format($bond_policy_issue_checklist->date_of_receipt, 'd/m/Y') ?? '-' }}
                </td>

                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.booking_office_detail') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue_checklist->booking_office_detail ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.executed_deed_indemnity') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue_checklist->executed_deed_indemnity ?? '-' }}
                </td>
                @if ($bond_policy_issue_checklist->executed_deed_indemnity == 'Yes')
                    <td class="width_15em text-light-grey">
                        {{ __('proposals.deed_attach_document') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#deed_attach_document_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="deed_attach_document_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Deed Attach Document
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($issue_checklist_dms) && isset($issue_checklist_dms['deed_attach_document']) && count($issue_checklist_dms['deed_attach_document']) > 0)
                                                @foreach ($issue_checklist_dms['deed_attach_document'] as $document)
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

            @if ($bond_policy_issue_checklist->executed_deed_indemnity == 'No')
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.remarks') }}
                    </td>
                    <td class="width_15em text-black" colspan="3">
                        {{ $bond_policy_issue_checklist->deed_remarks ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            @endif

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('proposals.executed_board_resolution') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue_checklist->executed_board_resolution ?? '-' }}
                </td>
                @if ($bond_policy_issue_checklist->executed_board_resolution == 'Yes')
                    <td class="width_15em text-light-grey">
                        {{ __('proposals.board_attach_document') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#board_attach_document_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="board_attach_document_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Board Attach Document
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($issue_checklist_dms) && isset($issue_checklist_dms['board_attach_document']) && count($issue_checklist_dms['board_attach_document']) > 0)
                                                @foreach ($issue_checklist_dms['board_attach_document'] as $document)
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

            @if ($bond_policy_issue_checklist->executed_board_resolution == 'No')
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.remarks') }}
                    </td>
                    <td class="width_15em text-black" colspan="3">
                        {{ $bond_policy_issue_checklist->board_remarks ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            @endif

            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('bond_policies_issue.broker_mandate') }}
                </td>
                <td class="width_15em text-black">
                    {{ $bond_policy_issue_checklist->broker_mandate ?? '-' }}
                </td>
                @if ($bond_policy_issue_checklist->broker_mandate == 'Broker')
                    <td class="width_15em text-light-grey">
                        {{ __('proposals.broker_attach_document') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#broker_attach_document_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="broker_attach_document_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Broker Attach Document
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($issue_checklist_dms) && isset($issue_checklist_dms['broker_attach_document']) && count($issue_checklist_dms['broker_attach_document']) > 0)
                                                @foreach ($issue_checklist_dms['broker_attach_document'] as $document)
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
                                                <img height="35px;" width="25px;"
                                                    src="{{ asset('/default.jpg') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                @elseif ($bond_policy_issue_checklist->broker_mandate == 'Agent')
                    <td class="width_15em text-light-grey">
                        {{ __('proposals.agent_attach_document') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#agent_attach_document_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="agent_attach_document_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Agent Attach Document
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($issue_checklist_dms) && isset($issue_checklist_dms['agent_attach_document']) && count($issue_checklist_dms['agent_attach_document']) > 0)
                                                @foreach ($issue_checklist_dms['agent_attach_document'] as $document)
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
                                                <img height="35px;" width="25px;"
                                                    src="{{ asset('/default.jpg') }}">
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

            {{-- @if ($bond_policy_issue_checklist->collateral_available == 'Yes') --}}
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.collateral_available') }}
                    </td>
                    <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->collateral_available ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            {{-- @endif --}}

            @if ($bond_policy_issue_checklist->collateral_available == 'Yes')
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.fd_amount') }} {{ $currencySymbol }}
                    </td>
                    <td class="width_15em text-black">
                        {{ numberFormatPrecision($bond_policy_issue_checklist->fd_amount, 0) ?? '-' }}
                    </td>

                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.fd_issuing_bank_name') }}
                    </td>
                    <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->fd_issuing_bank_name ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.fd_issuing_branch_name') }}
                    </td>
                    <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->fd_issuing_branch_name ?? '-' }}
                    </td>

                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.fd_receipt_number') }}
                    </td>
                    <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->fd_receipt_number ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>

                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.bank_address') }}
                    </td>
                    <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->bank_address ?? '-' }}
                    </td>

                    <td class="width_15em text-light-grey">
                        {{ __('proposals.collateral_attach_document') }}
                    </td>
                    <td class="width_15em text-black">
                        <a type="button" data-toggle="modal" data-target="#collateral_attach_document_modal">
                            <i class="fas fa-file"></i>
                        </a>
                        <div class="modal fade" id="collateral_attach_document_modal" tabindex="-1" role="dialog"
                            aria-labelledby="staticBackdrop" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Collateral Attach Document
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i aria-hidden="true" class="ki ki-close"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div data-scroll="true" data-height="100">
                                            @if (isset($issue_checklist_dms) && isset($issue_checklist_dms['collateral_attach_document']) && count($issue_checklist_dms['collateral_attach_document']) > 0)
                                                @foreach ($issue_checklist_dms['collateral_attach_document'] as $document)
                                                    <div class="row">
                                                        <div class="col">
                                                            {{ $loop->iteration }}.
                                                            {{ $document->file_name }}
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <a target="_blank" href="{{ isset($document->attachment) && !empty($document->attachment) ? route('secure-file', encryptId($document->attachment)) : asset('/default.jpg') }}"
                                                                download><i class="fa fa-download text-black"></i></a>
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
                    <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_details')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_type ?? '-' }}
                    </td>
                     <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_code')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_code ?? '-' }}
                    </td>
                     <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_name')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_name ?? '-' }}
                    </td>
                </tr>
                 <tr>
                    <td>&nbsp;</td>
                </tr>
                   <tr>
                    <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_email')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_email ?? '-' }}
                    </td>
                     <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_mobile')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_mobile ?? '-' }}
                    </td>
                     <td class="width_15em text-light-grey">{{__('bond_policies_issue.intermediary_address')}}</td>
                     <td class="width_15em text-black">
                        {{ $bond_policy_issue_checklist->intermediary_detail_address ?? '-' }}
                    </td>
                </tr>
                 <tr>
                    <td>&nbsp;</td>
                </tr>
            @else
                <tr>
                    <td class="width_15em text-light-grey">
                        {{ __('bond_policies_issue.remarks') }}
                    </td>
                    <td class="width_15em text-black" colspan="3">
                        {{ $bond_policy_issue_checklist->collateral_remarks ?? '-' }}
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            @endif
        </table>
    </div>
@else
    <div class="text-center mt-5">
        <strong>{{ __('common.no_records_found') }}</strong>
    </div>
@endif
