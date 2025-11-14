<div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="contractorAccordion">
    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title" data-toggle="collapse" data-target="#collapsecontractor" aria-expanded="false">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"></path>
                            <path
                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                            </path>
                        </g>
                    </svg>
                </span>
                <div class="card-label pl-4">Contractor Details</div>
            </div>
        </div>
        <div id="collapsecontractor" class="collapse show" data-parent="#contractorAccordion">
            <div class="card-body">


                <table class="w-100">
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label('entity_type', __('cases.entity_type')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{ $case->contractor->typeOfEntity->name ?? '' }}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.gst_no')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->contractor->gst_no ?? '' }}</div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.status')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->contractor->status ?? ''}}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.pan_no')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->contractor->pan_no ?? ''}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('principle.registration_no')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->contractor->registration_no ?? '' }}
                            </div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.address')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->contractor->address ?? ''}} -
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.phone_no')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->contractor->user->mobile ?? ''}}</div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.pincode')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->contractor->pincode ?? ''}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                         <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">{!! Form::label(__('common.email')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->contractor->user->email ?? ''}}</div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('common.city')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->contractor->city ?? ''}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('principle.website')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">: {{ $case->contractor->website ?? ''}}</div>
                        </th>
                        <th width="12%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label('', __('cases.incharge')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class=" font-weight-bold  text-black">:
                                {{$case->underwriter_user_name ?? ''}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        <th width="10%">
                            <div class="font-weight-bold p-1 davy-grey-color">
                                {!! Form::label(__('cases.incharge_since')) !!}
                            </div>
                        </th>
                        <th width="25%">
                            <div class="font-weight-bold text-black">:
                                {{ custom_date_format($case->underwriter_assigned_date, 'd/m/Y | H:i')}}
                            </div>
                        </th>
                    </tr>
                </table>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapsetradsector"
                aria-expanded="false">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"></path>
                            <path
                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                            </path>
                        </g>
                    </svg>
                </span>
                <div class="card-label pl-4">{{ __('cases.tradesector') }}</div>
            </div>
        </div>
        <div id="collapsetradsector" class="collapse" data-parent="#contractorAccordion">
            <div class="card-body">
                <table class="table table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th class="p-2">{{ __('common.no') }}</th>
                            <th class="p-2 w-40">
                                {{ __('proposals.trade_sector') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.from') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.till') }}
                            </th>
                            <th class="p-2 w-20">
                                {{ __('proposals.main') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($case->contractor->tradeSector) && $case->contractor->tradeSector->count() > 0)
                            @foreach ($case->contractor->tradeSector as $item)
                                <tr>
                                    <td class="p-2">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="p-2">
                                        {{ $item->tradeSector->name ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ custom_date_format($item->from, 'd/m/Y') ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ custom_date_format($item->till, 'd/m/Y') ?? '-' }}
                                    </td>
                                    <td class="p-2">
                                        {{ $item->is_main ?? '-' }}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-center">
                                <td colspan="10">
                                    {{ __('common.no_records_found') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header" id="headingOne7">
            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapseContractorKycDocuments"
                aria-expanded="false">
                <span class="svg-icon svg-icon-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                        height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path
                                d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                fill="#000000" fill-rule="nonzero"></path>
                            <path
                                d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                fill="#000000" fill-rule="nonzero" opacity="0.3"
                                transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) ">
                            </path>
                        </g>
                    </svg>
                </span>
                <div class="card-label pl-4">{{ __('cases.contractor_kyc_documents') }}</div>
            </div>
        </div>
        <div id="collapseContractorKycDocuments" class="collapse" data-parent="#contractorAccordion">
            <div class="card-body">
                <table class="table" style="width:100%">
                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.company_details') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#company_details_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="company_details_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['company_details']))
                                                    @foreach ($contractor_kyc_documents['company_details'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.company_technical_details') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#company_technical_details_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="company_technical_details_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['company_technical_details']))
                                                    @foreach ($contractor_kyc_documents['company_technical_details'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.company_presentation') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#company_presentation_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="company_presentation_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['company_presentation']))
                                                    @foreach ($contractor_kyc_documents['company_presentation'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.certificate_of_incorporation') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#certificate_of_incorporation_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="certificate_of_incorporation_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['certificate_of_incorporation']))
                                                    @foreach ($contractor_kyc_documents['certificate_of_incorporation'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.memorandum_and_articles') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#memorandum_and_articles_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="memorandum_and_articles_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['memorandum_and_articles']))
                                                    @foreach ($contractor_kyc_documents['memorandum_and_articles'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.gst_certificate') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#gst_certificate_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="gst_certificate_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['gst_certificate']))
                                                    @foreach ($contractor_kyc_documents['gst_certificate'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.company_pan_no') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#company_pan_no_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="company_pan_no_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['company_pan_no']))
                                                    @foreach ($contractor_kyc_documents['company_pan_no'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.last_three_years_itr') }}</div>
                        </td>
                        <td>
                            <a type="button" data-toggle="modal"
                                data-target="#last_three_years_itr_modal">
                                <i class="fas fa-file"></i>
                            </a>

                            <div class="modal fade"
                                id="last_three_years_itr_modal"
                                tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Attachment
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <i aria-hidden="true" class="ki ki-close"></i>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div data-scroll="true" data-height="100">
                                                @if (isset($contractor_kyc_documents['last_three_years_itr']))
                                                    @foreach ($contractor_kyc_documents['last_three_years_itr'] as $document)
                                                        <div class="row">
                                                            <div class="col">
                                                                {{ $loop->iteration }}.
                                                                {{ $document->file_name }}
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <a target="_blank" href="{{ isset($document->attachment) ? route('secure-file', encryptId($document->attachment)) : '' }}" download><i class="fa fa-download text-black"></i></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <img src="{{ asset('/default.jpg') }}" alt="default"
                                                        height="35" width="25">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>