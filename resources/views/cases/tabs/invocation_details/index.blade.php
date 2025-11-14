<table style="width:100%">
    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.reference_no') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->bondPoliciesIssue->reference_no ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_number') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->bond_number ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.contractor') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->contractor->company_name ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.beneficiary') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->beneficiary->company_name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.project_name') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->projectDetails->project_name ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.tender') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->tender->tender_id ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_conditionality') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->bond_conditionality ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_start_date') }}
        </td>
        <td class="width_15em text-black">
            {{ custom_date_format($case->casesable->bond_start_date, 'd/m/Y') ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_end_date') }}
        </td>
        <td class="width_15em text-black">
            {{ custom_date_format($case->casesable->bond_end_date, 'd/m/Y') ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_type') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->bondType->name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.proposal') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->proposal->code.'/V'.$case->casesable->proposal->version ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.invocation_date') }}
        </td>
        <td class="width_15em text-black">
             {{ custom_date_format($case->casesable->invocation_date, 'd/m/Y') ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_amount') }} {{ $case->casesable->contractor->country->currency->symbol ?? '' }}
        </td>
        <td class="width_15em text-black">
           {{ numberFormatPrecision($case->casesable->invocation_amount, 0) ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.invocation_ext') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->invocation_ext ?? '-' }}
        </td>                            
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.officer_invoking')}}</strong>:</h6></td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.name') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->officer_name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.designation') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->officer_designation ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.email') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->officer_email ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.mobile') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->officer_mobile ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.land_line') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->officer_land_line ?? '-' }}
        </td>                            
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.official_incharge')}}</strong></h6></td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.name') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->incharge_name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.designation') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->incharge_designation ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.email') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->incharge_email ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.mobile') }}
        </td>
        <td class="width_15em text-black">
            {{ $case->casesable->incharge_mobile ?? '-' }}
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.land_line') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->incharge_land_line ?? '-' }}
        </td>                            
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.beneficiary_office_details')}}</strong></h6></td>
    </tr>
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.branch') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->office_branch ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.attachment') }}
        </td>
        <td class="width_15em text-black">
            {{-- @if (isset($dms_data['invocation_notification_attachment']))
                @foreach ($dms_data['invocation_notification_attachment'] as $item)
                    <a href="{{ isset($item->attachment) && !empty($item->attachment) ? asset($item->attachment) : asset('/default.jpg') }}"
                        target="_blanck" title="{{ $item->file_name }}"
                        download>
                        <i class="fa fa-download text-black"></i>
                    </a>
                @endforeach
            @else
                <img height="35px;" width="25px;"
                    src="{{ asset('/default.jpg') }}">
            @endif --}}



            <a type="button" data-toggle="modal" data-target="#invocation_notification_attachment_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="invocation_notification_attachment_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Invocation Notification Attachment
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['invocation_notification_attachment']) &&
                                        count($invocation_details_dms_data['invocation_notification_attachment']) > 0)
                                    @foreach ($invocation_details_dms_data['invocation_notification_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.address') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->office_address ?? '-' }}
        </td>   
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.reason') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->reason ?? '-' }}
        </td>                          
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr> 
    <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.notice_details')}}</strong></h6></td>
    </tr>                       
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.remark') }}
        </td>
        <td class="width_15em text-black">
             {{ $case->casesable->remark ?? '-' }}
        </td>   
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.attachment') }}
        </td>
        <td class="width_15em text-black">
            <a type="button" data-toggle="modal" data-target="#notice_attachment_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="notice_attachment_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Notice Attachment
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['notice_attachment']) &&
                                        count($invocation_details_dms_data['notice_attachment']) > 0)
                                    @foreach ($invocation_details_dms_data['notice_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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
    {{-- <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.invocation_closed')}}</strong></h6></td>
    </tr> 
    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.reason') }}
        </td>
        <td class="width_15em text-black">
             {{ $invocationData->closed_reason ?? '-' }}
        </td>  
    </tr>                          --}}

    <tr class="border-top">                            
        <td><h6><br/><strong>{{__('invocation_notification.documents')}}</strong></h6></td>
    </tr>

    <tr>
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.contract_agreement') }}
        </td>
        <td class="width_15em text-black">
            <a type="button" data-toggle="modal" data-target="#contract_agreement_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="contract_agreement_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Contract Agreement Attachment
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['contract_agreement']) &&
                                        count($invocation_details_dms_data['contract_agreement']) > 0)
                                    @foreach ($invocation_details_dms_data['contract_agreement'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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

        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.beneficiary_communication_attachment') }}
        </td>
        <td class="width_15em text-black">
            <a type="button" data-toggle="modal" data-target="#beneficiary_communication_attachment_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="beneficiary_communication_attachment_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Beneficiary Communication with Contractor
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['beneficiary_communication_attachment']) &&
                                        count($invocation_details_dms_data['beneficiary_communication_attachment']) > 0)
                                    @foreach ($invocation_details_dms_data['beneficiary_communication_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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
        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.legal_documents') }}
        </td>
        <td class="width_15em text-black">
            <a type="button" data-toggle="modal" data-target="#legal_documents_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="legal_documents_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Legal Documents
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['legal_documents']) &&
                                        count($invocation_details_dms_data['legal_documents']) > 0)
                                    @foreach ($invocation_details_dms_data['legal_documents'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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

        <td class="width_15em text-light-grey pl-8">
            {{ __('invocation_notification.any_other_documents') }}
        </td>
        <td class="width_15em text-black">
            <a type="button" data-toggle="modal" data-target="#any_other_documents_modal">
                <i class="fas fa-file"></i>
            </a>
            <div class="modal fade" id="any_other_documents_modal" tabindex="-1" role="dialog"
                aria-labelledby="staticBackdrop" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Any Other Documents
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i aria-hidden="true" class="ki ki-close"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div data-scroll="true" data-height="100">
                                @if (isset($invocation_details_dms_data) &&
                                        isset($invocation_details_dms_data['any_other_documents']) &&
                                        count($invocation_details_dms_data['any_other_documents']) > 0)
                                    @foreach ($invocation_details_dms_data['any_other_documents'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i
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
</table>