

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('pd_beneficiary', __('tender.beneficiary')) !!}<i class="text-danger">*</i>
        {!! Form::select('pd_beneficiary', ['' => ''] + $beneficiary_id, null, [
            'class' => 'pd_beneficiary form-control jsSelect2ClearAllow required',
            'style' => 'width: 100%;',
            'data-placeholder' => 'Select Beneficiary',
            'disabled',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('pd_project_name', __('tender.project_name')) !!}<i class="text-danger">*</i>
        {{ Form::text('pd_project_name', null, ['class' => 'form-control form-control-solid pd_project_name required', 'data-rule-AlphabetsAndNumbersV8' => true, 'readonly']) }}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label('pd_project_description', __('tender.project_description')) !!}<i class="text-danger">*</i>
        {{ Form::textarea('pd_project_description', null, ['class' => 'form-control form-control-solid required pd_project_description', 'rows' => 2, 'readonly']) }}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label('pd_project_value', __('tender.project_value')) !!}<span class="currency_symbol">{{ isset($currency_symbol) ? ' (' .$currency_symbol . ')' : '' }}</span><i class="text-danger">*</i>

        {{ Form::number('pd_project_value', null, ['class' => 'form-control form-control-solid pd_project_value required text-right', 'data-rule-Numbers' => true, 'readonly']) }}
    </div>

    <div class="col-6 form-group">
        {!! Form::label('pd_type_of_project', __('tender.type_of_project')) !!}<i class="text-danger">*</i>
        {!! Form::select('pd_type_of_project', ['' => ''] + $type_of_project, null, [
            'class' => 'form-control required pd_type_of_project jsSelect2ClearAllow',
            'style' => 'width: 100%;',
            'data-placeholder' => 'Select Type of Project',
            'disabled',
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-4 form-group">
        {!! Form::label('pd_project_start_date', __('tender.project_start_date')) !!}<i class="text-danger">*</i>
        {!! Form::date('pd_project_start_date', null, [
            'class' => 'form-control form-control-solid pd_project_start_date jsPeriod required',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            'data-msg-min' => 'Please enter a Date greater than or equal to 01/01/1000',
            'data-msg-max' => 'Please enter a Date less than or equal to 31/12/9999',
            'readonly',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('pd_project_end_date', __('tender.project_end_date')) !!}<i class="text-danger">*</i>
        {!! Form::date('pd_project_end_date', null, [
            'class' => 'form-control form-control-solid pd_project_end_date jsPeriod required',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
            'data-msg-min' => 'Please enter a Date greater than or equal to 01/01/1000',
            'data-msg-max' => 'Please enter a Date less than or equal to 31/12/9999',
            'readonly',
        ]) !!}
    </div>

    <div class="col-4 form-group">
        {!! Form::label('pd_period_of_project', __('tender.period_of_project')) !!}<i class="text-danger">*</i>
        {!! Form::number('pd_period_of_project', null, [
            'class' => 'form-control form-control-solid jsProjectPeriod required pd_period_of_project',
            'data-rule-Numbers' => true,
            'readonly',
        ]) !!}
    </div>
</div>