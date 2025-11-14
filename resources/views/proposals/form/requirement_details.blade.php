<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.beneficiary_id'), __('proposals.beneficiary')) !!}<i class="text-danger">*</i>
        {!! Form::select('beneficiary_id', ['' => 'Select Beneficiary'] + $beneficiary_id, null, [
            'class' => 'form-control required jsSelect2ClearAllow',
            'style' => 'width:100%;',
            'id' => 'beneficiary_id',
            'data-placeholder' => 'Select Beneficiary',
            'disabled',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('proposals.beneficiary_type'), __('proposals.beneficiary_type')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('beneficiary_type', 'Government', false, ['class' => 'form-check-input beneficiary_type', 'id' => '', 'readonly',]) }}
                <span></span>Government
            </label>
            <label class="radio">
                {{ Form::radio('beneficiary_type', 'Non-Government', false, ['class' => 'form-check-input beneficiary_type', 'id' => '', 'readonly',]) }}
                <span></span>Non-Government
            </label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.beneficiary_address'), __('proposals.beneficiary_address')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('beneficiary_address', null, [
            'class' => 'form-control form-control-solid required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            'readonly',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.contract_value_of_project'), __('proposals.contract_value_of_project')) !!}<i class="text-danger">*</i>
        {!! Form::text('contract_value_of_project', null, [
            'class' => 'form-control required number contract_value',
            'id' => 'contract_value_of_project',
            'data-rule-Numbers' => true,
            'min' => 1,
        ]) !!}
    </div>
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.period_tenor_of_contract'), __('proposals.period_tenor_of_contract')) !!}<i class="text-danger">*</i>
        {!! Form::text('period_tenor_of_contract', null, [
            'class' => 'form-control form-control-solid required number period_of_contract',
            'id' => 'period_tenor_of_contract ',
            'data-rule-Numbers' => true,
            'min' => 1,
            'max' => 999,
            'readonly',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.project_brief'), __('proposals.project_brief')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('project_brief', null, [
            'class' => 'form-control form-control-solid required project_description',
            'rows' => 2,
            'readonly',
        ]) !!}
    </div>
</div>
{{-- @dd($bond_types) --}}
{{-- <h5 style="font-weight:800;">Primary Bond</h5> --}}
<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.type_of_bond'), __('proposals.type_of_bond')) !!}<i class="text-danger">*</i>
        {!! Form::select('type_of_bond', ['' => 'Select Bond Type'] + $bond_types, null, [
            'class' => 'form-control required',
            'style' => 'width:100%;',
            'id' => 'type_of_bond',
            'data-placeholder' => 'Select Bond Type',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {{ Form::label(__('proposals.bond_issued_date'), __('proposals.bond_issued_date')) }}<i
            class="text-danger">*</i>
        {!! Form::date('bond_issued_date', null, [
            'class' => 'form-control required jsPrimaryBondIssuedDate',
            'min' => '1000-01-01',
            'max' => now()->toDateString(),
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {{ Form::label('bond_start_date', __('proposals.bond_start_date')) }}<i class="text-danger">*</i>
        {!! Form::date('bond_start_date', null, [
            'class' => 'jsPrimaryBondStartDate form-control required bond_date',
            'min' => '1000-01-01',
            'id' => 'bond_start_date',
            'max' => $proposals->bond_end_date ?? null,
        ]) !!}
    </div>
    <div class="col-6 form-group">
        {{ Form::label('bond_end_date', __('proposals.bond_end_date')) }}<i class="text-danger">*</i>
        {!! Form::date('bond_end_date', null, [
            'class' => 'jsPrimaryBondEndDate form-control required bond_date',
            'max' => '9999-12-31',
            'id' => 'bond_end_date',
            'min' => $proposals->bond_start_date ?? null,
        ]) !!}
    </div>
</div>
<div class="row pl-5">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.bond_period'), __('proposals.bond_period')) !!}<i class="text-danger">*</i>
        <div class="row">
            {!! Form::text('bond_period', $proposals->bond_period ?? null, [
                'class' => 'form-control required number period_of_bond jsPrimaryPeriodOfBond form-control-solid max-w-90px',
                'id' => 'bond_period',
                'readonly',
                'data-rule-Numbers' => true,
                'min' => 0,
            ]) !!}
            {!! Form::text('bond_period_year', $proposals->bond_period_year ?? null, ['class' => 'form-control jsPrimaryPeriodOfBondYear max-w-75px  col-4 ml-5 form-control-solid', 'readonly'])
            !!}
            {!! Form::text('bond_period_month', $proposals->bond_period_month ?? null, ['class' => 'form-control jsPrimaryPeriodOfBondMonth max-w-90px  col-4 ml-5 form-control-solid', 'readonly'])
            !!}
            {!! Form::text('bond_period_days', $proposals->bond_period_days ?? null, ['class' => 'form-control jsPrimaryPeriodOfBondDays max-w-90px col-4 ml-5 form-control-solid', 'readonly'])
            !!}
        </div>
    </div>
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.bond_value'), __('proposals.bond_value')) !!}<i class="text-danger">*</i>
        {!! Form::text('bond_value', null, [
            'class' => 'bond_value form-control form-control-solid required number tender_bond_value',
            'id' => 'bond_value',
            'data-rule-Numbers' => true,
            'min' => 1,
            'readonly',
        ]) !!}
    </div>
</div><hr>

{{-- <h5 style="font-weight:800;">Additional Bond</h5>
<div id="additionalBondRepeater">
    <p class="duplicateError text-danger d-none"></p>
    @if (isset($additionalBonds))
        <div class="repeaterRow additional_repeater_row" data-repeater-list="additional_bond_items">
            @foreach ($additionalBonds as $item)
                <div class="row mb-5 additional_bond_row" data-repeater-item="" style="border-bottom: 1px solid grey;">
                    {!! Form::hidden('ab_id', $item->id ?? '', ['class' => 'jsAbondId']) !!}
                    <div class="col-6 form-group">

                        {!! Form::label(__('proposals.additional_bond'), __('proposals.additional_bond')) !!}<i class="text-danger">*</i>

                        {!! Form::select('additional_bond_id', ['' => 'Select Additional Bond'] + $additional_bonds, $item->additional_bond_id ?? null, [
                            'class' => 'form-control required additional_bond_id',
                            'style' => 'width:100%;',
                            'data-placeholder' => 'Select Additional Bond',
                        ]) !!}
                    </div>
                    <div class="col-6 form-group">
                        {{ Form::label(__('proposals.bond_issued_date'), __('proposals.bond_issued_date')) }}<i
                            class="text-danger">*</i>
                        {!! Form::date('additional_bond_issued_date', $item->additional_bond_issued_date ?? null, [
                            'class' => 'form-control required jsBondIssuedDate',
                            'min' => '1000-01-01',
                            'max' => now()->toDateString(),
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {{ Form::label('bond_start_date', __('proposals.bond_start_date')) }}<i
                            class="text-danger">*</i>
                        {!! Form::date('additional_bond_start_date', $item->additional_bond_start_date ?? null, [
                            'class' => 'jsBondStartDate form-control required bond_date',
                            'min' => '1000-01-01',
                            'max' => $item->additional_bond_end_date ?? null,
                        ]) !!}
                    </div>
                    <div class="col-6 form-group">
                        {{ Form::label('bond_end_date', __('proposals.bond_end_date')) }}<i class="text-danger">*</i>
                        {!! Form::date('additional_bond_end_date', $item->additional_bond_end_date ?? null, [
                            'class' => 'jsBondEndDate form-control required bond_date',
                            'max' => '9999-12-31',
                            'min' => $item->additional_bond_start_date ?? null,
                        ]) !!}
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.bond_period'), __('proposals.bond_period')) !!}<i class="text-danger">*</i>
                        <div class="row">
                            {!! Form::text('additional_bond_period', $item->additional_bond_period ?? null, [
                                'class' => 'form-control required number period_of_bond jsPeriodOfBond form-control-solid max-w-90px',
                                'readonly',
                                'data-rule-Numbers' => true,
                                'min' => 0,
                            ]) !!}
                            {!! Form::text('additional_bond_period_year', $item->additional_bond_period_year ?? null, [
                                'class' => 'form-control jsPeriodOfBondYear max-w-75px  col-4 ml-5 form-control-solid',
                                'readonly',
                            ]) !!}
                            {!! Form::text('additional_bond_period_month', $item->additional_bond_period_month ?? null, [
                                'class' => 'form-control jsPeriodOfBondMonth max-w-90px  col-4 ml-5 form-control-solid',
                                'readonly',
                            ]) !!}
                            {!! Form::text('additional_bond_period_days', $item->additional_bond_period_days ?? null, [
                                'class' => 'form-control jsPeriodOfBondDays max-w-90px col-4 ml-5 form-control-solid',
                                'readonly',
                            ]) !!}
                        </div>
                    </div>

                    <div class="col-6 form-group">
                        {!! Form::label(__('proposals.bond_value'), __('proposals.bond_value')) !!}<i class="text-danger">*</i>
                        {!! Form::text('additional_bond_value', $item->bond_value ?? null, [
                            'class' => 'form-control required number',
                            'data-rule-Numbers' => true,
                            'min' => 1,
                        ]) !!}
                    </div>

                    <div class="col-12 mb-5 delete_addbond_item" style="text-align: end;">
                        <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                            <i class="flaticon-delete"></i></a>
                    </div>
                </div>
                <input type="hidden" name="delete_addbond_id" value="" class="jsDeleteAbondId">
            @endforeach
        </div>
    @else
        <div class="repeaterRow additional_repeater_row" data-repeater-list="additional_bond_items">
            <div class="row mb-5 additional_bond_row" data-repeater-item="" style="border-bottom: 1px solid grey;">
                <input type="hidden" name="additional_bond_id" class="jsAbondId">
                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.additional_bond'), __('proposals.additional_bond')) !!}<i class="text-danger">*</i>

                    {!! Form::select('additional_bond_id', ['' => 'Select Additional Bond'] + $additional_bonds, null, [
                        'class' => 'form-control additional_bond_id',
                        'style' => 'width:100%;',
                        'data-placeholder' => 'Select Additional Bond',
                    ]) !!}
                </div>
                <div class="col-6 form-group">
                    {{ Form::label(__('proposals.bond_issued_date'), __('proposals.bond_issued_date')) }}<i
                        class="text-danger">*</i>
                    {!! Form::date('additional_bond_issued_date', null, [
                        'class' => 'form-control jsBondIssuedDate additional_bond_issued_date',
                        'min' => '1000-01-01',
                        'max' => now()->toDateString(),
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {{ Form::label('bond_start_date', __('proposals.bond_start_date')) }}<i class="text-danger">*</i>
                    {!! Form::date('additional_bond_start_date', null, [
                        'class' => 'jsBondStartDate form-control bond_date additional_bond_start_date',
                        'min' => '1000-01-01',
                        'max' => $proposals->additional_bond_end_date ?? null,
                    ]) !!}
                </div>
                <div class="col-6 form-group">
                    {{ Form::label('bond_end_date', __('proposals.bond_end_date')) }}<i class="text-danger">*</i>
                    {!! Form::date('additional_bond_end_date', null, [
                        'class' => 'jsBondEndDate form-control bond_date additional_bond_end_date',
                        'max' => '9999-12-31',
                        'min' => $proposals->additional_bond_start_date ?? null,
                    ]) !!}
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.bond_period'), __('proposals.bond_period')) !!}<i class="text-danger">*</i>
                    <div class="row">
                        {!! Form::text('additional_bond_period', $proposals->bond_period ?? null, [
                            'class' => 'form-control number period_of_bond jsPeriodOfBond form-control-solid max-w-90px additional_bond_period',
                            'readonly',
                            'data-rule-Numbers' => true,
                            'min' => 0,
                        ]) !!}
                        {!! Form::text('additional_bond_period_year', $proposals->additional_bond_period_year ?? null, [
                            'class' => 'form-control jsPeriodOfBondYear max-w-75px  col-4 ml-5 form-control-solid additional_bond_period_year',
                            'readonly',
                        ]) !!}
                        {!! Form::text('additional_bond_period_month', $proposals->additional_bond_period_month ?? null, [
                            'class' => 'form-control jsPeriodOfBondMonth max-w-90px  col-4 ml-5 form-control-solid additional_bond_period_month',
                            'readonly',
                        ]) !!}
                        {!! Form::text('additional_bond_period_days', $proposals->additional_bond_period_days ?? null, [
                            'class' => 'form-control jsPeriodOfBondDays max-w-90px col-4 ml-5 form-control-solid additional_bond_period_days',
                            'readonly',
                        ]) !!}
                    </div>
                </div>

                <div class="col-6 form-group">
                    {!! Form::label(__('proposals.bond_value'), __('proposals.bond_value')) !!}<i class="text-danger">*</i>
                    {!! Form::text('additional_bond_value', null, [
                        'class' => 'form-control number additional_bond_value',
                        'data-rule-Numbers' => true,
                        'min' => 1,
                    ]) !!}
                </div>

                <div class="col-12 mb-5 delete_addbond_item" style="text-align: end;">
                    <a href="javascript:;" data-repeater-delete="" class="btn btn-sm btn-icon btn-danger mr-2">
                        <i class="flaticon-delete"></i></a>
                </div>
            </div>
            <input type="hidden" name="delete_addbond_id" value="" class="jsDeleteAbondId">
        </div>
    @endif

    <div class="row">
        <div class="col-12 text-right">
            <a href="javascript:;" data-repeater-create=""
                class="btn btn-sm font-weight-bolder btn-light-primary jsAdditionalBond">
                <i class="flaticon2-plus" style="font-size: 12px;"></i>{{ __('common.add') }}</a>
        </div>
    </div>
</div> --}}

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.is_project_agreement'), __('proposals.is_project_agreement')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_project_agreement', 'Yes', true, ['class' => 'form_is_project_agreement', 'id' => 'is_yes_project_agreement']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_project_agreement', 'No', '', ['class' => 'form_is_project_agreement', 'id' => 'is_no_project_agreement']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="isProjectAgreementData">
            <div class="d-block">
                {!! Form::label(__('proposals.project_attachment'), __('proposals.project_attachment')) !!}<i class="text-danger">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('project_attachment', [
                    'id' => 'project_attachment',
                    'class' => 'project_attachment',
                    'data-id' => $proposals->is_project_agreement ?? null,
                    // empty($dms_data['project_attachment']) ? 'required' : '',
                    'data-document-uploaded' => empty($dms_data['project_attachment']) ? 'true' : 'false',
                ]) !!}
            </div>
            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['project_attachment']))
                @foreach ($dms_data['project_attachment'] as $item)
                    @if ($item->file_name)
                        <span>{{ $item->file_name ?? '' }}</span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.rfp_of_project'), __('proposals.rfp_of_project')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('rfp_of_project', 'Yes', true, ['class' => 'form_rfp_of_project', 'id' => 'is_yes_rfp_of_project']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('rfp_of_project', 'No', '', ['class' => 'form_rfp_of_project', 'id' => 'is_no_rfp_of_project']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="rfpOfProjectData">
            <div class="d-block">
                {!! Form::label(__('proposals.rfp_attachment'), __('proposals.rfp_attachment')) !!}<i class="text-danger">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('rfp_attachment', [
                    'id' => 'rfp_attachment',
                    'class' => 'rfp_attachment',
                    'data-id' => $proposals->rfp_of_project ?? null,
                    // empty($dms_data['rfp_attachment']) ? 'required' : '',
                    // 'disabled',
                ]) !!}
            </div>
            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['rfp_attachment']))
                @foreach ($dms_data['rfp_attachment'] as $item)
                    @if ($item->file_name)
                        @if (isset($item->attachment))
                            <span class="d-block"><a href="{{ asset($item->attachment) }}"
                                    target="_blank">{{ $item->file_name ?? '' }}</a></span>
                        @endif
                        <span class="rfp_attachment_file d-block"></span>
                    @endif
                @endforeach
            @else
                <span class="rfp_attachment_file"></span>
            @endif
            {{-- <a href="#" class="rfp_attachment_link" id="rfp_attachment_link" style="display:none;"
                target="_blank"></a> --}}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.relevant_approvals'), __('proposals.relevant_approvals')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('relevant_approvals', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV1' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.funding_arrangement_details'), __('proposals.funding_arrangement_details')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('funding_arrangement_details', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.cashflow_projection'), __('proposals.cashflow_projection')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('cashflow_projection', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.project_payment'), __('proposals.project_payment')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('project_payment', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.trigger_of_bond'), __('proposals.trigger_of_bond')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('trigger_of_bond', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.feasibility_report'), __('proposals.feasibility_report')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('feasibility_report', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.is_feasibility_attachment'), __('proposals.is_feasibility_attachment')) !!}<i class="text-danger">*</i>

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_feasibility_attachment', 'Yes', true, ['class' => 'form_is_feasibility_attachment', 'id' => 'is_yes_is_feasibility_attachment']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_feasibility_attachment', 'No', '', ['class' => 'form_is_feasibility_attachment', 'id' => 'is_no_is_feasibility_attachment']) }}
                <span></span>No
            </label>
        </div>
    </div>

    <div class="col-6 form-group">
        <div class="isFeasibilityAttachmentData">
            <div class="d-block">
                {!! Form::label(__('proposals.feasibility_attachment'), __('proposals.feasibility_attachment')) !!}<i class="text-danger">*</i>
            </div>
            <div class="d-block">
                {!! Form::file('feasibility_attachment', [
                    'id' => 'feasibility_attachment',
                    'class' => 'feasibility_attachment',
                    'data-id' => $proposals->is_feasibility_attachment ?? null,
                    // empty($dms_data['feasibility_attachment']) ? 'required' : '',
                    'data-document-uploaded' => empty($dms_data['feasibility_attachment']) ? 'true' : 'false',
                ]) !!}
            </div>
            @if (!empty($dms_data) && $dms_data->count() > 0 && isset($dms_data['feasibility_attachment']))
                @foreach ($dms_data['feasibility_attachment'] as $item)
                    @if ($item->file_name)
                        <span>{{ $item->file_name ?? '' }}</span>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.bid_requirement'), __('proposals.bid_requirement')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('bid_requirement', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.bank_status_report'), __('proposals.bank_status_report')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('bank_status_report', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.relevant_conditions'), __('proposals.relevant_conditions')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('relevant_conditions', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.additional_underlying_risk'), __('proposals.additional_underlying_risk')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('additional_underlying_risk', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.guarantees_details'), __('proposals.guarantees_details')) !!}<i class="text-danger">*</i>
        {!! Form::textarea('guarantees_details', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>
