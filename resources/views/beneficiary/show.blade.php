@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('beneficiary.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

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
                                    {{ $beneficiary->company_name ?? '' }}
                                </h3>
                            </a>
                            <span class="svg-icon pt-5" style="float:right;">
                                @if ($current_user->hasAnyAccess('beneficiary.edit', 'users.superadmin'))
                                    <a href="{{ route('beneficiary.edit', encryptId($beneficiary->id)) }}"
                                        class="btn btn-light-primary btn-sm font-weight-bold">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                        {{ __('common.edit') }}
                                    </a>
                                @endif
                                <!-- @if ($current_user->hasAnyAccess('beneficiary.delete', 'users.superadmin'))
    <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                        href="{{ route('beneficiary.destroy', [$beneficiary->id]) }}" aria-controls="delete"
                                        data-redirect="{{ route('beneficiary.index') }}">
                                        <i class="fas fa-trash-alt fa-1x"></i>
                                            {{ __('common.delete') }}
                                        </a>
    @endif -->
                                {{-- @if ($show_initiate_review)
                                    <button class="btn btn-light-success btn-sm font-weight-bold" data-toggle="modal"
                                        data-original-title="Underwriter" data-target="#underwriterModal">
                                        <i class="fas fa-info-circle fa-1x"></i>
                                        {{ __('cases.initiate_review') }}
                                    </button>
                                @endif --}}
                                @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                                    <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info"
                                        data-toggle="modal" data-target="#AddModelInfo" data-table="{{ $table_name }}"
                                        data-id="{{ $beneficiary->id }}" data-url="{{ route('get-info') }}">
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
                        <div class="pt-5 pr-15 pl-15">
                            <table style="width:100%">
                                <tr>
                                    <td class="pr-15" rowspan="7" colspan="2" style="width: 20%;">
                                        <div class=" font-weight-bold pb-20 text-black">
                                            {{ $beneficiary->company_name ?? '' }}<br>{{ $beneficiary->address ?? '' }}<br>{{ $beneficiary->city ?? '' }}
                                            - {{ $beneficiary->pincode ?? '' }}<br>{{ $beneficiary->state->name ?? '' }},
                                            {{ $beneficiary->country->name ?? '' }}
                                        </div>
                                    </td>
                                    <td style="width: 15%;">
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.beneficiary_identification_number') }} </div>
                                    </td>
                                    <td style="width: 12%;">
                                        <div class=" font-weight-bold  text-black">: {{ $beneficiary->code ?? '-' }}</div>
                                    </td>

                                    <td>
                                        <div class="font-weight-bold p-1  davy-grey-color">
                                            {{ __('beneficiary.registration_no') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->registration_no ?? '-' }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    {{-- <td>
                                        <div class="font-weight-bold p-1davy-grey-color">
                                            {{ __('beneficiary.company_code') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">: {{ $beneficiary->company_code ?? '-' }}
                                        </div>
                                    </td> --}}
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.email') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->user->email ?? '-' }}</a>
                                        </div>
                                    </td>

                                    <td style="width: 12%;">
                                        <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.phone_no') }}</div>
                                    </td>
                                    <td style="width: 12%;">
                                        <div class=" font-weight-bold  text-black">: {{ $beneficiary->user->mobile ?? '-' }}
                                        </div>
                                    </td>
                                </tr>
                                {{-- <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.reference_code') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->reference_code ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">{{ __('beneficiary.website') }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $website = $beneficiary->website;
                                        @endphp
                                        <div class=" font-weight-bold  text-black"><a href="{{ $website ?? '' }}"
                                                target="_black" rel="noopener">: {{ $beneficiary->website ?? '-' }}</a>
                                        </div>
                                    </td>
                                </tr> --}}

                                @if (strtolower($beneficiary->country->name) == 'india')
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.pan_no') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold  text-black">: {{ $beneficiary->pan_no ?? '-' }}
                                            </div>
                                        </td>

                                        <td>
                                            <div class="font-weight-bold p-1 davy-grey-color">{{ __('common.gst_no') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class=" font-weight-bold  text-black">: {{ $beneficiary->gst_no ?? '-' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endif

                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">{{ __('beneficiary.website') }}
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $website = $beneficiary->website;
                                        @endphp
                                        <div class=" font-weight-bold  text-black"><a href="{{ $website ?? '' }}"
                                                target="_black" rel="noopener">: {{ $beneficiary->website ?? '-' }}</a>
                                        </div>
                                    </td>

                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.beneficiary_type') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->beneficiary_type ?? '-' }}</div>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.establishment_type') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->establishmentTypeId->name ?? '-' }}</div>
                                    </td>

                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.ministry_type') }}</div>
                                    </td>
                                    <td>
                                        <div class=" font-weight-bold  text-black">:
                                            {{ $beneficiary->ministryType->name ?? '-' }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.bond_wording') }}</div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold text-black">:
                                            <span class="d-inline-block text-truncate" style="max-width: 200px;">
                                                {{ $beneficiary->bond_wording ?? '' }}
                                            </span>
                                            
                                            @if(Str::of($beneficiary->bond_wording)->length() > 30)
                                                <a href="#" data-toggle="modal" data-target="#bondWording" class="call-modal navi-link">...Read More</a>
                                            @endif
                                        </div>

                                        <div class="modal fade" tabindex="-1" id="bondWording">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{ __('beneficiary.bond_wording') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">
                                                        {{ $beneficiary->bond_wording ?? '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-weight-bold p-1 davy-grey-color">
                                            {{ __('beneficiary.bond_attachment') }}</div>
                                    </td>
                                    <td>
                                        <div class="width_15em font-weight-bold text-black">:
                                            <a href="#" data-toggle="modal"
                                                data-target="#beneficiaryDocuments"
                                                class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <br>

                            <table class="table table-separate table-head-custom table-checkable">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('beneficiary.trade_sector') }}</th>
                                        <th>{{ __('beneficiary.from') }}</th>
                                        <th>{{ __('beneficiary.till') }}</th>
                                        <th>{{ __('beneficiary.main') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($tradeSector) && $tradeSector->count() > 0)
                                        @foreach ($tradeSector as $key => $row)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $row->name ?? '' }}</td>
                                                <td>{{ custom_date_format($row->from ?? '', 'd/m/Y') }}</td>
                                                <td>{{ $row->till ? custom_date_format($row->till, 'd-m-Y') : '-' }}</td>
                                                <td>{{ $row->is_main ?? '' }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="text-center" colspan="5">No data available</td>
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
                                            <a class="nav-link" data-toggle="tab" href="#approved_limit">
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
                                            <a class="nav-link" data-toggle="tab" href="#overdue">
                                                <span class="nav-text">Overdue</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body pt-1">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active pt-5" id="synopsis" role="tabpanel"
                                        aria-labelledby="synopsis">
                                        @include('beneficiary.synopsis')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="action_plan" role="tabpanel"
                                        aria-labelledby="action_plan">
                                        @include('beneficiary.action_plan')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="approved_limit" role="tabpanel"
                                        aria-labelledby="approved_limit">
                                        @include('beneficiary.approved_limit')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="group_approved_limit" role="tabpanel"
                                        aria-labelledby="group_approved_limit">
                                        @include('beneficiary.group_approved_limit')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="dms" role="tabpanel"
                                        aria-labelledby="dms">
                                        @include('beneficiary.dms')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="analysis" role="tabpanel"
                                        aria-labelledby="analysis">
                                        @include('beneficiary.analysis')
                                    </div>

                                    <div class="tab-pane fade show pt-5" id="overdue" role="tabpanel"
                                        aria-labelledby="overdue">
                                        @include('beneficiary.overdue')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

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
                <form method="post" action="{{ route('beneficiary.initiateReview') }}">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="beneficiary_id" value="{{ $beneficiary->id }}">

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

    <div class="modal fade" tabindex="-1" id="beneficiaryDocuments">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Beneficiary Documents</h5>
                </div>

                <div class="modal-body">
                    @if (isset($dms_data) && count($dms_data) > 0)
                        @foreach ($dms_data as $item)
                            <div class="mb-3">
                                <a href="{{ isset($item->attachment) && !empty($item->attachment) ? route('secure-file', encryptId($item->attachment)) : asset('/default.jpg') }}"
                                    target="_blanck">
                                    {!! getdmsFileIcon(e($item->file_name)) !!}
                                </a>
                                {{ $item->file_name }}
                            </div>
                        @endforeach
                        {{-- <a href="{{ isset($dms_data->attachment) && !empty($dms_data->attachment) ? asset($dms_data->attachment) : asset('/default.jpg') }}"
                                                                target="_blanck">
                                                                {{ $dms_data->file_name }}
                                                            </a> --}}
                    @else
                        <img height="35px;" width="25px;" src="{{ asset('/default.jpg') }}">
                    @endif
                </div>
            </div>
        </div>
    </div>
    @include('info')
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.underwriter').select2({
                    allowClear: true
                });
            });
        </script>
    @endpush
@endsection
