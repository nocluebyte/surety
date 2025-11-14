<div class="row">
    <div class="col-lg-4">
        <label class="col-form-label">
            <h4>{{ __('principle.bond_limit_strategy') }}</h4>
        </label>
    </div>
</div>
<br>
<ul class="nav nav-tabs nav-light-info nav-bold  ">
    <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" href="#bond_limit_strategy_current">
            <span class="nav-icon"><i class="flaticon2-hourglass-1"></i></span>
            <span class="nav-text">{{ __('principle.current') }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" data-toggle="tab" href="#bond_limit_strategy_past">
            <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
            <span class="nav-text">{{ __('principle.past') }}</span>
        </a>
    </li>
</ul>
<div class="tab-content mt-5">
    <div class="tab-pane fade show active" id="bond_limit_strategy_current" role="tabpanel">


        <div>
            <table class="table table-separate table-head-custom table-checkable tradeSector" id="machine"
                data-repeater-list="bond">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th>{{__('common.no')}}</th>
                        <th width="350">{{ __('principle.bond_type') }}<i class="text-danger">*</i></th>
                        <th class="text-right">{{ __('principle.current_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="text-right">{{ __('principle.utilized_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="text-right">{{ __('principle.utilized_cap_persontage') }}</th>
                        <th class="text-right">{{ __('principle.remaining_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="text-right">{{ __('principle.proposed_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th>{{ __('principle.valid_till') }}<i class="text-danger">*</i></th>
                    </tr>
                </thead>
                <tbody>
                     @if (isset($casesBondLimitStrategy) && $casesBondLimitStrategy->count() > 0)
                        @foreach ($casesBondLimitStrategy as $casesBondLimitStrategy)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ $casesBondLimitStrategy['bondType']['name'] ?? '' }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatPrecision($casesBondLimitStrategy['bond_current_cap'], 0) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatPrecision($case_action_plan->utilizedCasesBondLimitStrategy($casesBondLimitStrategy['bond_type_id'],'sum'), 0) }}
                                </td>
                                <td class="text-right">
                                     {{numberFormatPrecision(safe_divide($case_action_plan->utilizedCasesBondLimitStrategy($casesBondLimitStrategy['bond_type_id'],'sum')*100,$casesBondLimitStrategy['bond_current_cap']),2)}}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatPrecision($casesBondLimitStrategy['bond_remaining_cap'],0) }}
                                </td>
                                <td class="text-right">
                                    {{ numberFormatPrecision($casesBondLimitStrategy['bond_proposed_cap'], 0) }}
                                </td>
                                <td>{{ isset($casesBondLimitStrategy['bond_valid_till']) ? custom_date_format($casesBondLimitStrategy['bond_valid_till'] , 'd/m/Y') : '' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="text-right">
                            {{numberFormatPrecision($case_action_plan?->utilized_cases_bond_limit_strategy_sum_value,0)}}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>
    <div class="tab-pane fade show" id="bond_limit_strategy_past" role="tabpanel">
        @if (isset($casesBondLimitStrategylog) && count($casesBondLimitStrategylog) > 0)
            @foreach ($casesBondLimitStrategylog as $key => $casesLimitStrategy)
                <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                    <thead>
                        <th>{{ $key }}</th>
                    </thead>
                    <tbody>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('principle.bond_type') }}</th>
                                        <th class="text-right">{{ __('principle.current_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('principle.utilized_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('principle.utilized_cap_persontage') }}</th>
                                        <th class="text-right">{{ __('principle.remaining_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('principle.proposed_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' . $currency_symbol . ')' : '' }}</span></th>
                                        <th>{{ __('common.date') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($casesLimitStrategy as $casesLimitStrategy)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                {{ $casesLimitStrategy['bondType']['name'] ?? '' }}
                                            </td>
                                            <td class="text-right">
                                                {{ numberFormatPrecision($casesLimitStrategy['bond_current_cap'], 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ numberFormatPrecision($casesLimitStrategy['bond_utilized_cap'], 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{numberFormatPrecision($casesLimitStrategy['bond_utilized_cap_persontage'], 2)}}
                                            </td>
                                            <td class="text-right">
                                                {{ numberFormatPrecision($casesLimitStrategy['bond_remaining_cap'], 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ numberFormatPrecision($casesLimitStrategy['bond_proposed_cap'], 0) }}
                                            </td>
                                            <td>{{  isset($casesLimitStrategy['created_at']) ? custom_date_format($casesLimitStrategy['created_at'], 'd/m/Y') : '' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tbody>
                </table>
            @endforeach
        @else
            <div class="d-flex justify-content-center pb-5">
                {{ __('common.no_records_found') }}
            </div>
        @endif
    </div>
</div>