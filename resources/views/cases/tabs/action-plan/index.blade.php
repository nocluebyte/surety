@php
    $adverse_notification = $case->cases_action_adverse_notification ?? 'No';
    $adverse_notification_remark_show = $adverse_notification == 'Yes' ? 'visible' : 'invisible';
    $adverse_notification_remark_remark_required = $adverse_notification == 'Yes' ? ' required ' : '';
    // beneficiary_acceptable
    $beneficiary_acceptable = $case->cases_action_beneficiary_acceptable ?? 'No';
    $beneficiary_acceptable_remark_show = $beneficiary_acceptable == 'No' ? 'visible' : 'invisible';
    $beneficiary_acceptable_remark_required = $beneficiary_acceptable == 'No' ? ' required' : '';
    // beneficiary_acceptable
    $amendment_type = $case->cases_action_amendment_type ?? 'TermSheet';
    $amendment_type_show =  $case->cases_action_reason_for_submission === 'Amendment' ? '' : 'd-none';
    //Any Bond Invocation
    $bond_invocation = $case->cases_action_bond_invocation ?? 'No'; 
    $bond_invocation_remark_show = $bond_invocation == 'Yes' ? 'visible' : 'invisible';
    $bond_invocation_remark_required = $bond_invocation == 'Yes' ? ' required ' : '';
    //blacklisted_contractor
    $blacklisted_contractor =$case->cases_action_blacklisted_contractor ?? 'No';
    $blacklisted_contractor_remark_show = $blacklisted_contractor == 'Yes' ? 'visible' : 'invisible';
    $blacklisted_contractor_remark_required = $blacklisted_contractor == 'Yes' ? ' required ' : '';
    $proposed_group_cap_readonly = $case->contractor->isGroup ? '' : 'readonly' ;
    $proposed_group_cap_form_control_solid = $case->contractor->isGroup ? '' : 'form-control-solid' ;

@endphp
<form action="{{ route('store-cases-action-plan', $case->id) }}" method="POST"id="casesActionForm">
    @csrf
    <input type="hidden" name="casesable_type" value="{{ $case->casesable_type ?? '' }}">
    <input type="hidden" name="casesable_id" value="{{ $case->casesable_id ?? '' }}">
    <input type="hidden" name="case_type" value="{{ $case->case_type ?? '' }}">
    <input type="hidden" name="is_reload" value="0" class="jsisReload">
    <input type="hidden" class="Jscontractor" name="contractor_id" value="{{$case->contractor_id ?? ''}}">
    <input type="hidden" name="underwriter_id" value="{{$case->underwriter_id ?? ''}}">
    <div class="row">
        <div class="col-lg-6">
            <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.reason_for_submission') }}<i
                    class="text-danger">*</i></div>
            {{ Form::select('cases_action_reason_for_submission', ['' => 'Select'] + ['New' => 'New', 'Amendment' =>
            'Amendment', 'Review' => 'Review'], $case->cases_action_reason_for_submission ?? '', ['class' =>
            'form-control required jsReasonForSubmission', 'data-placeholder' => 'Select Reason for Submission', '']) }}
        </div>
        <div class="col-lg-6">
            <div class="jsAmendmentTypeDiv {{$amendment_type_show}}">
                <div class="form-group">
                    <label class="col-form-label">{{ __('cases.amendment_type') }}<i class="text-danger">*</i></label>
                    <div class="radio-inline ">
                        <label class="radio">
                            {{ Form::radio('cases_action_amendment_type', 'TermSheet', $amendment_type == 'TermSheet' ? true : false, ['class' => 'form-check-input jsAmendmentType', 'id' => 'term-sheet']) }}
                            <span></span>{{ __('cases.term_sheet') }}
                        </label>
                        <label class="radio">
                            {{ Form::radio('cases_action_amendment_type', 'Bond', $amendment_type == 'Bond' ? true :
                            false, ['class' => 'form-check-input jsAmendmentType', 'id' => 'bond']) }}
                            <span></span>{{ __('cases.bond') }}
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label class="col-form-label">{{ __('cases.any_adverse_notification') }}<i class="text-danger">*</i></label>
                <div class="radio-inline ">
                    <label class="radio">
                        {{ Form::radio('cases_action_adverse_notification', 'Yes', $adverse_notification == 'Yes' ? true
                        : false, ['class' => 'form-check-input jsAdverseNotification', 'id' => 'yes']) }}
                        <span></span>{{ __('cases.yes') }}
                    </label>
    
                    <label class="radio">
                        {{ Form::radio('cases_action_adverse_notification', 'No', $adverse_notification == 'No' ? true :
                        false, ['class' => 'form-check-input jsAdverseNotification', 'id' => 'no']) }}
                        <span></span>{{ __('cases.no') }}
                    </label>
                </div>
            </div>
    
        </div>
        <div class="col-lg-4">
            <label class="col-form-label"></label>
            <div class="text-black jsAdverseNotificationDiv {{ $adverse_notification_remark_show }}">
                {!! Form::textarea('cases_action_adverse_notification_remark',
                $case->cases_action_adverse_notification_remark ?? '', [
                'class' => 'form-control jsAdverseNotificationRemark' .$adverse_notification_remark_remark_required,
                'rows' => '2',
                ]) !!}
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="col-form-label">{{ __('cases.beneficiary_acceptable') }}<i class="text-danger">*</i></label>
                <div class="radio-inline ">
                    <label class="radio">
                        {{ Form::radio('cases_action_beneficiary_acceptable', 'Yes', $beneficiary_acceptable == 'Yes' ?
                        true : false, ['class' => 'form-check-input jsBeneficiaryAcceptable', 'id' => 'yes']) }}
                        <span></span>{{ __('cases.yes') }}
                    </label>
    
                    <label class="radio">
                        {{ Form::radio('cases_action_beneficiary_acceptable', 'No', $beneficiary_acceptable == 'No' ?
                        true : false, ['class' => 'form-check-input jsBeneficiaryAcceptable', 'id' => 'no']) }}
                        <span></span>{{ __('cases.no') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <label class="col-form-label"></label>
            <div class="text-black jsBeneficiaryAcceptableDiv {{ $beneficiary_acceptable_remark_show }}">
                {!! Form::textarea('cases_action_beneficiary_acceptable_remark',
                $case->cases_action_beneficiary_acceptable_remark ?? '', [
                'class' => 'form-control jsBeneficiaryAcceptableRemark'.$beneficiary_acceptable_remark_required,
                'rows' => '2',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-2">
            <div class="form-group">
                <label class="col-form-label">{{ __('cases.any_bond_invocation') }}<i class="text-danger">*</i></label>
                <div class="radio-inline ">
                    <label class="radio">
                        {{ Form::radio('cases_action_bond_invocation', 'Yes', $bond_invocation == 'Yes' ? true : false,
                        ['class' => 'form-check-input jsBondInvocation', 'id' => 'yes']) }}
                        <span></span>{{ __('cases.yes') }}
                    </label>
    
                    <label class="radio">
                        {{ Form::radio('cases_action_bond_invocation', 'No', $bond_invocation == 'No' ? true : false,
                        ['class' => 'form-check-input jsBondInvocation', 'id' => 'no']) }}
                        <span></span>{{ __('cases.no') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <label class="col-form-label"></label>
            <div class="text-black jsBondInvocationDiv {{ $bond_invocation_remark_show }}">
                {!! Form::textarea('cases_action_bond_invocation_remark', $case->cases_action_bond_invocation_remark ??
                '', [
                'class' => 'form-control jsBondInvocationRemark'.$bond_invocation_remark_required,
                'rows' => '2',
                ]) !!}
            </div>
        </div>
        <div class="col-lg-2">
            <div class="form-group">
                <label class="col-form-label">{{ __('cases.blacklisted_contractor') }}<i class="text-danger">*</i></label>
                <div class="radio-inline ">
                    <label class="radio">
                        {{ Form::radio('cases_action_blacklisted_contractor', 'Yes', $blacklisted_contractor == 'Yes' ? true : false,
                        ['class' => 'form-check-input jsBlacklistedContractor', 'id' => 'yes']) }}
                        <span></span>{{ __('cases.yes') }}
                    </label>
    
                    <label class="radio">
                        {{ Form::radio('cases_action_blacklisted_contractor', 'No', $blacklisted_contractor == 'No' ? true : false,
                        ['class' => 'form-check-input jsBlacklistedContractor', 'id' => 'no']) }}
                        <span></span>{{ __('cases.no') }}
                    </label>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <label class="col-form-label"></label>
            <div class="text-black jsBlacklistedContractorDiv {{ $blacklisted_contractor_remark_show }}">
                {!! Form::textarea('cases_action_blacklisted_contractor_remark', $case->cases_action_blacklisted_contractor_remark ??
                '', [
                'class' => 'form-control jsBlacklistedContractorRemark'.$blacklisted_contractor_remark_required,
                'rows' => '2',
                ]) !!}
            </div>
        </div>
    </div>
    <hr class="hr-border">
    <div class="row">
        <div class="col-lg-12">
            <label class="col-form-label"><h4>{{ __('cases.financials') }}</h4></label>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                {{ Form::select('cases_action_audited', ['' => 'Select'] + ['Audited' => 'Audited', 'Unaudited' => 'Unaudited'], $case->cases_action_audited ?? null, ['class' => 'form-control jsAudited', 'data-placeholder' => 'Types of Account']) }}
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                {{ Form::select('cases_action_consolidated', ['' => 'Select'] + ['Consolidated' => 'Consolidated', 'Standalone' => 'Standalone'], $case->cases_action_consolidated ?? null, ['class' => 'form-control jsConsolidated', 'data-placeholder' => 'Types of Account']) }}
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                {{ Form::select('cases_action_currency_id', ['' => 'Select'] + $currencys, $case->cases_action_currency_id ?? null, ['class' => 'form-control jsCurrencyId', 'data-placeholder' => 'Select Currency']) }}
            </div>
        </div>
    </div>
    <div class="row">
        @include('cases.tabs.action-plan.financials-modal')
        <div class="col-auto">
            <button class="btn btn-outline-info jsActionPlanModal popupTab" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" data-tab="profitLossTab" id="apl-pl-model" onclick="modalTitle('Profit & Loss')">{{ __('cases.profit_loss') }}</button>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-info jsActionPlanModal popupTab" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" data-tab="balanceSheetTab" id="apl-bs-model" onclick="modalTitle('Balance Sheet')">{{ __('cases.balance_sheet') }}</button>
        </div>
        <div class="col-auto">
            <button class="btn btn-outline-info jsActionPlanModal popupTab" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" data-tab="ratiosTab" id="apl-r-model" onclick="modalTitle('Ratios')">{{ __('cases.ratios') }}</button>
        </div>
        <div class="col-auto ">
            <button class="btn btn-outline-info jsActionPlanModal popupTab" type="button" data-toggle="modal" data-target=".bd-example-modal-lg" data-tab="analysis_tab" id="apl-a-model" onclick="modalTitle('Analysis')">{{ __('cases.analysis') }}</button>
        </div>
    </div>
    <hr class="hr-border">
    <div class="row">
        <div class="col-lg-4">
            <label class="col-form-label">
                <h4>{{ __('cases.limit_strategy') }}</h4>
            </label>
        </div>
    </div>
    <ul class="nav nav-tabs nav-light-info nav-bold  ">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#limit_strategy_current">
                <span class="nav-icon"><i class="flaticon2-hourglass-1"></i></span>
                <span class="nav-text">{{ __('cases.current') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#limit_strategy_past">
                <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                <span class="nav-text">{{ __('cases.past') }}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5" id="myTabContent">
        <div class="tab-pane fade show active" id="limit_strategy_current" role="tabpanel">
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group pt-3">
                        <label class="col-form-label"></label><br>
                        <label class="col-form-label">{{ __('cases.current') }}</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    @php
                    $proposed_individual_cap = isset($casesLimitStrategy['proposed_individual_cap'])?$casesLimitStrategy['proposed_individual_cap']:0;
                    $proposed_overall_cap = isset($casesLimitStrategy['proposed_overall_cap'])?$casesLimitStrategy['proposed_overall_cap']:0;
                    @endphp
                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.individual_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></div>
                    {!! Form::number('', $proposed_individual_cap ?? '', ['class' => 'form-control form-control-solid proposed_individual_cap text-right','readonly',])
                    !!}
                </div>
                <div class="col-lg-2">
                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.overall_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></div>
                    {!! Form::number('', $proposed_overall_cap ?? '', ['class' => 'form-control form-control-solid proposed_overall_cap text-right',
                        'readonly',])
                    !!}
                </div>
                <div class="col-lg-2">
                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.valid_till') }}<i class="text-danger">*</i></div>
                    {!! Form::date('', $casesLimitStrategy['proposed_valid_till'] ?? '', ['class' => 'form-control form-control-solid proposed_valid_till',
                        'readonly'])
                    !!}
                </div>
                <div class="col-lg-2">
                    <div class="font-weight-bold p-1 davy-grey-color">{{ __('cases.group_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></div>
                    {!! Form::number('', $total_group_cap ?? '', [ 'class' => 'form-control form-control-solid proposed_group_cap text-right',
                        'readonly'])
                    !!}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2">
                    <div class="form-group">
                        <label class="col-form-label"></label>
                        <label class="col-form-label">{{ __('cases.proposed') }}</label>
                    </div>
                </div>
                <div class="col-lg-2">
                    {!! Form::number('proposed[proposed_individual_cap]', $actionPlantransferLog['proposed_individual_cap'] ?? null,
                        [
                            'class' => 'form-control required action_proposed_individual_cap',
                            'min' => '0',
                            'max' => $case->underwriter->individual_cap ?? '',
                            'id' => 'action_proposed_individual_cap',
                            'data-msg-max' => "Individual Cap should be less than underwriter's individual cap (".($case->underwriter->individual_cap ?? '').")",
                            'data-rule-Numbers' => true,
                        ],
                    ) !!}
                </div>
                <div class="col-lg-2">
                    {!! Form::number('proposed[proposed_overall_cap]', $actionPlantransferLog['proposed_overall_cap'] ?? null, [
                            'class' => 'form-control required action_proposed_overall_cap',
                            'id' => 'action_proposed_overall_cap',
                            'max' => $case->underwriter->individual_cap ?? '',
                            'data-msg-max' => "Overall Cap should be less than underwriter's Overall cap (".($case->underwriter->individual_cap ?? '').")",
                            'data-rule-Numbers' => true,
                        ]
                    ) !!}
                </div>
                <div class="col-lg-2">
                    {!! Form::date('proposed[proposed_valid_till]', $actionPlantransferLog['proposed_valid_till'] ?? null, [
                        'class' => 'form-control required',
                        'min' => $currentDate,
                        'max' => '9999-12-31',
                        'data-msg-min' => "Please enter a value greater than or equal to " . custom_date_format($currentDate, 'd/m/Y'),
                    ]) !!}
                </div>
                @php
                    $readonly = '';
                    $form_control = '';
                    /*if (isset($groupCapData) || count($groupCapDataCount) == 0) {
                        $readonly = '';
                        $form_control = '';
                    } else {
                        $readonly = 'readonly';
                        $form_control = 'form-control-solid';
                    }*/
                @endphp
                <div class="col-lg-2">
                    {!! Form::number('proposed[proposed_group_cap]', $total_group_cap ?? '', [
                        'class' => 'form-control text-right action_proposed_group_cap ' . $proposed_group_cap_form_control_solid,
                        'min' => $approvedLimitAmount ?? 0,
                        'max' => $case->underwriter->group_cap ?? '',
                        'data-msg-max'=>"The underwriter's group cap approval authority (".($case->underwriter->group_cap ?? '').") limit exceed",$proposed_group_cap_readonly, 'data-rule-Numbers' => true,])
                    !!}
                </div>
            </div>
        </div>
        <div class="tab-pane fade show" id="limit_strategy_past" role="tabpanel">
            <table class="table table-responsive table-separate table-head-custom table-checkable" id="dataTableBuilder">
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
                                    {{ format_amount($casesLimitStrategy['proposed_individual_cap'] ?? '', '0', '.') }}
                                </td>
                                <td class="text-right">
                                    {{ format_amount($casesLimitStrategy['proposed_overall_cap'] ?? '', '0', '.') }}
                                </td>
                                <td class="text-right">
                                    {{ format_amount($casesLimitStrategy['proposed_group_cap'] ?? '', '0', '.') }}
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
   {{--  <br>
    <div class="row">
        <div class="col-lg-4">
            <label class="col-form-label">
                <h4>{{ __('cases.bond_limit_strategy') }}</h4>
            </label>
        </div>
    </div>
    <ul class="nav nav-tabs nav-light-info nav-bold  ">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#bond_limit_strategy_current">
                <span class="nav-icon"><i class="flaticon2-hourglass-1"></i></span>
                <span class="nav-text">{{ __('cases.current') }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#bond_limit_strategy_past">
                <span class="nav-icon"><i class="flaticon2-pie-chart-4"></i></span>
                <span class="nav-text">{{ __('cases.past') }}</span>
            </a>
        </li>
    </ul>
    <div class="tab-content mt-5">
        <div class="tab-pane fade show active" id="bond_limit_strategy_current" role="tabpanel">


            <div id="bondLimitStrategyRepeater">
                <table class="table table-separate table-head-custom table-checkable tradeSector" id="machine"
                    data-repeater-list="bond">
                    <p class="text-danger d-none"></p>
                    <thead>
                        <tr>
                            <th width="350">{{ __('cases.bond_type') }}<i class="text-danger">*</i></th>
                            <th>{{ __('cases.current_cap') }}<i class="text-danger">*</i></th>
                            <th>{{ __('cases.utilized_cap') }}<i class="text-danger">*</i></th>
                            <th>{{ __('cases.remaining_cap') }}<i class="text-danger">*</i></th>
                            <th>{{ __('cases.proposed_cap') }}<i class="text-danger">*</i></th>
                            <th>{{ __('cases.current_valid_till') }}</th>
                            <th>{{ __('cases.valid_till') }}<i class="text-danger">*</i></th>
                            <th width="20"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($casesBondLimitStrategy) && $casesBondLimitStrategy->count() > 0)
                            @foreach ($casesBondLimitStrategy as $key => $item)
                                <tr data-repeater-item="">
                                        <td>
                                            {!! Form::select('bond_type_id', ['' => ''] + $bondTypes, $item['bond_type_id'] ?? '', [
                                                'class' => 'form-control required bond_type jsSelect2ClearAllow',
                                                'data-placeholder' => 'Select',
                                                'disabled',
                                            ]) !!}
                                            {!! Form::hidden('bond_type_id', $item['bond_type_id'] ?? '') !!}
                                        </td>
                                    <td>
                                        {!! Form::number('current_cap', $item['bond_current_cap'] ?? 0, [
                                            'class' => 'form-control form-control-solid required current_cap',
                                            'readonly' => true,
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('utilized_cap',$item['bond_utilized_cap'], [
                                            'class' => 'form-control required form-control-solid utilized_cap ',
                                            'readonly' => true,
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('remaining_cap', $item['bond_remaining_cap'] ?? 0, [
                                            'class' => 'form-control form-control-solid required remaining_cap ',
                                            'readonly' => true,
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::number('proposed_cap', '', [
                                            'class' => 'form-control required proposed_cap ',
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::date('', $item['bond_valid_till'], [
                                            'class' => 'form-control form-control-solid',
                                            'readonly' => true,
                                        ]) !!}
                                    </td>
                                    <td>
                                        {!! Form::date('valid_till', '', [
                                            'class' => 'form-control required valid_till ',
                                        ]) !!}
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr data-repeater-item="" class="trade_sector_row">
                                <td>
                                    {!! Form::select('bond_type_id', ['' => ''] + $bondTypes, $case->bond_type_id ?? '', [
                                        'class' => 'form-control required bond_type jsSelect2ClearAllow',
                                        'data-placeholder' => 'Select',
                                        ($case->bond_type_id) ? 'disabled' : '',
                                    ]) !!}
                                    @if($case->bond_type_id)
                                        {!! Form::hidden('bond_type_id', $case->bond_type_id ?? '') !!}
                                    @endif
                                </td>
                                <td>
                                    {!! Form::number('current_cap', $casesLimitStrategy['bond_current_cap'] ?? 0, [
                                        'class' => 'form-control form-control-solid required current_cap',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('utilized_cap', $case->cases_decision_sum_bond_value ?? 0, [
                                        'class' => 'form-control required form-control-solid utilized_cap ',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('remaining_cap', 0, [
                                        'class' => 'form-control form-control-solid required remaining_cap ',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('proposed_cap', '', [
                                        'class' => 'form-control required proposed_cap ',
                                    ]) !!}
                                </td>
                                <td></td>
                                <td>
                                    {!! Form::date('valid_till', '', [
                                        'class' => 'form-control required valid_till ',
                                    ]) !!}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                                {!! Form::number('',$case_action_plan->cases_bond_limit_strategy_save_data_sum_bond_utilized_cap ?? 0, [
                                        'class' => 'form-control form-control-solid',
                                        'readonly' => true,
                                ]) !!}
                            </td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <div class="col-md-12 col-12">
                    <button type="button" data-repeater-create=""
                        class="btn btn-outline-primary btn-sm trade_sector_create"><i class="fa fa-plus-circle"></i>
                        Add</button>
                </div>
            </div>

        </div>
        <div class="tab-pane fade show" id="bond_limit_strategy_past" role="tabpanel">
            @if (isset($casesBondLimitStrategylog) && count($casesBondLimitStrategylog) > 0)
                @foreach ($casesBondLimitStrategylog as $key => $casesLimitStrategy)
                    <table class="table table-separate table-head-custom table-checkable" id="dataTableBuilder">
                        <thead>
                        </thead>
                        <tbody>
                            <td>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>{{ __('common.no') }}</th>
                                            <th>{{ __('cases.bond_type') }}</th>
                                            <th class="text-right">{{ __('cases.current_cap') }}</th>
                                            <th class="text-right">{{ __('cases.utilized_cap') }}</th>
                                            <th class="text-right">{{ __('cases.remaining_cap') }}</th>
                                            <th class="text-right">{{ __('cases.proposed_cap') }}</th>
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
                                                    {{ format_amount($casesLimitStrategy['bond_current_cap'] ?? '', '0', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ format_amount($casesLimitStrategy['bond_utilized_cap'] ?? '', '0', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ format_amount($casesLimitStrategy['bond_remaining_cap'] ?? '', '0', '.') }}
                                                </td>
                                                <td class="text-right">
                                                    {{ format_amount($casesLimitStrategy['bond_proposed_cap'] ?? '', '0', '.') }}
                                                </td>
                                                <td>{{ $casesLimitStrategy['created_at'] ?? '' ? custom_date_format($casesLimitStrategy['created_at'] ?? '', 'd/m/Y') : '' }}
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
    </div> --}}
    <br>
    <table class="row">
        <tr>
            <span class="p-1 text-danger cases-action-plan-error-0 d-none">
                Please assign underwriter to take any action.
            </span>
        </tr>
         <tr>
            <span class="p-1 text-danger cases-action-plan-error-1 d-none">
                Overallcap greater then of equal to sum of bond utilized cap.
            </span>
        </tr>
    </table>
    <div class="card-footer pt-3 pb-1 ">
        <div class="row">
            <div class="col-12 text-right ">
                @if ($current_user->id === $case->underwriterUserId)
                     <input class="btn btn-light " type="reset" value="Reset">
                @endif
                <button class="btn btn-primary" type="button" data-toggle="modal" data-original-title="test" data-target="#actionld">Log Detail</button>
                <button class="btn btn-primary transferDataAction" type="button" data-toggle="modal" data-original-title="test" data-target="#tfaction">Transfer</button>
                @if ($current_user->id === $case->underwriterUserId)
                    <button class="btn btn-primary jsActionSave" type="submit">Save</button>
                @endif
            </div>
        </div>
    </div>
</form>
@include('cases.tabs.action-plan.log-detail-modal')
@include('cases.tabs.action-plan.transfer-modal')