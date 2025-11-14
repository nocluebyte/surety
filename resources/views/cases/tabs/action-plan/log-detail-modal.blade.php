<div class="modal fade bd-example-modal-lg" id="actionld" tabindex="-5" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myLargeModalLabel">{{ __('cases.log_detail') }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>

            <div class="tab-content p-3" id="top-tabContent">
                <div class="tab-pane fade active show" id="limit-strategy" role="tabpanel" aria-labelledby="limit-strategy-tab">
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th>{{ __('common.no') }}</th>
                                <th class="text-right">{{ __('cases.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                <th class="text-right">{{ __('cases.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                <th class="text-right">{{ __('cases.group_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                <th>{{ __('cases.valid_till') }}</th>
                                <th>{{ __('cases.name') }}</th>
                                <th>{{ __('cases.create_date') }}</th>
                                <th>{{ __('cases.update_date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($casesLimitStrategylog) && count($casesLimitStrategylog) > 0)
                                @foreach ($casesLimitStrategylog as $key => $casesLimitStrategy)
                                    <tr>
                                        <td>{{ $loop->iteration}}</td>
                                        <td class="text-right">
                                            {{ format_amount($casesLimitStrategy['proposed_individual_cap'] ?? '', '0', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ format_amount($casesLimitStrategy['proposed_overall_cap'] ?? '', '0', '.') }}
                                        </td>
                                        <td class="text-right">
                                            {{ format_amount($casesLimitStrategy['proposed_group_cap'] ?? '', '0', '.') }}
                                        </td>
                                        <td>
                                            {{ $casesLimitStrategy['proposed_valid_till'] ?? '' ? custom_date_format($casesLimitStrategy['proposed_valid_till'] ?? '','d/m/Y') : '' }}
                                        </td>
                                        <td>{{ $casesLimitStrategy['user']['first_name'] ?? '' }}
                                            {{ $casesLimitStrategy['user']['last_name'] ?? '' }}</td>
                                        <td>
                                            {{ $casesLimitStrategy['created_at'] ?? '' ? custom_date_format($casesLimitStrategy['created_at'] ?? '', 'd/m/Y') : '' }}
                                        </td>
                                        <td>
                                            {{ $casesLimitStrategy['updated_at'] ?? '' ? custom_date_format($casesLimitStrategy['updated_at'] ?? '','d/m/Y') : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="8">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="analysis-log" role="tabpanel" aria-labelledby="analysis-log-tab">
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Added By</th>
                                <th>Detail</th>
                                <th>Created Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($analyses) && $analyses->count() > 0)
                                @foreach ($analyses as $key => $analyseslog)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $analyseslog->user->full_name ?? '' }}</td>
                                        <td>{{ strip_tags($analyseslog->description ?? '') }}</td>
                                        <td>{{ date('d/m/Y', strtotime($analyseslog->created_at)) }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td class="text-center" colspan="8">{{ __('common.no_records_found') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>