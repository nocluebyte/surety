@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('project-details.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title font-weight-bolder text-dark text-right">
                        @if ($current_user->hasAnyAccess('project-details.edit', 'users.superadmin'))
                            <a href="{{ route('project-details.edit', encryptId($project_details->id)) }}"
                                class="btn btn-light-primary btn-sm font-weight-bold">
                                <i class="fas fa-pencil-alt fa-1x"></i>
                                {{ __('common.edit') }}
                            </a>
                        @endif

                        @if ($current_user->hasAnyAccess('project-details.delete', 'users.superadmin'))
                            <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                href="{{ route('project-details.destroy', [encryptId($project_details->id)]) }}" aria-controls="delete"
                                data-redirect="{{ route('project-details.index') }}">
                                <i class="fas fa-trash-alt fa-1x"></i>
                                    {{ __('common.delete') }}
                            </a>
                        @endif

                        @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                            <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info"
                                data-toggle="modal" data-target="#AddModelInfo" data-table="{{ $table_name }}"
                                data-id="{{ $project_details->id }}" data-url="{{ route('get-info') }}">
                                <span class="navi-icon">
                                    <i class="fas fa-info-circle fa-1x"></i>
                                </span>
                                <span class="navi-text">Info</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="card-body pl-12">
                    <table style="width: 100%">
                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.code') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ $project_details->code ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.beneficiary') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ $project_details->beneficiary->company_name ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('project_details.project_name') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ $project_details->project_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.project_description') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black" colspan="3">
                                {{ $project_details->project_description ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.project_value') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ numberFormatPrecision($project_details->project_value, 0) ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('project_details.type_of_project') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ $project_details->projectType->name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.project_start_date') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ custom_date_format($project_details->project_start_date, 'd/m/Y') ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('project_details.project_end_date') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ custom_date_format($project_details->project_end_date, 'd/m/Y') ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('project_details.period_of_project') }}
                            </td>
                            <td>:</td>
                            <td class="width_15em text-black">
                                {{ $project_details->period_of_project ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('info')
@endsection
