@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('principle.index'),
        'text' => __('common.back'),
    ])
    @endcomponent
    @php
        $roles = $current_user->roles->first();
        $role_slug = $roles->slug ?? '';
    @endphp
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            @include('components.error')
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="faq">
                <div class="card">
                    <div class="card-header" id="faqHeading1">
                        <div class="d-flex justify-content-between flex-column flex-md-row col-lg-12">
                            <a class="card-title text-dark collapsed" data-toggle="collapse" href="#faq1"
                                aria-expanded="false" aria-controls="faq1" role="button">
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
                                    {{ $principle->company_name ?? '' }}
                                </h3>
                            </a>
                            <span class="svg-icon pt-5" style="float:right;">
                                @if ($principle->status == 'Approved')
                                    <div class="badge bg-success p-3">
                                        <span style="font-size:small;">
                                            {{ $principle->status ?? '' }}
                                        </span>
                                    </div>
                                @else
                                    <div class="badge bg-danger p-3">
                                        <span class="text-light" style="font-size:small;">
                                            {{ $principle->status ?? '' }}
                                        </span>
                                    </div>
                                @endif
                                @if ($current_user->hasAnyAccess('principle.edit', 'users.superadmin'))
                                    <a href="{{ route('principle.edit', encryptId($principle->id)) }}"
                                        class="btn btn-light-primary btn-sm font-weight-bold">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                        {{__('common.edit')}}
                                    </a>
                                @endif
                                <!-- @if ($current_user->hasAnyAccess('principle.delete', 'users.superadmin'))
    <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                                        href="{{ route('principle.destroy', [$principle->id]) }}" aria-controls="delete"
                                                        data-redirect="{{ route('principle.index') }}">
                                                        <i class="fas fa-trash-alt fa-1x"></i>
                                        {{__('common.delete')}}
                                                        </a>
    @endif -->
                                @if ($show_initiate_review && $current_user->hasAnyAccess('users.superadmin', 'principle.initiate_review'))
                                    <button
                                        class="btn btn-light-success btn-sm font-weight-bold" data-toggle="modal"
                                        data-original-title="Underwriter" data-target="#underwriterModal">
                                        <i class="fas fa-info-circle fa-1x"></i>
                                        {{ __('cases.initiate_review') }}
                                    </button>
                                @endif
                                @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                                    <a href=""
                                        class="btn btn-light-success btn-sm font-weight-bold show-info"
                                        data-toggle="modal" data-target="#AddModelInfo"
                                        data-table="{{ $table_name }}" data-id="{{ $principle->id }}"
                                        data-url="{{ route('get-info') }}">
                                        <span class="navi-icon">
                                            <i class="fas fa-info-circle fa-1x"></i>
                                        </span>
                                        <span class="navi-text">Info</span>
                                    </a>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div id="faq1" class="collapse" aria-labelledby="faqHeading1" data-parent="#faq">
                        <div class="pt-5 pr-15 pl-15 row">
                            <div class="col-3">
                                <div class="font-weight-bold pb-20 text-black">
                                    {{ $principle->company_name ?? '' }}<br>{{ $principle->address ?? '' }}<br>{{ $principle->city ?? '' }}
                                    - {{ $principle->pincode ?? '' }}<br>{{ $principle->state->name ?? '' }},
                                    {{ $principle->country->name ?? '' }}
                                </div>
                            </div>
                            <div class="col-9">
                                <table style="width:100%">
                                    <tr>
                                        {{-- <td class="pr-15" rowspan="7" colspan="2" style="width: 20%;">
                                            <div class=" font-weight-bold pb-20" style=" color : #000000;">
                                                {{ $principle->company_name ?? '' }}<br>{{ $principle->address ?? '' }}<br>{{ $principle->city ?? '' }}
                                                - {{ $principle->pincode ?? '' }}<br>{{ $principle->state->name ?? '' }},
                                                {{ $principle->country->name ?? '' }}
                                            </div>
                                        </td> --}}
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.principle_identification_number') }} </div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->code ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">
                                                {{ __('principle.registration_no') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">:
                                                {{ $principle->registration_no ?? '-' }}</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">
                                                {{ __('principle.website') }}</div>
                                        </td>
                                        <td>
                                            @php
                                                $website = $principle->website;
                                            @endphp
                                            <div class=" font-weight-bold text-black"><a
                                                    href="{{ $website ?? '' }}" target="_black" rel="noopener">:
                                                    {{ $principle->website ?? '-' }}</a></div>
                                        </td>

                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{ __('common.email') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->user->email ?? '-' }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    {{-- @if (strtolower($principle->country->name) == 'india') --}}
                                        <tr>
                                            <td>
                                                <div class="font-weight-bold p-1 text-light-grey">
                                                    {{ __('principle.pan_no') }}</div>
                                            </td>
                                            <td>
                                                <div class=" font-weight-bold text-black">:
                                                    {{ $principle->pan_no ?? '-' }}</div>
                                            </td>
    
                                            <td>
                                                <div class="font-weight-bold p-1 text-light-grey">
                                                    {{ __('common.gst_no') }}</div>
                                            </td>
                                            <td>
                                                <div class=" font-weight-bold text-black">:
                                                    {{ $principle->gst_no ?? '-' }}
                                                </div>
                                            </td>
                                        </tr>
                                    {{-- @endif --}}
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">
                                                {{ __('principle.date_of_incorporation') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">:
                                                {{ custom_date_format($principle->date_of_incorporation, 'd/m/Y') }}</div>
                                        </td>

                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.principle_type') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->principleType->name ?? '-' }}</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{  __('common.phone_no') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->user->mobile ?? '-' }}</div>
                                        </td>

                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.are_you_blacklisted') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->are_you_blacklisted ?? '-' }}</div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{  __('principle.entity_type') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->typeOfEntity->name ?? '-' }}</div>
                                        </td>

                                        {{-- <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{ __('principle.inception_date') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ isset($principle->inception_date) ? custom_date_format($principle->inception_date, 'd/m/Y') : '-' }}</div>
                                        </td> --}}
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{  __('principle.staff_strength') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->staff_strength ?? '-' }}</div>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold p-1 text-light-grey">{{  __('principle.venture_type') }}</div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold text-black">: {{ $principle->venture_type ?? '-' }}</div>
                                        </td>
                                    </tr>

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
                                                                @if (isset($dms_data['company_details']))
                                                                    @foreach ($dms_data['company_details'] as $document)
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
                                                                @if (isset($dms_data['company_technical_details']))
                                                                    @foreach ($dms_data['company_technical_details'] as $document)
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
                                                                @if (isset($dms_data['company_presentation']))
                                                                    @foreach ($dms_data['company_presentation'] as $document)
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
                                                                @if (isset($dms_data['certificate_of_incorporation']))
                                                                    @foreach ($dms_data['certificate_of_incorporation'] as $document)
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
                                                                @if (isset($dms_data['memorandum_and_articles']))
                                                                    @foreach ($dms_data['memorandum_and_articles'] as $document)
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
                                                                @if (isset($dms_data['gst_certificate']))
                                                                    @foreach ($dms_data['gst_certificate'] as $document)
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
                                                                @if (isset($dms_data['company_pan_no']))
                                                                    @foreach ($dms_data['company_pan_no'] as $document)
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
                                                                @if (isset($dms_data['last_three_years_itr']))
                                                                    @foreach ($dms_data['last_three_years_itr'] as $document)
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

                            <br><br>
                            <div class="my-5" style="border-bottom: 1px solid;"></div>

                            {{-- <div class="my-5">
                                <span class="width_15em text-light-grey">
                                    {{ __('proposals.rating_date') }} : 
                                </span>
                                <span class="width_15em text-black">{{ isset($principle->rating_date) ? custom_date_format($principle->rating_date, 'd/m/Y') : '-' }}</span>
                            </div> --}}

                            <table class="table table-separate table-head-custom table-checkable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('principle.agency_name')}}</th>
                                        <th>{{ __('principle.rating')}}</th>
                                        <th>{{ __('principle.remarks')}}</th>
                                        <th>{{ __('proposals.rating_date')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($principle->agencyRatingDetails) && $principle->agencyRatingDetails->count() > 0)
                                        @foreach ($principle->agencyRatingDetails as $key => $row)
                                        {{-- @dd($row) --}}
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->agencyName->agency_name ?? '-' }}</td>
                                                <td>{{ $row->rating ?? '-'  }}</td>
                                                <td style="width: 40%;">{{ $row->remarks ?? '-'  }}</td>
                                                <td>{{ isset($row->rating_date) ? custom_date_format($row->rating_date, 'd/m/Y') : '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>

                            <br>

                            <table class="table table-separate table-head-custom table-checkable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('principle.cin_number')}}</th>
                                        <th>{{ __('principle.contractor_name')}}</th>
                                        <th>{{ __('principle.pan_no') }}</th>
                                        <th>{{ __('principle.share_holding') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($contractorItem) && $contractorItem->count() > 0)
                                        @foreach ($contractorItem as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->code ?? '-'  }}</td>
                                        <td>{{ $row->company_name ?? '-'  }}</td>
                                                <td>{{ $row->pan_no ?? '-' }}</td>
                                                <td>{{ $row->share_holding ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <br>

                            <table class="table table-separate table-head-custom table-checkable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('principle.trade_sector')}}</th>
                                        <th>{{ __('principle.from') }}</th>
                                        <th>{{ __('principle.till') }}</th>
                                        <th>{{ __('principle.main') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($tradeSector) && $tradeSector->count() > 0)
                                        @foreach ($tradeSector as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->name ?? '-'  }}</td>
                                                <td>{{ custom_date_format($row->from ?? '-', 'd/m/Y') }}</td>
                                                <td>{{ $row->till ? custom_date_format($row->till, 'd/m/Y') : '-' }}</td>
                                                <td>{{ $row->is_main ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <br>

                            <table class="table table-separate table-head-custom table-checkable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('principle.contact_person')}}</th>
                                        <th>{{ __('common.email') }}</th>
                                        <th>{{ __('common.mobile') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($contactDetail) && $contactDetail->count() > 0)
                                        @foreach ($contactDetail as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->contact_person ?? '-'}}</td>
                                                <td>{{ $row->email ?? '-' }}</td>
                                                <td>{{ $row->phone_no ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="4">No data available</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="card card-custom gutter-b">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card card-custom">
                            <div class="card-header">
                                <div class="card-toolbar">
                                    <ul class="nav nav-light-success nav-boldest nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#synopsis">
                                                <span class="nav-text">{{ __('principle.synopsis') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#action_plan">
                                                <span class="nav-text">{{ __('principle.action_plan') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#parameter">
                                                <span class="nav-text">{{ __('principle.parameter') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab"
                                                href="#approved_limit">
                                                <span class="nav-text">{{ __('principle.approved_limit') }}</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#group_approved_limit">
                                                <span class="nav-text">Group Approved limit</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#dms">
                                                <span class="nav-text">DMS</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#analysis">
                                                <span class="nav-text">Analysis</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#invocation_notification">
                                                <span class="nav-text">Invocation Notification</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#recovery">
                                                <span class="nav-text">Recovery</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#adverse_information">
                                                <span class="nav-text">Adverse Information</span>
                                            </a>
                                        </li>
                                        {{-- <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#overdue">
                                                <span class="nav-text">Overdue</span>
                                            </a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#other_details">
                                                <span class="nav-text">Other Details</span>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#letter_of_award">
                                                <span class="nav-text">Letter of Award</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active pt-5" id="synopsis" role="tabpanel" aria-labelledby="synopsis">
                                        <table class="w-100">
                                            <tr>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.group_no')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th style="width: 10%">
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ $parent->contractor->code ?? $principle->code }}
                                                    </div>
                                                </th>
                                                
                                                <th style="width: 10%">
                                                    <div class="font-weight-bold davy-grey-color text-black"></div>
                                                </th>
                                                <td style="width: 20%">
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.group_name')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th style="width: 10%">
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ $parent->contractor->company_name ?? $principle->company_name }}
                                                    </div>
                                                </th>
                                                <th style="width: 10%">
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.total_approved_limit')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($total_approved_limit) && $total_approved_limit > 0 ? format_amount($total_approved_limit ?? '', '0') : '0' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.pending')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($total_pending_limit) ? numberFormatPrecision($total_pending_limit,0) : 0 }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.highest')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        0
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.spare_capacity')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($spare_capecity) ? numberFormatPrecision($spare_capecity,0) : 0}}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.individual_cap')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($total_individual_cap) && $total_individual_cap > 0 ? format_amount($total_individual_cap ?? '', '0', '.') : '0' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.overall_cap')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($total_overall_cap) && $total_overall_cap > 0 ? format_amount($total_overall_cap ?? '', '0', '.') : '0' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.group_cap')) }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($total_group_cap) && $total_group_cap > 0 ? format_amount($total_group_cap ?? 0, '0') : '0' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('principle.regular_review_date') }}</div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    @if (isset($casesLimitStrategy))
                                                        <div class="font-weight-bold text-right text-black">
                                                            {{ $casesLimitStrategy['proposed_valid_till'] ? custom_date_format($casesLimitStrategy['proposed_valid_till'], 'd/m/Y'): '' }}
                                                        </div>
                                                    @else
                                                        <div class="font-weight-bold text-right text-black">NA</div>
                                                    @endif
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.contractor_rating')) }}</div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ $principle->contractor_rating ?? '-' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('principle.contractor_rating_date') }}</div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($principle->contractor_rating_date) ? custom_date_format($principle->contractor_rating_date, 'd/m/Y') : '-' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">
                                                        {{ Form::label(__('principle.last_analysis_date')) }}
                                                    </div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                        {{ isset($principle->last_analysis_date) ?custom_date_format($principle->last_analysis_date,'d/m/Y') : 'N/A' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                                <td>
                                                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('principle.last_bs_date') }}</div>
                                                </td>
                                                <td>:</td>
                                                <th>
                                                    <div class="font-weight-bold text-right text-black">
                                                          {{ isset($principle->last_balance_sheet_date) ?custom_date_format($principle->last_balance_sheet_date,'d/m/Y') : 'N/A' }}
                                                    </div>
                                                </th>
                                                <th>
                                                    <div class="font-weight-bold text-black"></div>
                                                </th>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="parameter" role="tabpanel" aria-labelledby="action_plan">
                                        @include('principle.parameter')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="action_plan" role="tabpanel" aria-labelledby="action_plan">
                                        @include('principle.action_plan')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="approved_limit" role="tabpanel" aria-labelledby="approved_limit">
                                        @include('principle.approved_limit')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="group_approved_limit" role="tabpanel" aria-labelledby="group_approved_limit">
                                        @include('principle.group_approved_limit')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="dms" role="tabpanel" aria-labelledby="dms">
                                        @include('principle.tabs.dms.index')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="analysis" role="tabpanel" aria-labelledby="analysis">
                                        @include('principle.analysis')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="invocation_notification" role="tabpanel" aria-labelledby="invocation_notification">
                                        @include('principle.invocation_notification')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="recovery" role="tabpanel" aria-labelledby="recovery">
                                        @include('principle.recovery')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="adverse_information" role="tabpanel"
                                        aria-labelledby="adverse_information">
                                        @include('principle.adverse_information')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="overdue" role="tabpanel"
                                        aria-labelledby="overdue">
                                        @include('principle.overdue')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="other_details" role="tabpanel"
                                        aria-labelledby="other_details">
                                        @include('principle.other_details')
                                    </div>
                                    <div class="tab-pane fade show pt-5" id="letter_of_award" role="tabpanel"
                                        aria-labelledby="letter_of_award">
                                        @include('principle.letter_of_award')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="load-modal"></div>

    <div class="modal fade" id="underwriterModal" tabindex="-1" role="dialog" aria-labelledby="underwriterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="underwriterModalLabel">Initiate Review</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form method="post" action="{{ route('principle.initiateReview') }}">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="principle_id" value="{{ $principle->id }}">

                        <div class="form-group">
                            {{ Form::label('underwriter', __('cases.underwriter')) }}
                            {{ Form::select('underwriter_id', ['' => 'Select'] + $underwriter, null, ['class' => 'form-control underwriter', 'data-placeholder' => 'Select underwriter']) }}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Save</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    @include('info')
    @push('scripts')
        <script>
            $(document).ready(function(){
                $('.actionModal').click(function(){
                    $('.modal-common-title').text($(this).data('title'));
                });
                $(document).on('click', '.actionModal', function() {
                    var curTab = $(this).attr('data-tab');
                    $(`.${curTab}`).tab('show');
                    return false;
                });

            });

            $('.underwriter').select2({
                allowClear: true,
            })
        </script>
    @endpush
@endsection
@include('principle.script')
