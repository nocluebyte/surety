@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('tender.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">

            @include('components.error')
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="tenderData">
                <div class="card">
                    <div class="card-header" id="faqHeading1">
                        <div class="d-flex justify-content-between flex-column flex-md-row col-lg-12">
                            <a class="card-title text-dark collapsed" data-toggle="collapse" href="#tenderTab"
                                aria-expanded="false" aria-controls="tenderTab" role="button">
                                <h3 class="font-weight-bolder pt-3">
                                    <span class="svg-icon svg-icon-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24"></polygon>
                                                <path
                                                    d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                                    fill="#000000" fill-rule="nonzero"></path>
                                                <path
                                                    d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                                    fill="#000000" fill-rule="nonzero" opacity="0.3"
                                                    transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999)">
                                                </path>
                                            </g>
                                        </svg>
                                    </span>&nbsp;
                                    {{ $tender->beneficiary->company_name ?? '' }}
                                </h3>
                            </a>

                            <span class="svg-icon mt-5" style="float:right;">
                                @if ($current_user->hasAnyAccess('tender.edit', 'users.superadmin'))
                                    <a href="{{ route('tender.edit', encryptId($tender->id)) }}"
                                        class="btn btn-light-primary btn-sm font-weight-bold">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                        {{ __('common.edit') }}
                                    </a>
                                @endif
                                @if ($current_user->hasAnyAccess('tender.delete', 'users.superadmin'))
                                    <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link"
                                        id="" href="{{ route('tender.destroy', [encryptId($tender->id)]) }}"
                                        aria-controls="delete" data-redirect="{{ route('tender.index') }}">
                                        <i class="fas fa-trash-alt fa-1x"></i>
                                        {{ __('common.delete') }}
                                    </a>
                                @endif
                                @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                                    <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info"
                                        data-toggle="modal" data-target="#AddModelInfo" data-table="{{ $table_name }}"
                                        data-id="{{ $tender->id }}" data-url="{{ route('get-info') }}">
                                        <span class="navi-icon">
                                            <i class="fas fa-info-circle fa-1x"></i>
                                        </span>
                                        <span class="navi-text">Info</span>
                                    </a>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div id="tenderTab" class="collapse" aria-labelledby="faqHeading1" data-parent="#tenderData">
                        <div class="pt-5 pr-15 pl-15">
                            <table style="width:100%">
                                <tr>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.tender_identification_number') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 30%">
                                        <div class="font-weight-bold text-black">
                                            {{ $tender->code ?? '-' }}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.tender_id') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 30%">
                                        <div class="font-weight-bold text-black">
                                            {{ $tender->tender_id ?? '-' }}
                                        </div>
                                    </td>
                                    {{-- <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.tender_reference_no') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold  text-black">
                                            {{ $tender->tender_reference_no ?? '' }}
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold text-black"></div>
                                    </td> --}}
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.tender_header') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 30%">
                                        <div class="font-weight-bold text-black">
                                            {{ $tender->tender_header ?? '-' }}
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.beneficiary') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 30%">
                                        <div class="font-weight-bold text-black">
                                            {{ $tender->beneficiary->company_name ?? '-' }}
                                        </div>
                                    </td>

                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.bin') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 30%">
                                        <div class="font-weight-bold text-black">
                                            {{ $tender->beneficiary->code ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('common.phone_no') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold  davy-grey-color">
                                            {{ $tender->phone_no ?? '' }}
                                        </div>
                                    </td>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold davy-grey-color text-black"></div>
                                    </td>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('common.phone_no') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold  text-black">
                                            {{ $tender->phone_no ?? '' }}
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold text-black"></div>
                                    </td>
                                </tr> --}}

                                {{-- <tr>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.contact_person_name') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold  davy-grey-color">
                                            {{ $tender->first_name ?? '' }} {{ $tender->middle_name ?? ''}} {{ $tender->last_name ?? ''}}
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold davy-grey-color text-black"></div>
                                    </td>
                                    <td style="width: 20%">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('tender.address') }}
                                        </div>
                                    </td>
                                    <td>:</td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold  text-black">
                                            {{ $tender->address ?? '' }}<br>
                                            {{ $tender->city ?? '' }}<br>
                                            {{ $tender->state->name ?? '' }},
                                            {{ $tender->country->name ?? '' }}
                                        </div>
                                    </td>
                                    <td style="width: 10%">
                                        <div class="font-weight-bold text-black"></div>
                                    </td>
                                </tr> --}}



                                {{-- <tr>
                                    @if (strtolower($tender->country->name) == 'india')
                                        <td style="width: 20%">
                                            <div class="font-weight-bold p-1 davy-grey-color">
                                                {{ __('common.pan_no') }}
                                            </div>
                                        </td>
                                        <td>:</td>
                                        <td style="width: 10%">
                                            <div class="font-weight-bold  davy-grey-color">
                                                {{ $tender->pan_no ?? '-' }}
                                            </div>
                                        </td>
                                    @endif
                                </tr> --}}
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card card-custom gutter-b">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-header">
                            <div class="card-toolbar">
                                <ul class="nav nav-light-success nav-bold nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#synopsis">
                                            <span class="nav-text">{{ __('principle.synopsis') }}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#proposal_details">
                                            <span class="nav-text">{{ __('tender.proposal_details') }}</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="card-body pt-3">
                            <div class="tab-content">
                                <div class="tab-pane fade active show pt-5" id="synopsis" role="synopsis" aria-labelledby="synopsis">
                                    @include('tender.tabs.synopsis')
                                </div>
                                <div class="tab-pane fade pt-5" id="proposal_details" role="proposal_details" aria-labelledby="proposal_details">
                                    @include('tender.tabs.proposal_details')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="tenderDocuments">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tender Documents</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <div class="modal-body">
                    @if (isset($tender_document) && count($tender_document) > 0)
                        @foreach ($tender_document as $item)
                            <div class="mb-3">
                                {{-- <a href="{{ isset($item->attachment) && !empty($item->attachment) ? asset($item->attachment) : asset('/default.jpg') }}"
                                    target="_blanck">
                                    {!! getdmsFileIcon($item->file_name) !!}
                                </a>
                                {!! $item->file_name !!} --}}

                                {!! getdmsFileIcon(e($item->file_name)) !!}&nbsp; {{ $item->file_name ?? '' }} <a href="{{ isset($item->attachment) ? route('secure-file', encryptId($item->attachment)) : '' }}" target="_blank" download><i class="fa fa-download text-black m-5" aria-hidden="true"></i>
                                </a>
                            </div>
                        @endforeach
                        {{-- <a href="{{ isset($tender_document->attachment) && !empty($tender_document->attachment) ? asset($tender_document->attachment) : asset('/default.jpg') }}"
                                                                target="_blanck">
                                                                {{ $tender_document->file_name }}
                                                            </a> --}}
                    @else
                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('info')
@endsection
