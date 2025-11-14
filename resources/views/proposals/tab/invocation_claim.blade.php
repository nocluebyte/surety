@if (isset($invocationClaimData))
    <div class="card-body pl-12">
        <table style="width:100%">
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.bond_type') }}
                </td>
                <td class="width_15em text-black">
                    {{ $invocationClaimData->bondType->name ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.proposal') }}
                </td>
                <td class="width_15em text-black">
                    {{ $invocationClaimData->proposal->code.'V/'.$invocationClaimData->proposal->version ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.bond_detail') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->bond_detail ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.conditional') }}
                </td>
                <td class="width_15em text-black">
                   {{ $invocationClaimData->conditional ?? '-' }}
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
             <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.bond_wordings') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->bond_wording ?? '-' }}
                </td>                            
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.invocation_notice_date') }}
                </td>
                <td class="width_15em text-black">
                     {{ custom_date_format($invocationClaimData->invocation_notice_date, 'd/m/Y') ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.invocation_claim_date') }}
                </td>
                <td class="width_15em text-black">
                     {{ custom_date_format($invocationClaimData->invocation_claim_date, 'd/m/Y') ?? '-' }}
                </td>
               
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.claim_form') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->claim_form ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#claim_form_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="claim_form_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Claim Form Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['claim_form_attachment']) && count($invocationClaimDms['claim_form_attachment']) > 0)
                                        @foreach ($invocationClaimDms['claim_form_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.invocation_notice') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->invocation_notice ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#invocation_notice_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="invocation_notice_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Invocation Notice Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['invocation_notice_attachment']) && count($invocationClaimDms['invocation_notice_attachment']) > 0)
                                        @foreach ($invocationClaimDms['invocation_notice_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.correspondence_details') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->correspondence_details ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#correspondence_detail_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="correspondence_detail_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Correspondence Detail Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['correspondence_detail_attachment']) && count($invocationClaimDms['correspondence_detail_attachment']) > 0)
                                        @foreach ($invocationClaimDms['correspondence_detail_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.contract_copy') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->contract_copy ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#contract_copy_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="contract_copy_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Contract Copy Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['contract_copy_attachment']) && count($invocationClaimDms['contract_copy_attachment']) > 0)
                                        @foreach ($invocationClaimDms['contract_copy_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.arbitration') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->arbitration ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#arbitration_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="arbitration_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Arbitration Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['arbitration_attachment']) && count($invocationClaimDms['arbitration_attachment']) > 0)
                                        @foreach ($invocationClaimDms['arbitration_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.dispute') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->dispute ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.attachment') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#dispute_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="dispute_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Dispute Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['dispute_attachment']) && count($invocationClaimDms['dispute_attachment']) > 0)
                                        @foreach ($invocationClaimDms['dispute_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.bank_name') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->bank_name ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.account_number') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->account_number ?? '-' }}
                </td>
               
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.address') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->bank_address ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.account_type') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->account_type ?? '-' }}
                </td>
               
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.micr') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->micr ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.ifsc_code') }}
                </td>
                <td class="width_15em text-black">
                     {{ $invocationClaimData->ifsc_code ?? '-' }}
                </td>
               
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.cancelled_cheque') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#cancelled_cheque_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="cancelled_cheque_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cancelled Cheque</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['cancelled_cheque']) && count($invocationClaimDms['cancelled_cheque']) > 0)
                                        @foreach ($invocationClaimDms['cancelled_cheque'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.claimed_amount') }}
                </td>
                <td class="width_15em text-black">
                    {{ numberFormatPrecision($invocationClaimData->claimed_amount, 0) ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.claimed_disallowed') }}
                </td>
                <td class="width_15em text-black">
                     {{ numberFormatPrecision($invocationClaimData->claimed_disallowed, 0) ?? '-' }}
                </td>
               
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.total_claim_approved') }}
                </td>
                <td class="width_15em text-black">
                    {{ $invocationClaimData->total_claim_approved ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.assessment_note') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#assessment_note_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="assessment_note_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Assessment Note Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['assessment_note_attachment']) && count($invocationClaimDms['assessment_note_attachment']) > 0)
                                        @foreach ($invocationClaimDms['assessment_note_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.remarks') }}
                </td>
                <td class="width_15em text-black">
                    {{ $invocationClaimData->remark ?? '-' }}
                </td>
                <td class="width_15em text-light-grey">
                    {{ __('invocation_claims.approval_note') }}
                </td>
                <td class="width_15em text-black">
                    <a href="#" data-toggle="modal" data-target="#approval_note_attachment_model"
                        class="call-modal navi-link">
                        <i class="fa fa-file" aria-hidden="true"></i>
                    </a>

                    <div class="modal fade" tabindex="-1" id="approval_note_attachment_model">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Approval Note Attachment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    @if (isset($invocationClaimDms['approval_note_attachment']) && count($invocationClaimDms['approval_note_attachment']) > 0)
                                        @foreach ($invocationClaimDms['approval_note_attachment'] as $item)
                                            <div class="mb-3">
                                                {!! getdmsFileIcon($item->file_name) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ asset($item->attachment ?? '') }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    @else
                                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                                    @endif
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
                    {{ __('invocation_claims.status') }}
                </td>
                <td class="width_15em text-black">
                    {{ $invocationClaimData->status ?? '-' }}
                </td>                           
            </tr>
        </table>
        <div id="load-modal"></div>
    </div>
@endif
