<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.ongoing_projects_details'), __('proposals.ongoing_projects_details')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('ongoing_projects_details', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.updated_blacklisting_details'), __('proposals.updated_blacklisting_details')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('updated_blacklisting_details', null, [
            'class' => 'form-control required',
            'rows' => 2,
            'data-rule-AlphabetsAndNumbersV3' => true,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-12 form-group">
        {!! Form::label(__('proposals.total_bgs_provided'), __('proposals.total_bgs_provided')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::textarea('total_bgs_provided', null, [
            'class' => 'form-control required',
            'data-rule-AlphabetsAndNumbersV3' => true,
            'rows' => 2,
        ]) !!}
    </div>
</div>

<div class="row">
    <div class="col-6 form-group">
        {{ Form::label(__('proposals.total_bgs_provided_date'), __('proposals.total_bgs_provided_date')) }}<i
            class="text-danger displayNone">*</i>
        {!! Form::date('total_bgs_provided_date', null, [
            'class' => 'form-control required total_bgs_provided_date',
            'min' => '1000-01-01',
            'max' => '9999-12-31',
        ]) !!}
    </div>

    <div class="col-6 form-group">
        {!! Form::label(__('proposals.amount_of_margin'), __('proposals.amount_of_margin')) !!}<i class="text-danger displayNone">*</i>
        {!! Form::text('amount_of_margin', null, [
            'class' => 'form-control required number',
            'id' => 'amount_of_margin',
            'data-rule-Numbers' => true,
        ]) !!}
    </div>
</div>
