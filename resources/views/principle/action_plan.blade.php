<table style="width:100%">
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.reason_for_submission') }}</div>
        </th>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">Amendment Type</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_reason_for_submission ?? ''}}
            </div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_amendment_type ?? ''}}
            </div>
        </th>
    </tr>
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.any_adverse_notification') }}</div>
        </th>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">Remark</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_adverse_notification ?? ''}}
            </div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_adverse_notification_remark ?? ''}}
            </div>
        </th>
    </tr>

    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.beneficiary_acceptable') }}</div>
        </th>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">Remark</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_beneficiary_acceptable ?? ''}}
            </div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_beneficiary_acceptable_remark ?? ''}}
            </div>
        </th>
    </tr>
    
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.any_bond_invocation') }}</div>
        </th>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">Remark</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_bond_invocation ?? ''}}
            </div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_bond_invocation_remark ?? ''}}
            </div>
        </th>
    </tr>

    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey"> {{ __('principle.blacklisted_contractor') }}</div>
        </th>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">Remark</div>
        </th>
    </tr>
    <tr>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_blacklisted_contractor ?? ''}}
            </div>
        </th>
        <th>
            <div class="form-group font-weight-bold mt-n2 text-black">
                {{$principle->contractorLatestCase->cases_action_blacklisted_contractor_remark ?? ''}}
            </div>
        </th>
    </tr>
</table>
<hr>
<h4>Financials</h4>
<br>
<table style="width:100%">
    <tr>
        <th width="25%">
            <div class="font-weight-bold my-2 text-light-grey">{{ __('principle.types_of_account') }}</div>
        </th>
        <th width="20%">
            <div class="font-weight-bold my-2 text-light-grey">{{__('principle.consolidated_standalone')}}</div>
        </th>
        <th width="20%">
            <div class="font-weight-bold my-2 text-light-grey">{{ __('common.currency') }}</div>
        </th>
    </tr>
    <tr>
        <th>
            <h6>
                <div class="form-group font-weight-bold mt-n2 text-black">
                    {{$principle->contractorLatestCase->cases_action_audited ?? ''}}
                </div>
            </h6>
        </th>
        <th>
            <h6>
                <div class="form-group font-weight-bold mt-n2 text-black">
                    {{$principle->contractorLatestCase->cases_action_consolidated ?? ''}}
                </div>
            </h6>
        </th>
        <th>
            <h6>
                <div class="form-group font-weight-bold mt-n2 text-black">
                </div>
            </h6>
        </th>
    </tr>
</table>
<div class="row">
    @include('principle.tabs.action-plan.financials-modal')
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="profitLossTab" data-title="Profit & Loss" id="pl-model">{{ __('cases.profit_loss') }}
        </button>
    </div>
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="balanceSheetTab" data-title="Balance Sheet" id="pl-model">{{__('cases.balance_sheet')}}
        </button>
    </div>
    <div class="col-auto ">
        <button class="btn btn-outline-info actionModal popupTab" type="button"
            data-toggle="modal" data-target=".bd-example-modal-lg"
            data-tab="ratiosTab" data-title="Ratios" id="pl-model">{{__('cases.ratios')}}
        </button>
    </div>
</div>
<hr>
<h4>{{ __('cases.limit_strategy') }}</h4>
<br>
<div class="col-sm-12">
    <ul class="nav nav-tabs nav-light-info nav-bold  ">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#kt_tab_pane_1">
                <span class="nav-icon"><i
                        class="flaticon2-hourglass-1"></i></span>
                <span class="nav-text">{{ __('cases.current') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#kt_tab_pane_2">
                <span class="nav-icon"><i
                        class="flaticon2-pie-chart-4"></i></span>
                <span class="nav-text">{{ __('cases.past') }}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel"
            aria-labelledby="kt_tab_pane_2">
            <table class="table" style="width: 100%;">
                <thead>
                    <tr>
                        <th width="25%" class="text-right">{{ __('cases.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span> </th>
                        <th width="25%" class="text-right">{{ __('cases.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                        <th width="25%" class="text-center">{{ __('cases.valid_till') }}</th>
                        <th width="25%" class="text-right">{{ __('cases.group_cap') }}</th>
                    </tr>
                </thead>
                <tbody>
                        <td width="25%" class="text-right">{{isset($casesLimitStrategy['proposed_individual_cap']) ? numberFormatPrecision($casesLimitStrategy['proposed_individual_cap'],0) : 0}}</td>
                        <td width="25%" class="text-right">{{isset($casesLimitStrategy['proposed_overall_cap']) ? numberFormatPrecision($casesLimitStrategy['proposed_overall_cap'],0) : 0}}</td>
                        <td width="25%" class="text-center">{{isset($casesLimitStrategy['proposed_valid_till']) ? custom_date_format($casesLimitStrategy['proposed_valid_till']) : ''}}</td>
                        <td width="25%" class="text-right">{{isset($casesLimitStrategy['proposed_group_cap']) ? numberFormatPrecision($casesLimitStrategy['proposed_group_cap'],0) : '' }}</td>
                </tbody>
            </table>
        </div>
        <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel"
            aria-labelledby="kt_tab_pane_2">
            <table class="table table-responsive" style="width: 100%;">
                <thead>
                    <tr>
                        <th>{{ __('common.no') }}</th>
                        <th class="text-right min-width-200">{{ __('cases.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                        <th class="text-right min-width-200">{{ __('cases.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                        <th class="text-right min-width-200">{{ __('cases.group_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                        <th class="min-width-150">{{ __('cases.valid_till') }}</th>
                        <th class="min-width-200">{{ __('cases.name') }}</th>
                        <th class="min-width-150">{{ __('cases.create_date') }}</th>
                        <th class="min-width-150">{{ __('cases.update_date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($casesLimitStrategylog) && count($casesLimitStrategylog) > 0)
                    @foreach ($casesLimitStrategylog as $key => $casesLimitStrategy)
                        <tr>
                            <td>{{ $loop->iteration}}</td>
                            <td class="text-right">
                                {{ numberFormatPrecision($casesLimitStrategy['proposed_individual_cap'], 0) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatPrecision($casesLimitStrategy['proposed_overall_cap'], 0) }}
                            </td>
                            <td class="text-right">
                                {{ numberFormatPrecision($casesLimitStrategy['proposed_group_cap'], 0) }}
                            </td>
                            <td>{{ $casesLimitStrategy['proposed_valid_till'] ?? '' ? custom_date_format($casesLimitStrategy['proposed_valid_till'] ?? '', 'd/m/Y') : '' }}
                            </td>
                            <td>{{ $casesLimitStrategy['user']['first_name'] ?? '' }}
                                {{ $casesLimitStrategy['user']['last_name'] ?? '' }}</td>
                            <td>{{ $casesLimitStrategy['created_at'] ?? '' ? custom_date_format($casesLimitStrategy['created_at'] ?? '', 'd/m/Y') : '' }}
                            </td>
                            <td>{{ $casesLimitStrategy['updated_at'] ?? '' ? custom_date_format($casesLimitStrategy['updated_at'] ?? '', 'd/m/Y') : '' }}
                            </td>
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