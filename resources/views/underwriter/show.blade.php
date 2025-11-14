@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('underwriter.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">

            @include('components.error')
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="underwriterData">
                <div class="card">
                    <div class="card-header" id="faqHeading1">
                        <div class="d-flex justify-content-between flex-column flex-md-row col-lg-12">
                            <a class="card-title text-dark collapsed" data-toggle="collapse" href="#underwriterTab"
                                aria-expanded="false" aria-controls="underwriterTab" role="button">
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
                                    {{ $underwriter->user->first_name ?? '' }}
                                    {{ $underwriter->user->middle_name ?? '' }}
                                    {{ $underwriter->user->last_name ?? '' }}
                                </h3>
                            </a>

                            <span class="svg-icon mt-5" style="float:right;">
                                @if ($current_user->hasAnyAccess('underwriter.edit', 'users.superadmin'))
                                    <a href="{{ route('underwriter.edit', encryptId($underwriter->id)) }}"
                                        class="btn btn-light-primary btn-sm font-weight-bold">
                                        <i class="fas fa-pencil-alt fa-1x"></i>
                                        {{ __('common.edit') }}
                                    </a>
                                @endif
                                @if ($current_user->hasAnyAccess('underwriter.delete', 'users.superadmin'))
                                    <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link"
                                        id="" href="{{ route('underwriter.destroy', [encryptId($underwriter->id)]) }}"
                                        aria-controls="delete" data-redirect="{{ route('underwriter.index') }}">
                                        <i class="fas fa-trash-alt fa-1x"></i>
                                        {{ __('common.delete') }}
                                    </a>
                                @endif
                                @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                                    <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info"
                                        data-toggle="modal" data-target="#AddModelInfo" data-table="{{ $table_name }}"
                                        data-id="{{ $underwriter->id }}" data-url="{{ route('get-info') }}">
                                        <span class="navi-icon">
                                            <i class="fas fa-info-circle fa-1x"></i>
                                        </span>
                                        <span class="navi-text">Info</span>
                                    </a>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div id="underwriterTab" class="collapse" aria-labelledby="faqHeading1" data-parent="#underwriterData">
                        <div class="pt-5 pr-15 pl-15">
                            <div class="row">
                                <div class="col-3">
                                    <table style="width:100%">
                                        <tr>
                                            <td class="pr-15" rowspan="11" colspan="2" style="width: 20%;">
                                                <div class=" font-weight-bold pb-20 dataColor">
                                                    {{ $underwriter->user->first_name ?? '' }}
                                                    {{ $underwriter->user->middle_name ?? '' }}
                                                    {{ $underwriter->user->last_name ?? '' }}<br>
                                                    {{ $underwriter->address ?? '' }}<br>
                                                    {{ $underwriter->city ?? '' }}<br>
                                                    {{ $underwriter->state->name ?? '' }},
                                                    {{ $underwriter->country->name ?? '' }}
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-9">
                                    <table style="width:100%">
                                        <tr>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('common.company_name') }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class="font-weight-bold dataColor">:
                                                    {{ $underwriter->company_name ?? '' }}
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('common.email') }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ $underwriter->user->email ?? '' }}
                                                </div>
                                            </td>

                                            @if (strtolower($underwriter->country->name) == 'india')
                                                <td class="width_15em">
                                                    <div class="font-weight-bold p-1 labelColor">{{ __('common.pan_no') }}
                                                    </div>
                                                </td>
                                                <td class="width_15em">
                                                    <div class=" font-weight-bold dataColor">:
                                                        {{ $underwriter->pan_no ?? '' }}</div>
                                                </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('common.phone_no') }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ $underwriter->user->mobile ?? '' }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">{{ __('underwriter.type') }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ $underwriter->type ?? '' }}</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('underwriter.max_approved_limit') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ numberFormatPrecision($underwriter->max_approved_limit, 0) ?? '' }}</a>
                                                </div>
                                            </td>

                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('underwriter.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ numberFormatPrecision($underwriter->individual_cap, 0) ?? '' }}</a>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('underwriter.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ numberFormatPrecision($underwriter->overall_cap, 0) ?? '' }}
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class="font-weight-bold p-1 labelColor">
                                                    {{ __('underwriter.group_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                                                </div>
                                            </td>
                                            <td class="width_15em">
                                                <div class=" font-weight-bold dataColor">:
                                                    {{ numberFormatPrecision($underwriter->group_cap, 0) ?? '' }}</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('info')
@endsection
