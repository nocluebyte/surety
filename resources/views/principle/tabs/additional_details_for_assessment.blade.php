<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('principle.is_bank_guarantee_provided'), __('principle.is_bank_guarantee_provided')) !!}

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_bank_guarantee_provided', 'Yes', true, ['class' => 'is_bank_guarantee_provided', 'id' => 'is_yes_is_bank_guarantee_provided']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_bank_guarantee_provided', 'No', '', ['class' => 'is_bank_guarantee_provided', 'id' => 'is_no_is_bank_guarantee_provided']) }}
                <span></span>No
            </label>
        </div>
    </div>
</div>

<div class="form-group isBankGuaranteeProvidedData {{ isset($principle) && $principle->is_bank_guarantee_provided == 'No' ? 'd-none' : ''}}">
    {!! Form::label(__('principle.circumstance_short_notes'), __('principle.circumstance_short_notes')) !!}
    {!! Form::textarea('circumstance_short_notes', null, [
        'class' => 'form-control circumstance_short_notes',
        'rows' => 2,
        'data-rule-AlphabetsAndNumbersV3' => true,
    ]) !!}
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('principle.is_action_against_proposer'), __('principle.is_action_against_proposer')) !!}

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_action_against_proposer', 'Yes', true, ['class' => 'is_action_against_proposer', 'id' => 'is_yes_is_action_against_proposer']) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_action_against_proposer', 'No', '', ['class' => 'is_action_against_proposer', 'id' => 'is_no_is_action_against_proposer']) }}
                <span></span>No
            </label>
        </div>
    </div>
</div>

<div class="form-group isActionAgainstProposerData {{ isset($principle) && $principle->is_action_against_proposer == 'No' ? 'd-none' : ''}}">
    {!! Form::label(__('principle.action_details'), __('principle.action_details')) !!}
    {!! Form::textarea('action_details', null, [
        'class' => 'form-control action_details',
        'rows' => 2,
        'data-rule-AlphabetsAndNumbersV3' => true,
    ]) !!}
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('principle.contractor_failed_project_details'), __('principle.contractor_failed_project_details')) !!}
        {!! Form::textarea('contractor_failed_project_details', null, [
            'class' => 'form-control',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('principle.completed_rectification_details'), __('principle.completed_rectification_details')) !!}
        {!! Form::textarea('completed_rectification_details', null, [
            'class' => 'form-control',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('principle.performance_security_details'), __('principle.performance_security_details')) !!}
        {!! Form::textarea('performance_security_details', null, [
            'class' => 'form-control',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('principle.relevant_other_information'), __('principle.relevant_other_information')) !!}
        {!! Form::textarea('relevant_other_information', null, [
            'class' => 'form-control',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>