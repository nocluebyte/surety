{{-- <div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.circumstances_surety_bond'), __('proposals.circumstances_surety_bond')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('circumstances_surety_bond', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.bank_guarantees_details'), __('proposals.bank_guarantees_details')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('bank_guarantees_details', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div> --}}

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.is_bank_guarantee_provided'), __('proposals.is_bank_guarantee_provided')) !!}

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_bank_guarantee_provided', 'Yes', true, ['class' => 'form_is_bank_guarantee_provided', 'id' => 'is_yes_is_bank_guarantee_provided', $disabled,]) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_bank_guarantee_provided', 'No', '', ['class' => 'form_is_bank_guarantee_provided', 'id' => 'is_no_is_bank_guarantee_provided', $disabled,]) }}
                <span></span>No
            </label>
        </div>
    </div>
</div>

<div class="form-group isBankGuaranteeProvidedData">
    {!! Form::label(__('proposals.circumstance_short_notes'), __('proposals.circumstance_short_notes')) !!}
    {!! Form::textarea('circumstance_short_notes', null, [
        'class' => 'form-control jsClearContractorType circumstance_short_notes ' . $readonly_cls,
        'rows' => 2,
        'data-rule-AlphabetsAndNumbersV3' => true,
        $readonly,
    ]) !!}
</div>

<div class="row">
    <div class="col-6 form-group">
        {!! Form::label(__('proposals.is_action_against_proposer'), __('proposals.is_action_against_proposer')) !!}

        <div class="radio-inline">
            <label class="radio">
                {{ Form::radio('is_action_against_proposer', 'Yes', true, ['class' => 'form_is_action_against_proposer', 'id' => 'is_yes_is_action_against_proposer', $disabled,]) }}
                <span></span>Yes
            </label>
            <label class="radio">
                {{ Form::radio('is_action_against_proposer', 'No', '', ['class' => 'form_is_action_against_proposer', 'id' => 'is_no_is_action_against_proposer', $disabled,]) }}
                <span></span>No
            </label>
        </div>
    </div>
</div>

<div class="form-group isActionAgainstProposerData">
    {!! Form::label(__('proposals.action_details'), __('proposals.action_details')) !!}
    {!! Form::textarea('action_details', null, [
        'class' => 'form-control jsClearContractorType action_details ' . $readonly_cls,
        'rows' => 2,
        'data-rule-AlphabetsAndNumbersV3' => true,
        $readonly,
    ]) !!}
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.contractor_failed_project_details'), __('proposals.contractor_failed_project_details')) !!}
        {!! Form::textarea('contractor_failed_project_details', null, [
            'class' => 'form-control jsClearContractorType contractor_failed_project_details ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.completed_rectification_details'), __('proposals.completed_rectification_details')) !!}
        {!! Form::textarea('completed_rectification_details', null, [
            'class' => 'form-control jsClearContractorType completed_rectification_details ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.performance_security_details'), __('proposals.performance_security_details')) !!}
        {!! Form::textarea('performance_security_details', null, [
            'class' => 'form-control jsClearContractorType performance_security_details ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.relevant_other_information'), __('proposals.relevant_other_information')) !!}
        {!! Form::textarea('relevant_other_information', null, [
            'class' => 'form-control jsClearContractorType relevant_other_information ' . $readonly_cls,
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
            $readonly,
        ]) !!}
    </div>
</div>