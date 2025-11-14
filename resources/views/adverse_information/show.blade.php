@extends($theme)
@section('title', $title)
@section('content')
    @component('partials._subheader.subheader-v6', [
        'page_title' => $title,
        'back_action' => route('adverse-information.index'),
        'text' => __('common.back'),
    ])
    @endcomponent

    <div class="d-flex flex-column-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="card-title font-weight-bolder text-dark text-right">
                        @if ($current_user->hasAnyAccess('adverse-information.edit', 'users.superadmin'))
                            <a href="{{ route('adverse-information.edit', encryptId($adverse_information->id)) }}"
                                class="btn btn-light-primary btn-sm font-weight-bold">
                                <i class="fas fa-pencil-alt fa-1x"></i>
                                {{ __('common.edit') }}
                            </a>
                        @endif

                        @if ($current_user->hasAnyAccess('adverse-information.delete', 'users.superadmin'))
                            <a class="btn btn-light-danger btn-sm font-weight-bold delete-confrim navi-link" id=""
                                href="{{ route('adverse-information.destroy', [encryptId($adverse_information->id)]) }}" aria-controls="delete"
                                data-redirect="{{ route('adverse-information.index') }}">
                                <i class="fas fa-trash-alt fa-1x"></i>
                                    {{ __('common.delete') }}
                            </a>
                        @endif

                        @if ($current_user->hasAnyAccess('users.info', 'users.superadmin'))
                            <a href="" class="btn btn-light-success btn-sm font-weight-bold show-info"
                                data-toggle="modal" data-target="#AddModelInfo" data-table="{{ $table_name }}"
                                data-id="{{ $adverse_information->id }}" data-url="{{ route('get-info') }}">
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
                            <td class="width_15em text-light-grey"></td>
                            <td class="width_15em text-black"></td>

                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.code') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->code ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.contractor_id') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->contractor->code ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.contractor') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->contractor->company_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('common.pan_no') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->contractor->pan_no ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.source_of_adverse_information') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->source_of_adverse_information ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.adverse_information') }}
                            </td>
                            <td class="width_15em text-black" colspan="3">
                                <a href="#" data-toggle="modal"
                                data-target="#adverseInformationDetail"
                                class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('adverse_information.attachment') }}
                            </td>
                            <td class="width_15em text-black">
                                <a href="#" data-toggle="modal"
                                data-target="#adverseInformationDocuments"
                                class="call-modal navi-link"><i class="fa fa-file" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                        <tr>
                            <td class="width_15em text-light-grey">
                                {{ __('common.created_at') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ custom_date_format($adverse_information->source_date, 'd/m/Y') ?? '-' }}
                            </td>

                            <td class="width_15em text-light-grey">
                                {{ __('common.created_by') }}
                            </td>
                            <td class="width_15em text-black">
                                {{ $adverse_information->create_by->full_name ?? '-' }}
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>

                    <hr>

                    @if(isset($adverse_information->inActiveReason) && $adverse_information->inActiveReason->count() > 0)
                        <h5><strong style="border-bottom: 1px solid;">In Active Reasons</strong></h5>
                        <table class="table table-responsive" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="min-width-200">{{ __('common.name') }}</th>
                                    <th class="min-width-500">{{ __('adverse_information.reason') }}</th>
                                    <th class="min-width-150">{{ __('common.date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($adverse_information->inActiveReason->sortDesc() as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->createdBy->full_name ?? '-' }}</td>
                                        <td>{{ $item->reason ?? '-' }}</td>
                                        <td>{{ isset($item->created_at) ? custom_date_format($item->created_at, 'd/m/Y | H:m:s') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="8">{{__('common.no_records_found')}}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="adverseInformationDocuments">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adverse Information Documents</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
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

    <div class="modal fade" tabindex="-1" id="adverseInformationDetail">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Adverse Information</h5>
                    <button type="button" class="close"
                        data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>

                <div class="modal-body overflow-auto">
                    {!! $adverse_information->adverse_information ?? '-' !!}
                </div>
            </div>
        </div>
    </div>
    @include('info')
@endsection
