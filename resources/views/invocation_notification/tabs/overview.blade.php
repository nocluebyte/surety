<table style="width:100%">
    <tr>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.reference_no') }}
        </td>
        <td class="width_15em text-black">
            {{ $reference_no ?? '-' }}
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
            {{ $invocationData->bond_number ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.contractor') }}
        </td>
        <td class="width_15em text-black">
            {{ $contractor ?? '-' }}
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
            {{ $beneficiary ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.project_name') }}
        </td>
        <td class="width_15em text-black">
            {{ $project_name ?? '-' }}
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
            {{ $tender ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_conditionality') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->bond_conditionality ?? '-' }}
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
            {{ custom_date_format($invocationData->bond_start_date, 'd/m/Y') ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_end_date') }}
        </td>
        <td class="width_15em text-black">
            {{ custom_date_format($invocationData->bond_end_date, 'd/m/Y') ?? '-' }}
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
            {{ $invocationData->bondType->name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.proposal') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->proposal->code.'/V'.$invocationData->proposal->version ?? '-' }}
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
             {{ custom_date_format($invocationData->invocation_date, 'd/m/Y') ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.bond_amount') }}
        </td>
        <td class="width_15em text-black">
           {{ numberFormatPrecision($invocationData->invocation_amount, 0) ?? '-' }}
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
             {{ $invocationData->invocation_ext ?? '-' }}
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
             {{ $invocationData->officer_name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.designation') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->officer_designation ?? '-' }}
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
             {{ $invocationData->officer_email ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.mobile') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->officer_mobile ?? '-' }}
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
             {{ $invocationData->officer_land_line ?? '-' }}
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
             {{ $invocationData->incharge_name ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.designation') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->incharge_designation ?? '-' }}
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
             {{ $invocationData->incharge_email ?? '-' }}
        </td>
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.mobile') }}
        </td>
        <td class="width_15em text-black">
            {{ $invocationData->incharge_mobile ?? '-' }}
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
             {{ $invocationData->incharge_land_line ?? '-' }}
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
             {{ $invocationData->office_branch ?? '-' }}
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['invocation_notification_attachment']) &&
                                        count($dms_data['invocation_notification_attachment']) > 0)
                                    @foreach ($dms_data['invocation_notification_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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
             {{ $invocationData->office_address ?? '-' }}
        </td>   
        <td class="width_15em text-light-grey">
            {{ __('invocation_notification.reason') }}
        </td>
        <td class="width_15em text-black">
             {{ $invocationData->reason ?? '-' }}
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
             {{ $invocationData->remark ?? '-' }}
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['notice_attachment']) &&
                                        count($dms_data['notice_attachment']) > 0)
                                    @foreach ($dms_data['notice_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['contract_agreement']) &&
                                        count($dms_data['contract_agreement']) > 0)
                                    @foreach ($dms_data['contract_agreement'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['beneficiary_communication_attachment']) &&
                                        count($dms_data['beneficiary_communication_attachment']) > 0)
                                    @foreach ($dms_data['beneficiary_communication_attachment'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['legal_documents']) &&
                                        count($dms_data['legal_documents']) > 0)
                                    @foreach ($dms_data['legal_documents'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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
                                @if (isset($dms_data) &&
                                        isset($dms_data['any_other_documents']) &&
                                        count($dms_data['any_other_documents']) > 0)
                                    @foreach ($dms_data['any_other_documents'] as $document)
                                        <div class="row">
                                            <div class="col">
                                                {{ $loop->iteration }}.
                                                {{ $document->file_name }}
                                            </div>
                                            <div class="col-sm-2">
                                                <a target="_blank"
                                                    href="{{ asset($document->attachment) }}" download><i
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