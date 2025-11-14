<div class="row">
    <div class="col-lg-4">
        <label class="col-form-label">
            <h4>{{ __('cases.bond_limit_strategy') }}</h4>
        </label>
    </div>
</div>
<br>
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
<form action="{{ route('store-cases-parameter', $case->id) }}" method="POST"id="casesParameterForm">
    @csrf
    <input type="hidden" name="casesable_type" value="{{ $case->casesable_type ?? '' }}">
    <input type="hidden" name="casesable_id" value="{{ $case->casesable_id ?? '' }}">
    <input type="hidden" name="case_type" value="{{ $case->case_type ?? '' }}">
    <input type="hidden" name="contractor_id" value="{{$case->contractor_id ?? ''}}">
    <input type="hidden" name="underwriter_id" value="{{$case->underwriter_id ?? ''}}">
<div class="tab-content mt-5">
    <div class="tab-pane fade show active" id="bond_limit_strategy_current" role="tabpanel">


        <div id="bondLimitStrategyRepeater">
            <table class="table table-responsive table-separate table-head-custom table-checkable tradeSector" id="machine"
                data-repeater-list="bond">
                <p class="text-danger d-none"></p>
                <thead>
                    <tr>
                        <th class="min-width-200">{{ __('cases.bond_type') }}<i class="text-danger">*</i></th>
                        <th class="min-width-200">{{ __('cases.current_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="min-width-200">{{ __('cases.utilized_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="text-center min-width-100">%</th>
                        <th class="min-width-200">{{ __('cases.remaining_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="min-width-200">{{ __('cases.current_valid_till') }}</th>
                        <th class="min-width-200">{{ __('cases.proposed_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i></th>
                        <th class="min-width-100">{{ __('cases.valid_till') }}<i class="text-danger">*</i></th>
                        <th width="20"></th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($casesBondLimitStrategy) && $casesBondLimitStrategy->count() > 0)
                        @if (!in_array($case->bond_type_id,$casesBondLimitStrategy->pluck('bond_type_id')->toArray()) && $case->case_type == "Application")
                        <tr data-repeater-item="" class="cases_bond_limit_strategy_row" data-current-case-bond-limit-strategy=true>
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
                                {!! Form::number('current_cap',0, [
                                    'class' => 'form-control form-control-solid required text-right current_cap',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::number('utilized_cap',0, [
                                    'class' => 'form-control required form-control-solid text-right utilized_cap ',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td>
                                <span class="form-control form-control-solid bond_utilized_cap_persontage">
                                    {{numberFormatPrecision(0,2)}}
                                </span>
                            </td>
                            <td>
                                {!! Form::number('remaining_cap', 0, [
                                    'class' => 'form-control form-control-solid required text-right remaining_cap ',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td></td>
                            <td>
                                {!! Form::number('proposed_cap', '', [
                                    'class' => 'form-control required proposed_cap ',
                                    'min'=>$case_action_plan?->utilizedCasesBondLimitStrategy($case->bond_type_id,'sum') ?? 0
                                ]) !!}
                            </td>
                            <td>
                                {!! Form::date('valid_till', '', [
                                    'class' => 'form-control required valid_till ',
                                ]) !!}
                            </td>
                        </tr>
                        @endif
                        @foreach ($casesBondLimitStrategy as $key => $item)
                            <tr data-repeater-item="" class="cases_bond_limit_strategy_row" {{$case->bond_type_id == $item['bond_type_id'] ? 'data-current-case-bond-limit-strategy=true' : '' }}>
                                {{-- @if ($loop->first) --}}
                                    <td>
                                        {!! Form::select("bond[$key][bond_type_id]", ['' => ''] + $bondTypes, $item['bond_type_id'] ?? '', [
                                            'class' => 'form-control required bond_type jsSelect2ClearAllow',
                                            'data-placeholder' => 'Select',
                                            'disabled',
                                        ]) !!}
                                        {!! Form::hidden("bond[$key][bond_type_id]", $item['bond_type_id'] ?? '') !!}
                                    </td>
                                {{-- @else
                                    <td>
                                        {!! Form::select('bond_type_id', ['' => ''] + $bondTypes, $item['bond_type_id'] ?? '', [
                                            'class' => 'form-control required bond_type jsSelect2ClearAllow',
                                            'data-placeholder' => 'Select',
                                        ]) !!}
                                    </td>
                                @endif --}}
                                <td>
                                    {!! Form::number('current_cap', $item['bond_current_cap'] ?? 0, [
                                        'class' => 'form-control form-control-solid text-right required current_cap',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('utilized_cap',$case_action_plan?->utilizedCasesBondLimitStrategy($item['bond_type_id'],'sum') ?? 0, [
                                        'class' => 'form-control required text-right form-control-solid utilized_cap ',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    <span class="form-control form-control-solid bond_utilized_cap_persontage">
                                          {{numberFormatPrecision(safe_divide($case_action_plan?->utilizedCasesBondLimitStrategy($item['bond_type_id'],'sum')*100,$item['bond_current_cap']),2)}}
                                    </span>
                                </td>
                                <td>
                                    {!! Form::number('remaining_cap',$item['bond_current_cap'] - $case_action_plan?->utilizedCasesBondLimitStrategy($item['bond_type_id'],'sum'), [
                                        'class' => 'form-control text-right form-control-solid required remaining_cap ',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::date('', $item['bond_valid_till'], [
                                        'class' => 'form-control form-control-solid bond_valid_till',
                                        'readonly' => true,
                                    ]) !!}
                                </td>
                                <td>
                                    {!! Form::number('proposed_cap', '', [
                                        'class' => 'form-control required proposed_cap ',
                                        'min'=>$case_action_plan?->utilizedCasesBondLimitStrategy($item['bond_type_id'],'sum') ?? 0,
                                         'data-msg-min'=>'Proposed Cap amount should be greater than or equal to bond wise utilized cap'
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
                        <tr data-repeater-item="" class="cases_bond_limit_strategy_row" data-current-case-bond-limit-strategy=true>
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
                                    'class' => 'form-control form-control-solid text-right required current_cap',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td>
                               {!! Form::number('utilized_cap', $case_action_plan?->utilizedCasesBondLimitStrategy($case->bond_type_id,'sum') ?? 0, [
                                    'class' => 'form-control required text-right form-control-solid utilized_cap ',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td>
                                <span class="form-control form-control-solid bond_utilized_cap_persontage">
                                    {{numberFormatPrecision(0,2)}}
                                </span>
                            </td>
                            <td>
                                {!! Form::number('remaining_cap', 0, [
                                    'class' => 'form-control form-control-solid text-right required remaining_cap ',
                                    'readonly' => true,
                                ]) !!}
                            </td>
                            <td></td>
                            <td>
                                {!! Form::number('proposed_cap', '', [
                                    'class' => 'form-control required proposed_cap ',
                                    'min'=>$case_action_plan?->utilizedCasesBondLimitStrategy($case->bond_type_id,'sum') ?? 0,
                                    'data-msg-min'=>'Proposed Cap amount should be greater than or equal to bond wise utilized cap'
                                ]) !!}
                            </td>
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
                            {!! Form::number('',$case_action_plan->utilized_cases_bond_limit_strategy_sum_value ?? 0, [
                                    'class' => 'form-control form-control-solid JsTotalBondUtilizedCap text-right',
                                    'readonly' => true,
                            ]) !!}
                        </td>
                        <td></td>
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
                        <th>{{ $key }}</th>
                    </thead>
                    <tbody>
                        <td>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>{{ __('common.no') }}</th>
                                        <th>{{ __('cases.bond_type') }}</th>
                                        <th class="text-right">{{ __('cases.current_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('cases.utilized_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('cases.utilized_cap_persontage') }}</th>
                                        <th class="text-right">{{ __('cases.remaining_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
                                        <th class="text-right">{{ __('cases.proposed_cap') }}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span></th>
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
                                                {{numberFormatPrecision($casesLimitStrategy['bond_utilized_cap_persontage'],2)}}
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
</div>
<br>
<br>
<table class="row">
    <tr>
        <span class="p-1 text-danger parmeter-error-0 d-none">
            Please assign underwriter to take any action.
        </span>
      </tr>
</table>
<div class="card-footer pt-3 pb-1 ">
    <div class="row">
        <div class="col-12 text-right ">
            @if ($current_user->id === $case->underwriterUserId)
                <button class="btn btn-primary jsParameterSave" type="submit">Save</button>
            @endif
        </div>
    </div>
</div>
</form>