<div class="table-responsive">
    <table class="table" style="width:100%;">
        <div class="container">
            <thead>
                <tr>
                    <th>
                        {{__('common.no')}}
                    </th>
                    <th>
                        {{ __('proposals.project_name') }}
                    </th>
                    <th class="text-right">
                        {{ __('proposals.project_cost') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th>
                        {{ __('proposals.project_description') }}
                    </th>
                    <th>
                        {{ __('proposals.project_tenor') }}
                    </th>
                    <th>
                        {{ __('proposals.project_start_date') }}
                    </th>
                    <th>
                        {{ __('proposals.project_end_date') }}
                    </th>
                    <th>
                        {{ __('proposals.actual_date_completion') }}
                    </th>
                    <th>
                        {{ __('proposals.bank_guarantees_details') }}
                    </th>
                    <th class="text-right">
                        {{ __('proposals.bg_amount') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span>
                    </th>
                    <th>
                        {{ __('principle.project_track_records_attachment') }}
                    </th>
                </tr>
            </thead>
            @if (isset($case->contractor->projectTrackRecords) && $case->contractor->projectTrackRecords->count() > 0)
                @foreach($case->contractor->projectTrackRecords->sortDesc() as $item)
                    <tbody>
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td class="width_35em text-black">
                                {{ $item->project_name ?? '-' }}
                            </td>
                            <td class="width_10em text-black text-right">
                                {{ numberFormatPrecision($item->project_cost, 0) ?? '-' }}
                            </td>
                            <td class="width_35em text-black">
                                {{ $item->project_description ?? '-' }}
                            </td>
                            <td class="width_10em text-black">
                                {{ $item->project_tenor ?? '-' }}
                            </td>
                            <td class="width_10em text-black">
                                {{ custom_date_format($item->project_start_date, 'd/m/Y') ?? '-' }}
                            </td>
                            <td class="width_10em text-black">
                                {{ custom_date_format($item->project_end_date, 'd/m/Y') ?? '-' }}
                            </td>
                            <td class="width_10em text-black">
                                {{ custom_date_format($item->actual_date_completion, 'd/m/Y') ?? '-' }}
                            </td>
                            <td class="width_35em text-black">
                                {{ $item->bank_guarantees_details ?? '-' }}
                            </td>
                            <td class="width_10em text-black text-right">
                                {{ numberFormatPrecision($item->bg_amount, 0) ?? '-' }}
                            </td>
                            <td class="width_10em">
                                <a type="button" data-toggle="modal"
                                    data-target="#project_track_records_attachment_modal_{{ $loop->iteration }}">
                                    <i class="fas fa-file"></i>
                                </a>
                                <div class="modal fade"
                                    id="project_track_records_attachment_modal_{{ $loop->iteration }}"
                                    tabindex="-1" role="dialog" aria-labelledby="staticBackdrop"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Attachment
                                                </h5>
                                                <button type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <i aria-hidden="true" class="ki ki-close"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div data-scroll="true" data-height="100">
                                                    @foreach ($item->dMS as $document)
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
                                                </div>
                                            </div>
                                        </div>
                                    <div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                @endforeach
            @else
                <tr>
                    <td colspan="4" class="text-center">No data available in table</td>
                </tr>
            @endif
        </div>
    </table>
</div>