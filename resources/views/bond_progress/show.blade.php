<div class="pt-5 pr-15 pl-15">
    <div class="accordion accordion-solid accordion-light-borderless accordion-svg-toggle" id="accordionBondProgress">
        <table class="table table-separate table-head-custom table-checkable">
            <thead>
                <tr>
                    <th>{{ __('common.no') }}</th>
                    <th>{{ __('common.created_at') }}</th>
                    <th>{{ __('common.created_by') }}</th>
                </tr>
            </thead>
            <tbody>
                @if ($bond_progress->count() > 0)
                    @foreach ($bond_progress as $key => $item)
                        {{-- @dd($item) --}}
                        <tr>
                            <td>{{ $loop->index + 1 }}</td>
                            <td width="80%">
                                <div class="card">
                                    <div class="card-header" id="headingOne7-{{ $loop->index + 1 }}">
                                        <div class="card-title" data-toggle="collapse"
                                            data-target="#collapseOne7-{{ $loop->index + 1 }}" aria-expanded="false">
                                            <span class="svg-icon svg-icon-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                    height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none"
                                                        fill-rule="evenodd">
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
                                            <div class="card-label pl-4">
                                                {{ isset($item->created_at) ? custom_date_format($item->created_at, 'd/m/Y') : '-' }}</div>
                                        </div>
                                    </div>
                                    <div id="collapseOne7-{{ $loop->index + 1 }}" class="collapse"
                                        data-parent="#accordionBondProgress">
                                        <div class="card-body pl-12">
                                            <table class="table">
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.progress_date') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        {{ custom_date_format($item->progress_date, 'd/m/Y') ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.bond_type') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        {{ $item->bondType->name ?? '-' }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.progress_attachment') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#progressAttachment_{{ $loop->index + 1 }}"
                                                            class="call-modal navi-link"><i class="fa fa-file"
                                                                aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.progress_remarks') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        <div class="d-inline-block text-truncate"
                                                            style="max-width: 200px;">
                                                            <p>{{ $item->progress_remarks ?? '' }}</p> 
                                                            @if(Str::of($item->progress_remarks)->length() > 30)
                                                                <a href="#" data-toggle="modal" data-target="#progress_remarks_{{ $loop->index + 1 }}" class="call-modal navi-link">...Read More</a>
                                                            @endif
                                                        </div>

                                                        <div class="modal fade" tabindex="-1"
                                                            id="progress_remarks_{{ $loop->index + 1 }}">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            {{ __('bond_progress.progress_remarks') }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <i style="font-size: 30px;"
                                                                                aria-hidden="true">&times;</i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $item->progress_remarks ?? '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.physical_completion_remarks') }}
                                                    </td>
                                                    <td class="font-weight-bold" width="50%">
                                                        <div class="d-inline-block text-truncate"
                                                            style="max-width: 200px;">
                                                            <p>{{ $item->physical_completion_remarks ?? '' }}</p> 
                                                            @if(Str::of($item->physical_completion_remarks)->length() > 30)
                                                                <a href="#"
                                                                data-toggle="modal"
                                                                data-target="#physical_completion_remarks_{{ $loop->index + 1 }}"
                                                                class="call-modal navi-link">...Read More</a>
                                                            @endif
                                                        </div>

                                                        <div class="modal fade" tabindex="-1"
                                                            id="physical_completion_remarks_{{ $loop->index + 1 }}">
                                                            <div class="modal-dialog modal-lg" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">
                                                                            {{ __('bond_progress.physical_completion_remarks') }}
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <i style="font-size: 30px;"
                                                                                aria-hidden="true">&times;</i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        {{ $item->physical_completion_remarks ?? '' }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.physical_completion_attachment') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        <a href="#" data-toggle="modal"
                                                            data-target="#physicalCompletionAttachment_{{ $loop->index + 1 }}"
                                                            class="call-modal navi-link"><i class="fa fa-file"
                                                                aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="font-weight-bolder">
                                                        {{ __('bond_progress.dispute_initiated') }}
                                                    </td>
                                                    <td class="font-weight-bold">
                                                        {{ $item->dispute_initiated ?? '-' }}
                                                    </td>
                                                </tr>
                                                @if ($item->dispute_initiated == 'Yes')
                                                    <tr>
                                                        <td class="font-weight-bolder">
                                                            {{ __('bond_progress.dispute_initiated_remarks') }}
                                                        </td>
                                                        <td class="font-weight-bold" width="50%">
                                                            <div class="d-inline-block text-truncate"
                                                                style="max-width: 200px;">
                                                                <p>{{ $item->dispute_initiated_remarks ?? '' }}</p> 
                                                                @if(Str::of($item->dispute_initiated_remarks)->length() > 30)
                                                                    <a href="#"
                                                                    data-toggle="modal"
                                                                    data-target="#dispute_initiated_remarks_{{ $loop->index + 1 }}"
                                                                    class="call-modal navi-link">...Read More</a>
                                                                @endif
                                                            </div>
                                                            <div class="modal fade" tabindex="-1"
                                                                id="dispute_initiated_remarks_{{ $loop->index + 1 }}">
                                                                <div class="modal-dialog modal-lg" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">
                                                                                {{ __('bond_progress.dispute_initiated_remarks') }}
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <i style="font-size: 30px;"
                                                                                    aria-hidden="true">&times;</i>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            {{ $item->dispute_initiated_remarks ?? '' }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endif
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->create_by->full_name ?? '-' }}</td>
                        </tr>

                        @php
                            $documents = $item->dMS->groupBy('attachment_type');
                        @endphp
                        {{-- @dd($documents) --}}
                        <div class="modal fade" tabindex="-1" id="progressAttachment_{{ $loop->index + 1 }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Progress Attachment</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @if (isset($documents['progress_attachment']) && count($documents['progress_attachment']) > 0)
                                            @foreach ($documents['progress_attachment'] as $item)
                                                <div class="mb-3">
                                                    {!! getdmsFileIcon(e($item->file_name)) !!}
                                                    {{ $item->file_name ?? '' }}&nbsp;
                                                    <a target="_blank"
                                                        href="{{ isset($item->attachment) && !empty($item->attachment) ? route('secure-file', encryptId($item->attachment)) : asset('/default.jpg') }}"
                                                        download target="_blanck">
                                                        <i class="fa fa-download text-black"></i>
                                                    </a>
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

                        <div class="modal fade" tabindex="-1"
                            id="physicalCompletionAttachment_{{ $loop->index + 1 }}">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Physical Completion Attachment</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <i style="font-size: 30px;" aria-hidden="true">&times;</i>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        @if (isset($documents['physical_completion_attachment']) && count($documents['physical_completion_attachment']) > 0)
                                            @foreach ($documents['physical_completion_attachment'] as $item)
                                                <div class="mb-3">
                                                    {!! getdmsFileIcon(e($item->file_name)) !!}
                                                    {{ $item->file_name ?? '' }}&nbsp;
                                                    <a target="_blank"
                                                        href="{{ isset($item->attachment) && !empty($item->attachment) ? route('secure-file', encryptId($item->attachment)) : asset('/default.jpg') }}"
                                                        download target="_blanck">
                                                        <i class="fa fa-download text-black"></i>
                                                    </a>
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
                    @endforeach
                @else
                    <tr>
                        <td colspan="7" class="text-center">{{ __('common.no_records_found') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
